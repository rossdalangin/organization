<?php
/**
 * Template Name: Donation Page
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main py-5 bg-light">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-7">
				<div class="card shadow border-0 overflow-hidden">
					<div class="bg-primary text-white p-5 text-center">
						<h1 class="display-4 fw-bold mb-3"><?php echo esc_html( get_theme_mod( 'donation_cta_title', __( 'Support Our Mission', 'org-ecosystem' ) ) ); ?></h1>
						<p class="lead mb-0"><?php echo esc_html( get_theme_mod( 'donation_cta_text', __( 'Your contribution helps us continue our impactful work in the community.', 'org-ecosystem' ) ) ); ?></p>
					</div>
					<div class="card-body p-5 bg-white">
						<?php if ( isset( $_GET['thanks'] ) ) : ?>
							<div class="alert alert-success text-center p-4">
								<i class="bi bi-heart-fill text-danger display-4 mb-3 d-block"></i>
								<h3><?php _e( 'Thank You!', 'org-ecosystem' ); ?></h3>
								<p><?php _e( 'Your donation has been received. We deeply appreciate your support.', 'org-ecosystem' ); ?></p>
								<a href="<?php echo home_url(); ?>" class="btn btn-primary"><?php _e( 'Back to Home', 'org-ecosystem' ); ?></a>
							</div>
						<?php else : ?>
							<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
								<input type="hidden" name="action" value="org_process_donation">
								<?php wp_nonce_field( 'org_donation', 'org_donation_nonce' ); ?>

								<div class="mb-4">
									<label class="form-label fw-bold"><?php _e( 'Select Amount', 'org-ecosystem' ); ?></label>
									<div class="row g-2">
										<div class="col-4">
											<input type="radio" class="btn-check" name="amount" id="amt500" value="500" checked>
											<label class="btn btn-outline-primary w-100 py-3" for="amt500">₱ 500</label>
										</div>
										<div class="col-4">
											<input type="radio" class="btn-check" name="amount" id="amt1000" value="1000">
											<label class="btn btn-outline-primary w-100 py-3" for="amt1000">₱ 1,000</label>
										</div>
										<div class="col-4">
											<input type="radio" class="btn-check" name="amount" id="amt5000" value="5000">
											<label class="btn btn-outline-primary w-100 py-3" for="amt5000">₱ 5,000</label>
										</div>
									</div>
								</div>

								<div class="mb-4">
									<label class="form-label fw-bold"><?php _e( 'Other Amount', 'org-ecosystem' ); ?></label>
									<div class="input-group">
										<span class="input-group-text">₱</span>
										<input type="number" name="custom_amount" class="form-control" placeholder="Enter custom amount">
									</div>
								</div>

								<hr class="my-4">

								<div class="row g-3">
									<div class="col-12">
										<label class="form-label fw-bold"><?php _e( 'Full Name', 'org-ecosystem' ); ?></label>
										<input type="text" name="donor_name" class="form-control" required>
									</div>
									<div class="col-12">
										<label class="form-label fw-bold"><?php _e( 'Email Address', 'org-ecosystem' ); ?></label>
										<input type="email" name="donor_email" class="form-control" required>
									</div>
									<div class="col-12 mt-4">
										<button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold"><?php _e( 'Donate Now', 'org-ecosystem' ); ?></button>
									</div>
								</div>
							</form>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
