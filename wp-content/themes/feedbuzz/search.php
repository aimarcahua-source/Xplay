<?php
/**
 * Search-results template.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="primary" tabindex="-1" class="fb-main fb-archive-main">
	<div class="fb-container">
		<header class="fb-page-header">
			<span class="fb-eyebrow"><?php esc_html_e( 'Search results', 'feedbuzz' ); ?></span>
			<h1>
				<?php
				printf(
					/* translators: %s: Search query. */
					esc_html__( 'Results for “%s”', 'feedbuzz' ),
					esc_html( get_search_query() )
				);
				?>
			</h1>
		</header>

		<div class="fb-archive-layout">
			<div class="fb-archive-grid">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'card' );
					endwhile;
					the_posts_pagination();
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php
get_footer();
