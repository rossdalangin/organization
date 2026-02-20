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

    // Save Payout Details to User Meta
    if ( isset( $_POST['member_paypal'] ) ) {
        update_user_meta( $user_id, '_member_paypal', sanitize_email( $_POST['member_paypal'] ) );
    }
    if ( isset( $_POST['member_gcash'] ) ) {
        update_user_meta( $user_id, '_member_gcash', sanitize_text_field( $_POST['member_gcash'] ) );
    }

	wp_redirect( add_query_arg( array( 'dash_page' => 'edit-profile', 'updated' => 'true' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
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

    if ( ! is_user_logged_in() ) {
        wp_die( __( 'You must be logged in to send messages.', 'org-ecosystem' ) );
    }

    $sender_id = get_current_user_id();
    $receiver_id = intval( $_POST['receiver_id'] ); // 0 for admin
    $subject = sanitize_text_field( $_POST['msg_subject'] );
    $content = sanitize_textarea_field( $_POST['msg_content'] );

    // Permission check: Community members can only message Admin
    if ( ! org_ecosystem_can_user_do( 'send_messages' ) && $receiver_id !== 0 ) {
        wp_redirect( add_query_arg( array( 'dash_page' => 'messages', 'error' => 'upgrade_required' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
        exit;
    }

    $msg_id = wp_insert_post( array(
        'post_title'   => $subject,
        'post_content' => $content,
        'post_type'    => 'org_message',
        'post_status'  => 'publish',
        'post_author'  => $sender_id,
    ) );

    if ( $msg_id && ! is_wp_error( $msg_id ) ) {
        update_post_meta( $msg_id, '_msg_receiver_id', $receiver_id );
        update_post_meta( $msg_id, '_msg_read', '0' );

        wp_redirect( add_query_arg( array( 'dash_page' => 'messages', 'sent' => 'true' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
    } else {
        wp_redirect( add_query_arg( array( 'dash_page' => 'messages', 'error' => 'failed' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
    }
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

	wp_redirect( add_query_arg( array( 'dash_page' => 'support', 'submitted' => 'true' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
	exit;
}
add_action( 'admin_post_org_submit_ticket', 'org_ecosystem_handle_ticket_submission' );

/**
 * Handle Ticket Reply
 */
function org_ecosystem_handle_ticket_reply() {
    if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'org_reply_ticket' ) ) {
        wp_die('Security check failed.');
    }

    $ticket_id = intval( $_POST['ticket_id'] );
    $content = sanitize_textarea_field( $_POST['reply_content'] );
    $user_id = get_current_user_id();

    if ( $ticket_id && $content ) {
        wp_insert_comment( array(
            'comment_post_ID'      => $ticket_id,
            'comment_content'      => $content,
            'user_id'             => $user_id,
            'comment_author'       => wp_get_current_user()->display_name,
            'comment_author_email' => wp_get_current_user()->user_email,
            'comment_approved'     => 1,
        ) );
        wp_redirect( add_query_arg( array( 'dash_page' => 'support', 'view_ticket' => $ticket_id, 'replied' => 'true' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
        exit;
    }
}
add_action( 'admin_post_org_reply_ticket', 'org_ecosystem_handle_ticket_reply' );
add_action( 'admin_post_nopriv_org_reply_ticket', 'org_ecosystem_handle_ticket_reply' );

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

		// Redirect to Checkout for paid events
		if ( $is_paid ) {
             wp_redirect( add_query_arg( array(
                'checkout_type'    => 'event',
                'checkout_item_id' => $event_id
            ), org_ecosystem_get_page_url( 'page-checkout.php' ) ) );
            exit;
		}

		$registrations[] = $event_id;
		update_user_meta( $user_id, '_registered_events', $registrations );

		$attendees = get_post_meta( $event_id, '_event_attendees', true ) ?: array();
		$attendees[] = $user_id;
		update_post_meta( $event_id, '_event_attendees', $attendees );
	}

	wp_redirect( add_query_arg( array( 'dash_page' => 'my-events', 'registered' => 'true' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
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

    if ( ! org_ecosystem_can_user_do( 'manage_products' ) ) {
        wp_die( __( 'You do not have permission to manage products.', 'org-ecosystem' ) );
    }

	$user_id = get_current_user_id();
	$product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;
	$name = sanitize_text_field( $_POST['product_name'] );
	$description = sanitize_textarea_field( $_POST['product_description'] );
	$price = sanitize_text_field( $_POST['product_price'] );
	$stock = sanitize_text_field( $_POST['product_stock'] );
	$sku = sanitize_text_field( $_POST['product_sku'] );
	$external_url = esc_url_raw( $_POST['product_external_url'] );
    $cat_id = intval( $_POST['product_cat'] );
    $features = sanitize_textarea_field( $_POST['product_features'] );

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
		update_post_meta( $product_id, '_product_stock', $stock );
		update_post_meta( $product_id, '_product_sku', $sku );
		update_post_meta( $product_id, '_product_external_url', $external_url );
		update_post_meta( $product_id, '_product_features', $features );

        if ( $cat_id ) {
            wp_set_post_terms( $product_id, array( $cat_id ), 'product_cat' );
        }

		$member_id = get_user_meta( $user_id, '_member_profile_id', true );
		if ( $member_id ) {
			update_post_meta( $product_id, '_product_business_id', $member_id );
		}

        // Handle Image Upload
        if ( ! empty( $_FILES['product_image']['name'] ) ) {
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );

            $attachment_id = media_handle_upload( 'product_image', $product_id );
            if ( ! is_wp_error( $attachment_id ) ) {
                set_post_thumbnail( $product_id, $attachment_id );
            }
        }
	}

	wp_redirect( add_query_arg( array( 'dash_page' => 'my-products', 'saved' => 'true' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
	exit;
}
add_action( 'admin_post_org_save_product', 'org_ecosystem_handle_product_save' );

/**
 * Handle Product Delete
 */
function org_ecosystem_handle_product_delete() {
    $product_id = isset( $_GET['product_id'] ) ? intval( $_GET['product_id'] ) : 0;
    if ( ! $product_id || ! check_admin_referer( 'org_delete_product_action' ) ) return;

    $user_id = get_current_user_id();
    if ( (int) get_post_field( 'post_author', $product_id ) === (int) $user_id ) {
        wp_delete_post( $product_id, true );
    }

    wp_redirect( add_query_arg( array( 'dash_page' => 'my-products', 'deleted' => 'true' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
    exit;
}
add_action( 'admin_post_org_delete_product', 'org_ecosystem_handle_product_delete' );

/**
 * Handle Job Save
 */
function org_ecosystem_handle_job_save() {
	if ( ! isset( $_POST['org_job_nonce'] ) || ! wp_verify_nonce( $_POST['org_job_nonce'], 'org_save_job_action' ) ) {
		return;
	}

    if ( ! org_ecosystem_can_user_do( 'manage_jobs' ) ) {
        wp_die( __( 'You do not have permission to post jobs. Please upgrade your membership.', 'org-ecosystem' ) );
    }

	$user_id = get_current_user_id();
	$job_id = isset( $_POST['job_id'] ) ? intval( $_POST['job_id'] ) : 0;
	$title = sanitize_text_field( $_POST['job_title'] );
	$description = sanitize_textarea_field( $_POST['job_description'] );
	$location = intval( $_POST['job_location'] );
    $salary = sanitize_text_field( $_POST['job_salary'] );
    $type = sanitize_text_field( $_POST['job_type'] );
    $promote = isset( $_POST['job_promote'] ) ? '1' : '0';

	if ( $job_id ) {
		if ( (int) get_post_field( 'post_author', $job_id ) === (int) $user_id ) {
			wp_update_post( array(
				'ID'           => $job_id,
				'post_title'   => $title,
				'post_content' => $description,
			) );
		}
	} else {
        $is_vendor = current_user_can( 'vendor' );
		$job_id = wp_insert_post( array(
			'post_title'   => $title,
			'post_content' => $description,
			'post_type'    => 'job',
			'post_status'  => ( $is_vendor ) ? 'pending' : (current_user_can('publish_posts') ? 'publish' : 'pending'),
			'post_author'  => $user_id,
		) );
	}

    if ( $job_id ) {
        update_post_meta( $job_id, '_job_salary', $salary );
        update_post_meta( $job_id, '_job_type', $type );
    }

	if ( $job_id ) {
		if ( $location ) {
			wp_set_post_terms( $job_id, array( $location ), 'location' );
		}

        $is_vendor = current_user_can( 'vendor' );
        $job_id_existing = isset( $_POST['job_id'] ) ? intval( $_POST['job_id'] ) : 0;

        $checkout_type = '';
        if ( ! $job_id_existing && $is_vendor ) {
            $checkout_type = ( $promote === '1' ) ? 'job_listing_promoted' : 'job_listing';
        } elseif ( $promote === '1' ) {
            $checkout_type = 'promotion';
        }

        if ( $checkout_type ) {
             if ( $promote === '1' ) {
                 update_post_meta( $job_id, '_job_is_featured', 'pending' );
             }
             wp_redirect( add_query_arg( array(
                'checkout_type'    => $checkout_type,
                'checkout_item_id' => $job_id
            ), org_ecosystem_get_page_url( 'page-checkout.php' ) ) );
            exit;
        }
	}

	wp_redirect( add_query_arg( array( 'dash_page' => 'my-jobs', 'saved' => 'true' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
	exit;
}
add_action( 'admin_post_org_save_job', 'org_ecosystem_handle_job_save' );

/**
 * Handle Job Delete
 */
function org_ecosystem_handle_job_delete() {
    $job_id = isset( $_GET['job_id'] ) ? intval( $_GET['job_id'] ) : 0;
    if ( ! $job_id || ! check_admin_referer( 'org_delete_job_action' ) ) return;

    $user_id = get_current_user_id();
    if ( (int) get_post_field( 'post_author', $job_id ) === (int) $user_id ) {
        wp_delete_post( $job_id, true );
    }

    wp_redirect( add_query_arg( array( 'dash_page' => 'my-jobs', 'deleted' => 'true' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
    exit;
}
add_action( 'admin_post_org_delete_job', 'org_ecosystem_handle_job_delete' );

/**
 * Handle Listing Promotion
 */
function org_ecosystem_handle_promote_listing() {
    $item_id = isset( $_GET['checkout_item_id'] ) ? intval( $_GET['checkout_item_id'] ) : (isset($_GET['item_id']) ? intval($_GET['item_id']) : 0);
    $type = isset( $_GET['checkout_type'] ) ? sanitize_text_field( $_GET['checkout_type'] ) : 'promotion';

    if ( ! $item_id || ! check_admin_referer( 'org_promote_listing_action' ) ) return;

    $user_id = get_current_user_id();
    if ( (int) get_post_field( 'post_author', $item_id ) === (int) $user_id ) {
        // Redirect to unified checkout
        wp_redirect( add_query_arg( array(
            'checkout_type'    => $type,
            'checkout_item_id' => $item_id
        ), org_ecosystem_get_page_url( 'page-checkout.php' ) ) );
        exit;
    }

    wp_redirect( add_query_arg( array( 'dash_page' => 'overview', 'error' => 'unauthorized' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
    exit;
}
add_action( 'admin_post_org_promote_listing', 'org_ecosystem_handle_promote_listing' );

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
