<?php
/**
 * Homepage Featured Products Section
 */
?>
<section class="featured-products py-5 bg-white">
	<div class="container">
		<div class="section-header text-center mb-5">
			<h2 class="fw-bold"><?php _e( 'Featured Products & Services', 'org-ecosystem' ); ?></h2>
			<p class="text-muted"><?php _e( 'Discover top offerings from our professional network.', 'org-ecosystem' ); ?></p>
		</div>

		<div class="row g-4">
			<?php
			$products = new WP_Query( array(
				'post_type' => 'product',
				'posts_per_page' => 4,
				// For demo, we just take the latest. In a real site, we'd use a 'featured' meta key.
			) );

			if ( $products->have_posts() ) :
				while ( $products->have_posts() ) : $products->the_post();
					?>
					<div class="col-md-6 col-lg-3">
						<div class="card h-100 shadow-sm border-0">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'medium', array( 'class' => 'card-img-top' ) ); ?>
								</a>
							<?php endif; ?>
							<div class="card-body">
								<h5 class="card-title h6 fw-bold"><?php the_title(); ?></h5>
								<?php
								$business_id = get_post_meta( get_the_ID(), '_product_business_id', true );
								if ( $business_id ) : ?>
									<p class="small text-muted mb-2"><?php echo get_the_title( $business_id ); ?></p>
								<?php endif; ?>
								<div class="text-primary fw-bold mb-3"><?php echo esc_html( get_post_meta( get_the_ID(), '_product_price', true ) ); ?></div>
								<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm w-100"><?php _e( 'View Product', 'org-ecosystem' ); ?></a>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				echo '<p class="text-center">' . __( 'No products featured yet.', 'org-ecosystem' ) . '</p>';
			endif;
			?>
		</div>
	</div>
</section>
