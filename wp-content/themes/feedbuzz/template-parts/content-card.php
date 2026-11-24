<?php
/**
 * Archive-card template part.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article <?php post_class( 'fb-archive-card' ); ?>>
	<a class="fb-card-link" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( feedbuzz_get_post_link_label() ); ?>"></a>
	<?php feedbuzz_post_media( 'feedbuzz-card' ); ?>
	<div class="fb-archive-card-body">
		<?php feedbuzz_category_badge(); ?>
		<h2><?php echo esc_html( feedbuzz_get_post_display_title() ); ?></h2>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
		<?php feedbuzz_post_meta( false ); ?>
	</div>
</article>
