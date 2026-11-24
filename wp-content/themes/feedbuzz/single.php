<?php
/**
 * Single post template.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$post_id        = get_the_ID();
	$post_title     = feedbuzz_get_post_display_title( $post_id );
	$categories     = get_the_category( $post_id );
	$primary_cat    = ! empty( $categories ) ? $categories[0] : null;
	$author_id      = (int) get_the_author_meta( 'ID' );
	$author_name    = get_the_author();
	$author_url     = get_author_posts_url( $author_id );
	$author_bio     = get_the_author_meta( 'description', $author_id );
	$comment_count  = (int) get_comments_number( $post_id );
	$reading_time   = feedbuzz_reading_time( $post_id );
	$breadcrumb_end = wp_trim_words( $post_title, 8, '…' );
	?>
	<main id="primary" tabindex="-1" class="fb-main fb-article-page">
		<div class="fb-container fb-article-shell">
			<nav class="fb-article-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'feedbuzz' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'feedbuzz' ); ?></a>
				<span aria-hidden="true">›</span>
				<?php if ( $primary_cat ) : ?>
					<a href="<?php echo esc_url( get_category_link( $primary_cat->term_id ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a>
					<span aria-hidden="true">›</span>
				<?php endif; ?>
				<span aria-current="page"><?php echo esc_html( $breadcrumb_end ); ?></span>
			</nav>

			<div class="fb-article-layout">
				<div class="fb-article-column">
					<article <?php post_class( 'fb-article-card' ); ?>>
						<header class="fb-article-header">
							<?php if ( $primary_cat ) : ?>
								<a class="fb-article-category" href="<?php echo esc_url( get_category_link( $primary_cat->term_id ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a>
							<?php endif; ?>

							<h1 class="fb-article-title"><?php echo esc_html( $post_title ); ?></h1>

							<div class="fb-article-meta">
								<div class="fb-article-author">
									<a href="<?php echo esc_url( $author_url ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: Author name. */ __( 'View all posts by %s', 'feedbuzz' ), $author_name ) ); ?>">
										<?php echo wp_kses_post( get_avatar( $author_id, 48, '', $author_name, array( 'class' => 'fb-article-avatar' ) ) ); ?>
									</a>
									<div>
										<strong><a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $author_name ); ?></a></strong>
										<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
									</div>
								</div>

								<div class="fb-article-stats" role="group" aria-label="<?php esc_attr_e( 'Article information', 'feedbuzz' ); ?>">
									<span>
										<?php feedbuzz_icon( 'clock' ); ?>
										<?php
										printf(
											/* translators: %s: Estimated reading time in minutes. */
											esc_html( _n( '%s minute read', '%s minutes read', $reading_time, 'feedbuzz' ) ),
											esc_html( number_format_i18n( $reading_time ) )
										);
										?>
									</span>
									<span>
										<?php feedbuzz_icon( 'comment' ); ?>
										<?php
										printf(
											/* translators: %s: Number of comments. */
											esc_html( _n( '%s comment', '%s comments', $comment_count, 'feedbuzz' ) ),
											esc_html( number_format_i18n( $comment_count ) )
										);
										?>
									</span>
								</div>
							</div>
						</header>

						<?php if ( has_post_thumbnail() ) : ?>
							<figure class="fb-article-hero">
								<?php the_post_thumbnail( 'full', array( 'loading' => 'eager', 'fetchpriority' => 'high' ) ); ?>
								<?php
								$caption = get_the_post_thumbnail_caption();
								if ( $caption ) :
									?>
									<figcaption><?php echo wp_kses_post( $caption ); ?></figcaption>
								<?php endif; ?>
							</figure>
						<?php endif; ?>

						<div class="fb-article-content entry-content">
							<?php
							the_content();
							wp_link_pages(
								array(
									'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Post pages', 'feedbuzz' ) . '">',
									'after'  => '</nav>',
								)
							);
							?>
						</div>

						<footer class="fb-article-footer">
							<div class="fb-article-actions">
								<div class="fb-article-share-label"><?php esc_html_e( 'Article topics', 'feedbuzz' ); ?></div>
								<?php the_tags( '<div class="fb-article-tags">', '', '</div>' ); ?>
							</div>

							<section class="fb-article-author-box" aria-label="<?php esc_attr_e( 'Author information', 'feedbuzz' ); ?>">
								<?php echo wp_kses_post( get_avatar( $author_id, 76, '', $author_name, array( 'class' => 'fb-author-box-avatar' ) ) ); ?>
								<div>
									<h2><a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $author_name ); ?></a></h2>
									<p><?php echo esc_html( $author_bio ? $author_bio : __( 'Explore more articles from this author.', 'feedbuzz' ) ); ?></p>
								</div>
							</section>
						</footer>

						<?php if ( comments_open() || get_comments_number() ) : ?>
							<?php comments_template(); ?>
						<?php endif; ?>
					</article>
				</div>

				<?php get_sidebar(); ?>
			</div>
		</div>
	</main>
	<?php
endwhile;

get_footer();
