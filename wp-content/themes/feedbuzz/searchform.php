<?php
/**
 * Search form template.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$feedbuzz_search_id = wp_unique_id( 'fb-search-field-' );
$feedbuzz_args      = isset( $args ) && is_array( $args ) ? $args : array();
$feedbuzz_variant   = isset( $feedbuzz_args['feedbuzz_variant'] ) ? sanitize_html_class( $feedbuzz_args['feedbuzz_variant'] ) : '';
$feedbuzz_header    = 'header' === $feedbuzz_variant;
$feedbuzz_class     = 'fb-search-form' . ( $feedbuzz_header ? ' fb-search-form-header' : '' );
$feedbuzz_label     = isset( $feedbuzz_args['aria_label'] ) ? sanitize_text_field( $feedbuzz_args['aria_label'] ) : __( 'Search for:', 'feedbuzz' );
$feedbuzz_placeholder = isset( $feedbuzz_args['placeholder'] )
	? sanitize_text_field( $feedbuzz_args['placeholder'] )
	: __( 'Search stories…', 'feedbuzz' );
?>
<form role="search" method="get" class="<?php echo esc_attr( $feedbuzz_class ); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( $feedbuzz_label ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $feedbuzz_search_id ); ?>"><?php esc_html_e( 'Search for:', 'feedbuzz' ); ?></label>
	<?php feedbuzz_icon( 'search' ); ?>
	<input id="<?php echo esc_attr( $feedbuzz_search_id ); ?>" type="search" placeholder="<?php echo esc_attr( $feedbuzz_placeholder ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	<?php if ( $feedbuzz_header ) : ?>
		<span class="fb-header-search-shortcut" aria-hidden="true">⌘K</span>
		<button type="submit" aria-label="<?php esc_attr_e( 'Search site', 'feedbuzz' ); ?>">
			<?php feedbuzz_icon( 'search' ); ?>
			<span class="screen-reader-text"><?php esc_html_e( 'Search', 'feedbuzz' ); ?></span>
		</button>
	<?php else : ?>
		<button type="submit"><?php esc_html_e( 'Search', 'feedbuzz' ); ?></button>
	<?php endif; ?>
</form>
