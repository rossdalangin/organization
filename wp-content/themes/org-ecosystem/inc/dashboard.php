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
 * Handle Internal Messaging
 */
function org_ecosystem_handle_send_message() {
    if ( ! isset( $_POST['org_message_nonce'] ) || ! wp_verify_nonce( $_POST['org_message_nonce'], 'org_send_message' ) ) {
        return;
    }

    $sender_id = get_current_user_id();
    $receiver_id = intval( $_POST['receiver_id'] ); // 0 for admin
    $subject = sanitize_text_field( $_POST['msg_subject'] );
    $content = sanitize_textarea_field( $_POST['msg_content'] );

    $msg_id = wp_insert_post( array(
        'post_title'   => $subject,
        'post_content' => $content,
        'post_type'    => 'org_message',
        'post_status'  => 'publish',
        'post_author'  => $sender_id,
    ) );

    if ( $msg_id ) {
        update_post_meta( $msg_id, '_msg_receiver_id', $receiver_id );
        update_post_meta( $msg_id, '_msg_read', '0' );
    }

    wp_redirect( add_query_arg( array( 'action' => 'messages', 'sent' => 'true' ), home_url( '/dashboard' ) ) );
    exit;
}
add_action( 'admin_post_org_send_message', 'org_ecosystem_handle_send_message' );

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

		// Use Unified Payment for paid events
		if ( $is_paid ) {
            org_ecosystem_process_unified_payment( array(
                'amount'  => $price,
                'gateway' => 'offline', // Default for dashboard
                'type'    => 'event_ticket',
                'item_id' => $event_id,
                'user_id' => $user_id
            ) );
		}

		$registrations[] = $event_id;
		update_user_meta( $user_id, '_registered_events', $registrations );

		$attendees = get_post_meta( $event_id, '_event_attendees', true ) ?: array();
		$attendees[] = $user_id;
		update_post_meta( $event_id, '_event_attendees', $attendees );
	}

	wp_redirect( add_query_arg( array( 'action' => 'my-events', 'registered' => 'true' ), home_url( '/dashboard' ) ) );
	exit;
}
add_action( 'admin_post_org_event_register', 'org_ecosystem_handle_event_registration' );

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
		if ( (int) get_post_field( 'post_author', $product_id ) === (int) $user_id ) {
			wp_update_post( array(
				'ID'           => $product_id,
				'post_title'   => $name,
				'post_content' => $description,
			) );
		}
	} else {
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
 * Get Member Stats
 */
function org_ecosystem_get_member_stats( $member_id ) {
	return array(
		'views' => get_post_meta( $member_id, '_member_view_count', true ) ?: 0,
		'inquiries' => get_post_meta( $member_id, '_member_inquiry_count', true ) ?: 0,
		'product_clicks' => get_post_meta( $member_id, '_member_product_clicks', true ) ?: 0,
        'commissions'    => org_ecosystem_get_user_total_commissions( get_post_field('post_author', $member_id) ),
	);
}

function org_ecosystem_get_user_total_commissions( $user_id ) {
    $total = 0;
    $txns = new WP_Query( array(
        'post_type' => 'org_transaction',
        'meta_query' => array(
            array( 'key' => '_txn_user_id', 'value' => $user_id ),
            array( 'key' => '_txn_type', 'value' => 'commission' ),
        )
    ) );
    if ( $txns->have_posts() ) {
        foreach ( $txns->posts as $t ) {
            $total += floatval( get_post_meta( $t->ID, '_txn_amount', true ) );
        }
    }
    return $total;
}
