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

	$fields = array(
		'member_bio'            => '_member_bio',
		'member_phone'          => '_member_phone',
		'member_website'        => '_member_website',
		'member_business_name'  => '_member_business_name',
		'member_cover_photo'    => '_member_cover_photo',
		'member_facebook'       => '_member_facebook',
		'member_linkedin'       => '_member_linkedin',
		'member_twitter'        => '_member_twitter',
		'member_certifications' => '_member_certifications',
	);

	foreach ( $fields as $key => $meta_key ) {
		if ( isset( $_POST[$key] ) ) {
			$value = ( strpos( $key, 'url' ) !== false || strpos( $key, 'photo' ) !== false || strpos( $key, 'facebook' ) !== false || strpos( $key, 'linkedin' ) !== false || strpos( $key, 'twitter' ) !== false )
				? esc_url_raw( $_POST[$key] )
				: sanitize_textarea_field( $_POST[$key] );
			update_post_meta( $member_id, $meta_key, $value );
		}
	}

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

	$price = get_post_meta( $event_id, '_event_price', true );
	$is_paid = ! empty( $price ) && floatval( $price ) > 0;

	$registrations = get_user_meta( $user_id, '_registered_events', true ) ?: array();
	if ( ! in_array( $event_id, $registrations ) ) {

		// Mock payment for paid events
		if ( $is_paid ) {
			$history = get_user_meta( $user_id, '_payment_history', true ) ?: array();
			$history[] = array(
				'date'   => date( 'Y-m-d H:i:s' ),
				'txn_id' => 'EVT_' . time(),
				'amount' => $price,
				'level'  => 'Event Ticket: ' . get_the_title( $event_id ),
				'status' => 'Paid'
			);
			update_user_meta( $user_id, '_payment_history', $history );
		}

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

		// Mime-type validation
		$file_type = wp_check_filetype( basename( $uploadedfile['name'] ) );
		if ( 'application/pdf' !== $file_type['type'] ) {
			wp_die( __( 'Only PDF files are allowed for resumes.', 'org-ecosystem' ) );
		}

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
 * Handle Listing Promotion (Paid)
 */
function org_ecosystem_handle_promote_listing() {
	if ( ! is_user_logged_in() ) return;
	check_admin_referer( 'org_promote_listing_action' );

	$user_id = get_current_user_id();
	$item_id = isset( $_GET['item_id'] ) ? intval( $_GET['item_id'] ) : 0;
	$item_type = isset( $_GET['type'] ) ? sanitize_text_field( $_GET['type'] ) : 'member';

	if ( ! $item_id ) return;

	// Verify ownership
	if ( $item_type === 'member' ) {
		if ( (int) get_user_meta( $user_id, '_member_profile_id', true ) !== $item_id ) return;
	} else {
		if ( (int) get_post_field( 'post_author', $item_id ) !== $user_id ) return;
	}

	$amount = get_theme_mod( 'promotion_price', '500' );

	// Mock successful payment
	$payment_status = 'completed';

	if ( $payment_status === 'completed' ) {
		$transaction_id = 'PROM_' . time();

		// Log transaction in history
		$history = get_user_meta( $user_id, '_payment_history', true ) ?: array();
		$history[] = array(
			'date'   => date( 'Y-m-d H:i:s' ),
			'txn_id' => $transaction_id,
			'amount' => $amount,
			'level'  => 'Promotion (' . ucfirst($item_type) . ')',
			'status' => 'Paid'
		);
		update_user_meta( $user_id, '_payment_history', $history );

		// Update featured status
		if ( $item_type === 'member' ) {
			update_post_meta( $item_id, '_member_is_featured', '1' );
		} else {
			update_post_meta( $item_id, '_product_is_featured', '1' );
		}

		wp_redirect( add_query_arg( array( 'action' => 'overview', 'promoted' => 'true' ), home_url( '/dashboard' ) ) );
		exit;
	}
}
add_action( 'admin_post_org_promote_listing', 'org_ecosystem_handle_promote_listing' );

/**
 * Handle Job Save (Paid for Vendors)
 */
function org_ecosystem_handle_job_save() {
	if ( ! is_user_logged_in() ) return;
	check_admin_referer( 'org_save_job_action', 'org_job_nonce' );

	$user_id = get_current_user_id();
	$job_id = isset( $_POST['job_id'] ) ? intval( $_POST['job_id'] ) : 0;
	$title = sanitize_text_field( $_POST['job_title'] );
	$description = sanitize_textarea_field( $_POST['job_description'] );
	$location = isset( $_POST['job_location'] ) ? intval( $_POST['job_location'] ) : 0;
	$promote = isset( $_POST['job_promote'] ) ? '1' : '0';

	$is_vendor = current_user_can( 'vendor' );
	$listing_fee = get_theme_mod( 'job_listing_price', '1000' );
	$promotion_fee = get_theme_mod( 'promotion_price', '500' );

	if ( $job_id ) {
		if ( (int) get_post_field( 'post_author', $job_id ) !== $user_id ) return;
		wp_update_post( array(
			'ID'           => $job_id,
			'post_title'   => $title,
			'post_content' => $description,
		) );
	} else {
		$job_id = wp_insert_post( array(
			'post_title'   => $title,
			'post_content' => $description,
			'post_type'    => 'job',
			'post_status'  => 'publish',
			'post_author'  => $user_id,
		) );

		// Handle payment for Vendors or Promotions
		if ( $is_vendor || $promote === '1' ) {
			$total = 0;
			if ( $is_vendor ) $total += (int) $listing_fee;
			if ( $promote === '1' ) $total += (int) $promotion_fee;

			if ( $total > 0 ) {
				$history = get_user_meta( $user_id, '_payment_history', true ) ?: array();
				$history[] = array(
					'date'   => date( 'Y-m-d H:i:s' ),
					'txn_id' => 'JOB_' . time(),
					'amount' => $total,
					'level'  => 'Job Posting' . ( $promote === '1' ? ' (Featured)' : '' ),
					'status' => 'Paid'
				);
				update_user_meta( $user_id, '_payment_history', $history );
			}
		}
	}

	if ( $job_id ) {
		update_post_meta( $job_id, '_job_is_featured', $promote );
		if ( $location ) {
			wp_set_object_terms( $job_id, array( $location ), 'location' );
		}
	}

	wp_redirect( add_query_arg( array( 'action' => 'my-jobs', 'saved' => 'true' ), home_url( '/dashboard' ) ) );
	exit;
}
add_action( 'admin_post_org_save_job', 'org_ecosystem_handle_job_save' );

/**
 * Handle Job Delete
 */
function org_ecosystem_handle_job_delete() {
	$job_id = isset( $_GET['job_id'] ) ? intval( $_GET['job_id'] ) : 0;
	if ( ! $job_id ) return;

	check_admin_referer( 'org_delete_job_action' );

	$user_id = get_current_user_id();
	if ( (int) get_post_field( 'post_author', $job_id ) === $user_id ) {
		wp_delete_post( $job_id );
	}

	wp_redirect( add_query_arg( array( 'action' => 'my-jobs', 'deleted' => 'true' ), home_url( '/dashboard' ) ) );
	exit;
}
add_action( 'admin_post_org_delete_job', 'org_ecosystem_handle_job_delete' );

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
