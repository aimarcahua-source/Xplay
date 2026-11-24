<?php
/**
 * Template helper functions.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render a small inline SVG icon from an allowlist.
 *
 * @param string $name Icon name.
 * @param string $class Optional class.
 * @return void
 */
function feedbuzz_icon( $name, $class = '' ) {
	$icons = array(
		'menu'     => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'close'    => '<path d="M6 6l12 12M18 6 6 18"/>',
		'search'   => '<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>',
		'arrow'    => '<path d="M5 12h14M14 7l5 5-5 5"/>',
		'clock'    => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
		'flash'    => '<path d="m13 2-8 12h7l-1 8 8-12h-7l1-8Z"/>',
		'comment'  => '<path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4Z"/>',
		'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/>',
		'tag'      => '<path d="M20 13 13 20 4 11V4h7l9 9Z"/><circle cx="8.5" cy="8.5" r="1.3"/>',
		'link'     => '<path d="M10 13a5 5 0 0 0 7.5.5l2-2a5 5 0 0 0-7-7l-1.15 1.15"/><path d="M14 11a5 5 0 0 0-7.5-.5l-2 2a5 5 0 0 0 7 7l1.15-1.15"/>',
		'home-solid'     => '<path d="M2.6 10.7 12 2.8l9.4 7.9-1.9 2.2-1.3-1.1V21h-5v-5.5h-2.4V21h-5v-9.2l-1.3 1.1-1.9-2.2Z" fill="currentColor" stroke="none"/>',
		'star-solid'     => '<path d="m12 2.4 2.9 5.9 6.5.9-4.7 4.6 1.1 6.5-5.8-3-5.8 3 1.1-6.5-4.7-4.6 6.5-.9L12 2.4Z" fill="currentColor" stroke="none"/>',
		'flash-solid'    => '<path d="M13.2 1.5 4.5 13.7h6.7l-.8 8.8 9.1-13.1h-6.8l.5-7.9Z" fill="currentColor" stroke="none"/>',
		'crown-solid'    => '<path d="m3 7 4.5 3L12 3l4.5 7L21 7l-1.8 10H4.8L3 7Zm2.1 12h13.8v2H5.1v-2Z" fill="currentColor" stroke="none"/>',
		'monitor-solid'  => '<rect x="2.5" y="4" width="19" height="13" rx="1.5"/><path d="M8 21h8M12 17v4"/>',
		'shirt-solid'    => '<path d="m8.2 3 3.8 2 3.8-2 5.4 3.7-2.8 4.2-2-1.1V22H7.6V9.8l-2 1.1-2.8-4.2L8.2 3Z" fill="currentColor" stroke="none"/>',
		'cosmetic-solid' => '<path d="M9 2h6v3H9V2Zm-1 4h8l1.5 3.5V21h-11V9.5L8 6Zm2.1 5v6h3.8v-6h-3.8Z" fill="currentColor" stroke="none"/>',
		'dumbbell-solid' => '<path d="M2 9h2V7h3v4h10V7h3v2h2v6h-2v2h-3v-4H7v4H4v-2H2V9Z" fill="currentColor" stroke="none"/>',
		'tag-solid'      => '<path d="M3 4v7.4L12.6 21 21 12.6 11.4 3H4a1 1 0 0 0-1 1Zm5 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4Z" fill="currentColor" stroke="none"/>',
		'grid-solid'     => '<circle cx="5" cy="5" r="2" fill="currentColor" stroke="none"/><circle cx="12" cy="5" r="2" fill="currentColor" stroke="none"/><circle cx="19" cy="5" r="2" fill="currentColor" stroke="none"/><circle cx="5" cy="12" r="2" fill="currentColor" stroke="none"/><circle cx="12" cy="12" r="2" fill="currentColor" stroke="none"/><circle cx="19" cy="12" r="2" fill="currentColor" stroke="none"/><circle cx="5" cy="19" r="2" fill="currentColor" stroke="none"/><circle cx="12" cy="19" r="2" fill="currentColor" stroke="none"/><circle cx="19" cy="19" r="2" fill="currentColor" stroke="none"/>',
		'facebook' => '<path d="M14 8h3V4h-3c-3 0-5 2-5 5v3H6v4h3v6h4v-6h3l1-4h-4V9c0-.6.4-1 1-1Z"/>',
		'x'        => '<path d="M5 4l14 16M19 4 5 20"/>',
		'instagram'=> '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>',
		'youtube'  => '<path d="M22 12s0-4-1-6c-.5-1-1.5-1.5-2.5-1.7C16 4 12 4 12 4s-4 0-6.5.3C4.5 4.5 3.5 5 3 6c-1 2-1 6-1 6s0 4 1 6c.5 1 1.5 1.5 2.5 1.7C8 20 12 20s4 0 6.5-.3c1-.2 2-.7 2.5-1.7 1-2 1-6 1-6Z"/><path d="m10 9 5 3-5 3Z" fill="currentColor" stroke="none"/>',
	);

	if ( ! isset( $icons[ $name ] ) ) {
		return;
	}

	printf(
		'<svg class="fb-icon %1$s" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">%2$s</svg>',
		esc_attr( $class ),
		$icons[ $name ] // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static allowlisted SVG paths.
	);
}

/**
 * Add a decorative icon to each top-level primary navigation label.
 *
 * Icon selection follows common menu labels and falls back to menu order so
 * custom WordPress menus still retain the reference design's visual rhythm.
 *
 * @param string   $title Menu item title.
 * @param WP_Post  $item  Menu item data.
 * @param stdClass $args  Menu arguments.
 * @param int      $depth Menu depth.
 * @return string
 */
