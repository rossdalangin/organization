<?php
/**
 * Dashboard Billing Part
 */
$user_id = get_current_user_id();
$member_id = get_user_meta( $user_id, '_member_profile_id', true );
$membership_level = get_user_meta( $user_id, '_membership_level', true ) ?: 'community';
$status = get_post_meta( $member_id, '_member_status', true ) ?: 'pending';
$history = get_user_meta( $user_id, '_payment_history', true ) ?: array();

$status_colors = array(
    'active'  => 'success',
    'pending' => 'warning',
    'expired' => 'danger'
);
$status_color = isset($status_colors[$status]) ? $status_colors[$status] : 'secondary';
?>
<h2 class="h4 mb-4"><?php _e( 'Billing & Subscription', 'org-ecosystem' ); ?></h2>

<div class="card bg-white border shadow-sm mb-4 rounded-4 overflow-hidden">
    <div class="card-header bg-light py-3 border-bottom">
        <h5 class="mb-0 fw-bold"><?php _e( 'Plan Details', 'org-ecosystem' ); ?></h5>
    </div>
	<div class="card-body p-4">
		<div class="row align-items-center">
			<div class="col-md-8">
				<div class="d-flex align-items-center mb-3">
                    <h5 class="mb-0 me-3"><?php _e( 'Current Plan:', 'org-ecosystem' ); ?> <span class="badge bg-primary fs-6"><?php echo esc_html( ucfirst( $membership_level ) ); ?></span></h5>
                    <span class="badge bg-<?php echo $status_color; ?>-subtle text-<?php echo $status_color; ?> border border-<?php echo $status_color; ?> px-3"><?php echo esc_html( ucfirst( $status ) ); ?></span>
                </div>
				<p class="text-muted mb-0">
                    <?php
                    if ($status === 'active') {
                        _e( 'Your subscription is active and gives you full access to ecosystem benefits.', 'org-ecosystem' );
                    } elseif ($status === 'pending') {
                        _e( 'Your account is pending approval. Please complete your profile or payment.', 'org-ecosystem' );
                    } else {
                        _e( 'Your membership has expired. Please renew to regain access.', 'org-ecosystem' );
                    }
                    ?>
                </p>
			</div>
			<div class="col-md-4 text-md-end mt-3 mt-md-0">
				<?php
				if ( $status === 'expired' ) : ?>
					<a href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'org_renew_membership' ), admin_url( 'admin-post.php' ) ), 'org_renew_membership_action' ); ?>" class="btn btn-warning fw-bold"><i class="bi bi-arrow-repeat me-1"></i> <?php _e( 'Renew Now', 'org-ecosystem' ); ?></a>
				<?php elseif ( $membership_level === 'community' || $membership_level === 'free' ) : ?>
                    <a href="<?php echo esc_url( add_query_arg( array( 'checkout_type' => 'membership', 'plan_id' => 'professional' ), org_ecosystem_get_page_url( 'page-checkout.php' ) ) ); ?>" class="btn btn-success fw-bold shadow-sm">
                        <i class="bi bi-rocket-takeoff me-1"></i> <?php _e( 'Upgrade Membership', 'org-ecosystem' ); ?>
                    </a>
				<?php else : ?>
					<a href="<?php echo esc_url( org_ecosystem_get_page_url( 'page-plans.php' ) ); ?>" class="btn btn-primary"><?php _e( 'Change Plan', 'org-ecosystem' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<div class="card bg-white border shadow-sm mb-4 rounded-4 overflow-hidden">
    <div class="card-header bg-light py-3 border-bottom">
        <h5 class="mb-0 fw-bold"><?php _e( 'Plan Benefits', 'org-ecosystem' ); ?></h5>
    </div>
    <div class="card-body p-4">
        <ul class="list-group list-group-flush">
            <?php
            $levels = org_ecosystem_get_membership_levels();
            if ( isset($levels[$membership_level]['features']) ) :
                foreach ( $levels[$membership_level]['features'] as $feature ) : ?>
                    <li class="list-group-item px-0 border-0 d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-3"></i>
                        <?php echo esc_html( $feature ); ?>
                    </li>
                <?php endforeach;
            endif; ?>
        </ul>
    </div>
</div>

<h5 class="mb-3 fw-bold"><?php _e( 'Payment History & Receipts', 'org-ecosystem' ); ?></h5>
<div class="table-responsive">
	<table class="table table-hover border rounded-3 overflow-hidden">
		<thead class="table-light">
			<tr>
				<th>Date</th>
				<th>Transaction ID</th>
				<th>Amount</th>
				<th>Status</th>
				<th>Receipt</th>
			</tr>
		</thead>
		<tbody>
			<?php if ( ! empty( $history ) ) :
				foreach ( array_reverse( $history ) as $item ) : ?>
				<tr>
					<td><?php echo date( 'M d, Y', strtotime( $item['date'] ) ); ?></td>
					<td><code><?php echo esc_html( $item['txn_id'] ); ?></code></td>
					<td>₱ <?php echo number_format( $item['amount'] ); ?></td>
					<td><span class="badge bg-success"><?php echo esc_html( $item['status'] ); ?></span></td>
					<td>
						<a href="<?php echo esc_url( add_query_arg( array( 'txn_id' => $item['txn_id'], 'dash_page' => 'download_receipt' ), org_ecosystem_get_dash_url() ) ); ?>" class="btn btn-sm btn-outline-secondary">
							<i class="bi bi-download"></i>
						</a>
					</td>
				</tr>
				<?php endforeach;
			else : ?>
			<tr>
				<td colspan="5" class="text-center py-4"><?php _e( 'No payment history found.', 'org-ecosystem' ); ?></td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
