<?php
/**
 * Homepage Latest News (Blog)
 */
?>
<section class="section-news latest-news py-5 bg-white">
	<div class="container">
		<div class="section-header text-center mb-5 animate-on-scroll">
			<h2 class="fw-bold"><?php echo esc_html( get_theme_mod( 'news_title', __( 'Inside Our Community', 'org-ecosystem' ) ) ); ?></h2>
			<p class="text-muted"><?php echo esc_html( get_theme_mod( 'news_subtitle', __( 'The latest stories, news, and insights from our members.', 'org-ecosystem' ) ) ); ?></p>
		</div>

		<div class="row g-4">
			<?php
			$news = new WP_Query( array(
				'post_type' => 'post',
				'posts_per_page' => 3,
			) );

			if ( $news->have_posts() ) :
				while ( $news->have_posts() ) : $news->the_post();
					?>
					<div class="col-lg-4 animate-on-scroll delay-<?php echo $news->current_post + 1; ?>">
						<article class="card h-100 shadow-sm border-0 overflow-hidden rounded-4">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium_large', array( 'class' => 'card-img-top', 'style' => 'height: 200px; object-fit: cover;' ) ); ?>
							<?php endif; ?>
							<div class="card-body p-4">
								<h5 class="fw-bold mb-3"><a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none"><?php the_title(); ?></a></h5>
								<p class="text-muted small"><?php echo wp_trim_words( get_the_excerpt(), 18 ); ?></p>
								<div class="mt-4">
									<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3"><?php _e( 'Read Article', 'org-ecosystem' ); ?></a>
								</div>
							</div>
						</article>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>
	</div>
</section>
