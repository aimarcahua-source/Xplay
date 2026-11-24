<?php
/**
 * The template for displaying 404 pages.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="primary" tabindex="-1" class="fb-main">
	<div class="fb-container fb-not-found">
		<span aria-hidden="true">404</span>
		<h1><?php esc_html_e( 'This story moved off the page.', 'feedbuzz' ); ?></h1>
		<p><?php esc_html_e( 'Try a search or return to the homepage to continue exploring.', 'feedbuzz' ); ?></p>
		<?php get_search_form(); ?>
		<a class="fb-button fb-button-dark" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php esc_html_e( 'Back to homepage', 'feedbuzz' ); ?>
			<?php feedbuzz_icon( 'arrow' ); ?>
		</a>
	</div>
</main>
<?php
get_footer();
