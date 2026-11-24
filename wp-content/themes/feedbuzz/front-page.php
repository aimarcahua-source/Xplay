<?php
/**
 * Front-page template.
 *
 * The template respects both WordPress Reading modes:
 * - Latest posts: the WordPress main query is used directly.
 * - Static page: the selected Page content is preserved and the magazine feed
 *   follows the core Settings > Reading posts-per-page value.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

global $wp_query;

$options            = feedbuzz_get_options();
$is_static_front    = 'page' === get_option( 'show_on_front' );
$current_page       = max( 1, absint( get_query_var( 'paged' ) ), absint( get_query_var( 'page' ) ) );
$show_magazine_feed = true;
$showcase_posts     = array();
$remaining_posts    = array();
$ideas_query        = null;
$reading_post_count = feedbuzz_get_reading_posts_per_page();
$home_recent_comments = get_comments(
	array(
		'status'      => 'approve',
		'number'      => 1,
		'type'        => 'comment',
		'post_status' => 'publish',
	)
);
$has_home_recent_comments = ! empty( $home_recent_comments );
$has_home_sidebar   = ! empty( $options['show_trending'] ) || $has_home_recent_comments || is_active_sidebar( 'primary-sidebar' ) || feedbuzz_sidebar_has_latest_posts_widget( 'primary-sidebar' ) || feedbuzz_sidebar_has_recent_comments_widget( 'primary-sidebar' );
$pagination_total_pages = 1;
$pagination_items      = array();
$has_pagination        = false;

/*
 * Query architecture:
 *
 * - When Settings > Reading uses "Your latest posts", the ideas grid and
 *   pagination come directly from WordPress's public main query. This keeps
 *   posts_per_page, paged, sticky-post handling and max_num_pages under core
 *   control.
 * - When a static front page is selected, WordPress's main query must remain
 *   that Page. The magazine feed therefore uses a secondary post query whose
 *   page size comes from the same core posts_per_page Reading option.
 * - The three-post visual showcase is intentionally independent from feed
 *   pagination so it remains visible and unchanged on every homepage page.
 */
if ( $show_magazine_feed ) {
	$showcase_query = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 4,
			'ignore_sticky_posts' => false,
			'no_found_rows'       => true,
		)
	);

	if ( ! empty( $showcase_query->posts ) ) {
		foreach ( $showcase_query->posts as $showcase_post ) {
			if ( $showcase_post instanceof WP_Post ) {
				$showcase_posts[] = $showcase_post;
			}
		}
	}

	if ( $is_static_front ) {
		$ideas_query = new WP_Query(
			array(
				'post_type'            => 'post',
				'post_status'          => 'publish',
				'paged'                => $current_page,
				'ignore_sticky_posts'  => false,
				'no_found_rows'        => false,
				'feedbuzz_home_feed'    => true,
			)
		);

		$reading_post_count = max( 1, absint( $ideas_query->get( 'posts_per_page' ) ) );

		if ( ! empty( $ideas_query->posts ) ) {
			foreach ( $ideas_query->posts as $ideas_post ) {
				if ( $ideas_post instanceof WP_Post ) {
					$remaining_posts[] = $ideas_post;
				}
			}
		}

		$pagination_total_pages = max( 1, (int) $ideas_query->max_num_pages );
	} elseif ( $wp_query instanceof WP_Query ) {
		/*
		 * Do not create a second posts query here. The main query already has
		 * the Reading setting applied by WordPress/pre_get_posts.
		 */
		$reading_post_count = max( 1, absint( $wp_query->get( 'posts_per_page' ) ) );

		if ( ! empty( $wp_query->posts ) ) {
			foreach ( $wp_query->posts as $ideas_post ) {
				if ( $ideas_post instanceof WP_Post ) {
					$remaining_posts[] = $ideas_post;
				}
			}
		}

		$pagination_total_pages = max( 1, (int) $wp_query->max_num_pages );
	}

	$has_pagination = $pagination_total_pages > 1;

	if ( $has_pagination ) {
		if ( $pagination_total_pages <= 7 ) {
			$pagination_items = range( 1, $pagination_total_pages );
		} else {
			$window_start = max( 1, $current_page - 2 );
			$window_end   = min( $pagination_total_pages, $current_page + 2 );

			if ( $current_page <= 3 ) {
				$window_start = 1;
				$window_end   = 5;
			} elseif ( $current_page >= ( $pagination_total_pages - 2 ) ) {
				$window_start = max( 1, $pagination_total_pages - 4 );
				$window_end   = $pagination_total_pages;
			}

			if ( $window_start > 1 ) {
				$pagination_items[] = 1;
			}

			if ( $window_start > 2 ) {
				$pagination_items[] = 'ellipsis';
			}

			foreach ( range( $window_start, $window_end ) as $page_number ) {
				$pagination_items[] = $page_number;
			}

			if ( $window_end < ( $pagination_total_pages - 1 ) ) {
				$pagination_items[] = 'ellipsis';
			}

			if ( $window_end < $pagination_total_pages ) {
				$pagination_items[] = $pagination_total_pages;
			}
		}
	}
}

