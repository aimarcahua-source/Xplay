<?php
/**
 * Theme setup and asset loading.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Configure theme supports.
 *
 * @return void
 */
function feedbuzz_setup() {
	load_theme_textdomain( 'feedbuzz', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'custom-header',
		array(
			'default-image' => '',
			'width'         => 1600,
			'height'        => 420,
			'flex-width'    => true,
			'flex-height'   => true,
			'uploads'       => true,
			'header-text'   => false,
		)
	);
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f4f5fb',
			'default-image' => '',
		)
	);
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 96,
			'width'       => 320,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus(
		array(
			'primary'           => __( 'Header Category Menu', 'feedbuzz' ),
			'category_dropdown' => __( 'Categories Dropdown Menu', 'feedbuzz' ),
			'utility'           => __( 'Utility Menu', 'feedbuzz' ),
			'footer'            => __( 'Footer Menu', 'feedbuzz' ),
		)
	);

	add_image_size( 'feedbuzz-hero', 1100, 760, true );
	add_image_size( 'feedbuzz-card', 720, 480, true );
	add_image_size( 'feedbuzz-thumb', 320, 240, true );
	add_image_size( 'feedbuzz-leaderboard', 728, 90, true );
}
add_action( 'after_setup_theme', 'feedbuzz_setup' );

/**
 * Migrate the legacy default container width to the wider 1480px canvas.
 *
 * Only the old default value is changed; custom user widths remain untouched.
 *
 * @return void
 */
function feedbuzz_migrate_container_width_1080() {
	$options = get_option( 'feedbuzz_options', array() );

	if ( ! is_array( $options ) ) {
		return;
	}

	if ( isset( $options['container_width'] ) && 1380 === absint( $options['container_width'] ) ) {
		$options['container_width'] = 1480;
		update_option( 'feedbuzz_options', $options );
	}
}
add_action( 'after_setup_theme', 'feedbuzz_migrate_container_width_1080', 20 );


/**
 * Set the maximum content width.
 *
 * @return void
 */
function feedbuzz_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'feedbuzz_content_width', 860 );
}
add_action( 'after_setup_theme', 'feedbuzz_content_width', 0 );


/**
 * Return the post count configured in Settings > Reading.
 *
 * This is the single source of truth for post-list page size throughout the
 * theme. It deliberately reads WordPress core's posts_per_page option rather
 * than maintaining a theme-specific copy of the setting.
 *
 * @return int
 */
function feedbuzz_get_reading_posts_per_page() {
	return max( 1, absint( get_option( 'posts_per_page', 10 ) ) );
}

/**
 * Keep homepage post queries tied to Settings > Reading.
 *
 * WordPress normally applies posts_per_page to the public posts index itself.
 * The same standard pre_get_posts hook also applies the core value to the
 * theme's explicitly marked static-front-page magazine feed. The selected
 * static Page remains WordPress's main query and is never converted to posts.
 *
 * @param WP_Query $query Main WordPress query object.
 * @return void
 */
function feedbuzz_apply_reading_posts_per_page( $query ) {
	if ( is_admin() || ! ( $query instanceof WP_Query ) ) {
		return;
	}

	$is_posts_index = $query->is_main_query() && $query->is_home();
	$is_front_feed   = (bool) $query->get( 'feedbuzz_home_feed' );

	if ( $is_posts_index || $is_front_feed ) {
		$query->set( 'posts_per_page', feedbuzz_get_reading_posts_per_page() );
	}
}
add_action( 'pre_get_posts', 'feedbuzz_apply_reading_posts_per_page' );

/**
 * Register widget areas.
 *
 * @return void
 */
