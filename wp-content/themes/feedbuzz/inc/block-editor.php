<?php
/**
 * Block editor styles and patterns.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register optional block styles and a starter editorial pattern.
 *
 * @return void
 */
function feedbuzz_register_block_editor_features() {
	if ( function_exists( 'register_block_style' ) ) {
		register_block_style(
			'core/image',
			array(
				'name'         => 'feedbuzz-framed',
				'label'        => __( 'FeedBuzz Frame', 'feedbuzz' ),
				'inline_style' => '.wp-block-image.is-style-feedbuzz-framed img{border-radius:12px;box-shadow:0 14px 34px rgba(15,23,42,.12)}',
			)
		);

		register_block_style(
			'core/quote',
			array(
				'name'         => 'feedbuzz-accent',
				'label'        => __( 'FeedBuzz Accent', 'feedbuzz' ),
				'inline_style' => '.wp-block-quote.is-style-feedbuzz-accent{border-inline-start:4px solid var(--wp--preset--color--accent,#d81b60);padding:1.25rem 1.5rem;background:rgba(216,27,96,.06);border-radius:0 12px 12px 0}',
			)
		);

		register_block_style(
			'core/group',
			array(
				'name'         => 'feedbuzz-soft-card',
				'label'        => __( 'FeedBuzz Soft Card', 'feedbuzz' ),
				'inline_style' => '.wp-block-group.is-style-feedbuzz-soft-card{padding:clamp(1.25rem,3vw,2rem);background:#fff;border:1px solid rgba(15,23,42,.1);border-radius:12px;box-shadow:0 12px 30px rgba(15,23,42,.06)}',
			)
		);
	}

	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'feedbuzz',
			array(
				'label' => __( 'FeedBuzz', 'feedbuzz' ),
			)
		);
	}

	if ( function_exists( 'register_block_pattern' ) ) {
		$pattern_content = sprintf(
			'<!-- wp:group {"className":"is-style-feedbuzz-soft-card","layout":{"type":"constrained"}} --><div class="wp-block-group is-style-feedbuzz-soft-card"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">%1$s</h3><!-- /wp:heading --><!-- wp:paragraph --><p>%2$s</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
			esc_html__( 'Featured story', 'feedbuzz' ),
			esc_html__( 'Use this editorial callout to highlight an important article or announcement.', 'feedbuzz' )
		);

		register_block_pattern(
			'feedbuzz/editorial-callout',
			array(
				'title'       => __( 'Editorial callout', 'feedbuzz' ),
				'description' => __( 'A compact editorial callout with a heading and summary.', 'feedbuzz' ),
				'categories'  => array( 'feedbuzz', 'featured' ),
				'keywords'    => array( __( 'news', 'feedbuzz' ), __( 'featured', 'feedbuzz' ), __( 'callout', 'feedbuzz' ) ),
				'content'     => $pattern_content,
			)
		);
	}
}
add_action( 'init', 'feedbuzz_register_block_editor_features' );