?>
<main id="primary" tabindex="-1" class="fb-main fb-home-main<?php echo $is_static_front ? ' fb-static-front-page' : ''; ?>">
	<?php
	/*
	 * A static front page must display the selected Page. When the Page has no
	 * editor content or featured image, skip the otherwise empty title-only
	 * block so the magazine feed starts immediately.
	 */
	if ( $is_static_front && 1 === $current_page && have_posts() ) {
		while ( have_posts() ) {
			the_post();

			$front_page_content = (string) get_post_field( 'post_content', get_the_ID() );
			$has_page_intro     = '' !== trim( $front_page_content ) || has_post_thumbnail();

			if ( $has_page_intro ) {
				get_template_part(
					'template-parts/content',
					'page',
					array(
						'compact_front_page' => true,
					)
				);
			}
		}
	}
	?>

	<?php if ( $show_magazine_feed ) : ?>
		<section id="latest" class="fb-content-section fb-home-magazine-section">
			<div class="fb-container">
				<div class="fb-content-layout fb-home-feed<?php echo $has_home_sidebar ? '' : ' fb-home-feed--no-sidebar'; ?>">
					<div class="fb-content-column">
						<?php if ( ! empty( $showcase_posts ) ) : ?>
					<div class="fb-home-showcase<?php echo count( $showcase_posts ) < 2 ? ' fb-home-showcase--single' : ''; ?>" data-fb-showcase>
						<div class="fb-showcase-hero">
							<div class="fb-showcase-slides">
								<?php foreach ( $showcase_posts as $showcase_index => $showcase_post ) : ?>
									<?php
									$GLOBALS['post'] = $showcase_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- Required for template tags inside this custom display loop.
									setup_postdata( $showcase_post );
									$is_active_slide = 0 === $showcase_index;
									$reading_time    = feedbuzz_reading_time( $showcase_post->ID );
									?>
									<article <?php post_class( 'fb-showcase-slide' . ( $is_active_slide ? ' is-active' : '' ), $showcase_post->ID ); ?> data-fb-showcase-slide aria-hidden="<?php echo $is_active_slide ? 'false' : 'true'; ?>"<?php echo $is_active_slide ? '' : ' inert'; ?>>
										<a class="fb-card-link" href="<?php echo esc_url( get_permalink( $showcase_post ) ); ?>" aria-label="<?php echo esc_attr( feedbuzz_get_post_link_label( $showcase_post->ID ) ); ?>"></a>
										<div class="fb-post-media fb-showcase-media">
											<?php if ( has_post_thumbnail( $showcase_post ) ) : ?>
												<?php
												echo get_the_post_thumbnail(
													$showcase_post,
													'feedbuzz-hero',
													array(
														'loading'       => $is_active_slide ? 'eager' : 'lazy',
														'fetchpriority' => $is_active_slide ? 'high' : 'auto',
																		'decoding'      => $is_active_slide ? 'sync' : 'async',
														'class'         => 'fb-showcase-image fb-stable-image',
													)
												); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core-generated attachment markup.
												?>
											<?php else : ?>
												<div class="fb-image-fallback" aria-hidden="true"><span></span><span></span><span></span></div>
											<?php endif; ?>
										</div>
										<div class="fb-showcase-shade" aria-hidden="true"></div>
										<div class="fb-showcase-copy">
											<?php feedbuzz_category_badge( $showcase_post->ID ); ?>
											<h2 class="fb-showcase-title"><?php echo esc_html( feedbuzz_get_post_display_title( $showcase_post->ID ) ); ?></h2>
											<p class="fb-showcase-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $showcase_post ), 22 ) ); ?></p>
											<span class="fb-showcase-cta"><?php esc_html_e( 'Read article', 'feedbuzz' ); ?> <span aria-hidden="true">&rarr;</span></span>
											<div class="fb-showcase-meta">
												<span><?php feedbuzz_icon( 'clock' ); ?><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $showcase_post ) ); ?>"><?php echo esc_html( get_the_date( '', $showcase_post ) ); ?></time></span>
												<span class="fb-showcase-meta-divider" aria-hidden="true"></span>
												<span><?php feedbuzz_icon( 'clock' ); ?><?php
													printf(
														/* translators: %s: Estimated reading time in minutes. */
														esc_html( _n( '%s minute read', '%s minutes read', $reading_time, 'feedbuzz' ) ),
														esc_html( number_format_i18n( $reading_time ) )
													);
												?></span>
											</div>
										</div>
									</article>
								<?php endforeach; ?>
							</div>

							<?php if ( count( $showcase_posts ) > 1 ) : ?>
								<button class="fb-showcase-control fb-showcase-control--prev" type="button" data-fb-showcase-prev aria-label="<?php esc_attr_e( 'Previous featured story', 'feedbuzz' ); ?>">
									<?php feedbuzz_icon( 'arrow', 'fb-icon-arrow-left' ); ?>
								</button>
								<button class="fb-showcase-control fb-showcase-control--next" type="button" data-fb-showcase-next aria-label="<?php esc_attr_e( 'Next featured story', 'feedbuzz' ); ?>">
									<?php feedbuzz_icon( 'arrow' ); ?>
								</button>
								<div class="fb-showcase-dots" role="group" aria-label="<?php esc_attr_e( 'Featured stories', 'feedbuzz' ); ?>">
									<?php foreach ( $showcase_posts as $dot_index => $dot_post ) : ?>
										<button type="button" class="fb-showcase-dot<?php echo 0 === $dot_index ? ' is-active' : ''; ?>" data-fb-showcase-dot="<?php echo esc_attr( (string) $dot_index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Show featured story %d', 'feedbuzz' ), $dot_index + 1 ) ); ?>" aria-pressed="<?php echo 0 === $dot_index ? 'true' : 'false'; ?>"></button>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>

						<?php if ( count( $showcase_posts ) > 1 ) : ?>
							<div class="fb-showcase-rail fb-showcase-rail--<?php echo esc_attr( (string) min( 3, count( $showcase_posts ) - 1 ) ); ?>" aria-label="<?php esc_attr_e( 'More featured stories', 'feedbuzz' ); ?>">
								<?php foreach ( array_slice( $showcase_posts, 1, 3 ) as $rail_index => $rail_post ) : ?>
									<?php $GLOBALS['post'] = $rail_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- Required for template tags inside this custom display loop. ?>
									<?php setup_postdata( $rail_post ); ?>
									<article <?php post_class( 'fb-showcase-rail-card fb-showcase-rail-card--' . ( $rail_index + 1 ), $rail_post->ID ); ?>>
										<a class="fb-card-link" href="<?php echo esc_url( get_permalink( $rail_post ) ); ?>" aria-label="<?php echo esc_attr( feedbuzz_get_post_link_label( $rail_post->ID ) ); ?>"></a>
										<div class="fb-post-media fb-showcase-rail-media">
											<?php if ( has_post_thumbnail( $rail_post ) ) : ?>
												<?php echo get_the_post_thumbnail( $rail_post, 'feedbuzz-thumb', array( 'loading' => 'eager', 'fetchpriority' => 'auto', 'decoding' => 'sync', 'class' => 'fb-showcase-rail-image fb-stable-image' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core-generated attachment markup. ?>
											<?php else : ?>
												<div class="fb-image-fallback" aria-hidden="true"><span></span><span></span><span></span></div>
											<?php endif; ?>
										</div>
										<div class="fb-showcase-rail-body">
											<?php feedbuzz_category_badge( $rail_post->ID ); ?>
											<h3><?php echo esc_html( feedbuzz_get_post_display_title( $rail_post->ID ) ); ?></h3>
											<div class="fb-showcase-rail-footer">
												<span class="fb-showcase-rail-date"><?php feedbuzz_icon( 'clock' ); ?><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $rail_post ) ); ?>"><?php echo esc_html( get_the_date( '', $rail_post ) ); ?></time></span>
												<span class="fb-showcase-rail-arrow" aria-hidden="true"><?php feedbuzz_icon( 'arrow' ); ?></span>
											</div>
										</div>
									</article>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php else : ?>
					<div class="fb-empty-card">
						<h2><?php esc_html_e( 'No stories yet', 'feedbuzz' ); ?></h2>
						<p><?php esc_html_e( 'Published posts will appear here in a flexible editorial grid.', 'feedbuzz' ); ?></p>
					</div>
				<?php endif; ?>

				<?php wp_reset_postdata(); ?>

						<?php if ( ! empty( $remaining_posts ) ) : ?>
							<section class="fb-home-ideas" data-fb-ideas-count="<?php echo esc_attr( (string) $reading_post_count ); ?>" aria-label="<?php esc_attr_e( 'Editorial story highlights', 'feedbuzz' ); ?>">
								<div class="fb-home-ideas-head">
									<h2><?php esc_html_e( 'Ideas for Your Living Spaces', 'feedbuzz' ); ?></h2>
								</div>

								<div class="fb-latest-grid fb-latest-grid--remaining fb-latest-grid--ideas">
									<?php foreach ( $remaining_posts as $remaining_index => $remaining_post ) : ?>
										<?php
										$GLOBALS['post'] = $remaining_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- Required for template tags inside this custom display loop.
										setup_postdata( $remaining_post );
										$idea_card_class = 'fb-story-card';
										$idea_slot       = $remaining_index % 7;
										$idea_group      = (int) floor( $remaining_index / 7 );
										$group_start     = $idea_group * 7;
										$group_count     = min( 7, count( $remaining_posts ) - $group_start );

										if ( $group_count <= 3 || $idea_slot >= 4 ) {
											$idea_card_class .= ' fb-story-card--third';
										} else {
											$idea_card_class .= ' fb-story-card--quarter';
										}
										?>
										<article <?php post_class( $idea_card_class, $remaining_post->ID ); ?>>
											<a class="fb-card-link" href="<?php echo esc_url( get_permalink( $remaining_post ) ); ?>" aria-label="<?php echo esc_attr( feedbuzz_get_post_link_label( $remaining_post->ID ) ); ?>"></a>
											<?php feedbuzz_post_media( 'feedbuzz-card' ); ?>
											<div class="fb-story-body">
												<?php feedbuzz_category_badge( $remaining_post->ID ); ?>
												<h3><?php echo esc_html( feedbuzz_get_post_display_title( $remaining_post->ID ) ); ?></h3>
												<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $remaining_post ), 18 ) ); ?></p>
												<?php feedbuzz_post_meta( false ); ?>
											</div>
										</article>
									<?php endforeach; ?>
								</div>

							</section>
							<?php wp_reset_postdata(); ?>
						<?php endif; ?>

						<?php if ( $has_pagination ) : ?>
							<nav class="fb-home-pagination fb-home-pagination--reference" aria-label="<?php esc_attr_e( 'Homepage posts pagination', 'feedbuzz' ); ?>">
								<div class="fb-home-pagination-box fb-home-pagination-box--prev">
									<?php if ( $current_page > 1 ) : ?>
										<a class="fb-home-pagination-link fb-home-pagination-link--prev" href="<?php echo esc_url( get_pagenum_link( $current_page - 1 ) ); ?>">
											<span class="fb-home-pagination-arrow" aria-hidden="true">
												<svg viewBox="0 0 24 24" focusable="false" aria-hidden="true"><path d="M19 12H7" /><path d="m12 17-5-5 5-5" /></svg>
											</span>
											<span class="fb-home-pagination-text"><?php esc_html_e( 'Previous Page', 'feedbuzz' ); ?></span>
										</a>
									<?php else : ?>
										<span class="fb-home-pagination-link fb-home-pagination-link--prev is-disabled" aria-disabled="true">
											<span class="fb-home-pagination-arrow" aria-hidden="true">
												<svg viewBox="0 0 24 24" focusable="false" aria-hidden="true"><path d="M19 12H7" /><path d="m12 17-5-5 5-5" /></svg>
											</span>
											<span class="fb-home-pagination-text"><?php esc_html_e( 'Previous Page', 'feedbuzz' ); ?></span>
										</span>
									<?php endif; ?>
								</div>

								<div class="fb-home-pagination-summary">
									<p class="fb-home-pagination-total"><?php esc_html_e( 'Total', 'feedbuzz' ); ?> <strong><?php echo esc_html( number_format_i18n( $pagination_total_pages ) ); ?></strong> <?php echo esc_html( _n( 'page', 'pages', $pagination_total_pages, 'feedbuzz' ) ); ?></p>
									<?php if ( ! empty( $pagination_items ) ) : ?>
										<div class="fb-home-pagination-list" role="list">
											<?php foreach ( $pagination_items as $pagination_item ) : ?>
												<?php if ( 'ellipsis' === $pagination_item ) : ?>
													<span class="fb-home-pagination-ellipsis" role="listitem" aria-hidden="true">&hellip;</span>
												<?php elseif ( (int) $pagination_item === (int) $current_page ) : ?>
													<span class="fb-home-pagination-number is-current" role="listitem" aria-current="page"><?php echo esc_html( number_format_i18n( $pagination_item ) ); ?></span>
												<?php else : ?>
													<a class="fb-home-pagination-number" role="listitem" href="<?php echo esc_url( get_pagenum_link( (int) $pagination_item ) ); ?>"><?php echo esc_html( number_format_i18n( $pagination_item ) ); ?></a>
												<?php endif; ?>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
								</div>

								<div class="fb-home-pagination-box fb-home-pagination-box--next">
									<?php if ( $current_page < $pagination_total_pages ) : ?>
										<a class="fb-home-pagination-link fb-home-pagination-link--next" href="<?php echo esc_url( get_pagenum_link( $current_page + 1 ) ); ?>">
											<span class="fb-home-pagination-text"><?php esc_html_e( 'Next Page', 'feedbuzz' ); ?></span>
											<span class="fb-home-pagination-arrow" aria-hidden="true">
												<svg viewBox="0 0 24 24" focusable="false" aria-hidden="true"><path d="M5 12h12" /><path d="m12 7 5 5-5 5" /></svg>
											</span>
										</a>
									<?php else : ?>
										<span class="fb-home-pagination-link fb-home-pagination-link--next is-disabled" aria-disabled="true">
											<span class="fb-home-pagination-text"><?php esc_html_e( 'Next Page', 'feedbuzz' ); ?></span>
											<span class="fb-home-pagination-arrow" aria-hidden="true">
												<svg viewBox="0 0 24 24" focusable="false" aria-hidden="true"><path d="M5 12h12" /><path d="m12 7 5 5-5 5" /></svg>
											</span>
										</span>
									<?php endif; ?>
								</div>
							</nav>
						<?php endif; ?>
						</div>

						<?php if ( $has_home_sidebar ) : ?>
							<aside class="fb-sidebar-column" aria-label="<?php esc_attr_e( 'Homepage sidebar', 'feedbuzz' ); ?>">
								<?php if ( ! empty( $options['show_trending'] ) ) : ?>
									<section class="fb-trending-card">
										<div class="fb-side-title">
											<span><?php feedbuzz_icon( 'flash' ); ?></span>
											<div>
												<small><?php esc_html_e( 'Readers are following', 'feedbuzz' ); ?></small>
												<h2><?php esc_html_e( 'Trending now', 'feedbuzz' ); ?></h2>
											</div>
										</div>
										<ol class="fb-trending-list">
											<?php
											$trending_query = new WP_Query(
												array(
													'post_type'           => 'post',
													'post_status'         => 'publish',
													'posts_per_page'      => 5,
													'orderby'             => 'comment_count',
													'ignore_sticky_posts' => true,
													'no_found_rows'       => true,
												)
											);

											if ( $trending_query->have_posts() ) {
												while ( $trending_query->have_posts() ) {
													$trending_query->the_post();
													?>
													<li>
														<a href="<?php the_permalink(); ?>">
															<span class="fb-trending-thumb">
																<?php if ( has_post_thumbnail() ) : ?>
																	<?php the_post_thumbnail( 'feedbuzz-thumb', array( 'loading' => 'eager', 'fetchpriority' => 'auto', 'decoding' => 'sync', 'class' => 'fb-trending-image fb-stable-image' ) ); ?>
																<?php endif; ?>
															</span>
															<span>
																<strong><?php echo esc_html( feedbuzz_get_post_display_title() ); ?></strong>
																<small><?php echo esc_html( get_the_date() ); ?></small>
															</span>
														</a>
													</li>
													<?php
												}
												wp_reset_postdata();
											} else {
												for ( $placeholder_index = 1; $placeholder_index <= 4; $placeholder_index++ ) {
													?>
													<li class="fb-trending-placeholder" aria-hidden="true"><span></span><div><i></i><i></i></div></li>
													<?php
												}
											}
											?>
										</ol>
									</section>
								<?php endif; ?>

								<?php if ( $has_home_recent_comments || is_active_sidebar( 'primary-sidebar' ) || feedbuzz_sidebar_has_latest_posts_widget( 'primary-sidebar' ) || feedbuzz_sidebar_has_recent_comments_widget( 'primary-sidebar' ) ) : ?>
									<div class="fb-widget-stack">
										<?php if ( $has_home_recent_comments ) : ?>
											<?php feedbuzz_render_designed_recent_comments_widget(); ?>
										<?php endif; ?>
										<?php if ( feedbuzz_sidebar_has_latest_posts_widget( 'primary-sidebar' ) ) : ?>
											<?php feedbuzz_render_designed_latest_posts_widget(); ?>
										<?php endif; ?>
										<?php feedbuzz_dynamic_sidebar( 'primary-sidebar' ); ?>
									</div>
								<?php endif; ?>
							</aside>
						<?php endif; ?>
				</div>
			</div>
		</section>

	<?php endif; ?>

	<?php if ( ! empty( $options['show_editor'] ) ) : ?>
		<?php
		$footer_editor_query = new WP_Query(
			array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => 6,
				'ignore_sticky_posts' => false,
				'no_found_rows'       => true,
			)
		);
		?>

		<?php if ( $footer_editor_query->have_posts() ) : ?>
			<section class="fb-footer-editor-picks" aria-label="<?php esc_attr_e( "Editor's selection", 'feedbuzz' ); ?>">
				<div class="fb-container">
					<div class="fb-footer-editor-shell">
						<div class="fb-footer-editor-head">
							<div class="fb-footer-editor-title-wrap">
								<h2 class="fb-footer-editor-title"><?php esc_html_e( "Editor's selection", 'feedbuzz' ); ?></h2>
							</div>
							<a class="fb-footer-editor-link" href="<?php echo esc_url( feedbuzz_get_posts_page_url() ); ?>">
								<?php esc_html_e( 'View all', 'feedbuzz' ); ?>
								<span aria-hidden="true">&rarr;</span>
							</a>
						</div>

						<div class="fb-footer-editor-grid">
							<?php while ( $footer_editor_query->have_posts() ) : ?>
								<?php $footer_editor_query->the_post(); ?>
								<article <?php post_class( 'fb-footer-editor-card' ); ?>>
									<a class="fb-card-link" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( feedbuzz_get_post_link_label() ); ?>"></a>
									<div class="fb-footer-editor-media">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'feedbuzz-card', array( 'loading' => 'lazy' ) ); ?>
										<?php else : ?>
											<div class="fb-image-fallback" aria-hidden="true"><span></span><span></span><span></span></div>
										<?php endif; ?>
									</div>
									<div class="fb-footer-editor-body">
										<?php feedbuzz_category_badge( get_the_ID() ); ?>
										<h3><?php echo esc_html( feedbuzz_get_post_display_title() ); ?></h3>
										<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?></p>
									</div>
								</article>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</section>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	<?php endif; ?>
</main>
<?php
get_footer();
