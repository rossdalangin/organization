<?php
/**
 * Homepage Testimonials Section
 */
?>
<section class="section-testimonials testimonials-slider py-5 bg-white">
	<div class="container py-4">
		<div class="section-header text-center mb-5">
			<h2 class="fw-bold"><?php _e( 'Community Voices', 'org-ecosystem' ); ?></h2>
			<p class="text-muted"><?php _e( 'What our members say about their experience with us.', 'org-ecosystem' ); ?></p>
		</div>

		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="row g-4">
					<?php
					$testimonials = new WP_Query( array(
						'post_type' => 'testimonial',
						'posts_per_page' => 3,
					) );

					if ( $testimonials->have_posts() ) :
						while ( $testimonials->have_posts() ) : $testimonials->the_post();
							?>
							<div class="col-md-4">
								<div class="testimonial-item text-center">
									<i class="bi bi-quote fs-1 text-primary mb-3"></i>
									<div class="mb-4 fst-italic text-muted">"<?php the_content(); ?>"</div>
									<h6 class="fw-bold mb-0"><?php the_title(); ?></h6>
									<small class="text-uppercase text-muted"><?php echo get_post_meta( get_the_ID(), '_testimonial_title', true ); ?></small>
								</div>
							</div>
							<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
</section>
