<?php
/**
 * WordPress Customizer integration.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register all theme presentation settings in the native WordPress Customizer.
 *
 * FeedBuzz keeps its existing single prefixed option array so upgrades from
 * earlier versions retain every saved value while the configuration UI lives
 * entirely in WordPress core's Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @return void
 */
function feedbuzz_customize_register( $wp_customize ) {
	$defaults = feedbuzz_get_defaults();

	$wp_customize->add_section(
		'feedbuzz_header_options',
		array(
			'title'       => __( 'FeedBuzz Header', 'feedbuzz' ),
			'description' => __( 'Control the visible header areas and the optional header advertisement.', 'feedbuzz' ),
			'priority'    => 35,
		)
	);

	$header_toggles = array(
		'show_topbar' => array(
			'label'       => __( 'Top information bar', 'feedbuzz' ),
			'description' => __( 'Display the date, utility menu, and icon links above the logo.', 'feedbuzz' ),
		),
		'show_ticker' => array(
			'label'       => __( 'Breaking-news ticker', 'feedbuzz' ),
			'description' => __( 'Display recent posts in the ticker below the primary menu.', 'feedbuzz' ),
		),
	);

	foreach ( $header_toggles as $key => $labels ) {
		$wp_customize->add_setting(
			"feedbuzz_options[{$key}]",
			array(
				'type'              => 'option',
				'default'           => $defaults[ $key ],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'feedbuzz_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			"feedbuzz_options[{$key}]",
			array(
				'type'        => 'checkbox',
				'section'     => 'feedbuzz_header_options',
				'label'       => $labels['label'],
				'description' => $labels['description'],
			)
		);
	}

	$wp_customize->add_section(
		'feedbuzz_header_banner',
		array(
			'title'       => __( 'Header Banner', 'feedbuzz' ),
			'description' => __( 'Upload the header advertisement banner, preview the bundled default banner, and set its destination link here.', 'feedbuzz' ),
			'priority'    => 36,
		)
	);

	$wp_customize->add_setting(
		'feedbuzz_options[show_header_ad]',
		array(
			'type'              => 'option',
			'default'           => $defaults['show_header_ad'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'feedbuzz_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'feedbuzz_options[show_header_ad]',
		array(
			'type'        => 'checkbox',
			'section'     => 'feedbuzz_header_banner',
			'label'       => __( 'Show header banner', 'feedbuzz' ),
			'description' => __( 'Display the uploaded advertisement banner in the header.', 'feedbuzz' ),
		)
	);

	$wp_customize->add_setting(
		'feedbuzz_options[header_ad_image_id]',
		array(
			'type'              => 'option',
			'default'           => $defaults['header_ad_image_id'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'feedbuzz_sanitize_image_id',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'feedbuzz_options[header_ad_image_id]',
			array(
				'section'     => 'feedbuzz_header_banner',
				'label'       => __( 'Header advertisement image', 'feedbuzz' ),
				'description' => __( 'Recommended image ratio: 728 × 90 pixels. The bundled default banner is shown below and can be replaced here.', 'feedbuzz' ) . '<br><img src="' . esc_url( get_theme_file_uri( 'assets/images/header-banner-default.png' ) ) . '" alt="" style="display:block;max-width:100%;height:auto;margin-top:8px;border:1px solid #d7dce7;border-radius:10px;" />',
				'mime_type'   => 'image',
			)
		)
	);

	$wp_customize->add_setting(
		'feedbuzz_options[header_ad_url]',
		array(
			'type'              => 'option',
			'default'           => $defaults['header_ad_url'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'feedbuzz_sanitize_external_url',
		)
	);
	$wp_customize->add_control(
		'feedbuzz_options[header_ad_url]',
		array(
			'type'        => 'url',
			'section'     => 'feedbuzz_header_banner',
			'label'       => __( 'Advertisement destination URL', 'feedbuzz' ),
			'description' => __( 'Advertisement links are marked as sponsored.', 'feedbuzz' ),
		)
	);

	$wp_customize->add_setting(
		'feedbuzz_options[header_ad_alt]',
		array(
			'type'              => 'option',
			'default'           => $defaults['header_ad_alt'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'feedbuzz_options[header_ad_alt]',
		array(
			'type'    => 'text',
			'section' => 'feedbuzz_header_banner',
			'label'   => __( 'Advertisement image alternative text', 'feedbuzz' ),
		)
	);

	$wp_customize->add_setting(
		'feedbuzz_options[header_ad_new_tab]',
		array(
			'type'              => 'option',
			'default'           => $defaults['header_ad_new_tab'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'feedbuzz_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'feedbuzz_options[header_ad_new_tab]',
		array(
			'type'    => 'checkbox',
			'section' => 'feedbuzz_header_banner',
			'label'   => __( 'Open advertisement link in a new tab', 'feedbuzz' ),
		)
	);

	$wp_customize->add_section(
		'feedbuzz_social_options',
		array(
			'title'       => __( 'FeedBuzz Social Links', 'feedbuzz' ),
			'description' => __( 'Enter the complete public profile URL for each icon in the top information bar.', 'feedbuzz' ),
			'priority'    => 37,
		)
	);

	$social_settings = array(
		'topbar_facebook_url'  => __( 'Facebook URL', 'feedbuzz' ),
		'topbar_x_url'         => __( 'X URL', 'feedbuzz' ),
		'topbar_instagram_url' => __( 'Instagram URL', 'feedbuzz' ),
		'topbar_youtube_url'   => __( 'YouTube URL', 'feedbuzz' ),
	);

	foreach ( $social_settings as $key => $label ) {
		$wp_customize->add_setting(
			"feedbuzz_options[{$key}]",
			array(
				'type'              => 'option',
				'default'           => $defaults[ $key ],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'feedbuzz_sanitize_external_url',
			)
		);
		$wp_customize->add_control(
			"feedbuzz_options[{$key}]",
			array(
				'type'    => 'url',
				'section' => 'feedbuzz_social_options',
				'label'   => $label,
			)
		);
	}

	$wp_customize->add_section(
		'feedbuzz_home_options',
		array(
			'title'       => __( 'FeedBuzz Homepage', 'feedbuzz' ),
			'description' => __( 'Choose which editorial sections appear when the front page displays the latest posts.', 'feedbuzz' ),
			'priority'    => 37,
		)
	);

	$home_toggles = array(
		'show_trending' => __( 'Trending-posts section', 'feedbuzz' ),
		'show_editor'   => __( "Editor's selection section", 'feedbuzz' ),
	);

	foreach ( $home_toggles as $key => $label ) {
		$wp_customize->add_setting(
			"feedbuzz_options[{$key}]",
			array(
				'type'              => 'option',
				'default'           => $defaults[ $key ],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'feedbuzz_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			"feedbuzz_options[{$key}]",
			array(
				'type'    => 'checkbox',
				'section' => 'feedbuzz_home_options',
				'label'   => $label,
			)
		);
	}

	$wp_customize->add_section(
		'feedbuzz_design_options',
		array(
			'title'       => __( 'FeedBuzz Design', 'feedbuzz' ),
			'description' => __( 'Adjust layout, typography, and the theme color system.', 'feedbuzz' ),
			'priority'    => 38,
		)
	);

	$range_settings = array(
		'container_width' => array(
			'label'    => __( 'Maximum content width', 'feedbuzz' ),
			'min'      => 1080,
			'max'      => 1600,
			'step'     => 10,
			'sanitize' => 'feedbuzz_sanitize_container_width',
		),
		'card_radius' => array(
			'label'    => __( 'Card corner radius', 'feedbuzz' ),
			'min'      => 0,
			'max'      => 20,
			'step'     => 1,
			'sanitize' => 'feedbuzz_sanitize_card_radius',
		),
		'base_font_size' => array(
			'label'    => __( 'Base font size', 'feedbuzz' ),
			'min'      => 14,
			'max'      => 20,
			'step'     => 1,
			'sanitize' => 'feedbuzz_sanitize_base_font_size',
		),
	);

	foreach ( $range_settings as $key => $args ) {
		$wp_customize->add_setting(
			"feedbuzz_options[{$key}]",
			array(
				'type'              => 'option',
				'default'           => $defaults[ $key ],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => $args['sanitize'],
			)
		);
		$wp_customize->add_control(
			"feedbuzz_options[{$key}]",
			array(
				'type'        => 'range',
				'section'     => 'feedbuzz_design_options',
				'label'       => $args['label'],
				'input_attrs' => array(
					'min'  => $args['min'],
					'max'  => $args['max'],
					'step' => $args['step'],
				),
			)
		);
	}

	$wp_customize->add_setting(
		'feedbuzz_options[heading_weight]',
		array(
			'type'              => 'option',
			'default'           => $defaults['heading_weight'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'feedbuzz_sanitize_heading_weight',
		)
	);
	$wp_customize->add_control(
		'feedbuzz_options[heading_weight]',
		array(
			'type'    => 'select',
			'section' => 'feedbuzz_design_options',
			'label'   => __( 'Heading font weight', 'feedbuzz' ),
			'choices' => array(
				300 => __( 'Light', 'feedbuzz' ),
				400 => __( 'Normal', 'feedbuzz' ),
				500 => __( 'Medium', 'feedbuzz' ),
			),
		)
	);

	$color_settings = array(
		'accent_color'    => __( 'Primary accent color', 'feedbuzz' ),
		'secondary_color' => __( 'Secondary accent color', 'feedbuzz' ),
		'tertiary_color'  => __( 'Tertiary accent color', 'feedbuzz' ),
		'warning_color'   => __( 'Warning color', 'feedbuzz' ),
		'ink_color'       => __( 'Text color', 'feedbuzz' ),
		'surface_color'   => __( 'Card color', 'feedbuzz' ),
		'page_color'      => __( 'Page background color', 'feedbuzz' ),
		'dark_color'      => __( 'Dark-area color', 'feedbuzz' ),
	);

	foreach ( $color_settings as $key => $label ) {
		$wp_customize->add_setting(
			"feedbuzz_options[{$key}]",
			array(
				'type'              => 'option',
				'default'           => $defaults[ $key ],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				"feedbuzz_options[{$key}]",
				array(
					'section' => 'feedbuzz_design_options',
					'label'   => $label,
				)
			)
		);
	}
}
add_action( 'customize_register', 'feedbuzz_customize_register' );
