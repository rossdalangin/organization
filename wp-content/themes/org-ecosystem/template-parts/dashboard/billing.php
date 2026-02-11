<?php
/**
 * Dashboard Billing Part
 */
$user_id = get_current_user_id();
$membership_level = get_user_meta( $user_id, '_membership_level', true );
$last_txn = get_user_meta( $user_id, '_last_transaction_id', true );
?>
<h2 class="h4 mb-4"><?php _e( 'Billing & Subscription', 'org-ecosystem' ); ?></h2>

<div class="card bg-white border shadow-sm mb-4">
	<div class="card-body">
		<div class="row align-items-center">
			<div class="col-md-8">
				<h5><?php _e( 'Current Plan:', 'org-ecosystem' ); ?> <strong><?php echo esc_html( ucfirst( $membership_level ) ); ?></strong></h5>
				<p class="text-muted mb-0"><?php _e( 'Your subscription is active and will renew automatically.', 'org-ecosystem' ); ?></p>
			</div>
			<div class="col-md-4 text-md-end mt-3 mt-md-0">
				<?php
				$member_id = get_user_meta( $user_id, '_member_profile_id', true );
				$status = get_post_meta( $member_id, '_member_status', true );
				if ( $status === 'expired' ) : ?>
					<a href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'org_renew_membership' ), admin_url( 'admin-post.php' ) ), 'org_renew_membership_action' ); ?>" class="btn btn-warning fw-bold"><i class="bi bi-arrow-repeat me-1"></i> <?php _e( 'Renew Now', 'org-ecosystem' ); ?></a>
				<?php else : ?>
					<a href="#" class="btn btn-primary"><?php _e( 'Change Plan', 'org-ecosystem' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<h5 class="mb-3"><?php _e( 'Payment History', 'org-ecosystem' ); ?></h5>
<div class="table-responsive">
	<table class="table table-hover border">
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
			<?php if ( $last_txn ) : ?>
			<tr>
				<td><?php echo date( 'M d, Y' ); ?></td>
				<td><code><?php echo esc_html( $last_txn ); ?></code></td>
				<td>₱ 1,500.00</td>
				<td><span class="badge bg-success">Paid</span></td>
				<td><a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-download"></i></a></td>
			</tr>
			<?php else : ?>
			<tr>
				<td colspan="5" class="text-center py-4"><?php _e( 'No payment history found.', 'org-ecosystem' ); ?></td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
