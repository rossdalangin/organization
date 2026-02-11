<?php
/**
 * Homepage Latest News Section
 */
?>
<section class="latest-news-section py-5">
	<div class="container">
		<div class="section-header d-flex justify-content-between align-items-end mb-5">
			<div>
				<h2 class="fw-bold mb-0"><?php _e( 'Latest from Our Blog', 'org-ecosystem' ); ?></h2>
				<p class="text-muted mb-0"><?php _e( 'Stay updated with our community news and updates.', 'org-ecosystem' ); ?></p>
			</div>
			<a href="<?php echo esc_url( home_url( '/news' ) ); ?>" class="btn btn-outline-primary d-none d-md-block"><?php _e( 'Read All News', 'org-ecosystem' ); ?></a>
		</div>

		<div class="row g-4">
			<?php
			$news = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3 ) );
			if ( $news->have_posts() ) :
				while ( $news->have_posts() ) : $news->the_post();
					?>
					<div class="col-md-4">
						<article class="card h-100 shadow-sm border-0">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium', array( 'class' => 'card-img-top' ) ); ?>
							<?php endif; ?>
							<div class="card-body">
								<div class="small text-muted mb-2"><?php echo get_the_date(); ?></div>
								<h5 class="card-title fw-bold"><a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark"><?php the_title(); ?></a></h5>
								<p class="card-text text-muted small"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
							</div>
							<div class="card-footer bg-white border-0 pb-4">
								<a href="<?php the_permalink(); ?>" class="fw-bold text-primary text-decoration-none small"><?php _e( 'Read More', 'org-ecosystem' ); ?> <i class="bi bi-arrow-right"></i></a>
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