function feedbuzz_primary_menu_item_icon( $title, $item, $args, $depth ) {
	if ( 0 !== $depth || empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $title;
	}

	$label     = strtolower( remove_accents( wp_strip_all_tags( $item->title ) ) );
	$item_path = untrailingslashit( (string) wp_parse_url( $item->url, PHP_URL_PATH ) );
	$home_path = untrailingslashit( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ) );
	$icon      = '';

	$icon_keywords = array(
		'home-solid'     => array( 'ana sayfa', 'anasayfa', 'home', 'ev & yasam', 'ev ve yasam', 'home & living' ),
		'star-solid'     => array( 'yeni gelen', 'new arrival', 'latest' ),
		'flash-solid'    => array( 'flas', 'indirim', 'deal', 'sale' ),
		'crown-solid'    => array( 'cok satan', 'best seller', 'popular' ),
		'monitor-solid'  => array( 'elektronik', 'technology', 'teknoloji' ),
		'shirt-solid'    => array( 'moda', 'fashion', 'giyim' ),
		'cosmetic-solid' => array( 'kozmetik', 'beauty', 'bakim' ),
		'dumbbell-solid' => array( 'spor', 'sport', 'fitness' ),
		'tag-solid'      => array( 'marka', 'brand' ),
		'grid-solid'     => array( 'tum kategori', 'all categor' ),
	);

	if ( $item_path === $home_path ) {
		$icon = 'home-solid';
	} else {
		foreach ( $icon_keywords as $candidate_icon => $keywords ) {
			foreach ( $keywords as $keyword ) {
				if ( false !== strpos( $label, $keyword ) ) {
					$icon = $candidate_icon;
					break 2;
				}
			}
		}
	}

	if ( ! $icon ) {
		$fallback_icons = array( 'home-solid', 'star-solid', 'flash-solid', 'crown-solid', 'monitor-solid', 'shirt-solid', 'home-solid', 'cosmetic-solid', 'dumbbell-solid', 'tag-solid', 'grid-solid' );
		$position       = max( 0, (int) $item->menu_order - 1 );
		$icon           = $fallback_icons[ $position % count( $fallback_icons ) ];
	}

	ob_start();
	feedbuzz_icon( $icon, 'fb-menu-glyph fb-menu-glyph-' . $icon );
	$icon_markup = ob_get_clean();

	return $icon_markup . '<span class="fb-menu-label">' . $title . '</span>';
}
add_filter( 'nav_menu_item_title', 'feedbuzz_primary_menu_item_icon', 10, 4 );


/**
 * Normalize a menu label for comparisons.
 *
 * @param string $label Raw label.
 * @return string
 */
function feedbuzz_normalize_menu_label( $label ) {
	$label = strtolower( remove_accents( wp_strip_all_tags( (string) $label ) ) );
	$label = preg_replace( '/\s+/', ' ', trim( $label ) );

	return is_string( $label ) ? $label : '';
}

/**
 * Adjust the primary menu so category-driven labels behave like the requested header UX.
 *
 * If the first top-level item is labeled "Genel", it becomes the homepage link
 * labeled "Anasayfa". A top-level item labeled "Tüm kategoriler" is kept as
 * the dedicated overflow trigger; JavaScript fills its submenu only with primary
 * menu items that do not fit on the desktop row.
 *
 * @param WP_Post[] $items Menu items.
 * @param stdClass  $args  wp_nav_menu() arguments.
 * @return WP_Post[]
 */
