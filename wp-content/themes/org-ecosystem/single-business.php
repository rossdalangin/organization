<?php
/**
 * The template for displaying single business listings
 *
 * @package OrgEcosystem
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'business-single py-5' ); ?>>
		<div class="container">
			<header class="business-header mb-5 text-center">
				<div class="business-logo mb-4">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded shadow-sm' ) ); ?>
					<?php endif; ?>
				</div>
				<h1 class="display-4 fw-bold"><?php the_title(); ?></h1>
				<?php the_terms( get_the_ID(), 'industry', '<p class="lead text-primary">', ', ', '</p>' ); ?>
			</header>

			<div class="row">
				<div class="col-lg-8">
					<div class="business-content bg-white p-4 shadow-sm border rounded mb-4">
						<h2 class="h4 mb-4"><?php _e( 'Overview', 'org-ecosystem' ); ?></h2>
						<?php the_content(); ?>
					</div>

					<div class="business-products-services mt-5">
						<h2 class="h4 mb-4"><?php _e( 'Products & Services', 'org-ecosystem' ); ?></h2>
						<?php
						// Query related products for this business
						$products = new WP_Query( array(
							'post_type' => 'product',
							'posts_per_page' => 6,
							'meta_query' => array(
								array(
									'key' => '_product_business_id',
									'value' => get_the_ID(),
								),
							),
						) );

						if ( $products->have_posts() ) :
							echo '<div class="row">';
							while ( $products->have_posts() ) : $products->the_post();
								?>
								<div class="col-md-6 mb-4">
									<div class="card h-100 shadow-sm">
										<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'medium', array( 'class' => 'card-img-top' ) ); ?>
										<div class="card-body">
											<h5 class="card-title"><?php the_title(); ?></h5>
											<p class="card-text small"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
											<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm"><?php _e( 'View Details', 'org-ecosystem' ); ?></a>
										</div>
									</div>
								</div>
								<?php
							endwhile;
							echo '</div>';
							wp_reset_postdata();
						else :
							echo '<p class="text-muted">' . __( 'No products listed yet.', 'org-ecosystem' ) . '</p>';
						endif;
						?>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="business-sidebar">
						<div class="card shadow-sm mb-4">
							<div class="card-body">
								<h5 class="card-title mb-4"><?php _e( 'Contact Info', 'org-ecosystem' ); ?></h5>
								<ul class="list-unstyled">
									<li class="mb-3"><i class="bi bi-geo-alt me-2 text-primary"></i> <?php the_terms( get_the_ID(), 'location', '', ', ', '' ); ?></li>
									<?php
									$phone = get_post_meta( get_the_ID(), '_business_phone', true );
									if ( $phone ) : ?>
										<li class="mb-3"><i class="bi bi-telephone me-2 text-primary"></i> <?php echo esc_html( $phone ); ?></li>
									<?php endif; ?>
								</ul>
								<div class="d-grid mt-4">
									<a href="#contact" class="btn btn-primary"><?php _e( 'Inquire Now', 'org-ecosystem' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>

<?php
endwhile;

get_footer();
