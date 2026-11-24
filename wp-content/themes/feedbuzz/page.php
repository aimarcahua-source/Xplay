<?php
/**
 * Page template.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="primary" tabindex="-1" class="fb-main fb-page-main">
	<div class="fb-container fb-page-layout">
		<div class="fb-page-content-column">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part(
					'template-parts/content',
					'page',
					array(
						'inside_sidebar_layout' => true,
					)
				);
			endwhile;
			?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</main>
<?php
get_footer();
