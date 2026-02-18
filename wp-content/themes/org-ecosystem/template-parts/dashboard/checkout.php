<?php
/**
 * Dashboard Checkout Template Part
 */
$user_id = get_current_user_id();
$type = isset( $_GET['type'] ) ? sanitize_text_field( $_GET['type'] ) : '';
$item_id = isset( $_GET['item_id'] ) ? intval( $_GET['item_id'] ) : 0;
$plan = isset( $_GET['plan'] ) ? sanitize_text_field( $_GET['plan'] ) : '';

$item_name = '';
$amount = 0;
$description = '';

if ( $type === 'membership' ) {
    $levels = org_ecosystem_get_membership_levels();
    if ( isset( $levels[$plan] ) ) {
        $item_name = $levels[$plan]['name'];
        $amount = $levels[$plan]['price'];
        $description = sprintf( __( 'Upgrade to %s plan.', 'org-ecosystem' ), $item_name );
    }
} elseif ( $type === 'promotion' ) {
    $item_name = __( 'Listing Promotion (Featured)', 'org-ecosystem' );
    $amount = get_theme_mod( 'promotion_price', '500' );
    $description = __( 'Promote your profile or product to the featured section.', 'org-ecosystem' );
} elseif ( $type === 'event' ) {
    $event = get_post( $item_id );
    if ( $event ) {
        $item_name = $event->post_title;
        $amount = get_post_meta( $item_id, '_event_price', true ) ?: 0;
        $description = __( 'Event Ticket Registration', 'org-ecosystem' );
    }
} elseif ( $type === 'product' ) {
    $product = get_post( $item_id );
    if ( $product ) {
        $item_name = $product->post_title;
        $amount = get_post_meta( $item_id, '_product_price', true ) ?: 0;
        $description = __( 'Product/Service Purchase', 'org-ecosystem' );
    }
} elseif ( $type === 'job_listing' ) {
    $job = get_post( $item_id );
    if ( $job ) {
        $item_name = $job->post_title;
        $amount = get_theme_mod( 'job_listing_price', '1000' );
        $description = __( 'Job Board Listing Fee (Vendor)', 'org-ecosystem' );
    }
} elseif ( $type === 'job_listing_promoted' ) {
    $job = get_post( $item_id );
    if ( $job ) {
        $item_name = $job->post_title;
        $listing_fee = get_theme_mod( 'job_listing_price', '1000' );
        $promo_fee = get_theme_mod( 'promotion_price', '500' );
        $amount = floatval($listing_fee) + floatval($promo_fee);
        $description = __( 'Job Listing Fee + Featured Promotion', 'org-ecosystem' );
    }
}

if ( ! $item_name ) {
    echo '<div class="alert alert-danger">' . __( 'Invalid checkout item.', 'org-ecosystem' ) . '</div>';
    return;
}
?>

