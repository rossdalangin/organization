<?php
/**
 * Homepage Testimonials Section
 */
?>
<section class="testimonials-section py-5 bg-dark text-white">
	<div class="container py-4">
		<div class="section-header text-center mb-5">
			<h2 class="fw-bold"><?php _e( 'What Our Members Say', 'org-ecosystem' ); ?></h2>
			<p class="text-light opacity-75"><?php _e( 'Success stories from our professional community.', 'org-ecosystem' ); ?></p>
		</div>

		<div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
			<div class="carousel-inner">
				<?php
				$testimonials = new WP_Query( array(
					'post_type' => 'testimonial',
					'posts_per_page' => 3
				) );

				if ( $testimonials->have_posts() ) :
					$count = 0;
					while ( $testimonials->have_posts() ) : $testimonials->the_post();
						?>
						<div class="carousel-item <?php echo $count === 0 ? 'active' : ''; ?>">
							<div class="row justify-content-center text-center">
								<div class="col-lg-8">
									<div class="testimonial-content mb-4">
										<i class="bi bi-quote display-1 text-primary opacity-25"></i>
										<p class="h4 fw-light mb-4">"<?php the_content(); ?>"</p>
									</div>
									<div class="testimonial-author">
										<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'thumbnail', array( 'class' => 'rounded-circle mb-3', 'style' => 'width: 80px; height: 80px; object-fit: cover;' ) ); ?>
										<h5 class="fw-bold mb-0"><?php the_title(); ?></h5>
										<p class="small text-primary"><?php echo esc_html( get_post_meta( get_the_ID(), '_testimonial_role', true ) ); ?></p>
									</div>
								</div>
							</div>
						</div>
						<?php
						$count++;
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<div class="carousel-item active">
						<div class="text-center">
							<p class="lead"><?php _e( 'Join us and share your success story!', 'org-ecosystem' ); ?></p>
						</div>
					</div>
					<?php
				endif;
				?>
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
		</div>
	</div>
</section>
