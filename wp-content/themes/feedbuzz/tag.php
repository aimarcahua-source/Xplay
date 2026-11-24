<?php
/** Archive template. @package FeedBuzz */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); ?>
<main id="primary" class="fb-main fb-archive-main"><div class="fb-container">
<header class="fb-page-header"><span class="fb-eyebrow"><?php esc_html_e( 'Archive', 'feedbuzz' ); ?></span><?php the_archive_title( '<h1>', '</h1>' ); ?><?php the_archive_description( '<div class="fb-archive-description">', '</div>' ); ?></header>
<div class="fb-archive-layout"><div class="fb-archive-grid"><?php if ( have_posts() ) : while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content', 'card' ); endwhile; the_posts_pagination(); else : get_template_part( 'template-parts/content', 'none' ); endif; ?></div><?php get_sidebar(); ?></div>
</div></main><?php get_footer(); ?>
