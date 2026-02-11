<?php
/**
 * Homepage Featured Members Section
 */
?>
<section class="featured-members py-5 bg-light">
	<div class="container">
		<div class="section-header text-center mb-5">
			<h2 class="fw-bold"><?php _e( 'Featured Members', 'org-ecosystem' ); ?></h2>
			<p class="text-muted"><?php _e( 'Meet some of our top-tier professional members.', 'org-ecosystem' ); ?></p>
		</div>

		<div class="row g-4">
			<?php
			$featured = new WP_Query( array(
				'post_type' => 'member',
				'posts_per_page' => 4,
				'meta_query' => array(
					array(
						'key' => '_member_is_featured',
						'value' => '1',
					),
				),
			) );

			if ( $featured->have_posts() ) :
				while ( $featured->have_posts() ) : $featured->the_post();
					?>
					<div class="col-md-6 col-lg-3">
						<div class="card h-100 shadow-sm text-center p-4 border-0">
							<div class="mb-3">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'rounded-circle shadow-sm', 'style' => 'width: 100px; height: 100px; object-fit: cover;' ) ); ?>
								<?php endif; ?>
							</div>
							<h5 class="mb-1"><?php the_title(); ?></h5>
							<p class="text-muted small mb-3"><?php echo esc_html( get_post_meta( get_the_ID(), '_member_business_name', true ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm"><?php _e( 'View Profile', 'org-ecosystem' ); ?></a>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				echo '<p class="text-center">' . __( 'No featured members at the moment.', 'org-ecosystem' ) . '</p>';
			endif;
			?>
		</div>

		<div class="text-center mt-5">
			<a href="<?php echo esc_url( home_url( '/members' ) ); ?>" class="btn btn-primary btn-lg"><?php _e( 'View All Members', 'org-ecosystem' ); ?></a>
		</div>
	</div>
</section>
