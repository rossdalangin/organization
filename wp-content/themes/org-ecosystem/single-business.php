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

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'business-single pb-5' ); ?>>
		<!-- Business Cover/Hero -->
		<div class="business-hero bg-dark text-white position-relative py-5" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>'); background-size: cover; background-position: center; min-height: 400px; display: flex; align-items: flex-end;">
			<div class="container position-relative z-index-1 mb-5 animate-fade-in-up">
				<div class="row align-items-end">
					<div class="col-lg-8">
						<?php the_terms( get_the_ID(), 'industry', '<span class="badge bg-primary px-3 py-2 rounded-pill mb-3">', ', ', '</span>' ); ?>
						<h1 class="display-3 fw-bold mb-2"><?php the_title(); ?></h1>
						<div class="d-flex align-items-center gap-3 opacity-75">
							<span><i class="bi bi-geo-alt me-1"></i> <?php the_terms( get_the_ID(), 'location', '', ', ', '' ); ?></span>
							<span><i class="bi bi-calendar-check me-1"></i> <?php echo sprintf( __( 'Member since %s', 'org-ecosystem' ), get_the_date('Y') ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container mt-n5 position-relative z-index-2">
			<div class="row">
				<div class="col-lg-8">
					<!-- Description Card -->
					<div class="org-card p-0 mb-5 overflow-hidden">
						<div class="org-card-body p-4 p-md-5">
							<h3 class="fw-bold mb-4"><?php _e( 'About the Business', 'org-ecosystem' ); ?></h3>
							<div class="business-description fs-5 text-muted">
								<?php the_content(); ?>
							</div>
						</div>
					</div>

					<!-- Products & Services Mini-Website Section -->
					<div class="products-showcase mb-5">
						<div class="d-flex justify-content-between align-items-center mb-4">
							<h3 class="fw-bold mb-0"><?php _e( 'Solutions & Offerings', 'org-ecosystem' ); ?></h3>
							<span class="badge bg-light text-dark border rounded-pill px-3 py-2"><?php _e( 'Direct from Member', 'org-ecosystem' ); ?></span>
						</div>

						<?php
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

						if ( $products->have_posts() ) : ?>
							<div class="row g-4">
								<?php while ( $products->have_posts() ) : $products->the_post(); ?>
									<div class="col-md-6">
										<div class="org-card p-0">
											<?php if ( has_post_thumbnail() ) : ?>
												<img src="<?php the_post_thumbnail_url('medium_large'); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php the_title(); ?>">
											<?php endif; ?>
											<div class="org-card-body">
												<h5 class="fw-bold"><?php the_title(); ?></h5>
												<p class="text-muted small"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
												<div class="d-flex justify-content-between align-items-center mt-3">
													<span class="h6 mb-0 text-primary fw-bold">₱ <?php echo get_post_meta(get_the_ID(), '_product_price', true); ?></span>
													<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-link p-0 text-decoration-none fw-bold"><?php _e( 'Learn More', 'org-ecosystem' ); ?> <i class="bi bi-arrow-right"></i></a>
												</div>
											</div>
										</div>
									</div>
								<?php endwhile; wp_reset_postdata(); ?>
							</div>
						<?php else : ?>
							<div class="bg-white p-5 rounded-3 border border-dashed text-center text-muted">
								<i class="bi bi-cart-x display-4 d-block mb-3"></i>
								<?php _e( 'No products or services listed yet.', 'org-ecosystem' ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="sidebar-inner sticky-top" style="top: 100px;">
						<!-- Contact Card -->
						<div class="org-card p-4 mb-4">
							<h4 class="fw-bold mb-4"><?php _e( 'Connect with Member', 'org-ecosystem' ); ?></h4>

							<?php
							$can_view = true;
							if ( get_theme_mod( 'protect_leads', false ) ) {
								$level = get_user_meta( get_current_user_id(), '_membership_level', true );
								if ( ! is_user_logged_in() || ! in_array( $level, array( 'premium', 'corporate', 'lifetime' ) ) ) {
									$can_view = false;
								}
							}

							if ( $can_view ) : ?>
								<div class="contact-details">
									<div class="d-flex mb-3">
										<div class="icon-box me-3 text-primary"><i class="bi bi-telephone-fill"></i></div>
										<div>
											<p class="small text-muted mb-0"><?php _e( 'Phone Number', 'org-ecosystem' ); ?></p>
											<p class="fw-bold mb-0"><?php echo esc_html( get_post_meta( get_the_ID(), '_business_phone', true ) ?: 'Not provided' ); ?></p>
										</div>
									</div>
									<div class="d-flex mb-3">
										<div class="icon-box me-3 text-primary"><i class="bi bi-envelope-at-fill"></i></div>
										<div>
											<p class="small text-muted mb-0"><?php _e( 'Official Email', 'org-ecosystem' ); ?></p>
											<p class="fw-bold mb-0"><?php echo esc_html( get_post_meta( get_the_ID(), '_member_email', true ) ?: 'Protected' ); ?></p>
										</div>
									</div>
								</div>
								<hr>
								<div class="d-grid gap-2">
									<a href="#inquiry" class="btn btn-primary btn-lg"><?php _e( 'Send Message', 'org-ecosystem' ); ?></a>
								</div>
							<?php else : ?>
								<div class="lead-protection-notice bg-light p-4 rounded text-center">
									<i class="bi bi-lock display-5 text-secondary mb-3"></i>
									<h6 class="fw-bold mb-2"><?php _e( 'Premium Member Content', 'org-ecosystem' ); ?></h6>
									<p class="small text-muted mb-4"><?php _e( 'Direct contact info is exclusive to Premium members. Upgrade today to unlock networking.', 'org-ecosystem' ); ?></p>
									<a href="<?php echo home_url('/membership-plans'); ?>" class="btn btn-primary btn-sm w-100"><?php _e( 'Upgrade to Unlock', 'org-ecosystem' ); ?></a>
								</div>
							<?php endif; ?>
						</div>

						<!-- Social Card -->
						<div class="org-card p-4">
							<h5 class="fw-bold mb-3"><?php _e( 'Professional Links', 'org-ecosystem' ); ?></h5>
							<div class="d-flex gap-2">
								<?php
								$socials = array('facebook', 'linkedin', 'twitter');
								foreach ($socials as $soc) {
									$val = get_post_meta(get_the_ID(), '_member_' . $soc, true);
									if ($val) {
										echo '<a href="' . esc_url($val) . '" class="btn btn-light rounded-circle shadow-none border" target="_blank"><i class="bi bi-' . $soc . '"></i></a>';
									}
								}
								?>
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
