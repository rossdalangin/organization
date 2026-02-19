<?php
/**
 * Payment Gateways and Transaction Management
 *
 * Supports PayPal, Stripe, GCash, and Offline.
 * Handles Commissions and Referrals.
 *
 * @package OrgEcosystem
 */

/**
 * Register Transaction Meta Boxes
 */
function org_ecosystem_transaction_meta() {
	add_meta_box( 'txn_details', __( 'Transaction Details', 'org-ecosystem' ), 'org_ecosystem_txn_callback', 'org_transaction', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'org_ecosystem_transaction_meta' );

function org_ecosystem_txn_callback( $post ) {
	$amount = get_post_meta( $post->ID, '_txn_amount', true );
	$gateway = get_post_meta( $post->ID, '_txn_gateway', true );
	$status = get_post_meta( $post->ID, '_txn_status', true );
	$type = get_post_meta( $post->ID, '_txn_type', true ); // membership, product, donation, etc.
	$user_id = get_post_meta( $post->ID, '_txn_user_id', true );
	?>
	<table class="form-table">
		<tr>
			<th>Amount</th>
			<td>₱ <?php echo esc_html( $amount ); ?></td>
		</tr>
		<tr>
			<th>Gateway</th>
			<td><?php echo esc_html( strtoupper( $gateway ) ); ?></td>
		</tr>
		<tr>
			<th>Status</th>
			<td><strong><?php echo esc_html( ucfirst( $status ) ); ?></strong></td>
		</tr>
		<tr>
			<th>User ID</th>
			<td><?php echo esc_html( $user_id ); ?></td>
		</tr>
	</table>
	<?php
}

/**
 * Handle Unified Payment Processing
 */
function org_ecosystem_process_unified_payment( $data ) {
    $user_id = isset($data['user_id']) ? $data['user_id'] : get_current_user_id();
    $amount  = $data['amount'];
    $gateway = $data['gateway']; // paypal, stripe, gcash, offline
    $type    = $data['type'];    // registration, product_sale, sponsor, donation
    $item_id = isset($data['item_id']) ? $data['item_id'] : 0;

    // Create Transaction Record
    $txn_id = wp_insert_post( array(
        'post_title'   => 'TXN_' . time() . '_' . $user_id,
        'post_type'    => 'org_transaction',
        'post_status'  => 'publish',
        'post_excerpt' => sprintf( '%s payment for %s', ucfirst($gateway), $type ),
    ) );

    update_post_meta( $txn_id, '_txn_amount', $amount );
    update_post_meta( $txn_id, '_txn_gateway', $gateway );
    update_post_meta( $txn_id, '_txn_type', $type );
    update_post_meta( $txn_id, '_txn_user_id', $user_id );
    update_post_meta( $txn_id, '_txn_item_id', $item_id );

    // Status Logic
    // In production, Stripe/PayPal should be 'pending' until IPN/Webhook verification.
    // For this ecosystem, we default to 'pending' to ensure administrative review or API confirmation.
    $status = 'pending';
    update_post_meta( $txn_id, '_txn_status', $status );

    // Handle Commissions/Referrals if product sale
    if ( $type === 'product_sale' && $status === 'completed' ) {
        org_ecosystem_handle_commission( $txn_id, $amount, $item_id );
    }

    return $txn_id;
}

/**
 * Referral & Commission Logic
 */
function org_ecosystem_handle_commission( $txn_id, $amount, $product_id ) {
    $product_author = $product_id ? get_post_field( 'post_author', $product_id ) : 0;
    $referral_code = isset( $_COOKIE['org_referral'] ) ? sanitize_text_field( $_COOKIE['org_referral'] ) : '';

    if ( $referral_code ) {
        $referrer = get_users( array( 'meta_key' => '_org_referral_code', 'meta_value' => $referral_code, 'number' => 1 ) );
        if ( ! empty( $referrer ) ) {
            $referrer_id = $referrer[0]->ID;
            $commission_rate = 0.10; // 10%
            $commission_amount = $amount * $commission_rate;

            // Log Referral Commission
            $comm_id = wp_insert_post( array(
                'post_title' => 'Comm: ' . $referral_code . ' from TXN ' . $txn_id,
                'post_type'  => 'org_transaction',
                'post_status'=> 'publish',
            ) );
            update_post_meta( $comm_id, '_txn_amount', $commission_amount );
            update_post_meta( $comm_id, '_txn_type', 'commission' );
            update_post_meta( $comm_id, '_txn_user_id', $referrer_id );
            update_post_meta( $comm_id, '_txn_status', 'completed' );
        }
    }
}

/**
 * AJAX Handler for Payments (Simplified for Demo)
 */
function org_ajax_process_payment() {
    check_ajax_referer( 'org_payment_nonce', 'security' );

    $type = sanitize_text_field( $_POST['type'] );
    $plan = isset( $_POST['plan'] ) ? sanitize_text_field( $_POST['plan'] ) : '';

    // Determine the actual type for the ledger
    $txn_type = $type;
    if ( $type === 'membership' && $plan ) {
        $txn_type = $plan;
    }

    $data = array(
        'amount'  => sanitize_text_field( $_POST['amount'] ),
        'gateway' => sanitize_text_field( $_POST['gateway'] ),
        'type'    => $txn_type,
        'item_id' => intval( $_POST['item_id'] ),
    );

    $txn_id = org_ecosystem_process_unified_payment( $data );

    if ( $txn_id && ! is_wp_error( $txn_id ) ) {
        wp_send_json_success( array( 'message' => 'Payment recorded and pending verification.', 'txn_id' => $txn_id ) );
    } else {
        $error = is_wp_error( $txn_id ) ? $txn_id->get_error_message() : 'Failed to record transaction.';
        wp_send_json_error( $error );
    }
}
add_action( 'wp_ajax_org_process_payment', 'org_ajax_process_payment' );
add_action( 'wp_ajax_nopriv_org_process_payment', 'org_ajax_process_payment' );

/**
 * Handle Withdrawal Request
 */
function org_ecosystem_handle_withdrawal() {
    if ( ! isset( $_POST['org_withdraw_nonce'] ) || ! wp_verify_nonce( $_POST['org_withdraw_nonce'], 'org_withdraw_request' ) ) {
        return;
    }

    $user_id = get_current_user_id();
    $amount = floatval( $_POST['withdraw_amount'] );
    $method = sanitize_text_field( $_POST['withdraw_method'] );

    // Create a negative transaction (Debit)
    $txn_id = wp_insert_post( array(
        'post_title' => 'Withdrawal Request: ' . $user_id,
        'post_type'  => 'org_transaction',
        'post_status'=> 'publish',
        'post_excerpt'=> 'Payout via ' . strtoupper($method),
    ) );

    update_post_meta( $txn_id, '_txn_amount', -$amount ); // Negative amount for withdrawal
    update_post_meta( $txn_id, '_txn_gateway', $method );
    update_post_meta( $txn_id, '_txn_type', 'withdrawal' );
    update_post_meta( $txn_id, '_txn_user_id', $user_id );
    update_post_meta( $txn_id, '_txn_status', 'pending' );

    wp_redirect( add_query_arg( array( 'dash_page' => 'transactions', 'requested' => 'true' ), org_ecosystem_get_page_url( 'page-dashboard.php' ) ) );
    exit;
}
add_action( 'admin_post_org_withdraw_request', 'org_ecosystem_handle_withdrawal' );

/**
 * Handle Checkout Submission from Dashboard
 */
function org_ecosystem_handle_checkout_submission() {
    if ( ! isset( $_POST['org_checkout_nonce'] ) || ! wp_verify_nonce( $_POST['org_checkout_nonce'], 'org_checkout_action' ) ) {
        wp_die( __( 'Security check failed. Please refresh the page and try again.', 'org-ecosystem' ) );
    }

    if ( ! is_user_logged_in() ) {
        wp_redirect( wp_login_url() );
        exit;
    }

    $user_id = get_current_user_id();
    $item_type = sanitize_text_field( $_POST['item_type'] );
    $item_id   = intval( $_POST['item_id'] );
    $plan      = sanitize_text_field( $_POST['plan'] );
    $amount    = floatval( $_POST['amount'] );
    $gateway   = sanitize_text_field( $_POST['gateway'] );

    // Determine specific type for ledger
    $type = $item_type;
    if ( $item_type === 'membership' ) {
        $type = $plan;
    }

    $txn_id = org_ecosystem_process_unified_payment( array(
        'user_id' => $user_id,
        'amount'  => $amount,
        'gateway' => $gateway,
        'type'    => $type,
        'item_id' => $item_id,
    ) );

    if ( $txn_id ) {
        // Special logic for Promotion (mark as pending promotion)
        if ( $item_type === 'promotion' ) {
            $meta_key = ( get_post_type($item_id) === 'member' ) ? '_member_is_featured' : ($item_id && get_post_type($item_id) === 'job' ? '_job_is_featured' : '_product_is_featured');
            update_post_meta( $item_id, $meta_key, 'pending' );
        }

        $redirect_url = isset($_POST['redirect_to']) ? esc_url_raw($_POST['redirect_to']) : org_ecosystem_get_page_url( 'page-dashboard.php' );
        $final_url = add_query_arg( array( 'dash_page' => 'overview', 'payment' => 'pending', 'txn' => $txn_id ), $redirect_url );
        error_log('Org Ecosystem: Checkout redirect to: ' . $final_url);
        wp_redirect( $final_url );
        exit;
    } else {
        wp_die( __( 'Checkout failed. Please try again.', 'org-ecosystem' ) );
    }
}
add_action( 'admin_post_org_process_checkout', 'org_ecosystem_handle_checkout_submission' );
add_action( 'admin_post_nopriv_org_process_checkout', 'org_ecosystem_handle_checkout_submission' );
