<?php
/**
 * Template Name: Payment Methods
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="payments-page py-5 bg-light">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold mb-3"><?php _e( 'Secure Payment Solutions', 'org-ecosystem' ); ?></h1>
        <div class="lead text-muted mb-5">
            <?php
            $payments_intro = get_option( 'org_payments_intro' );
            if ( $payments_intro ) {
                echo wp_kses_post( $payments_intro );
            } else {
                _e( 'We support multiple payment gateways to ensure a seamless experience for our members.', 'org-ecosystem' );
            }
            ?>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" height="30" class="mb-4" alt="Stripe">
                    <p class="small text-muted mb-0"><?php _e( 'Global credit and debit card processing.', 'org-ecosystem' ); ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" height="30" class="mb-4" alt="PayPal">
                    <p class="small text-muted mb-0"><?php _e( 'Secure digital wallet and checkout.', 'org-ecosystem' ); ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4 d-flex align-items-center justify-content-center">
                    <h4 class="fw-bold text-primary mb-3"><?php _e( 'GCash', 'org-ecosystem' ); ?></h4>
                    <p class="small text-muted mb-0"><?php _e( 'Mobile payments for local members.', 'org-ecosystem' ); ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                    <i class="bi bi-bank display-5 text-secondary mb-3"></i>
                    <h5 class="fw-bold"><?php _e( 'Offline', 'org-ecosystem' ); ?></h5>
                    <p class="small text-muted mb-0"><?php _e( 'Direct bank transfers and cash payments.', 'org-ecosystem' ); ?></p>
                </div>
            </div>
        </div>

        <div class="mt-5 p-5 bg-white rounded-4 shadow-sm text-start mx-auto" style="max-width: 800px;">
            <h3 class="fw-bold mb-4"><?php _e( 'Billing FAQ', 'org-ecosystem' ); ?></h3>
            <div class="mb-4">
                <h6 class="fw-bold"><?php _e( 'Is my payment data secure?', 'org-ecosystem' ); ?></h6>
                <p class="text-muted small"><?php _e( 'Yes, we do not store your card details. All transactions are encrypted and processed by our secure partners (Stripe/PayPal).', 'org-ecosystem' ); ?></p>
            </div>
            <div class="mb-0">
                <h6 class="fw-bold"><?php _e( 'How do I get a receipt?', 'org-ecosystem' ); ?></h6>
                <p class="text-muted small mb-0"><?php _e( 'You can download a printable receipt for every transaction from your member dashboard under the Billing section.', 'org-ecosystem' ); ?></p>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
