<?php
/**
 * Dashboard Edit Profile Part
 */
$user_id = get_current_user_id();
$member_id = get_user_meta( $user_id, '_member_profile_id', true );
$bio = get_post_meta( $member_id, '_member_bio', true );
$phone = get_post_meta( $member_id, '_member_phone', true );
$website = get_post_meta( $member_id, '_member_website', true );
?>
<h2 class="h4 mb-4"><?php _e( 'Edit Profile', 'org-ecosystem' ); ?></h2>

<?php if ( isset( $_GET['updated'] ) ) : ?>
	<div class="alert alert-success">Profile updated successfully!</div>
<?php endif; ?>

<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
	<input type="hidden" name="action" value="org_update_profile">
	<?php wp_nonce_field( 'org_update_profile', 'org_profile_nonce' ); ?>

	<div class="mb-3">
		<label for="member_bio" class="form-label"><?php _e( 'Bio', 'org-ecosystem' ); ?></label>
		<textarea id="member_bio" name="member_bio" class="form-control" rows="5"><?php echo esc_textarea( $bio ); ?></textarea>
	</div>

	<div class="mb-3">
		<label for="member_phone" class="form-label"><?php _e( 'Phone', 'org-ecosystem' ); ?></label>
		<input type="text" id="member_phone" name="member_phone" class="form-control" value="<?php echo esc_attr( $phone ); ?>">
	</div>

	<div class="mb-3">
		<label for="member_website" class="form-label"><?php _e( 'Website', 'org-ecosystem' ); ?></label>
		<input type="url" id="member_website" name="member_website" class="form-control" value="<?php echo esc_attr( $website ); ?>">
	</div>

	<button type="submit" class="btn btn-primary"><?php _e( 'Save Changes', 'org-ecosystem' ); ?></button>
</form>
