<?php
/**
 * Theme functions and definitions
 *
 * @package BlogMunch
 */

/**
 * After setup theme hook
 */
function blogmunch_theme_setup(){
    /*
     * Make child theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'blogmunch' );	
}
add_action( 'after_setup_theme', 'blogmunch_theme_setup' );

/**
 * Load assets.
 */

function blogmunch_theme_css() {
	wp_enqueue_style( 'blogmunch-parent-theme-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script( 'blogmunch-custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), '1.0.0', true);
}
add_action( 'wp_enqueue_scripts', 'blogmunch_theme_css', 99);

/*=========================================
 BlogMunch Customize Panel from parent theme
=========================================*/
function blogmunch_change_parent_setting( $wp_customize ) {
	$wp_customize->remove_control('newsmunch_hdr_banner');
	$wp_customize->remove_control('newsmunch_hs_hdr_banner');
	$wp_customize->remove_control('newsmunch_hdr_banner_img');
	$wp_customize->remove_control('newsmunch_hdr_banner_link');
	$wp_customize->remove_control('newsmunch_hdr_banner_target');
	$wp_customize->remove_control('newsmunch_hs_top_tags');
	$wp_customize->remove_control('newsmunch_top_tags_ttl');
	$wp_customize->remove_control('newsmunch_slider_ttl');
	$wp_customize->remove_control('slider_mdl_options_head');
	$wp_customize->remove_control('newsmunch_hs_slider_mdl');
	$wp_customize->remove_control('newsmunch_slider_mdl_ttl');
	$wp_customize->remove_control('newsmunch_slider_mdl_cat');
	$wp_customize->remove_control('newsmunch_hs_slider_mdl_title');
	$wp_customize->remove_control('newsmunch_hs_slider_mdl_cat_meta');
	$wp_customize->remove_control('newsmunch_hs_slider_mdl_auth_meta');
	$wp_customize->remove_control('newsmunch_hs_slider_mdl_date_meta');
	$wp_customize->remove_control('newsmunch_hs_slider_mdl_comment_meta');
	$wp_customize->remove_control('newsmunch_hs_slider_mdl_views_meta');
	$wp_customize->remove_control('newsmunch_num_slides_mdl_tab');
	$wp_customize->remove_control('slider_right_options_head');
	$wp_customize->remove_control('newsmunch_hs_slider_right');
	$wp_customize->remove_control('newsmunch_slider_right_ttl');
	$wp_customize->remove_control('newsmunch_tabfirst_cat');
	$wp_customize->remove_control('newsmunch_tabsecond_cat');
	$wp_customize->remove_control('newsmunch_tabthird_cat');
	$wp_customize->remove_control('newsmunch_hs_slider_tab_title');
	$wp_customize->remove_control('newsmunch_hs_slider_tab_cat_meta');
	$wp_customize->remove_control('newsmunch_hs_slider_tab_date_meta');
	$wp_customize->remove_control('newsmunch_num_slides_tab');
}
add_action( 'customize_register', 'blogmunch_change_parent_setting',99 );

/**
 * Top Tags
 */
function blogmunch_list_top_tags($taxonomy = 'post_tag', $number = 8)
{
	if (is_front_page() || is_home()) {
		$newsmunch_display_top_tags			= get_theme_mod( 'newsmunch_display_top_tags', 'front_post');
		if ((is_home() && ($newsmunch_display_top_tags=='post' || $newsmunch_display_top_tags=='front_post')) || (is_front_page() && ($newsmunch_display_top_tags=='front' || $newsmunch_display_top_tags=='front_post'))):
			$newsmunch_hs_hlatest_story 		= get_theme_mod('newsmunch_hs_hlatest_story','1');
			$newsmunch_hlatest_story_ttl 		= get_theme_mod('newsmunch_hlatest_story_ttl','Latest Story');
			$newsmunch_hlatest_story_cat		= get_theme_mod('newsmunch_hlatest_story_cat','0');
			$newsmunch_hlatest_story_posts		= newsmunch_get_posts($newsmunch_hlatest_story_cat);

				$html = '';

					$html .= '<section class="exclusive-wrapper clearfix"><div class="dt-container-md">';
					
					if($newsmunch_hs_hlatest_story == '1'){
						$html .= '<div class="exclusive-posts clearfix">';
						if (!empty($newsmunch_hlatest_story_ttl)):
							$html .= '<h5 class="title"><i class="fas fa-spinner fa-spin dt-mr-1"></i>';
							$html .= esc_html($newsmunch_hlatest_story_ttl);
							$html .= '</h5>';
						endif;
						$html .= ' <div class="exclusive-slides" dir="ltr"><div class="marquee flash-slide-left" data-speed="80000" data-gap="0" data-duplicated="true" data-direction="left">';
						if ($newsmunch_hlatest_story_posts->have_posts()) :
							while ($newsmunch_hlatest_story_posts->have_posts()) : $newsmunch_hlatest_story_posts->the_post();
							global $post;
							$html .= '<a href="' . esc_url(get_permalink()) . '">';
							if ( has_post_thumbnail() ) {
								$html .= '<img src="' . esc_url(get_the_post_thumbnail_url()) . '"/>';
							}
							$html .= esc_html(get_the_title());
							$html .= '</a>';	
						endwhile;endif;wp_reset_postdata();		
						$html .= '</div></div>';
						$html .= '</div>';
					}
					$html .= '</div></section>';
				//endif;
				echo $html;
			//}
		endif;	
	}
}

/**
 * blogmunch_background
 *
 * @return void
 */
function blogmunch_background() {
    ?>
    <div class="background-wrapper" aria-hidden="true">
        <div class="squares">
            <span class="square"></span>
            <span class="square"></span>
            <span class="square"></span>
            <span class="square"></span>
            <span class="square"></span>
        </div>

        <div class="circles">
            <span class="circle"></span>
            <span class="circle"></span>
            <span class="circle"></span>
            <span class="circle"></span>
            <span class="circle"></span>
        </div>

        <div class="triangles">
            <span class="triangle"></span>
            <span class="triangle"></span>
            <span class="triangle"></span>
            <span class="triangle"></span>
            <span class="triangle"></span>
        </div>
    </div>
    <?php
}

add_action( 'wp_footer', 'blogmunch_background', 5 );

/**
 * Import Options From Parent Theme
 *
 */
function blogmunch_parent_theme_options() {
	$newsmunch_mods = get_option( 'theme_mods_newsmunch' );
	if ( ! empty( $newsmunch_mods ) ) {
		foreach ( $newsmunch_mods as $newsmunch_mod_k => $newsmunch_mod_v ) {
			set_theme_mod( $newsmunch_mod_k, $newsmunch_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'blogmunch_parent_theme_options' );