<div class="checkout-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><?php _e( 'Secure Checkout', 'org-ecosystem' ); ?></h3>
        <a href="?action=overview" class="btn btn-outline-secondary btn-sm"><?php _e( 'Cancel', 'org-ecosystem' ); ?></a>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-4"><?php _e( 'Select Payment Method', 'org-ecosystem' ); ?></h5>

                <form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" id="checkout-form">
                    <input type="hidden" name="action" value="org_process_checkout">
                    <input type="hidden" name="item_type" value="<?php echo esc_attr( $type ); ?>">
                    <input type="hidden" name="item_id" value="<?php echo esc_attr( $item_id ); ?>">
                    <input type="hidden" name="plan" value="<?php echo esc_attr( $plan ); ?>">
                    <input type="hidden" name="amount" value="<?php echo esc_attr( $amount ); ?>">
                    <?php wp_nonce_field( 'org_checkout_action', 'org_checkout_nonce' ); ?>

                    <div class="payment-options">
                        <?php if ( get_option( 'org_stripe_enabled' ) ) : ?>
                            <div class="form-check payment-option-card p-3 mb-3 border rounded-3">
                                <input class="form-check-input ms-0 me-3" type="radio" name="gateway" id="gateway_stripe" value="stripe" checked>
                                <label class="form-check-label d-flex align-items-center" for="gateway_stripe">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" height="24" class="me-3" alt="Stripe">
                                    <span class="fw-bold"><?php _e( 'Credit / Debit Card', 'org-ecosystem' ); ?></span>
                                </label>
                            </div>
                        <?php endif; ?>

                        <?php if ( get_option( 'org_paypal_enabled' ) ) : ?>
                            <div class="form-check payment-option-card p-3 mb-3 border rounded-3">
                                <input class="form-check-input ms-0 me-3" type="radio" name="gateway" id="gateway_paypal" value="paypal" <?php echo !get_option('org_stripe_enabled') ? 'checked' : ''; ?>>
                                <label class="form-check-label d-flex align-items-center" for="gateway_paypal">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" height="24" class="me-3" alt="PayPal">
                                    <span class="fw-bold"><?php _e( 'PayPal Express', 'org-ecosystem' ); ?></span>
                                </label>
                            </div>
                        <?php endif; ?>

                        <?php if ( get_option( 'org_gcash_number' ) ) : ?>
                            <div class="form-check payment-option-card p-3 mb-3 border rounded-3">
                                <input class="form-check-input ms-0 me-3" type="radio" name="gateway" id="gateway_gcash" value="gcash">
                                <label class="form-check-label d-flex align-items-center" for="gateway_gcash">
                                    <i class="bi bi-smartphone fs-4 me-3 text-primary"></i>
                                    <div>
                                        <span class="fw-bold d-block"><?php _e( 'GCash Mobile Payment', 'org-ecosystem' ); ?></span>
                                        <small class="text-muted"><?php echo esc_html( get_option( 'org_gcash_number' ) ); ?></small>
                                    </div>
                                </label>
                            </div>
                        <?php endif; ?>

                        <div class="form-check payment-option-card p-3 mb-3 border rounded-3">
                            <input class="form-check-input ms-0 me-3" type="radio" name="gateway" id="gateway_offline" value="offline">
                            <label class="form-check-label d-flex align-items-center" for="gateway_offline">
                                <i class="bi bi-bank fs-4 me-3 text-secondary"></i>
                                <div>
                                    <span class="fw-bold d-block"><?php _e( 'Bank Transfer / Manual', 'org-ecosystem' ); ?></span>
                                    <small class="text-muted"><?php _e( 'Pay via bank or walk-in.', 'org-ecosystem' ); ?></small>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="payment-instructions" class="alert alert-info mt-4 d-none">
                        <h6 class="fw-bold"><i class="bi bi-info-circle me-2"></i> <?php _e( 'Payment Instructions', 'org-ecosystem' ); ?></h6>
                        <div id="instruction-text"></div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-4 py-3 rounded-pill fw-bold shadow">
                        <?php _e( 'Complete Payment', 'org-ecosystem' ); ?>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 2rem;">
                <h5 class="fw-bold mb-4"><?php _e( 'Order Summary', 'org-ecosystem' ); ?></h5>
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                    <div>
                        <h6 class="fw-bold mb-1"><?php echo esc_html( $item_name ); ?></h6>
                        <small class="text-muted"><?php echo esc_html( $description ); ?></small>
                    </div>
                    <div class="fw-bold text-primary">₱<?php echo number_format( $amount, 2 ); ?></div>
                </div>
                <div class="d-flex justify-content-between mb-4 h5 fw-bold">
                    <span><?php _e( 'Total Amount', 'org-ecosystem' ); ?></span>
                    <span>₱<?php echo number_format( $amount, 2 ); ?></span>
                </div>
                <div class="text-center">
                    <p class="small text-muted"><i class="bi bi-shield-check me-1 text-success"></i> <?php _e( 'Your transaction is secured with SSL encryption.', 'org-ecosystem' ); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        const instructions = {
            'gcash': '<?php echo esc_js( sprintf( __( "Please send ₱%s to GCash number: %s. Once sent, click 'Complete Payment' below. Our admin will verify your payment.", "org-ecosystem" ), number_format($amount, 2), get_option("org_gcash_number") ) ); ?>',
            'offline': '<?php echo esc_js( get_option("org_offline_instructions") ); ?>'
        };

        $('input[name="gateway"]').on('change', function() {
            const val = $(this).val();
            if (instructions[val]) {
                $('#instruction-text').html(instructions[val]);
                $('#payment-instructions').removeClass('d-none');
            } else {
                $('#payment-instructions').addClass('d-none');
            }
        });

        // Trigger change on load to show initial instructions if any
        $('input[name="gateway"]:checked').trigger('change');

        $('#checkout-form').on('submit', function(e) {
            const gateway = $('input[name="gateway"]:checked').val();
            if (gateway === 'stripe' || gateway === 'paypal') {
                e.preventDefault();
                const btn = $(this).find('button[type="submit"]');
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Redirecting to ' + gateway.toUpperCase() + '...');

                // Simulate gateway redirect
                setTimeout(() => {
                    this.submit();
                }, 1500);
            }
        });
    });
</script>

<style>
    .payment-option-card { cursor: pointer; transition: all 0.2s; }
    .payment-option-card:hover { border-color: #0d6efd !important; background: #f8faff; }
    .payment-option-card input:checked + label { color: #0d6efd; }
</style>
