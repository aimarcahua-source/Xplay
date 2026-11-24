<?php
/**
 * Dynamic theme CSS.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build safe CSS custom properties from theme options.
 *
 * @return string
 */
function feedbuzz_get_dynamic_css() {
	$options = feedbuzz_get_options();
	$colors  = array(
		'accent_color',
		'secondary_color',
		'tertiary_color',
		'warning_color',
		'ink_color',
		'surface_color',
		'page_color',
		'dark_color',
	);

	$valid = array();
	$defaults = feedbuzz_get_defaults();
	foreach ( $colors as $key ) {
		$valid[ $key ] = sanitize_hex_color( $options[ $key ] );
		if ( ! $valid[ $key ] ) {
			$valid[ $key ] = $defaults[ $key ];
		}
	}

	return sprintf(
		':root{--fb-container:%1$dpx;--fb-radius:%2$dpx;--fb-font-size:%3$dpx;--fb-heading-weight:%4$d;--fb-accent:%5$s;--fb-secondary:%6$s;--fb-tertiary:%7$s;--fb-warning:%8$s;--fb-ink:%9$s;--fb-surface:%10$s;--fb-page:%11$s;--fb-dark:%12$s;}',
		feedbuzz_sanitize_container_width( $options['container_width'] ),
		feedbuzz_sanitize_card_radius( $options['card_radius'] ),
		feedbuzz_sanitize_base_font_size( $options['base_font_size'] ),
		feedbuzz_sanitize_heading_weight( $options['heading_weight'] ),
		$valid['accent_color'],
		$valid['secondary_color'],
		$valid['tertiary_color'],
		$valid['warning_color'],
		$valid['ink_color'],
		$valid['surface_color'],
		$valid['page_color'],
		$valid['dark_color']
	);
}
