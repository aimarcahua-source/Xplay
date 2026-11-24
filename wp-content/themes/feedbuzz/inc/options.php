<?php
/**
 * Theme option defaults and sanitization helpers.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return theme defaults.
 *
 * @return array<string, mixed>
 */
function feedbuzz_get_defaults() {
	return array(
		'container_width'          => 1480,
		'card_radius'              => 10,
		'base_font_size'           => 16,
		'heading_weight'           => 400,
		'show_topbar'              => true,
		'show_ticker'              => true,
		'show_trending'            => true,
		'show_editor'              => true,
		'show_header_ad'           => true,
		'header_ad_image_id'       => 0,
		'header_ad_url'            => '',
		'header_ad_alt'            => '',
		'header_ad_new_tab'        => true,
		'topbar_facebook_url'      => 'https://www.facebook.com/',
		'topbar_x_url'             => 'https://x.com/',
		'topbar_instagram_url'     => 'https://www.instagram.com/',
		'topbar_youtube_url'       => 'https://www.youtube.com/',
		'accent_color'             => '#d81b60',
		'secondary_color'          => '#6c5ce7',
		'tertiary_color'           => '#00c2a8',
		'warning_color'            => '#ffb703',
		'ink_color'                => '#172033',
		'surface_color'            => '#ffffff',
		'page_color'               => '#f4f6fb',
		'dark_color'               => '#111827',
	);
}

/**
 * Get merged theme options from one prefixed option array.
 *
 * @return array<string, mixed>
 */
function feedbuzz_get_options() {
	$defaults = feedbuzz_get_defaults();
	$saved    = get_option( 'feedbuzz_options', array() );
	$options  = wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
	$colors   = array(
		'accent_color',
		'secondary_color',
		'tertiary_color',
		'warning_color',
		'ink_color',
		'surface_color',
		'page_color',
		'dark_color',
	);

	$header_ad_image_id = absint( $options['header_ad_image_id'] );
	if ( $header_ad_image_id && ! wp_attachment_is_image( $header_ad_image_id ) ) {
		$header_ad_image_id = 0;
	}

	$clean = array(
		'container_width'          => feedbuzz_sanitize_container_width( $options['container_width'] ),
		'card_radius'              => feedbuzz_sanitize_card_radius( $options['card_radius'] ),
		'base_font_size'           => feedbuzz_sanitize_base_font_size( $options['base_font_size'] ),
		'heading_weight'           => feedbuzz_sanitize_heading_weight( $options['heading_weight'] ),
		'show_topbar'              => feedbuzz_sanitize_checkbox( $options['show_topbar'] ),
		'show_ticker'              => feedbuzz_sanitize_checkbox( $options['show_ticker'] ),
		'show_trending'            => feedbuzz_sanitize_checkbox( $options['show_trending'] ),
		'show_editor'              => feedbuzz_sanitize_checkbox( $options['show_editor'] ),
		'show_header_ad'           => feedbuzz_sanitize_checkbox( $options['show_header_ad'] ),
		'header_ad_image_id'       => $header_ad_image_id,
		'header_ad_url'            => feedbuzz_sanitize_external_url( $options['header_ad_url'] ),
		'header_ad_alt'            => sanitize_text_field( $options['header_ad_alt'] ),
		'header_ad_new_tab'        => feedbuzz_sanitize_checkbox( $options['header_ad_new_tab'] ),
		'topbar_facebook_url'      => feedbuzz_sanitize_external_url( $options['topbar_facebook_url'] ),
		'topbar_x_url'             => feedbuzz_sanitize_external_url( $options['topbar_x_url'] ),
		'topbar_instagram_url'     => feedbuzz_sanitize_external_url( $options['topbar_instagram_url'] ),
		'topbar_youtube_url'       => feedbuzz_sanitize_external_url( $options['topbar_youtube_url'] ),
	);


	foreach ( $colors as $key ) {
		$clean[ $key ] = sanitize_hex_color( $options[ $key ] );
		if ( ! $clean[ $key ] ) {
			$clean[ $key ] = $defaults[ $key ];
		}
	}

	return $clean;
}

/**
 * Sanitize a checkbox value.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function feedbuzz_sanitize_checkbox( $value ) {
	return 1 === absint( $value );
}


/**
 * Sanitize a Media Library image attachment ID.
 *
 * @param mixed $value Raw attachment ID.
 * @return int
 */
function feedbuzz_sanitize_image_id( $value ) {
	$image_id = absint( $value );

	return $image_id && wp_attachment_is_image( $image_id ) ? $image_id : 0;
}

/**
 * Sanitize an external URL and allow only HTTP and HTTPS destinations.
 *
 * @param mixed $value Raw URL value.
 * @return string
 */
function feedbuzz_sanitize_external_url( $value ) {
	if ( ! is_string( $value ) ) {
		return '';
	}

	return esc_url_raw( trim( $value ), array( 'http', 'https' ) );
}

/**
 * Sanitize the content width setting.
 *
 * @param mixed $value Raw value.
 * @return int
 */
function feedbuzz_sanitize_container_width( $value ) {
	return min( 1600, max( 1080, absint( $value ) ) );
}

/**
 * Sanitize the card radius setting.
 *
 * @param mixed $value Raw value.
 * @return int
 */
function feedbuzz_sanitize_card_radius( $value ) {
	return min( 20, absint( $value ) );
}

/**
 * Sanitize the base font-size setting.
 *
 * @param mixed $value Raw value.
 * @return int
 */
function feedbuzz_sanitize_base_font_size( $value ) {
	return min( 20, max( 14, absint( $value ) ) );
}

/**
 * Sanitize the heading weight setting.
 *
 * @param mixed $value Raw value.
 * @return int
 */
function feedbuzz_sanitize_heading_weight( $value ) {
	$value = absint( $value );

	return in_array( $value, array( 300, 400, 500 ), true ) ? $value : 400;
}
