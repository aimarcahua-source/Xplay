<?php
/**
 * Site header.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options = feedbuzz_get_options();

$topbar_socials = array(
	array(
		'key'   => 'topbar_x_url',
		'icon'  => 'x',
		'label' => __( 'X', 'feedbuzz' ),
	),
	array(
		'key'   => 'topbar_facebook_url',
		'icon'  => 'facebook',
		'label' => __( 'Facebook', 'feedbuzz' ),
	),
	array(
		'key'   => 'topbar_instagram_url',
		'icon'  => 'instagram',
		'label' => __( 'Instagram', 'feedbuzz' ),
	),
	array(
		'key'   => 'topbar_youtube_url',
		'icon'  => 'youtube',
		'label' => __( 'YouTube', 'feedbuzz' ),
	),
);
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<noscript><style>.fb-nav-fit-pending{visibility:visible!important;}</style></noscript>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text fb-skip-link" href="#primary"><?php esc_html_e( 'Skip to content', 'feedbuzz' ); ?></a>
<div id="page" class="fb-site">
	<header class="fb-site-header fb-header-colormag">
		<?php if ( ! empty( $options['show_topbar'] ) ) : ?>
			<div class="fb-utilitybar">
				<div class="fb-container fb-utilitybar-inner">
					<div class="fb-utilitybar-left">
						<span class="fb-utility-date">
							<?php feedbuzz_icon( 'calendar' ); ?>
							<time datetime="<?php echo esc_attr( wp_date( 'c' ) ); ?>"><?php echo esc_html( wp_date( get_option( 'date_format' ) ) ); ?></time>
						</span>

						<nav class="fb-utility-menu" aria-label="<?php esc_attr_e( 'Utility menu', 'feedbuzz' ); ?>">
							<?php
							if ( has_nav_menu( 'utility' ) ) {
								wp_nav_menu(
									array(
										'theme_location' => 'utility',
										'container'      => false,
										'menu_class'     => 'fb-utility-menu-list',
										'depth'          => 1,
										'fallback_cb'    => false,
									)
								);
							} else {
								feedbuzz_utility_menu_fallback( 'fb-utility-menu-list' );
							}
							?>
						</nav>
					</div>

					<div class="fb-utilitybar-right">
						<div class="fb-utility-socials" role="group" aria-label="<?php esc_attr_e( 'Social links', 'feedbuzz' ); ?>">
							<?php foreach ( $topbar_socials as $social ) : ?>
								<?php
								$social_url = isset( $social['url'] ) ? $social['url'] : $options[ $social['key'] ];
								if ( ! $social_url ) {
									continue;
								}

								$social_rel   = isset( $social['rel'] ) ? $social['rel'] : 'nofollow noopener noreferrer';
								$social_label = sprintf(
									/* translators: %s: External website or social network name. */
									__( '%s (opens in a new tab)', 'feedbuzz' ),
									$social['label']
								);
								?>
								<a href="<?php echo esc_url( $social_url ); ?>" target="_blank" rel="<?php echo esc_attr( $social_rel ); ?>" title="<?php echo esc_attr( $social_label ); ?>" aria-label="<?php echo esc_attr( $social_label ); ?>">
									<?php feedbuzz_icon( $social['icon'] ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="fb-brandbar">
			<div class="fb-container fb-brandbar-inner fb-brandbar-layout">
				<button class="fb-icon-button fb-menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false">
					<span class="screen-reader-text"><?php esc_html_e( 'Open menu', 'feedbuzz' ); ?></span>
					<?php feedbuzz_icon( 'menu' ); ?>
				</button>

				<div class="fb-brand">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<?php
						$site_name         = get_bloginfo( 'name' );
						$default_logo_path = get_theme_file_path( 'assets/images/feedbuzz-logo.webp' );
						$default_logo_url  = get_theme_file_uri( 'assets/images/feedbuzz-logo.webp' );
						?>

						<?php if ( file_exists( $default_logo_path ) ) : ?>
							<a class="custom-logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<img class="custom-logo feedbuzz-default-logo" src="<?php echo esc_url( $default_logo_url ); ?>" alt="<?php echo esc_attr( $site_name ); ?>" width="560" height="187" decoding="async" fetchpriority="high">
							</a>
						<?php else : ?>
							<?php
							$plain_name = preg_replace( '/\s+/', '', wp_strip_all_tags( $site_name ) );
							$initials   = function_exists( 'mb_strtoupper' ) && function_exists( 'mb_substr' )
								? mb_strtoupper( mb_substr( $plain_name, 0, 2 ) )
								: strtoupper( substr( $plain_name, 0, 2 ) );
							?>
							<a class="fb-color-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<span class="fb-color-logo-mark"><?php echo esc_html( $initials ? $initials : 'PN' ); ?></span>
								<span class="fb-color-logo-text">
									<strong><?php echo esc_html( $site_name ); ?></strong>
								</span>
							</a>
						<?php endif; ?>
					<?php endif; ?>
				</div>

				<div class="fb-header-ad-slot">
					<?php
					$header_ad_id           = absint( $options['header_ad_image_id'] );
					$header_ad_url          = $options['header_ad_url'];
					$header_ad_alt          = $options['header_ad_alt'];
					$header_ad_target       = ! empty( $options['header_ad_new_tab'] ) ? '_blank' : '';
					$header_ad_rel          = ! empty( $options['header_ad_new_tab'] ) ? 'sponsored noopener noreferrer' : 'sponsored';
					$default_header_ad_url  = get_theme_file_uri( 'assets/images/header-banner-default.png' );
					$default_header_ad_path = get_theme_file_path( 'assets/images/header-banner-default.png' );
					$has_default_header_ad  = file_exists( $default_header_ad_path );

					if ( $header_ad_id && ! $header_ad_alt ) {
						$header_ad_alt = get_post_meta( $header_ad_id, '_wp_attachment_image_alt', true );
					}
					if ( ! $header_ad_alt ) {
						$header_ad_alt = __( 'Header advertisement', 'feedbuzz' );
					}
					?>

					<?php if ( ! empty( $options['show_header_ad'] ) && ( $header_ad_id || $has_default_header_ad ) ) : ?>
						<aside class="fb-header-ad" aria-label="<?php esc_attr_e( 'Advertisement', 'feedbuzz' ); ?>">
							<?php if ( $header_ad_url ) : ?>
								<a href="<?php echo esc_url( $header_ad_url ); ?>" rel="<?php echo esc_attr( $header_ad_rel ); ?>"<?php if ( $header_ad_target ) : ?> target="<?php echo esc_attr( $header_ad_target ); ?>"<?php endif; ?>>
								<?php if ( $header_ad_target ) : ?>
									<span class="screen-reader-text"><?php esc_html_e( 'Opens in a new tab.', 'feedbuzz' ); ?></span>
								<?php endif; ?>
							<?php endif; ?>
							<?php if ( $header_ad_id ) : ?>
								<?php
								echo wp_get_attachment_image(
									$header_ad_id,
									'feedbuzz-leaderboard',
									false,
									array(
										'class'   => 'fb-header-ad-image',
										'alt'     => $header_ad_alt,
										'loading' => 'eager',
									)
								); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Generated by wp_get_attachment_image().
								?>
							<?php else : ?>
								<img class="fb-header-ad-image" src="<?php echo esc_url( $default_header_ad_url ); ?>" alt="<?php echo esc_attr( $header_ad_alt ); ?>" loading="eager" decoding="sync">
							<?php endif; ?>
							<?php if ( $header_ad_url ) : ?>
								</a>
							<?php endif; ?>
						</aside>
					<?php else : ?>
						<span class="fb-header-ad-empty" aria-hidden="true"></span>
					<?php endif; ?>
				</div>

				<div class="fb-header-search" aria-label="<?php esc_attr_e( 'Header search', 'feedbuzz' ); ?>">
					<?php
					get_search_form(
						array(
							'aria_label'         => __( 'Header search', 'feedbuzz' ),
							'feedbuzz_variant' => 'header',
							'placeholder'        => __( 'Search the site…', 'feedbuzz' ),
						)
					);
					?>
				</div>
			</div>
		</div>

		<?php if ( get_header_image() ) : ?>
			<div class="fb-custom-header-media">
				<div class="fb-container">
					<img src="<?php echo esc_url( get_header_image() ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				</div>
			</div>
		<?php endif; ?>

		<div class="fb-navbar">
			<div class="fb-container fb-navbar-inner">
				<div class="fb-menu-surface">
					<details class="fb-category-menu">
						<summary class="fb-category-menu-toggle">
							<?php feedbuzz_icon( 'menu', 'fb-category-menu-hamburger' ); ?>
							<span><?php esc_html_e( 'Categories', 'feedbuzz' ); ?></span>
						</summary>
						<?php
						if ( has_nav_menu( 'category_dropdown' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'category_dropdown',
									'menu_class'     => 'fb-category-menu-list',
									'container'      => false,
									'depth'          => 2,
									'fallback_cb'    => false,
								)
							);
						} else {
							feedbuzz_category_menu_fallback( 'fb-category-menu-list' );
						}
						?>
					</details>

					<nav id="site-navigation" class="fb-primary-nav" aria-label="<?php esc_attr_e( 'Primary menu', 'feedbuzz' ); ?>">
						<button class="fb-icon-button fb-menu-close" type="button">
							<span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'feedbuzz' ); ?></span>
							<?php feedbuzz_icon( 'close' ); ?>
						</button>
						<?php
						if ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu_class'     => 'fb-nav-list fb-nav-fit-pending',
									'container'      => false,
									'depth'          => 2,
									'fallback_cb'    => false,
								)
							);
						}
						?>
					</nav>
				</div>
			</div>
			<div class="fb-nav-backdrop" data-fb-menu-backdrop hidden aria-hidden="true"></div>
		</div>

		<?php if ( ! empty( $options['show_ticker'] ) ) : ?>
			<div class="fb-ticker fb-breaking-bar">
				<div class="fb-container fb-ticker-inner">
					<strong><?php esc_html_e( 'Breaking News', 'feedbuzz' ); ?></strong>
					<div class="fb-ticker-viewport">
						<div class="fb-ticker-track" data-ticker-track>
							<?php
							$ticker_query = new WP_Query(
								array(
									'posts_per_page'      => 5,
									'ignore_sticky_posts' => true,
									'no_found_rows'       => true,
								)
							);

							if ( $ticker_query->have_posts() ) :
								while ( $ticker_query->have_posts() ) :
									$ticker_query->the_post();
									?>
									<a href="<?php the_permalink(); ?>"><?php echo esc_html( feedbuzz_get_post_display_title() ); ?></a>
									<?php
								endwhile;
								wp_reset_postdata();
							else :
								?>
								<span><?php esc_html_e( 'Published posts will appear here as a breaking-news stream.', 'feedbuzz' ); ?></span>
								<?php
							endif;
							?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</header>