function feedbuzz_filter_primary_menu_objects( $items, $args ) {
	if ( is_admin() || empty( $args->theme_location ) || 'primary' !== $args->theme_location || empty( $items ) ) {
		return $items;
	}

	$first_top_level_handled = false;

	foreach ( $items as $item ) {
		if ( ! isset( $item->menu_item_parent ) || 0 !== (int) $item->menu_item_parent ) {
			continue;
		}

		$normalized = feedbuzz_normalize_menu_label( $item->title );

		if ( ! $first_top_level_handled ) {
			$first_top_level_handled = true;

			if ( 'genel' === $normalized ) {
				$item->title   = __( 'Home', 'feedbuzz' );
				$item->url     = home_url( '/' );
				$item->classes = is_array( $item->classes ) ? $item->classes : array();
				$item->classes[] = 'fb-menu-home';
			}
		}

		if ( in_array( $normalized, array( 'tum kategoriler', 'all categories' ), true ) ) {
			$item->title     = __( 'All categories', 'feedbuzz' );
			$item->classes   = is_array( $item->classes ) ? $item->classes : array();
			$item->classes[] = 'fb-open-all-categories';
			$item->url       = '#';
		}
	}

	/*
	 * WordPress calculates current/ancestor menu classes before this filter.
	 * Because the first "Genel" item is converted into the homepage link above,
	 * an old current-menu-item class can otherwise remain attached to Anasayfa.
	 * Also, category hierarchy can mark another top-level item as
	 * current-menu-ancestor. The header design treats those classes like an
	 * exact selection, which makes several buttons look selected at once.
	 *
	 * Normalize only the top-level primary navigation: Anasayfa is current only
	 * on the actual front page, parent/ancestor items are not rendered as the
	 * selected button, and at most one exact top-level current item is kept.
	 */
	$home_url                  = untrailingslashit( home_url( '/' ) );
	$is_front_page             = is_front_page();
	$current_top_level_claimed = false;
	$ancestor_classes          = array(
		'current-menu-parent',
		'current-menu-ancestor',
		'current_page_parent',
		'current_page_ancestor',
	);
	$exact_current_classes     = array( 'current-menu-item', 'current_page_item' );

	foreach ( $items as $item ) {
		if ( ! isset( $item->menu_item_parent ) || 0 !== (int) $item->menu_item_parent ) {
			continue;
		}

		$classes      = isset( $item->classes ) && is_array( $item->classes ) ? $item->classes : array();
		$item_url     = untrailingslashit( (string) $item->url );
		$is_home_link = $item_url === $home_url;

		// This flat top-level header highlights only the exact current destination.
		$classes = array_values( array_diff( $classes, $ancestor_classes ) );
		$item->current_item_parent   = false;
		$item->current_item_ancestor = false;

		if ( $is_home_link ) {
			if ( ! in_array( 'fb-menu-home', $classes, true ) ) {
				$classes[] = 'fb-menu-home';
			}

			// Remove any stale category/page current state inherited before URL rewrite.
			$classes       = array_values( array_diff( $classes, $exact_current_classes ) );
			$item->current = false;

			if ( $is_front_page && ! $current_top_level_claimed ) {
				$classes[]                 = 'current-menu-item';
				$item->current             = true;
				$current_top_level_claimed = true;
			}
		} else {
			$is_exact_current = in_array( 'current-menu-item', $classes, true ) || in_array( 'current_page_item', $classes, true );

			if ( $is_front_page || ( $is_exact_current && $current_top_level_claimed ) ) {
				$classes       = array_values( array_diff( $classes, $exact_current_classes ) );
				$item->current = false;
			} elseif ( $is_exact_current ) {
				if ( ! in_array( 'current-menu-item', $classes, true ) ) {
					$classes[] = 'current-menu-item';
				}
				$item->current             = true;
				$current_top_level_claimed = true;
			}
		}

		$item->classes = array_values( array_unique( $classes ) );
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'feedbuzz_filter_primary_menu_objects', 10, 2 );

/**
 * Add trigger attributes to the synthetic "All categories" primary nav item.
 *
 * @param array    $atts  Link attributes.
 * @param WP_Post  $item  Menu item object.
 * @param stdClass $args  wp_nav_menu() args.
 * @param int      $depth Menu depth.
 * @return array
 */
function feedbuzz_primary_menu_link_attributes( $atts, $item, $args, $depth ) {
	if ( 0 !== (int) $depth || empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $atts;
	}

	$item_classes = isset( $item->classes ) && is_array( $item->classes ) ? $item->classes : array();

	if ( in_array( 'fb-open-all-categories', $item_classes, true ) ) {
		$atts['href']                   = '#';
		$atts['data-fb-overflow-menu'] = 'true';
		$atts['aria-haspopup']          = 'true';
		$atts['aria-expanded']          = 'false';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'feedbuzz_primary_menu_link_attributes', 10, 4 );

/**
 * Return a display-safe post title with an accessible fallback.
 *
 * @param int    $post_id Post ID.
 * @param string $fallback Optional fallback title.
 * @return string
 */
function feedbuzz_get_post_display_title( $post_id = 0, $fallback = '' ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	$title   = get_the_title( $post_id );

	if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
		if ( $fallback ) {
			$title = $fallback;
		} elseif ( 'page' === get_post_type( $post_id ) ) {
			$title = __( 'Untitled page', 'feedbuzz' );
		} else {
			$title = __( 'Untitled post', 'feedbuzz' );
		}
	}

	return $title;
}

/**
 * Return an accessible label for a post card link.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function feedbuzz_get_post_link_label( $post_id = 0 ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	$title   = feedbuzz_get_post_display_title( $post_id );

	return sprintf(
		/* translators: %s: Post title. */
		__( 'Read “%s”', 'feedbuzz' ),
		$title
	);
}

/**
 * Return a post category badge.
 *
 * @param int $post_id Post ID.
 * @return void
 */
function feedbuzz_category_badge( $post_id = 0 ) {
	$categories = get_the_category( $post_id );
	if ( empty( $categories ) ) {
		return;
	}
	$category    = $categories[0];
	$color_index = ( (int) $category->term_id % 6 ) + 1;
	printf(
		'<a class="fb-category-badge fb-category-color-%3$d" href="%1$s">%2$s</a>',
		esc_url( get_category_link( $category->term_id ) ),
		esc_html( $category->name ),
		(int) $color_index
	);
}

/**
 * Render post meta.
 *
 * @param bool $show_author Show author.
 * @return void
 */
