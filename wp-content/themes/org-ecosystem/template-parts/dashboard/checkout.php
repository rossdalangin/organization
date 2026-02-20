<?php
/**
 * Dashboard Checkout Template Part
 */
$user_id = get_current_user_id();
$type = isset( $_GET['checkout_type'] ) ? sanitize_text_field( $_GET['checkout_type'] ) : get_query_var('checkout_type');
$item_id = isset( $_GET['checkout_item_id'] ) ? intval( $_GET['checkout_item_id'] ) : get_query_var('checkout_item_id');
$plan = isset( $_GET['plan_id'] ) ? sanitize_text_field( $_GET['plan_id'] ) : get_query_var('plan_id');

// Fallback for Membership Upgrades if plan_id is missing but expected
if ( $type === 'membership' && empty($plan) ) {
    $plan = 'professional';
}

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
        <h3 class="fw-bold mb-0">
            <?php _e( 'Secure Checkout', 'org-ecosystem' ); ?>
            <span id="test-mode-badge" class="badge bg-warning text-dark ms-2 d-none" style="font-size: 0.5em; vertical-align: middle;">TEST MODE</span>
        </h3>
        <a href="?dash_page=overview" class="btn btn-outline-secondary btn-sm"><?php _e( 'Cancel', 'org-ecosystem' ); ?></a>
    </div>

    <div id="localhost-dev-alert" class="alert alert-warning border-0 shadow-sm mb-4 d-none">
        <div class="d-flex align-items-center">
            <i class="bi bi-cpu fs-3 me-3"></i>
            <div>
                <h6 class="fw-bold mb-1"><?php _e( 'Developer Environment detected', 'org-ecosystem' ); ?></h6>
                <p class="small mb-2"><?php _e( 'You are on localhost or in admin mode. Real gateway redirections might fail or be slow. Use the bypass tool to instantly activate the membership/feature.', 'org-ecosystem' ); ?></p>
                <div class="d-flex gap-2">
                    <button type="button" id="btn-bypass-payment" class="btn btn-dark btn-sm fw-bold">
                        <i class="bi bi-magic me-1"></i> <?php _e( 'Bypass Payment (Simulate Success)', 'org-ecosystem' ); ?>
                    </button>
                    <button type="button" class="btn btn-outline-dark btn-sm" onclick="location.reload();">
                        <i class="bi bi-arrow-clockwise"></i> <?php _e( 'Reload Page', 'org-ecosystem' ); ?>
                    </button>
                </div>
            </div>
        </div>
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
                    <input type="hidden" name="redirect_to" value="<?php echo esc_url( org_ecosystem_get_page_url( 'page-dashboard.php' ) ); ?>">
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

        // Localhost awareness - check both boolean and string variants
        if (org_ajax.is_localhost === true || org_ajax.is_localhost === '1' || org_ajax.is_localhost === 1) {
            $('#localhost-dev-alert').removeClass('d-none');
        }

        $('input[name="gateway"]').on('change', function() {
            const val = $(this).val();
            if (instructions[val]) {
                $('#instruction-text').html(instructions[val]);
                $('#payment-instructions').removeClass('d-none');
            } else {
                $('#payment-instructions').addClass('d-none');
            }

            // Show test mode badge if selected gateway is in test mode
            if ((val === 'stripe' && org_ajax.stripe_mode === 'test') || (val === 'paypal' && org_ajax.paypal_mode === 'test')) {
                $('#test-mode-badge').removeClass('d-none');
            } else {
                $('#test-mode-badge').addClass('d-none');
            }
        });

        // Trigger change on load to show initial instructions if any
        $('input[name="gateway"]:checked').trigger('change');

        function addQueryParam(url, key, value) {
            var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
            var separator = url.indexOf('?') !== -1 ? "&" : "?";
            if (url.match(re)) {
                return url.replace(re, '$1' + key + "=" + value + '$2');
            }
            else {
                return url + separator + key + "=" + value;
            }
        }

        $('#btn-bypass-payment').on('click', function() {
            if (!confirm('This will simulate a successful payment. Continue?')) return;

            const btn = $(this);
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Bypassing...');

            const ajaxData = {
                action: 'org_bypass_payment',
                amount: '<?php echo $amount; ?>',
                gateway: 'bypass',
                type: '<?php echo $type; ?>',
                item_id: '<?php echo $item_id; ?>',
                plan: '<?php echo $plan; ?>',
                security: '<?php echo wp_create_nonce("org_payment_nonce"); ?>'
            };

            $.post(org_ajax.ajaxurl, ajaxData, (response) => {
                if (response.success) {
                    const dashUrlBase = '<?php echo esc_url(org_ecosystem_get_page_url("page-dashboard.php")); ?>';
                    var successUrl = addQueryParam(dashUrlBase, 'dash_page', 'overview');
                    successUrl = addQueryParam(successUrl, 'payment', 'success');
                    window.location.href = successUrl;
                } else {
                    alert('Bypass Error: ' + response.data);
                    btn.prop('disabled', false).html('<i class="bi bi-magic me-1"></i> Bypass Payment');
                }
            });
        });

        $('#checkout-form').on('submit', function(e) {
            const gateway = $('input[name="gateway"]:checked').val();
            const btn = $(this).find('button[type="submit"]');

            if (gateway === 'stripe' || gateway === 'paypal') {
                e.preventDefault();
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Connecting to ' + gateway.toUpperCase() + ' Gateway...');

                // Still record the transaction in our DB first via AJAX
                const ajaxData = {
                    action: 'org_process_payment',
                    amount: '<?php echo $amount; ?>',
                    gateway: gateway,
                    type: '<?php echo $type; ?>',
                    item_id: '<?php echo $item_id; ?>',
                    plan: '<?php echo $plan; ?>',
                    security: '<?php echo wp_create_nonce("org_payment_nonce"); ?>'
                };

                $.post(org_ajax.ajaxurl, ajaxData, (response) => {
                    if (response.success) {
                        const dashUrlBase = $('input[name="redirect_to"]').val() || '<?php echo esc_url(org_ecosystem_get_page_url("page-dashboard.php")); ?>';

                        if (gateway === 'paypal') {
                            const business = '<?php echo esc_js( get_option("org_paypal_email") ); ?>';
                            const mode = org_ajax.paypal_mode;
                            const paypalUrl = (mode === 'live') ? 'https://www.paypal.com/cgi-bin/webscr' : 'https://www.sandbox.paypal.com/cgi-bin/webscr';

                            var returnUrl = addQueryParam(dashUrlBase, 'dash_page', 'overview');
                            returnUrl = addQueryParam(returnUrl, 'payment', 'pending');
                            returnUrl = addQueryParam(returnUrl, 'txn', response.data.txn_id);

                            var cancelUrl = addQueryParam(dashUrlBase, 'dash_page', 'checkout');
                            cancelUrl = addQueryParam(cancelUrl, 'checkout_type', '<?php echo $type; ?>');
                            cancelUrl = addQueryParam(cancelUrl, 'error', 'cancelled');

                            const params = {
                                'cmd': '_xclick',
                                'business': business,
                                'item_name': '<?php echo esc_js($item_name); ?>',
                                'amount': '<?php echo $amount; ?>',
                                'currency_code': 'PHP',
                                'custom': response.data.txn_id,
                                'return': returnUrl,
                                'cancel_return': cancelUrl
                            };

                            const form = $('<form>', { action: paypalUrl, method: 'post' });
                            $.each(params, (k, v) => form.append($('<input>', { type: 'hidden', name: k, value: v })));
                            $('body').append(form);
                            form.submit();
                        } else if (gateway === 'stripe') {
                            if (typeof Stripe !== 'undefined' && org_ajax.stripe_pub_key) {
                                // In a real implementation with a proper backend session creation:
                                // const stripe = Stripe(org_ajax.stripe_pub_key);
                                // stripe.redirectToCheckout({ sessionId: response.data.stripe_session_id });

                                // For now, since we don't have the Stripe PHP SDK installed,
                                // we simulate the redirection but inform the user.
                                alert('Stripe keys detected. In a production environment, this would redirect to Stripe Checkout.');
                            }

                            var successUrl = addQueryParam(dashUrlBase, 'dash_page', 'overview');
                            successUrl = addQueryParam(successUrl, 'payment', 'pending');
                            successUrl = addQueryParam(successUrl, 'txn', response.data.txn_id);

                            setTimeout(() => {
                                window.location.href = successUrl;
                            }, 1000);
                        }
                    } else {
                        alert('Error: ' + response.data);
                        btn.prop('disabled', false).text('<?php _e( "Complete Payment", "org-ecosystem" ); ?>');
                    }
                }).fail(function(xhr, status, error) {
                    alert('System Error: ' + error);
                    btn.prop('disabled', false).text('<?php _e( "Complete Payment", "org-ecosystem" ); ?>');
                });
            }
        });
    });
</script>

<style>
    .payment-option-card { cursor: pointer; transition: all 0.2s; }
    .payment-option-card:hover { border-color: #0d6efd !important; background: #f8faff; }
    .payment-option-card input:checked + label { color: #0d6efd; }
</style>
