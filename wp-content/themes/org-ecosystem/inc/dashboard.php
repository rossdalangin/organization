<?php
/**
 * Member Dashboard Features Logic
 *
 * @package OrgEcosystem
 */

/**
 * Handle Profile Update from Dashboard
 */
function org_ecosystem_handle_profile_update() {
	if ( ! isset( $_POST['org_profile_nonce'] ) || ! wp_verify_nonce( $_POST['org_profile_nonce'], 'org_update_profile' ) ) {
		return;
	}

	$user_id = get_current_user_id();
	$member_id = get_user_meta( $user_id, '_member_profile_id', true );

	if ( ! $member_id ) return;

	$bio = sanitize_textarea_field( $_POST['member_bio'] );
	$phone = sanitize_text_field( $_POST['member_phone'] );
	$website = esc_url_raw( $_POST['member_website'] );

	update_post_meta( $member_id, '_member_bio', $bio );
	update_post_meta( $member_id, '_member_phone', $phone );
	update_post_meta( $member_id, '_member_website', $website );

	wp_redirect( add_query_arg( array( 'action' => 'edit-profile', 'updated' => 'true' ), home_url( '/dashboard' ) ) );
	exit;
}
add_action( 'admin_post_org_update_profile', 'org_ecosystem_handle_profile_update' );

/**
 * Get Member Stats
 */
function org_ecosystem_get_member_stats( $member_id ) {
	return array(
		'views' => get_post_meta( $member_id, '_member_view_count', true ) ?: 0,
		'inquiries' => get_post_meta( $member_id, '_member_inquiry_count', true ) ?: 0,
		'product_clicks' => get_post_meta( $member_id, '_member_product_clicks', true ) ?: 0,
	);
}
