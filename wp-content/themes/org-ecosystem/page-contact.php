<?php
/**
 * Template Name: Contact Us
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main py-5 bg-light">
	<div class="container">
		<div class="row g-5">
			<div class="col-lg-5">
				<h1 class="display-4 fw-bold mb-4"><?php _e( 'Get in Touch', 'org-ecosystem' ); ?></h1>
				<p class="lead mb-5"><?php _e( 'Have questions? We are here to help. Reach out to us through any of the following channels.', 'org-ecosystem' ); ?></p>

				<div class="contact-info">
					<div class="d-flex align-items-center mb-4">
						<div class="bg-primary text-white rounded-circle p-3 me-3"><i class="bi bi-geo-alt h4 mb-0"></i></div>
						<div>
							<h6 class="fw-bold mb-0"><?php _e( 'Our Location', 'org-ecosystem' ); ?></h6>
							<p class="mb-0 text-muted"><?php echo esc_html( get_theme_mod( 'org_address', '123 Org St, City, Country' ) ); ?></p>
						</div>
					</div>
					<div class="d-flex align-items-center mb-4">
						<div class="bg-primary text-white rounded-circle p-3 me-3"><i class="bi bi-telephone h4 mb-0"></i></div>
						<div>
							<h6 class="fw-bold mb-0"><?php _e( 'Phone Number', 'org-ecosystem' ); ?></h6>
							<p class="mb-0 text-muted"><?php echo esc_html( get_theme_mod( 'org_phone', '+1 234 567 890' ) ); ?></p>
						</div>
					</div>
					<div class="d-flex align-items-center mb-4">
						<div class="bg-primary text-white rounded-circle p-3 me-3"><i class="bi bi-envelope h4 mb-0"></i></div>
						<div>
							<h6 class="fw-bold mb-0"><?php _e( 'Email Address', 'org-ecosystem' ); ?></h6>
							<p class="mb-0 text-muted"><?php echo esc_html( get_theme_mod( 'org_email', 'info@example.org' ) ); ?></p>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-7">
				<div class="contact-form-wrapper bg-white p-5 shadow-sm border rounded">
					<?php if ( isset( $_GET['contact_sent'] ) ) : ?>
						<div class="alert alert-success p-4 text-center">
							<i class="bi bi-check-circle display-4 mb-3 d-block"></i>
							<h5><?php _e( 'Message Sent!', 'org-ecosystem' ); ?></h5>
							<p><?php _e( 'Thank you for reaching out. We will get back to you as soon as possible.', 'org-ecosystem' ); ?></p>
						</div>
					<?php else : ?>
						<form id="contact-form" action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
							<input type="hidden" name="action" value="org_submit_contact">
							<?php wp_nonce_field( 'org_submit_contact', 'org_contact_nonce' ); ?>
							<div class="row g-3">
								<div class="col-md-6">
									<label class="form-label"><?php _e( 'First Name', 'org-ecosystem' ); ?></label>
									<input type="text" name="first_name" class="form-control" required>
								</div>
								<div class="col-md-6">
									<label class="form-label"><?php _e( 'Last Name', 'org-ecosystem' ); ?></label>
									<input type="text" name="last_name" class="form-control" required>
								</div>
								<div class="col-12">
									<label class="form-label"><?php _e( 'Email Address', 'org-ecosystem' ); ?></label>
									<input type="email" name="email" class="form-control" required>
								</div>
								<div class="col-12">
									<label class="form-label"><?php _e( 'Subject', 'org-ecosystem' ); ?></label>
									<input type="text" name="subject" class="form-control" required>
								</div>
								<div class="col-12">
									<label class="form-label"><?php _e( 'Message', 'org-ecosystem' ); ?></label>
									<textarea name="message" class="form-control" rows="5" required></textarea>
								</div>
								<div class="col-12 mt-4">
									<button type="submit" class="btn btn-primary btn-lg w-100"><?php _e( 'Send Message', 'org-ecosystem' ); ?></button>
								</div>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
