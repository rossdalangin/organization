<?php
/**
 * Homepage Featured Products Section
 */
?>
<section class="section-featured-products featured-products py-5 bg-white">
	<div class="container">
		<div class="section-header text-center mb-5 animate-on-scroll">
			<h2 class="fw-bold"><?php _e( 'Featured Solutions', 'org-ecosystem' ); ?></h2>
			<p class="text-muted"><?php _e( 'Discover high-quality products and services offered by our members.', 'org-ecosystem' ); ?></p>
		</div>

		<div class="row g-4">
			<?php
			$products = new WP_Query( array(
				'post_type' => 'product',
				'posts_per_page' => 4,
				'meta_query' => array(
					array(
						'key' => '_product_is_featured',
						'value' => '1',
					),
				),
			) );

			if ( $products->have_posts() ) :
				while ( $products->have_posts() ) : $products->the_post();
					?>
					<div class="col-md-6 col-lg-3 animate-on-scroll delay-<?php echo $products->current_post + 1; ?>">
						<div class="card h-100 shadow-sm border-0 product-card-hover overflow-hidden rounded-4">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium', array( 'class' => 'card-img-top', 'style' => 'height: 180px; object-fit: cover;' ) ); ?>
							<?php endif; ?>
							<div class="card-body">
								<h5 class="card-title h6 fw-bold mb-2"><?php the_title(); ?></h5>
								<p class="card-text small text-muted mb-3"><?php echo wp_trim_words( get_the_excerpt(), 12 ); ?></p>
								<div class="d-flex justify-content-between align-items-center">
									<span class="text-primary fw-bold">₱ <?php echo get_post_meta( get_the_ID(), '_product_price', true ); ?></span>
									<a href="<?php the_permalink(); ?>" class="btn btn-link p-0 text-decoration-none small fw-bold"><?php _e( 'Details', 'org-ecosystem' ); ?> <i class="bi bi-arrow-right"></i></a>
								</div>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				echo '<p class="text-center">' . __( 'No featured products yet.', 'org-ecosystem' ) . '</p>';
			endif;
			?>
		</div>
	</div>
</section>
