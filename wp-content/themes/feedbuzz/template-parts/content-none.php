<?php
/**
 * Template part displayed when no content is found.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="fb-empty-card">
	<span class="fb-eyebrow"><?php esc_html_e( 'Nothing here yet', 'feedbuzz' ); ?></span>
	<h2><?php esc_html_e( 'No matching stories were found.', 'feedbuzz' ); ?></h2>
	<p><?php esc_html_e( 'Try another search or publish new content.', 'feedbuzz' ); ?></p>
	<?php get_search_form(); ?>
</section>
