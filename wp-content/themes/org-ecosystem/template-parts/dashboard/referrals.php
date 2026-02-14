<?php
/**
 * Dashboard Referrals Template Part
 */

$user_id = get_current_user_id();
$referral_code = get_user_meta( $user_id, '_org_referral_code', true );
if ( ! $referral_code ) {
    $referral_code = strtoupper( substr( md5( $user_id . time() ), 0, 8 ) );
    update_user_meta( $user_id, '_org_referral_code', $referral_code );
}

$referral_link = add_query_arg( 'ref', $referral_code, home_url() );

// Get Referral Stats
$referrals_query = new WP_Query( array(
    'post_type' => 'org_transaction',
    'author'    => $user_id,
    'meta_query' => array(
        array( 'key' => '_txn_type', 'value' => 'commission' )
    )
) );

$total_earned = 0;
while ( $referrals_query->have_posts() ) {
    $referrals_query->the_post();
    $total_earned += abs( floatval( get_post_meta( get_the_ID(), '_txn_amount', true ) ) );
}
wp_reset_postdata();
?>

<div class="referral-center">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><?php _e( 'Referral & Affiliate Center', 'org-ecosystem' ); ?></h3>
        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
            <i class="bi bi-piggy-bank me-2"></i><?php _e( '10% Commission Active', 'org-ecosystem' ); ?>
        </span>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary text-white h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box bg-white bg-opacity-25 rounded-3 p-2 me-3">
                        <i class="bi bi-link-45deg fs-4"></i>
                    </div>
                    <h5 class="mb-0"><?php _e( 'Your Unique Referral Link', 'org-ecosystem' ); ?></h5>
                </div>
                <div class="input-group mb-2">
                    <input type="text" class="form-control border-0 bg-white bg-opacity-10 text-white" value="<?php echo esc_url( $referral_link ); ?>" readonly id="refLink">
                    <button class="btn btn-light" type="button" onclick="copyRef()"><i class="bi bi-clipboard"></i></button>
                </div>
                <p class="small mb-0 opacity-75"><?php _e( 'Share this link to earn 10% from every membership sign-up.', 'org-ecosystem' ); ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100 border-start border-4 border-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1"><?php _e( 'Total Referral Earnings', 'org-ecosystem' ); ?></p>
                        <h2 class="fw-bold mb-0">₱ <?php echo number_format( $total_earned, 2 ); ?></h2>
                    </div>
                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle p-3">
                        <i class="bi bi-cash-stack fs-2"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="?action=transactions" class="text-decoration-none small fw-bold text-success"><?php _e( 'View Earnings History', 'org-ecosystem' ); ?> <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-3"><?php _e( 'Recent Referral Activity', 'org-ecosystem' ); ?></h5>
    <div class="table-responsive bg-white rounded-4 shadow-sm border overflow-hidden">
        <table class="table table-hover mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3"><?php _e( 'Date', 'org-ecosystem' ); ?></th>
                    <th class="py-3"><?php _e( 'Type', 'org-ecosystem' ); ?></th>
                    <th class="py-3"><?php _e( 'Commission', 'org-ecosystem' ); ?></th>
                    <th class="py-3 text-end pe-4"><?php _e( 'Status', 'org-ecosystem' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ( $referrals_query->have_posts() ) : ?>
                    <?php while ( $referrals_query->have_posts() ) : $referrals_query->the_post(); ?>
                        <tr>
                            <td class="ps-4"><?php echo get_the_date(); ?></td>
                            <td><span class="text-muted small"><?php _e( 'Affiliate Payout', 'org-ecosystem' ); ?></span></td>
                            <td class="fw-bold text-success">₱ <?php echo number_format( abs( floatval( get_post_meta( get_the_ID(), '_txn_amount', true ) ) ), 2 ); ?></td>
                            <td class="text-end pe-4">
                                <span class="badge bg-success rounded-pill"><?php _e( 'Credited', 'org-ecosystem' ); ?></span>
                            </td>
                        </tr>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="py-5 text-center text-muted">
                            <i class="bi bi-info-circle mb-2 d-block fs-3 opacity-50"></i>
                            <?php _e( 'No referral commissions yet. Start sharing your link!', 'org-ecosystem' ); ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function copyRef() {
    var copyText = document.getElementById("refLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    alert("Referral link copied!");
}
</script>