function feedbuzz_post_meta( $show_author = true ) {
	echo '<div class="fb-post-meta">';
	if ( $show_author ) {
		feedbuzz_icon( 'user' );
		printf(
			'<span class="fb-post-author"><a href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
	feedbuzz_icon( 'clock' );
	printf( '<time datetime="%1$s">%2$s</time>', esc_attr( get_the_date( DATE_W3C ) ), esc_html( get_the_date() ) );
	echo '</div>';
}

/**
 * Get a thumbnail or decorative fallback.
 *
 * @param string $size Image size.
 * @param string $class CSS class.
 * @return void
 */
function feedbuzz_post_media( $size = 'feedbuzz-card', $class = '' ) {
	echo '<div class="fb-post-media ' . esc_attr( $class ) . '">';
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( $size, array( 'loading' => 'lazy' ) );
	} else {
		echo '<div class="fb-image-fallback" aria-hidden="true"><span></span><span></span><span></span></div>';
	}
	echo '</div>';
}

/**
 * Estimate reading time.
 *
 * @param int $post_id Post ID.
 * @return int
 */
function feedbuzz_reading_time( $post_id = 0 ) {
	$content = wp_strip_all_tags( (string) get_post_field( 'post_content', $post_id ? $post_id : get_the_ID() ) );
	$words   = preg_match_all( "/[\p{L}\p{N}]+(?:[’'-][\p{L}\p{N}]+)*/u", $content, $matches );

	if ( false === $words ) {
		$words = str_word_count( $content );
	}

	return max( 1, (int) ceil( $words / 220 ) );
}

/**
 * Normalize a navigation label or page title for reliable comparisons.
 *
 * @param string $value Raw label, title, slug, or URL path.
 * @return string
 */
function feedbuzz_normalize_navigation_text( $value ) {
	$value = wp_strip_all_tags( (string) $value );
	$value = strtr(
		$value,
		array(
			'ı' => 'i',
			'İ' => 'i',
			'ş' => 's',
			'Ş' => 's',
			'ğ' => 'g',
			'Ğ' => 'g',
			'ü' => 'u',
			'Ü' => 'u',
			'ö' => 'o',
			'Ö' => 'o',
			'ç' => 'c',
			'Ç' => 'c',
		)
	);
	$value = remove_accents( $value );
	$value = strtolower( $value );
	$value = preg_replace( '/[^a-z0-9]+/', ' ', $value );

	return trim( preg_replace( '/\s+/', ' ', (string) $value ) );
}

/**
 * Find a real WordPress destination for a standard navigation item.
 *
 * Existing navigation-menu items are preferred. Published pages are then
 * checked by both slug and title. The theme never creates virtual pages or
 * links a menu label to an unrelated section anchor.
 *
 * @param string[] $keywords Candidate labels, titles, or slug fragments.
 * @return string Destination URL, or an empty string when none exists.
 */
function feedbuzz_find_standard_destination( $keywords ) {
	$keywords = array_values(
		array_filter(
			array_map( 'feedbuzz_normalize_navigation_text', (array) $keywords )
		)
	);

	if ( empty( $keywords ) ) {
		return '';
	}

	$menus = wp_get_nav_menus();
	foreach ( $menus as $menu ) {
		$items = wp_get_nav_menu_items( $menu->term_id );
		if ( ! is_array( $items ) ) {
			continue;
		}

		foreach ( $items as $item ) {
			$haystacks = array(
				feedbuzz_normalize_navigation_text( $item->title ),
				feedbuzz_normalize_navigation_text( $item->attr_title ),
				feedbuzz_normalize_navigation_text( wp_parse_url( $item->url, PHP_URL_PATH ) ),
			);

			foreach ( $keywords as $keyword ) {
				foreach ( $haystacks as $haystack ) {
					if ( $haystack && ( $haystack === $keyword || false !== strpos( $haystack, $keyword ) ) ) {
						return esc_url_raw( $item->url );
					}
				}
			}
		}
	}

	foreach ( $keywords as $keyword ) {
		$slug = sanitize_title( $keyword );
		if ( ! $slug ) {
			continue;
		}

		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
			return get_permalink( $page );
		}
	}

	$pages = get_pages(
		array(
			'post_status' => 'publish',
			'sort_column' => 'menu_order,post_title',
		)
	);

	foreach ( $pages as $page ) {
		$haystacks = array(
			feedbuzz_normalize_navigation_text( $page->post_name ),
			feedbuzz_normalize_navigation_text( $page->post_title ),
		);

		foreach ( $keywords as $keyword ) {
			foreach ( $haystacks as $haystack ) {
				if ( $haystack && ( $haystack === $keyword || false !== strpos( $haystack, $keyword ) ) ) {
					return get_permalink( $page );
				}
			}
		}
	}

	return '';
}

/**
 * Return short, standard utility links backed by real WordPress destinations.
 *
 * The theme does not create pages and does not list every published page.
 * Missing destinations are omitted instead of producing dead links.
 *
 * @return array<int,array{label:string,url:string}>
 */
function feedbuzz_get_standard_utility_links() {
	$links = array(
		array(
			'label' => __( 'Home', 'feedbuzz' ),
			'url'   => home_url( '/' ),
		),
	);

	$about_url = feedbuzz_find_standard_destination(
		array(
			'hakkımızda',
			'hakkimizda',
			'biz kimiz',
			'kurumsal',
			'about us',
			'about',
		)
	);
	if ( $about_url ) {
		$links[] = array(
			'label' => __( 'About Us', 'feedbuzz' ),
			'url'   => $about_url,
		);
	}

	$contact_url = feedbuzz_find_standard_destination(
		array(
			'iletişim',
			'iletisim',
			'bize ulaşın',
			'bize ulasin',
			'contact us',
			'contact',
		)
	);
	if ( $contact_url ) {
		$links[] = array(
			'label' => __( 'Contact', 'feedbuzz' ),
			'url'   => $contact_url,
		);
	}

	$posts_page_id = absint( get_option( 'page_for_posts' ) );
	if ( $posts_page_id && 'publish' === get_post_status( $posts_page_id ) ) {
		$links[] = array(
			'label' => __( 'Blog', 'feedbuzz' ),
			'url'   => get_permalink( $posts_page_id ),
		);
	}

	$privacy_page_id = absint( get_option( 'wp_page_for_privacy_policy' ) );
	if ( $privacy_page_id && 'publish' === get_post_status( $privacy_page_id ) ) {
		$links[] = array(
			'label' => __( 'Privacy Policy', 'feedbuzz' ),
			'url'   => get_permalink( $privacy_page_id ),
		);
	}

	return $links;
}

/**
 * Render the standard utility-link fallback.
 *
 * @param string $menu_class CSS class for the generated list.
 * @return void
 */
function feedbuzz_utility_menu_fallback( $menu_class = 'fb-utility-menu-list' ) {
	if ( is_object( $menu_class ) && isset( $menu_class->menu_class ) ) {
		$menu_class = $menu_class->menu_class;
	} elseif ( is_array( $menu_class ) && isset( $menu_class['menu_class'] ) ) {
		$menu_class = $menu_class['menu_class'];
	}

	$menu_class = is_string( $menu_class ) && $menu_class ? $menu_class : 'fb-utility-menu-list';
	$links      = feedbuzz_get_standard_utility_links();

	if ( empty( $links ) ) {
		return;
	}

	printf( '<ul class="%s">', esc_attr( $menu_class ) );
	foreach ( $links as $link ) {
		printf(
			'<li><a href="%1$s">%2$s</a></li>',
			esc_url( $link['url'] ),
			esc_html( $link['label'] )
		);
	}
	echo '</ul>';
}

