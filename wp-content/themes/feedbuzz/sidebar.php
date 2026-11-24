<?php
/**
 * Sidebar template.
 *
 * Uses the assigned Primary Sidebar widgets when available. When the widget
 * area is empty, a small fallback sidebar is built only from real WordPress
 * content: search, published posts, and non-empty categories.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$feedbuzz_recent_posts    = array();
$feedbuzz_recent_comments = array();
$feedbuzz_categories      = array();

if ( ! is_active_sidebar( 'primary-sidebar' ) ) {
	$feedbuzz_recent_args = array(
		'post_type'              => 'post',
		'post_status'            => 'publish',
		'posts_per_page'         => 5,
		'ignore_sticky_posts'    => true,
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	);

	if ( is_singular( 'post' ) ) {
		$feedbuzz_recent_args['post__not_in'] = array( get_queried_object_id() );
	}

	$feedbuzz_recent_posts = get_posts( $feedbuzz_recent_args );
	$feedbuzz_recent_comments = get_comments(
		array(
			'status'      => 'approve',
			'number'      => 3,
			'type'        => 'comment',
			'post_status' => 'publish',
		)
	);

	$feedbuzz_categories   = get_categories(
		array(
			'hide_empty' => true,
			'number'     => 8,
			'orderby'    => 'count',
			'order'      => 'DESC',
		)
	);
}
?>
<aside class="fb-sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'feedbuzz' ); ?>">
	<?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
		<?php feedbuzz_dynamic_sidebar( 'primary-sidebar' ); ?>
	<?php else : ?>
		<section class="widget fb-widget fb-default-sidebar-search">
			<h2 class="widget-title"><?php esc_html_e( 'Search', 'feedbuzz' ); ?></h2>
			<?php get_search_form(); ?>
		</section>

		<?php if ( $feedbuzz_recent_comments ) : ?>
			<?php feedbuzz_render_designed_recent_comments_widget( count( $feedbuzz_recent_comments ) ); ?>
		<?php endif; ?>

		<?php if ( $feedbuzz_recent_posts ) : ?>
			<?php feedbuzz_render_designed_latest_posts_widget( count( $feedbuzz_recent_posts ) ); ?>
		<?php endif; ?>

		<?php if ( $feedbuzz_categories ) : ?>
			<section class="widget fb-widget fb-default-sidebar-categories">
				<h2 class="widget-title"><?php esc_html_e( 'Categories', 'feedbuzz' ); ?></h2>
				<ul class="fb-default-category-list">
					<?php foreach ( $feedbuzz_categories as $feedbuzz_category ) : ?>
						<li>
							<a href="<?php echo esc_url( get_category_link( $feedbuzz_category->term_id ) ); ?>">
								<span><?php echo esc_html( $feedbuzz_category->name ); ?></span>
								<small><?php echo esc_html( number_format_i18n( $feedbuzz_category->count ) ); ?></small>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>
	<?php endif; ?>
</aside>
