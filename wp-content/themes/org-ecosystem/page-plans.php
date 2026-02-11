<?php
/**
 * Template Name: Membership Plans
 *
 * @package OrgEcosystem
 */

get_header();

$levels = org_ecosystem_get_membership_levels();
?>

<main id="primary" class="site-main py-5 bg-light">
	<div class="container">
		<header class="page-header text-center mb-5">
			<h1 class="display-4 fw-bold"><?php _e( 'Membership Plans', 'org-ecosystem' ); ?></h1>
			<p class="lead text-muted"><?php _e( 'Choose the right level of access and benefits for your professional growth.', 'org-ecosystem' ); ?></p>
		</header>

		<div class="row g-4 justify-content-center">
			<?php foreach ( $levels as $key => $level ) : ?>
				<div class="col-lg-4 col-md-6">
					<div class="card h-100 shadow-sm border-0 pricing-card">
						<div class="card-header bg-white py-4 text-center border-0">
							<h3 class="fw-bold mb-0"><?php echo esc_html( $level['name'] ); ?></h3>
						</div>
						<div class="card-body p-4 text-center">
							<div class="price mb-4">
								<h2 class="display-4 fw-bold text-primary mb-0">
									<?php echo $level['price'] > 0 ? '₱' . number_format( $level['price'] ) : __( 'Free', 'org-ecosystem' ); ?>
								</h2>
								<span class="text-muted small text-uppercase fw-bold"><?php echo esc_html( ucfirst( $level['duration'] ) ); ?></span>
							</div>

							<ul class="list-unstyled mb-5 text-start">
								<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> <?php _e( 'Access to Member Directory', 'org-ecosystem' ); ?></li>
								<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> <?php _e( 'Member Dashboard', 'org-ecosystem' ); ?></li>
								<?php if ( $key !== 'free' ) : ?>
									<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> <?php _e( 'Business Listing', 'org-ecosystem' ); ?></li>
									<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> <?php _e( 'Product Showcase', 'org-ecosystem' ); ?></li>
								<?php endif; ?>
								<?php if ( in_array( $key, array( 'premium', 'corporate', 'lifetime' ) ) ) : ?>
									<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> <?php _e( 'Featured Badge', 'org-ecosystem' ); ?></li>
									<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> <?php _e( 'Exclusive Resources', 'org-ecosystem' ); ?></li>
								<?php endif; ?>
								<?php if ( $key === 'corporate' || $key === 'lifetime' ) : ?>
									<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> <?php _e( 'Regional Admin Support', 'org-ecosystem' ); ?></li>
									<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> <?php _e( 'Advanced Reporting', 'org-ecosystem' ); ?></li>
								<?php endif; ?>
							</ul>

							<div class="d-grid">
								<a href="<?php echo esc_url( add_query_arg( 'plan', $key, home_url( '/join' ) ) ); ?>" class="btn btn-<?php echo $key === 'premium' ? 'primary' : 'outline-primary'; ?> btn-lg fw-bold">
									<?php _e( 'Select Plan', 'org-ecosystem' ); ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="mt-5 text-center p-5 bg-white border rounded shadow-sm">
			<h4 class="fw-bold mb-3"><?php _e( 'Need a custom solution for your team?', 'org-ecosystem' ); ?></h4>
			<p class="text-muted"><?php _e( 'We offer customized corporate packages tailored to your specific organizational needs.', 'org-ecosystem' ); ?></p>
			<a href="<?php echo home_url( '/contact' ); ?>" class="btn btn-link text-decoration-none fw-bold"><?php _e( 'Talk to our Sales Team', 'org-ecosystem' ); ?> <i class="bi bi-arrow-right"></i></a>
		</div>
	</div>
</main>

<?php
get_footer();
