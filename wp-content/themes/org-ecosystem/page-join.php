<?php
/**
 * Template Name: Join/Register Page
 *
 * @package OrgEcosystem
 */

if ( is_user_logged_in() ) {
	wp_redirect( org_ecosystem_get_page_url( 'templates/dashboard.php' ) );
	exit;
}

get_header();
?>

<main id="primary" class="site-main py-5 bg-light">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="card shadow border-0 overflow-hidden">
					<div class="bg-primary text-white p-5 text-center">
						<h1 class="h2 fw-bold mb-3"><?php _e( 'Become a Member', 'org-ecosystem' ); ?></h1>
						<p class="mb-0"><?php _e( 'Create your professional account and join our digital ecosystem.', 'org-ecosystem' ); ?></p>
					</div>
					<div class="card-body p-5 bg-white">
						<?php if ( isset( $_GET['error'] ) && $_GET['error'] === 'exists' ) : ?>
							<div class="alert alert-danger"><?php _e( 'Username or email already exists. Please try another.', 'org-ecosystem' ); ?></div>
						<?php endif; ?>

						<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
							<input type="hidden" name="action" value="org_register">
							<?php if ( isset( $_GET['plan'] ) ) : ?>
								<input type="hidden" name="plan" value="<?php echo esc_attr( $_GET['plan'] ); ?>">
							<?php endif; ?>
							<?php wp_nonce_field( 'org_user_registration', 'org_registration_nonce' ); ?>

							<div class="row g-3">
								<div class="col-md-6">
									<label class="form-label fw-bold small"><?php _e( 'First Name', 'org-ecosystem' ); ?></label>
									<input type="text" name="first_name" class="form-control" required>
								</div>
								<div class="col-md-6">
									<label class="form-label fw-bold small"><?php _e( 'Last Name', 'org-ecosystem' ); ?></label>
									<input type="text" name="last_name" class="form-control" required>
								</div>
								<div class="col-12">
									<label class="form-label fw-bold small"><?php _e( 'Username', 'org-ecosystem' ); ?></label>
									<input type="text" name="username" class="form-control" required>
								</div>
								<div class="col-12">
									<label class="form-label fw-bold small"><?php _e( 'Email Address', 'org-ecosystem' ); ?></label>
									<input type="email" name="email" class="form-control" required>
								</div>
								<div class="col-12">
									<label class="form-label fw-bold small"><?php _e( 'Password', 'org-ecosystem' ); ?></label>
									<input type="password" name="password" class="form-control" required>
								</div>
								<div class="col-12 mt-4">
									<button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold"><?php _e( 'Create Account', 'org-ecosystem' ); ?></button>
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer bg-light p-4 text-center">
						<p class="mb-0 small text-muted"><?php _e( 'Already have an account?', 'org-ecosystem' ); ?> <a href="<?php echo wp_login_url(); ?>"><?php _e( 'Login here', 'org-ecosystem' ); ?></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
