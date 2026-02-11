<?php
/**
 * Dashboard Edit Profile Part
 */
$user_id = get_current_user_id();
$member_id = get_user_meta( $user_id, '_member_profile_id', true );
$bio = get_post_meta( $member_id, '_member_bio', true );
$phone = get_post_meta( $member_id, '_member_phone', true );
$website = get_post_meta( $member_id, '_member_website', true );
$business_name = get_post_meta( $member_id, '_member_business_name', true );
$cover_photo = get_post_meta( $member_id, '_member_cover_photo', true );
$facebook = get_post_meta( $member_id, '_member_facebook', true );
$linkedin = get_post_meta( $member_id, '_member_linkedin', true );
$twitter = get_post_meta( $member_id, '_member_twitter', true );
$certs = get_post_meta( $member_id, '_member_certifications', true );
?>
<h2 class="h4 mb-4"><?php _e( 'Edit Profile', 'org-ecosystem' ); ?></h2>

<?php if ( isset( $_GET['updated'] ) ) : ?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<?php _e( 'Profile updated successfully!', 'org-ecosystem' ); ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
<?php endif; ?>

<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
	<input type="hidden" name="action" value="org_update_profile">
	<?php wp_nonce_field( 'org_update_profile', 'org_profile_nonce' ); ?>

	<div class="row">
		<div class="col-md-6 mb-3">
			<label for="member_business_name" class="form-label fw-bold small"><?php _e( 'Business Name', 'org-ecosystem' ); ?></label>
			<input type="text" id="member_business_name" name="member_business_name" class="form-control" value="<?php echo esc_attr( $business_name ); ?>">
		</div>
		<div class="col-md-6 mb-3">
			<label for="member_phone" class="form-label fw-bold small"><?php _e( 'Phone Number', 'org-ecosystem' ); ?></label>
			<input type="text" id="member_phone" name="member_phone" class="form-control" value="<?php echo esc_attr( $phone ); ?>">
		</div>
	</div>

	<div class="mb-3">
		<label for="member_website" class="form-label fw-bold small"><?php _e( 'Website URL', 'org-ecosystem' ); ?></label>
		<input type="url" id="member_website" name="member_website" class="form-control" value="<?php echo esc_attr( $website ); ?>">
	</div>

	<div class="mb-3">
		<label for="member_cover_photo" class="form-label fw-bold small"><?php _e( 'Cover Photo URL', 'org-ecosystem' ); ?></label>
		<input type="url" id="member_cover_photo" name="member_cover_photo" class="form-control" value="<?php echo esc_attr( $cover_photo ); ?>" placeholder="https://example.com/cover.jpg">
	</div>

	<div class="mb-3">
		<label for="member_bio" class="form-label fw-bold small"><?php _e( 'Professional Bio', 'org-ecosystem' ); ?></label>
		<textarea id="member_bio" name="member_bio" class="form-control" rows="4"><?php echo esc_textarea( $bio ); ?></textarea>
	</div>

	<div class="mb-3">
		<label for="member_certifications" class="form-label fw-bold small"><?php _e( 'Certifications & Awards', 'org-ecosystem' ); ?></label>
		<textarea id="member_certifications" name="member_certifications" class="form-control" rows="3"><?php echo esc_textarea( $certs ); ?></textarea>
	</div>

	<h5 class="mt-4 mb-3"><?php _e( 'Social Media Profiles', 'org-ecosystem' ); ?></h5>
	<div class="row">
		<div class="col-md-4 mb-3">
			<label class="form-label small"><?php _e( 'Facebook URL', 'org-ecosystem' ); ?></label>
			<div class="input-group">
				<span class="input-group-text"><i class="bi bi-facebook"></i></span>
				<input type="url" name="member_facebook" class="form-control" value="<?php echo esc_attr( $facebook ); ?>">
			</div>
		</div>
		<div class="col-md-4 mb-3">
			<label class="form-label small"><?php _e( 'LinkedIn URL', 'org-ecosystem' ); ?></label>
			<div class="input-group">
				<span class="input-group-text"><i class="bi bi-linkedin"></i></span>
				<input type="url" name="member_linkedin" class="form-control" value="<?php echo esc_attr( $linkedin ); ?>">
			</div>
		</div>
		<div class="col-md-4 mb-3">
			<label class="form-label small"><?php _e( 'Twitter / X URL', 'org-ecosystem' ); ?></label>
			<div class="input-group">
				<span class="input-group-text"><i class="bi bi-twitter"></i></span>
				<input type="url" name="member_twitter" class="form-control" value="<?php echo esc_attr( $twitter ); ?>">
			</div>
		</div>
	</div>

	<div class="mt-4">
		<button type="submit" class="btn btn-primary px-4 fw-bold"><?php _e( 'Update Profile', 'org-ecosystem' ); ?></button>
	</div>
</form>
