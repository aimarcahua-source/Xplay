<?php
$newsmunch_hs_slider_left		= get_theme_mod('newsmunch_hs_slider_left','1');
$newsmunch_slider_bg_img		= get_theme_mod('newsmunch_slider_bg_img');
$newsmunch_slider_ttl			= get_theme_mod('newsmunch_slider_ttl','Main Story');
$newsmunch_slider_cat			= get_theme_mod('newsmunch_slider_cat','0');
$newsmunch_num_slides			= get_theme_mod('newsmunch_num_slides','6');
$newsmunch_slider_posts			= newsmunch_get_posts($newsmunch_num_slides, $newsmunch_slider_cat);
$newsmunch_hs_slider_title		= get_theme_mod('newsmunch_hs_slider_title','1');
$newsmunch_hs_slider_cat_meta	= get_theme_mod('newsmunch_hs_slider_cat_meta','1');
$newsmunch_hs_slider_auth_meta	= get_theme_mod('newsmunch_hs_slider_auth_meta','1');
$newsmunch_hs_slider_date_meta	= get_theme_mod('newsmunch_hs_slider_date_meta','1');
$newsmunch_hs_slider_comment_meta= get_theme_mod('newsmunch_hs_slider_comment_meta','1');
$newsmunch_hs_slider_views_meta	= get_theme_mod('newsmunch_hs_slider_views_meta','1');
?>
<section class="main-banner-section clearfix style-1 slider-4" <?php if(!empty($newsmunch_slider_bg_img)): ?> style="background-image: url(<?php echo esc_url($newsmunch_slider_bg_img); ?>);"<?php endif; ?>>
	<div class="dt-container-md">
		<div class="dt-row dt-g-4">
			<?php if($newsmunch_hs_slider_left=='1'): ?>
				<div class="dt-col-xl-12">
					<div class="post-carousel-banner">
						<?php
							if ($newsmunch_slider_posts->have_posts()) :
							while ($newsmunch_slider_posts->have_posts()) : $newsmunch_slider_posts->the_post();

							global $post;
							$format = get_post_format() ? : 'standard';	
						?>
						<div class="post featured-post-lg">
							<div class="details clearfix">
								<?php if($newsmunch_hs_slider_cat_meta=='1'): newsmunch_getpost_categories();  endif; ?>
								<?php if($newsmunch_hs_slider_title=='1'): newsmunch_common_post_title('h2','post-title'); endif; ?> 
								<ul class="meta list-inline dt-mt-0 dt-mb-0 dt-mt-3">
									<?php if($newsmunch_hs_slider_auth_meta=='1'): ?>
										<li class="list-inline-item"><i class="far fa-user-circle"></i> <?php esc_html_e('By','newsmunch');?> <a href="<?php echo esc_url(get_author_posts_url( absint(get_the_author_meta( 'ID' )) ));?>"><?php echo esc_html(get_the_author()); ?></a></li>
									<?php endif; ?>	
									
									<?php if($newsmunch_hs_slider_date_meta=='1'): ?>
										<li class="list-inline-item"><i class="far fa-calendar-alt"></i> <?php echo esc_html(get_the_date( 'F j, Y' )); ?></li>
									<?php endif; ?>	
									
									<?php if($newsmunch_hs_slider_comment_meta=='1'): ?>
										<li class="list-inline-item"><i class="far fa-comments"></i> <?php echo esc_html(get_comments_number($post->ID)); ?></li>
									<?php endif; ?>	
									
									<?php if($newsmunch_hs_slider_views_meta=='1'): ?>
										<li class="list-inline-item"><i class="far fa-eye"></i> <?php echo wp_kses_post(newsmunch_get_post_view()); ?></li>
									<?php endif; newsmunch_edit_post_link(); ?>
								</ul>
							</div>
							<div class="thumb">
								<?php if ( $format !== 'standard'): ?>
									<span class="post-format-sm">
										<?php do_action('newsmunch_post_format_icon_type'); ?>
									</span>
								<?php endif; ?>
								<a href="<?php echo esc_url(get_permalink()); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="inner data-bg-image" data-bg-image="<?php echo esc_url(get_the_post_thumbnail_url()); ?>"></div>
									<?php else: ?>
										<div class="inner"></div>
									<?php endif; ?>
								</a>
							</div>
						</div>
						<?php endwhile;endif;wp_reset_postdata(); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>