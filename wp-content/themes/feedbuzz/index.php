<?php
/**
 * Main fallback template.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$page_title = single_post_title( '', false );
?>
<main id="primary" tabindex="-1" class="fb-main fb-archive-main">
	<div class="fb-container">
		<header class="fb-page-header">
			<span class="fb-eyebrow"><?php esc_html_e( 'Newsroom', 'feedbuzz' ); ?></span>
			<h1><?php echo esc_html( $page_title ? $page_title : __( 'Latest Posts', 'feedbuzz' ) ); ?></h1>
			<p><?php esc_html_e( 'The latest reporting, ideas and conversations.', 'feedbuzz' ); ?></p>
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