/**
 * Render live post categories when no managed category dropdown menu is assigned.
 *
 * This fallback intentionally uses categories instead of WordPress pages. The
 * horizontal primary navigation itself has no fallback and is therefore always
 * controlled by Appearance > Menus.
 *
 * @param string $menu_class CSS class for the generated list.
 * @return void
 */
function feedbuzz_category_menu_fallback( $menu_class = 'fb-category-menu-list' ) {
	$menu_class = is_string( $menu_class ) && $menu_class ? $menu_class : 'fb-category-menu-list';

	echo '<ul class="' . esc_attr( $menu_class ) . '">';
	wp_list_categories(
		array(
			'title_li'   => '',
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'depth'      => 2,
		)
	);
	echo '</ul>';
}

/**
 * Backward-compatible primary menu fallback.
 *
 * Kept for child themes or third-party code that may call the old callback. It
 * no longer outputs pages; it outputs post categories instead.
 *
 * @return void
 */
function feedbuzz_menu_fallback() {
	echo '<ul class="fb-nav-list">';
	echo '<li class="menu-item menu-item-home"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'feedbuzz' ) . '</a></li>';
	$categories = get_categories(
		array(
			'taxonomy'   => 'category',
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'parent'     => 0,
		)
	);

	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		foreach ( $categories as $category ) {
			if ( 'genel' === feedbuzz_normalize_menu_label( $category->name ) ) {
				continue;
			}

			echo '<li class="menu-item menu-item-type-taxonomy menu-item-object-category"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
		}
	}

	echo '<li class="menu-item fb-open-all-categories"><a href="#" data-fb-overflow-menu="true" aria-haspopup="true" aria-expanded="false">' . esc_html__( 'All categories', 'feedbuzz' ) . '</a></li>';
	echo '</ul>';
}

/**
 * Render a registered widget area.
 *
 * @param string $sidebar_id Registered sidebar ID.
 * @return bool Whether the sidebar produced output.
 */
function feedbuzz_dynamic_sidebar( $sidebar_id ) {
	if ( ! is_active_sidebar( $sidebar_id ) ) {
		return false;
	}

	return dynamic_sidebar( $sidebar_id );
}


/**
 * Check whether the current front-end locale is Turkish.
 *
 * @return bool
 */
function feedbuzz_is_turkish_locale() {
	$locale = function_exists( 'determine_locale' ) ? determine_locale() : get_locale();
	$locale = strtolower( str_replace( '-', '_', (string) $locale ) );

	return 0 === strpos( $locale, 'tr' );
}

/**
 * Return a locale-aware label for common WordPress core widgets.
 *
 * WordPress normally supplies these translations from the core language pack.
 * This small front-end fallback keeps Turkish sites consistent even when a
 * hosting installation is missing or has not refreshed that core language
 * pack. Other locales continue to use WordPress' own translation system.
 *
 * @param string $source English WordPress core label.
 * @return string
 */
function feedbuzz_get_core_widget_label( $source ) {
	$turkish_labels = array(
		'Recent Posts'    => 'Son Yazılar',
		'Recent Comments' => 'Son yorumlar',
		'Archives'        => 'Arşivler',
		'Categories'      => 'Kategoriler',
		'Search'          => 'Ara',
		'Pages'           => 'Sayfalar',
		'Tag Cloud'       => 'Etiket Bulutu',
		'Calendar'        => 'Takvim',
		'Meta'            => 'Meta',
		'Select Category' => 'Kategori seç',
		'Select Month'    => 'Ay seç',
	);

	if ( feedbuzz_is_turkish_locale() && isset( $turkish_labels[ $source ] ) ) {
		return $turkish_labels[ $source ];
	}

	return translate( $source, 'default' );
}

/**
 * Provide a Turkish front-end fallback for common WordPress core widget text.
 *
 * This is deliberately limited to a short allowlist of standard core labels;
 * user content and custom widget copy are never rewritten.
 *
 * @param string $translated Translated text.
 * @param string $text       Source text.
 * @param string $domain     Text domain.
 * @return string
 */
function feedbuzz_turkish_core_widget_gettext( $translated, $text, $domain ) {
	if ( is_admin() || 'default' !== $domain || ! feedbuzz_is_turkish_locale() ) {
		return $translated;
	}

	$labels = array(
		'Recent Posts',
		'Recent Comments',
		'Archives',
		'Categories',
		'Search',
		'Pages',
		'Tag Cloud',
		'Calendar',
		'Meta',
		'Select Category',
		'Select Month',
	);

	if ( in_array( $text, $labels, true ) ) {
		return feedbuzz_get_core_widget_label( $text );
	}

	return $translated;
}
add_filter( 'gettext', 'feedbuzz_turkish_core_widget_gettext', 20, 3 );

/**
 * Normalize standard widget titles saved in either English or Turkish.
 *
 * Exact known WordPress labels are localized to the active locale. Custom
 * widget titles are left untouched.
 *
 * @param string $title    Widget title.
 * @param array  $instance Widget settings.
 * @param string $id_base  Widget base ID.
 * @return string
 */
