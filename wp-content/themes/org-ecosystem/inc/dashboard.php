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
 * Handle Ticket Submission
 */
function org_ecosystem_handle_ticket_submission() {
	if ( ! isset( $_POST['org_ticket_nonce'] ) || ! wp_verify_nonce( $_POST['org_ticket_nonce'], 'org_submit_ticket' ) ) {
		return;
	}

	$user_id = get_current_user_id();
	$subject = sanitize_text_field( $_POST['ticket_subject'] );
	$message = sanitize_textarea_field( $_POST['ticket_message'] );

	$ticket_id = wp_insert_post( array(
		'post_title'   => $subject,
		'post_content' => $message,
		'post_type'    => 'support_ticket',
		'post_status'  => 'publish',
		'post_author'  => $user_id,
	) );

	if ( $ticket_id ) {
		update_post_meta( $ticket_id, '_ticket_status', 'open' );
	}

	wp_redirect( add_query_arg( array( 'action' => 'support', 'submitted' => 'true' ), home_url( '/dashboard' ) ) );
	exit;
}
add_action( 'admin_post_org_submit_ticket', 'org_ecosystem_handle_ticket_submission' );

/**
 * Handle Event Registration
 */
function org_ecosystem_handle_event_registration() {
	if ( ! isset( $_POST['org_event_nonce'] ) || ! wp_verify_nonce( $_POST['org_event_nonce'], 'org_event_register' ) ) {
		return;
	}

	$user_id = get_current_user_id();
	$event_id = intval( $_POST['event_id'] );

	if ( ! $user_id || ! $event_id ) return;

	$registrations = get_user_meta( $user_id, '_registered_events', true ) ?: array();
	if ( ! in_array( $event_id, $registrations ) ) {
		$registrations[] = $event_id;
		update_user_meta( $user_id, '_registered_events', $registrations );

		// Also add user to event meta
		$attendees = get_post_meta( $event_id, '_event_attendees', true ) ?: array();
		$attendees[] = $user_id;
		update_post_meta( $event_id, '_event_attendees', $attendees );
	}

	wp_redirect( add_query_arg( array( 'action' => 'my-events', 'registered' => 'true' ), home_url( '/dashboard' ) ) );
	exit;
}
add_action( 'admin_post_org_event_register', 'org_ecosystem_handle_event_registration' );

/**
 * Handle Job Application
 */
function org_ecosystem_handle_job_application() {
	if ( ! isset( $_POST['org_job_nonce'] ) || ! wp_verify_nonce( $_POST['org_job_nonce'], 'org_job_apply' ) ) {
		return;
	}

	$user_id = get_current_user_id();
	$job_id = intval( $_POST['job_id'] );
	$name = sanitize_text_field( $_POST['app_name'] );
	$email = sanitize_email( $_POST['app_email'] );
	$message = sanitize_textarea_field( $_POST['app_message'] );

	// Handle file upload
	$resume_url = '';
	if ( ! empty( $_FILES['app_resume']['name'] ) ) {
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		$uploadedfile = $_FILES['app_resume'];
		$upload_overrides = array( 'test_form' => false );
		$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
		if ( $movefile && ! isset( $movefile['error'] ) ) {
			$resume_url = $movefile['url'];
		}
	}

	$application_id = wp_insert_post( array(
		'post_title'   => 'Application: ' . $name . ' for ' . get_the_title( $job_id ),
		'post_type'    => 'resource', // Using resource as a placeholder or could be a new CPT
		'post_status'  => 'private',
		'post_author'  => $user_id,
		'post_content' => $message,
	) );

	if ( $application_id ) {
		update_post_meta( $application_id, '_app_job_id', $job_id );
		update_post_meta( $application_id, '_app_email', $email );
		update_post_meta( $application_id, '_app_resume', $resume_url );

		$apps = get_user_meta( $user_id, '_my_applications', true ) ?: array();
		$apps[] = $application_id;
		update_user_meta( $user_id, '_my_applications', $apps );
	}

	wp_redirect( add_query_arg( array( 'action' => 'my-applications', 'submitted' => 'true' ), home_url( '/dashboard' ) ) );
	exit;
}
add_action( 'admin_post_org_job_apply', 'org_ecosystem_handle_job_application' );
add_action( 'admin_post_nopriv_org_job_apply', 'org_ecosystem_handle_job_application' );

/**
 * Handle Product Save
 */
function org_ecosystem_handle_product_save() {
	if ( ! isset( $_POST['org_product_nonce'] ) || ! wp_verify_nonce( $_POST['org_product_nonce'], 'org_save_product_action' ) ) {
		return;
	}

	$user_id = get_current_user_id();
	$product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;
	$name = sanitize_text_field( $_POST['product_name'] );
	$description = sanitize_textarea_field( $_POST['product_description'] );
	$price = sanitize_text_field( $_POST['product_price'] );

	if ( $product_id ) {
		// Update existing
		if ( (int) get_post_field( 'post_author', $product_id ) === (int) $user_id ) {
			wp_update_post( array(
				'ID'           => $product_id,
				'post_title'   => $name,
				'post_content' => $description,
			) );
		}
	} else {
		// Create new
		$product_id = wp_insert_post( array(
			'post_title'   => $name,
			'post_content' => $description,
			'post_type'    => 'product',
			'post_status'  => 'publish',
			'post_author'  => $user_id,
		) );
	}

	if ( $product_id ) {
		update_post_meta( $product_id, '_product_price', $price );
		// Link to business if user has one
		$member_id = get_user_meta( $user_id, '_member_profile_id', true );
		if ( $member_id ) {
			update_post_meta( $product_id, '_product_business_id', $member_id );
		}
	}

	wp_redirect( add_query_arg( array( 'action' => 'my-products', 'saved' => 'true' ), home_url( '/dashboard' ) ) );
	exit;
}
add_action( 'admin_post_org_save_product', 'org_ecosystem_handle_product_save' );

/**
 * Handle Product Delete
 */
function org_ecosystem_handle_product_delete() {
	$product_id = isset( $_GET['product_id'] ) ? intval( $_GET['product_id'] ) : 0;
	if ( ! $product_id ) return;

	check_admin_referer( 'org_delete_product_action' );

	$user_id = get_current_user_id();
	if ( (int) get_post_field( 'post_author', $product_id ) === (int) $user_id ) {
		wp_delete_post( $product_id );
	}

	wp_redirect( add_query_arg( array( 'action' => 'my-products', 'deleted' => 'true' ), home_url( '/dashboard' ) ) );
	exit;
}
add_action( 'admin_post_org_delete_product', 'org_ecosystem_handle_product_delete' );

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
