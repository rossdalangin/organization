<?php
/**
 * Dashboard Payments & Payouts Template Part
 */
$user_id = get_current_user_id();
$paypal = get_user_meta( $user_id, '_member_paypal', true );
$gcash = get_user_meta( $user_id, '_member_gcash', true );
$balance = org_ecosystem_get_user_total_commissions( $user_id );
?>
<div class="payments-center">
    <h3 class="fw-bold mb-4"><?php _e( 'Financial Center', 'org-ecosystem' ); ?></h3>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary text-white h-100">
                <h5 class="mb-3"><?php _e( 'How to Pay the Organization', 'org-ecosystem' ); ?></h5>
                <p class="small opacity-75 mb-4"><?php _e( 'For manual membership renewals or featured listing fees, please use our official channels:', 'org-ecosystem' ); ?></p>
                <div class="bg-white bg-opacity-10 p-3 rounded-3 mb-0">
                    <div class="mb-2"><strong>GCash:</strong> <?php echo esc_html( get_option('org_gcash_number', '0917XXXXXXX') ); ?></div>
                    <div><strong>Bank:</strong> <?php echo nl2br( esc_html( get_option('org_offline_instructions', 'Contact Admin') ) ); ?></div>
                </div>
                <p class="small mt-3 mb-0"><em>* <?php _e( 'Please send proof of payment to the support desk.', 'org-ecosystem' ); ?></em></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100 border-start border-4 border-success">
                <h5 class="mb-3"><?php _e( 'How You Get Paid', 'org-ecosystem' ); ?></h5>
                <p class="small text-muted mb-4"><?php _e( 'Commissions from referrals and product sales are credited to your balance.', 'org-ecosystem' ); ?></p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted"><?php _e( 'Current Balance:', 'org-ecosystem' ); ?></span>
                    <span class="h4 fw-bold mb-0 text-success">₱ <?php echo number_format( $balance, 2 ); ?></span>
                </div>
                <button class="btn btn-success w-100 py-2 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#withdrawModal" <?php echo ($balance < 500) ? 'disabled' : ''; ?>>
                    <?php _e( 'Request Payout', 'org-ecosystem' ); ?>
                </button>
                <?php if($balance < 500) : ?>
                    <p class="text-center x-small text-muted mt-2 mb-0"><?php _e( 'Minimum withdrawal: ₱500.00', 'org-ecosystem' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <h5 class="fw-bold mb-3"><?php _e( 'Your Payout Settings', 'org-ecosystem' ); ?></h5>
        <div class="row">
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 mb-3">
                    <small class="d-block text-muted text-uppercase fw-bold mb-1"><?php _e( 'PayPal Email', 'org-ecosystem' ); ?></small>
                    <strong><?php echo $paypal ?: '<em>Not set</em>'; ?></strong>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 mb-3">
                    <small class="d-block text-muted text-uppercase fw-bold mb-1"><?php _e( 'GCash Number', 'org-ecosystem' ); ?></small>
                    <strong><?php echo $gcash ?: '<em>Not set</em>'; ?></strong>
                </div>
            </div>
        </div>
        <a href="<?php echo org_ecosystem_get_dash_url('edit-profile'); ?>" class="btn btn-link p-0 text-decoration-none small"><?php _e( 'Update payout details in Profile settings', 'org-ecosystem' ); ?> <i class="bi bi-arrow-right"></i></a>
    </div>
</div>