function feedbuzz_widgets_init() {
	$sidebars = array(
		'primary-sidebar' => __( 'Primary Sidebar', 'feedbuzz' ),
		'footer-one'      => __( 'Footer Column One', 'feedbuzz' ),
		'footer-two'      => __( 'Footer Column Two', 'feedbuzz' ),
		'footer-three'    => __( 'Footer Column Three', 'feedbuzz' ),
	);

	foreach ( $sidebars as $id => $name ) {
		register_sidebar(
			array(
				'name'          => $name,
				'id'            => $id,
				'before_widget' => '<section id="%1$s" class="widget fb-widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'feedbuzz_widgets_init' );

/**
 * Return a file modification time for cache busting.
 *
 * @param string $relative_path Theme-relative file path.
 * @return string
 */
function feedbuzz_asset_version( $relative_path ) {
	$file = get_theme_file_path( $relative_path );

	return file_exists( $file ) ? (string) filemtime( $file ) : FEEDBUZZ_VERSION;
}

/**
 * Keep above-the-fold homepage images on one stable source.
 *
 * Responsive srcset candidate swaps can trigger a visible repaint while the
 * desktop layout settles. The top showcase already requests purpose-built
 * image sizes, so keep those critical images on their direct src URL.
 *
 * @param array        $attr       Image attributes.
 * @param WP_Post      $attachment Attachment object.
 * @param string|int[] $size       Requested image size.
 * @return array
 */
function feedbuzz_stabilize_critical_image_attributes( $attr, $attachment, $size ) {
	$classes = isset( $attr['class'] ) ? (string) $attr['class'] : '';

	if ( false === strpos( $classes, 'fb-stable-image' ) ) {
		return $attr;
	}

	unset( $attr['srcset'], $attr['sizes'] );
	$attr['loading']  = 'eager';
	$attr['decoding'] = 'sync';

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'feedbuzz_stabilize_critical_image_attributes', 30, 3 );

/**
 * Preload the four above-the-fold showcase images on the front page.
 *
 * @return void
 */
function feedbuzz_preload_home_showcase_images() {
	if ( is_admin() || ! is_front_page() ) {
		return;
	}

	$posts = get_posts(
		array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'numberposts'            => 4,
			'ignore_sticky_posts'    => false,
			'no_found_rows'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => false,
		)
	);

	foreach ( $posts as $index => $post ) {
		$thumbnail_id = get_post_thumbnail_id( $post );
		if ( ! $thumbnail_id ) {
			continue;
		}

		$size = 0 === $index ? 'feedbuzz-hero' : 'feedbuzz-thumb';
		$src  = wp_get_attachment_image_url( $thumbnail_id, $size );
		if ( ! $src ) {
			continue;
		}

		printf(
			'<link rel="preload" as="image" href="%1$s"%2$s>' . "\n",
			esc_url( $src ),
			0 === $index ? ' fetchpriority="high"' : ''
		);
	}
}
add_action( 'wp_head', 'feedbuzz_preload_home_showcase_images', 1 );

/**
 * Load public assets.
 *
 * @return void
 */
function feedbuzz_enqueue_assets() {
	wp_enqueue_style(
		'feedbuzz-style',
		get_stylesheet_uri(),
		array(),
		feedbuzz_asset_version( 'style.css' )
	);
	wp_enqueue_style(
		'feedbuzz-main',
		get_theme_file_uri( 'assets/css/main.css' ),
		array( 'feedbuzz-style' ),
		feedbuzz_asset_version( 'assets/css/main.css' )
	);
	wp_enqueue_style(
		'feedbuzz-ui',
		get_theme_file_uri( 'assets/css/ui.css' ),
		array( 'feedbuzz-main', 'wp-block-library' ),
		feedbuzz_asset_version( 'assets/css/ui.css' )
	);
	wp_add_inline_style( 'feedbuzz-ui', feedbuzz_get_dynamic_css() );

	if ( is_rtl() ) {
		wp_enqueue_style(
			'feedbuzz-rtl',
			get_theme_file_uri( 'rtl.css' ),
			array( 'feedbuzz-ui' ),
			feedbuzz_asset_version( 'rtl.css' )
		);
	}

	wp_enqueue_script(
		'feedbuzz-main',
		get_theme_file_uri( 'assets/js/main.js' ),
		array(),
		feedbuzz_asset_version( 'assets/js/main.js' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
	wp_localize_script(
		'feedbuzz-main',
		'feedbuzzData',
		array(
			'menuOpen'      => __( 'Open menu', 'feedbuzz' ),
			'menuClose'     => __( 'Close menu', 'feedbuzz' ),
			'menuMore'      => __( 'More menu items', 'feedbuzz' ),
			'allCategories' => __( 'All categories', 'feedbuzz' ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'feedbuzz_enqueue_assets' );

/**
 * Add body classes.
 *
 * @param array<int, string> $classes Body classes.
 * @return array<int, string>
 */
function feedbuzz_body_classes( $classes ) {
	return $classes;
}
add_filter( 'body_class', 'feedbuzz_body_classes' );



/**
 * Suppress the default latest-posts widget output on the homepage primary sidebar.
 *
 * The theme renders its own designed recent-posts block in that location. This
 * filter prevents duplicate output without making the sidebar appear inactive.
 *
 * @param array|false     $instance Widget settings.
 * @param WP_Widget       $widget   Widget instance.
 * @param array<string,mixed> $args Dynamic sidebar display arguments.
 * @return array|false
 */
function feedbuzz_filter_homepage_latest_posts_widget_output( $instance, $widget, $args ) {
	if ( is_admin() || ! ( is_front_page() || is_home() ) ) {
		return $instance;
	}

	if ( empty( $args['id'] ) || 'primary-sidebar' !== $args['id'] ) {
		return $instance;
	}

	$widget_id = '';

	if ( ! empty( $args['widget_id'] ) ) {
		$widget_id = (string) $args['widget_id'];
	} elseif ( isset( $widget->id ) ) {
		$widget_id = (string) $widget->id;
	}

	if ( $widget_id && function_exists( 'feedbuzz_is_latest_posts_widget_id' ) && feedbuzz_is_latest_posts_widget_id( $widget_id ) ) {
		return false;
	}

	return $instance;
}
add_filter( 'widget_display_callback', 'feedbuzz_filter_homepage_latest_posts_widget_output', 20, 3 );


/**
 * Suppress the default recent-comments widget output on the homepage primary sidebar.
 *
 * The theme renders its own designed recent-comments block in that location.
 *
 * @param array|false         $instance Widget settings.
 * @param WP_Widget           $widget   Widget instance.
 * @param array<string,mixed> $args     Dynamic sidebar display arguments.
 * @return array|false
 */
function feedbuzz_filter_homepage_recent_comments_widget_output( $instance, $widget, $args ) {
	if ( is_admin() || ! ( is_front_page() || is_home() ) ) {
		return $instance;
	}

	if ( empty( $args['id'] ) || 'primary-sidebar' !== $args['id'] ) {
		return $instance;
	}

	$widget_id = '';

	if ( ! empty( $args['widget_id'] ) ) {
		$widget_id = (string) $args['widget_id'];
	} elseif ( isset( $widget->id ) ) {
		$widget_id = (string) $widget->id;
	}

	if ( $widget_id && function_exists( 'feedbuzz_is_recent_comments_widget_id' ) && feedbuzz_is_recent_comments_widget_id( $widget_id ) ) {
		return false;
	}

	return $instance;
}
add_filter( 'widget_display_callback', 'feedbuzz_filter_homepage_recent_comments_widget_output', 21, 3 );