function feedbuzz_translate_legacy_core_widget_title( $title, $instance = array(), $id_base = '' ) {
	if ( ! is_string( $title ) || '' === trim( $title ) ) {
		return $title;
	}

	$normalized_title = strtolower( remove_accents( wp_strip_all_tags( trim( $title ) ) ) );
	$normalized_title = preg_replace( '/\s+/u', ' ', $normalized_title );

	$known_titles = array(
		'recent comments' => 'Recent Comments',
		'son yorumlar'     => 'Recent Comments',
		'recent posts'    => 'Recent Posts',
		'son yazilar'     => 'Recent Posts',
		'categories'      => 'Categories',
		'kategoriler'     => 'Categories',
		'search'          => 'Search',
		'ara'             => 'Search',
		'arama'           => 'Search',
		'archives'        => 'Archives',
		'arsivler'        => 'Archives',
		'pages'           => 'Pages',
		'sayfalar'        => 'Pages',
		'tag cloud'       => 'Tag Cloud',
		'etiket bulutu'   => 'Tag Cloud',
		'calendar'        => 'Calendar',
		'takvim'          => 'Calendar',
		'meta'            => 'Meta',
	);

	if ( ! isset( $known_titles[ $normalized_title ] ) ) {
		return $title;
	}

	return feedbuzz_get_core_widget_label( $known_titles[ $normalized_title ] );
}
add_filter( 'widget_title', 'feedbuzz_translate_legacy_core_widget_title', 10, 3 );

/**
 * Localize standard headings stored as literal block-widget content.
 *
 * @param string $content  Rendered block-widget content.
 * @param array  $instance Widget settings.
 * @param object $widget   Widget object.
 * @return string
 */
function feedbuzz_translate_legacy_block_widget_headings( $content, $instance = array(), $widget = null ) {
	if ( ! is_string( $content ) || '' === $content ) {
		return $content;
	}

	$raw_content = '';
	if ( is_array( $instance ) && isset( $instance['content'] ) && is_string( $instance['content'] ) ) {
		$raw_content = $instance['content'];
	}

	if ( '' === $raw_content || false === strpos( $raw_content, 'wp:' ) ) {
		return $content;
	}

	$heading_groups = array(
		'Recent Comments' => array( 'Recent Comments', 'Son yorumlar', 'Son Yorumlar' ),
		'Recent Posts'    => array( 'Recent Posts', 'Son Yazılar', 'Son yazılar' ),
		'Archives'        => array( 'Archives', 'Arşivler' ),
		'Categories'      => array( 'Categories', 'Kategoriler' ),
		'Search'          => array( 'Search', 'Ara', 'Arama' ),
		'Pages'           => array( 'Pages', 'Sayfalar' ),
		'Tag Cloud'       => array( 'Tag Cloud', 'Etiket Bulutu' ),
		'Calendar'        => array( 'Calendar', 'Takvim' ),
	);

	foreach ( $heading_groups as $source => $variants ) {
		$translated_heading = feedbuzz_get_core_widget_label( $source );

		foreach ( $variants as $heading ) {
			$pattern = '/(<h[1-6]\b[^>]*>\s*)' . preg_quote( $heading, '/' ) . '(\s*<\/h[1-6]>)/iu';
			$content = preg_replace( $pattern, '$1' . esc_html( $translated_heading ) . '$2', $content );
		}
	}

	return $content;
}
add_filter( 'widget_block_content', 'feedbuzz_translate_legacy_block_widget_headings', 10, 3 );

/**
 * Display the untouched default WordPress category name in Turkish on Turkish
 * front ends without modifying the term stored in the database.
 *
 * @param array $terms      Term results.
 * @param array $taxonomies Taxonomy names.
 * @param array $args       Query arguments.
 * @param object $term_query Term query object.
 * @return array
 */
function feedbuzz_translate_default_category_display( $terms, $taxonomies, $args, $term_query ) {
	if ( is_admin() || ! feedbuzz_is_turkish_locale() || ! is_array( $terms ) || ! in_array( 'category', (array) $taxonomies, true ) ) {
		return $terms;
	}

	foreach ( $terms as $index => $term ) {
		if ( $term instanceof WP_Term && 'uncategorized' === $term->slug && 'Uncategorized' === $term->name ) {
			$localized_term       = clone $term;
			$localized_term->name = 'Genel';
			$terms[ $index ]      = $localized_term;
		}
	}

	return $terms;
}
add_filter( 'get_terms', 'feedbuzz_translate_default_category_display', 10, 4 );

/**
 * Localize WordPress' untouched starter post title on Turkish front ends.
 *
 * This affects only the exact default hello-world starter post and does not
 * modify the stored post title or arbitrary user content.
 *
 * @param string $title   Post title.
 * @param int    $post_id Post ID.
 * @return string
 */
function feedbuzz_translate_default_starter_post_title( $title, $post_id = 0 ) {
	if ( is_admin() || ! feedbuzz_is_turkish_locale() || 'Hello world!' !== trim( (string) $title ) || ! $post_id ) {
		return $title;
	}

	if ( 'hello-world' === get_post_field( 'post_name', $post_id ) ) {
		return 'Merhaba dünya!';
	}

	return $title;
}
add_filter( 'the_title', 'feedbuzz_translate_default_starter_post_title', 20, 2 );

/**
 * Localize WordPress' untouched starter comment author on Turkish front ends.
 *
 * @param string     $author     Comment author.
 * @param string|int $comment_id Comment ID.
 * @param WP_Comment $comment    Comment object.
 * @return string
 */
function feedbuzz_translate_default_starter_comment_author( $author, $comment_id = 0, $comment = null ) {
	if ( is_admin() || ! feedbuzz_is_turkish_locale() || 'A WordPress Commenter' !== trim( (string) $author ) ) {
		return $author;
	}

	return 'Bir WordPress yorumcusu';
}
add_filter( 'get_comment_author', 'feedbuzz_translate_default_starter_comment_author', 20, 3 );

/**
 * Output a standard section title.
 *
 * @param string $title Title.
 * @param string $eyebrow Eyebrow.
 */
