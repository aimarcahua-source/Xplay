<?php
/**
 * Site footer.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site_name         = get_bloginfo( 'name' );
$site_description  = get_bloginfo( 'description' );
$plain_site_name   = preg_replace( '/\s+/', '', wp_strip_all_tags( $site_name ) );
$footer_initials   = function_exists( 'mb_strtoupper' ) && function_exists( 'mb_substr' )
	? mb_strtoupper( mb_substr( $plain_site_name, 0, 2 ) )
	: strtoupper( substr( $plain_site_name, 0, 2 ) );
$footer_initials   = $footer_initials ? $footer_initials : 'PN';
$footer_categories = array();
$footer_posts      = array();

if ( ! is_active_sidebar( 'footer-one' ) ) {
	$footer_categories = get_categories(
		array(
			'number'  => 6,
			'orderby' => 'count',
			'order'   => 'DESC',
		)
	);
}

if ( ! is_active_sidebar( 'footer-two' ) ) {
	$footer_posts = get_posts(
		array(
			'numberposts'         => 3,
			'ignore_sticky_posts' => true,
		)
	);
}
?>
	<footer class="fb-site-footer">
		<div class="fb-container">
			<div class="fb-footer-top">
				<section id="site-information" class="fb-footer-brand" aria-label="<?php esc_attr_e( 'Site information', 'feedbuzz' ); ?>">
					<?php if ( has_custom_logo() ) : ?>
						<div class="fb-footer-logo fb-footer-custom-logo"><?php echo wp_kses_post( get_custom_logo() ); ?></div>
					<?php else : ?>
						<?php
						$default_logo_path = get_theme_file_path( 'assets/images/feedbuzz-logo.webp' );
						$default_logo_url  = get_theme_file_uri( 'assets/images/feedbuzz-logo.webp' );
						?>

						<?php if ( file_exists( $default_logo_path ) ) : ?>
							<div class="fb-footer-logo fb-footer-custom-logo">
								<a class="custom-logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
									<img class="custom-logo feedbuzz-default-logo" src="<?php echo esc_url( $default_logo_url ); ?>" alt="<?php echo esc_attr( $site_name ); ?>" width="560" height="187" loading="lazy" decoding="async">
								</a>
							</div>
						<?php else : ?>
							<a class="fb-footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<span class="fb-footer-logo-mark"><?php echo esc_html( $footer_initials ); ?></span>
								<span><?php echo esc_html( $site_name ); ?></span>
							</a>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( $site_description ) : ?>
						<p><?php echo esc_html( $site_description ); ?></p>
					<?php endif; ?>
					<a class="fb-footer-home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php esc_html_e( 'Back to homepage', 'feedbuzz' ); ?>
						<?php feedbuzz_icon( 'arrow' ); ?>
					</a>
				</section>

				<section class="fb-footer-column">
					<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
						<?php feedbuzz_dynamic_sidebar( 'footer-one' ); ?>
					<?php else : ?>
						<h2><?php esc_html_e( 'Categories', 'feedbuzz' ); ?></h2>
						<?php if ( $footer_categories ) : ?>
							<ul class="fb-footer-list">
								<?php foreach ( $footer_categories as $footer_category ) : ?>
									<li><a href="<?php echo esc_url( get_category_link( $footer_category->term_id ) ); ?>"><?php echo esc_html( $footer_category->name ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					<?php endif; ?>
				</section>

				<section class="fb-footer-column">
					<?php if ( is_active_sidebar( 'footer-two' ) ) : ?>
						<?php feedbuzz_dynamic_sidebar( 'footer-two' ); ?>
					<?php else : ?>
						<h2><?php esc_html_e( 'Latest Posts', 'feedbuzz' ); ?></h2>
						<?php if ( $footer_posts ) : ?>
							<ul class="fb-footer-posts">
								<?php foreach ( $footer_posts as $footer_post ) : ?>
									<li>
										<a href="<?php echo esc_url( get_permalink( $footer_post ) ); ?>"><?php echo esc_html( feedbuzz_get_post_display_title( $footer_post->ID ) ); ?></a>
										<small><?php echo esc_html( get_the_date( '', $footer_post ) ); ?></small>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					<?php endif; ?>
				</section>

				<section class="fb-footer-column">
					<?php if ( is_active_sidebar( 'footer-three' ) ) : ?>
						<?php feedbuzz_dynamic_sidebar( 'footer-three' ); ?>
					<?php else : ?>
						<h2><?php esc_html_e( 'Quick Links', 'feedbuzz' ); ?></h2>
						<?php
						if ( has_nav_menu( 'footer' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'footer',
									'container'      => false,
									'menu_class'     => 'fb-footer-list',
									'depth'          => 1,
								)
							);
						} else {
							feedbuzz_utility_menu_fallback( 'fb-footer-list' );
						}
						?>
					<?php endif; ?>
				</section>
			</div>

			<div class="fb-footer-bottom">
				<p class="fb-footer-copyright">
					<span class="fb-footer-copyright-year">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?></span>
					<?php do_action( 'feedbuzz_footer_credit' ); ?>
					<span class="fb-footer-copyright-suffix"><?php esc_html_e( '. All rights reserved.', 'feedbuzz' ); ?></span>
				</p>
			</div>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