function feedbuzz_section_heading( $title, $eyebrow = '' ) {
	echo '<div class="fb-section-heading">';
	echo '<div>';
	if ( $eyebrow ) {
		echo '<span class="fb-eyebrow">' . esc_html( $eyebrow ) . '</span>';
	}
	echo '<h2>' . esc_html( $title ) . '</h2>';
	echo '</div><span class="fb-section-line" aria-hidden="true"></span></div>';
}


/**
 * Determine whether a widget ID is a latest-posts widget.
 *
 * Supports the classic Recent Posts widget and block widgets that contain the
 * core Latest Posts block markup.
 *
 * @param string $widget_id Sidebar widget instance ID.
 * @return bool
 */
function feedbuzz_is_latest_posts_widget_id( $widget_id ) {
	$widget_id = (string) $widget_id;

	if ( 0 === strpos( $widget_id, 'recent-posts-' ) ) {
		return true;
	}

	if ( 0 === strpos( $widget_id, 'block-' ) ) {
		$instance_number = (int) str_replace( 'block-', '', $widget_id );
		$block_widgets   = get_option( 'widget_block', array() );

		if ( isset( $block_widgets[ $instance_number ]['content'] ) ) {
			$block_content = (string) $block_widgets[ $instance_number ]['content'];

			if ( false !== strpos( $block_content, 'wp:latest-posts' ) ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Check whether a sidebar contains a latest-posts widget.
 *
 * @param string $sidebar_id Sidebar ID.
 * @return bool
 */
function feedbuzz_sidebar_has_latest_posts_widget( $sidebar_id ) {
	$sidebars_widgets = wp_get_sidebars_widgets();

	if ( empty( $sidebars_widgets[ $sidebar_id ] ) || ! is_array( $sidebars_widgets[ $sidebar_id ] ) ) {
		return false;
	}

	foreach ( $sidebars_widgets[ $sidebar_id ] as $widget_id ) {
		if ( feedbuzz_is_latest_posts_widget_id( $widget_id ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Return the public posts page URL.
 *
 * @return string
 */
function feedbuzz_get_posts_page_url() {
	$page_for_posts = absint( get_option( 'page_for_posts' ) );

	if ( $page_for_posts && 'publish' === get_post_status( $page_for_posts ) ) {
		$posts_page_url = get_permalink( $page_for_posts );

		if ( $posts_page_url ) {
			return (string) $posts_page_url;
		}
	}

	return (string) home_url( '/' );
}

/**
 * Render the designed latest-posts widget used on the homepage sidebar.
 *
 * @param int $count Number of posts.
 * @return void
 */
function feedbuzz_render_designed_latest_posts_widget( $count = 5 ) {
	$recent_posts = get_posts(
		array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'posts_per_page'         => max( 1, absint( $count ) ),
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	if ( empty( $recent_posts ) ) {
		return;
	}

	$archive_url = feedbuzz_get_posts_page_url();
	?>
	<section class="widget fb-widget fb-designed-latest-widget" aria-label="<?php esc_attr_e( 'Latest Posts', 'feedbuzz' ); ?>">
		<div class="fb-designed-latest-head">
			<div class="fb-designed-latest-titles">
				<h2 class="widget-title fb-designed-latest-title"><?php esc_html_e( 'Latest Posts', 'feedbuzz' ); ?></h2>
				<p class="fb-designed-latest-subtitle"><?php esc_html_e( 'Inspiring ideas for your home and tips for natural living.', 'feedbuzz' ); ?></p>
			</div>
			<a class="fb-designed-latest-all" href="<?php echo esc_url( $archive_url ); ?>"><?php esc_html_e( 'All Posts', 'feedbuzz' ); ?> <span aria-hidden="true">&rarr;</span></a>
		</div>
		<div class="fb-designed-latest-list">
			<?php foreach ( $recent_posts as $index => $recent_post ) : ?>
				<?php
				$category_name = '';
				$categories    = get_the_category( $recent_post->ID );

				if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
					$category_name = $categories[0]->name;
				}
				?>
				<article class="fb-designed-latest-item">
					<a class="fb-designed-latest-link" href="<?php echo esc_url( get_permalink( $recent_post ) ); ?>" aria-label="<?php echo esc_attr( feedbuzz_get_post_link_label( $recent_post->ID ) ); ?>">
						<span class="fb-designed-latest-thumb">
							<?php if ( has_post_thumbnail( $recent_post ) ) : ?>
								<?php echo get_the_post_thumbnail( $recent_post, 'feedbuzz-thumb', array( 'loading' => 'lazy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core-generated attachment markup. ?>
							<?php else : ?>
								<span class="fb-image-fallback" aria-hidden="true"><span></span><span></span><span></span></span>
							<?php endif; ?>
						</span>
						<span class="fb-designed-latest-copy">
							<strong><?php echo esc_html( feedbuzz_get_post_display_title( $recent_post->ID ) ); ?></strong>
							<span class="fb-designed-latest-meta">
								<span class="fb-designed-latest-date"><?php feedbuzz_icon( 'calendar' ); ?><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $recent_post ) ); ?>"><?php echo esc_html( get_the_date( 'j M Y', $recent_post ) ); ?></time></span>
								<?php if ( '' !== $category_name ) : ?>
									<span class="fb-designed-latest-category" title="<?php echo esc_attr( $category_name ); ?>"><?php feedbuzz_icon( 'tag' ); ?><span><?php echo esc_html( $category_name ); ?></span></span>
								<?php endif; ?>
							</span>
						</span>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}


/**
 * Determine whether a widget ID is a recent-comments widget.
 *
 * Supports the classic Recent Comments widget and block widgets that contain
 * the core Latest Comments block markup.
 *
 * @param string $widget_id Sidebar widget instance ID.
 * @return bool
 */
function feedbuzz_is_recent_comments_widget_id( $widget_id ) {
	$widget_id = (string) $widget_id;

	if ( 0 === strpos( $widget_id, 'recent-comments-' ) ) {
		return true;
	}

	if ( 0 === strpos( $widget_id, 'block-' ) ) {
		$instance_number = (int) str_replace( 'block-', '', $widget_id );
		$block_widgets   = get_option( 'widget_block', array() );

		if ( isset( $block_widgets[ $instance_number ]['content'] ) ) {
			$block_content = (string) $block_widgets[ $instance_number ]['content'];

			if ( false !== strpos( $block_content, 'wp:latest-comments' ) ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Check whether a sidebar contains a recent-comments widget.
 *
 * @param string $sidebar_id Sidebar ID.
 * @return bool
 */
function feedbuzz_sidebar_has_recent_comments_widget( $sidebar_id ) {
	$sidebars_widgets = wp_get_sidebars_widgets();

	if ( empty( $sidebars_widgets[ $sidebar_id ] ) || ! is_array( $sidebars_widgets[ $sidebar_id ] ) ) {
		return false;
	}

	foreach ( $sidebars_widgets[ $sidebar_id ] as $widget_id ) {
		if ( feedbuzz_is_recent_comments_widget_id( $widget_id ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Return a human-friendly comment age string.
 *
 * @param WP_Comment $comment Comment object.
 * @return string
 */
function feedbuzz_get_comment_age_label( $comment ) {
	$comment_time = (int) get_comment_date( 'U', $comment );
	$current_time = (int) current_time( 'timestamp' );
	$time_diff    = max( 0, $current_time - $comment_time );

	if ( $time_diff < HOUR_IN_SECONDS ) {
		return __( 'Just now', 'feedbuzz' );
	}

	return sprintf(
		/* translators: %s: Human readable time difference. */
		__( '%s ago', 'feedbuzz' ),
		human_time_diff( $comment_time, $current_time )
	);
}

/**
 * Render the designed recent-comments widget used on the homepage sidebar.
 *
 * @param int $count Number of comments to show.
 * @return void
 */
function feedbuzz_render_designed_recent_comments_widget( $count = 3 ) {
	$display_count    = max( 3, absint( $count ) );
	$recent_comments  = get_comments(
		array(
			'status'      => 'approve',
			'number'      => $display_count,
			'type'        => 'comment',
			'post_status' => 'publish',
		)
	);

	if ( empty( $recent_comments ) ) {
		return;
	}

	$visible_comments = array_slice( $recent_comments, 0, $display_count );

	if ( count( $visible_comments ) < $display_count ) {
		$seed_comments = $visible_comments;

		while ( count( $visible_comments ) < $display_count && ! empty( $seed_comments ) ) {
			foreach ( $seed_comments as $seed_comment ) {
				if ( count( $visible_comments ) >= $display_count ) {
					break;
				}

				$visible_comments[] = $seed_comment;
			}
		}
	}
	?>
	<section class="widget fb-widget fb-designed-recent-comments-widget" aria-label="<?php esc_attr_e( 'Recent Comments', 'feedbuzz' ); ?>">
		<div class="fb-designed-comments-head">
			<div class="fb-designed-comments-title-wrap">
				<span class="fb-designed-comments-badge" aria-hidden="true"><?php feedbuzz_icon( 'comment' ); ?></span>
				<span class="fb-designed-comments-heading">
					<h2 class="widget-title fb-designed-comments-title"><?php esc_html_e( 'Recent Comments', 'feedbuzz' ); ?></h2>
					<span class="fb-designed-comments-subtitle"><?php esc_html_e( 'Latest comments from our readers', 'feedbuzz' ); ?></span>
				</span>
			</div>
			<a class="fb-designed-comments-all" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'View all', 'feedbuzz' ); ?> <span aria-hidden="true">&rsaquo;</span></a>
		</div>

		<div class="fb-designed-comments-list">
			<?php foreach ( $visible_comments as $recent_comment ) : ?>
				<?php $comment_post_title = feedbuzz_get_post_display_title( $recent_comment->comment_post_ID ); ?>
				<article class="fb-designed-comments-item">
					<a class="fb-designed-comments-link" href="<?php echo esc_url( get_comment_link( $recent_comment ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'View comment by %1$s on %2$s', 'feedbuzz' ), wp_strip_all_tags( get_comment_author( $recent_comment ) ), wp_strip_all_tags( $comment_post_title ) ) ); ?>">
						<span class="fb-designed-comments-avatar" aria-hidden="true"><?php feedbuzz_icon( 'user' ); ?></span>
						<span class="fb-designed-comments-copy">
							<strong class="fb-designed-comments-author"><?php echo esc_html( get_comment_author( $recent_comment ) ); ?></strong>
							<span class="fb-designed-comments-context"><?php esc_html_e( 'commented on:', 'feedbuzz' ); ?></span>
							<span class="fb-designed-comments-post"><?php echo esc_html( $comment_post_title ); ?></span>
							<small class="fb-designed-comments-time"><?php echo esc_html( feedbuzz_get_comment_age_label( $recent_comment ) ); ?></small>
						</span>
						<span class="fb-designed-comments-arrow" aria-hidden="true">&rsaquo;</span>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

/**
 * Render the fixed Turkish footer reference link.
 *
 * The link is intentionally registered through a theme action so the footer
 * template remains presentation-focused. The anchor is visible, crawlable,
 * and uses the normal follow behavior (no nofollow/sponsored attribute).
 *
 * @return void
 */
function feedbuzz_render_footer_credit() {
	?>
	<a class="fb-footer-credit-link" href="<?php echo esc_url( 'https://narya.tr/' ); ?>">köpek maması &amp; kedi maması</a>
	<?php
}
add_action( 'feedbuzz_footer_credit', 'feedbuzz_render_footer_credit' );

