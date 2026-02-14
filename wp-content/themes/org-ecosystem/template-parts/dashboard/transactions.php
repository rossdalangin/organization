<?php
/**
 * Dashboard Transactions Template Part
 */
?>
<div class="transactions-panel">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><?php _e( 'Financial Ledger', 'org-ecosystem' ); ?></h3>
        <div class="d-flex align-items-center gap-3">
            <div class="earnings-badge bg-primary text-white px-4 py-2 rounded-4 shadow-sm">
                <small class="d-block opacity-75"><?php _e( 'Total Earnings', 'org-ecosystem' ); ?></small>
                <span class="h4 fw-bold mb-0">₱ <?php echo number_format( org_ecosystem_get_user_total_commissions( get_current_user_id() ), 2 ); ?></span>
            </div>
            <button class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#withdrawModal"><i class="bi bi-bank me-2"></i> Withdraw</button>
        </div>
    </div>

    <!-- Withdraw Modal -->
    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 rounded-4" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="org_withdraw_request">
            <?php wp_nonce_field('org_withdraw_nonce'); ?>
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Request Withdrawal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="small text-muted mb-4">Earnings are processed via your registered GCash or PayPal account. Minimum withdrawal is ₱500.00</p>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Amount to Withdraw (₱)</label>
                    <input type="number" name="withdraw_amount" class="form-control form-control-lg" min="500" max="<?php echo org_ecosystem_get_user_total_commissions($user_id); ?>" step="0.01" required>
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-bold">Select Method</label>
                    <select name="withdraw_method" class="form-select">
                        <option value="gcash">GCash</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">Submit Request</button>
            </div>
        </form>
      </div>
    </div>

    <ul class="nav nav-pills mb-4 bg-light p-2 rounded-3" id="txnTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab"><?php _e( 'Payment History', 'org-ecosystem' ); ?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="earnings-tab" data-bs-toggle="tab" data-bs-target="#earnings" type="button" role="tab"><?php _e( 'Commissions & Sales', 'org-ecosystem' ); ?></button>
        </li>
    </ul>

    <div class="tab-content" id="txnTabContent">
        <!-- Tab 1: User Payments -->
        <div class="tab-pane fade show active" id="history" role="tabpanel">
            <?php
            $user_id = get_current_user_id();
            $txns = new WP_Query( array(
                'post_type' => 'org_transaction',
                'meta_query' => array(
                    array( 'key' => '_txn_user_id', 'value' => $user_id ),
                    array( 'key' => '_txn_type', 'value' => array('membership', 'event_ticket', 'featured_promo'), 'compare' => 'IN' ),
                )
            ) );

            if ( $txns->have_posts() ) : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle bg-white rounded-3 shadow-sm border overflow-hidden">
                        <thead class="bg-light">
                            <tr>
                                <th class="p-3 border-0">Date</th>
                                <th class="p-3 border-0">Reason</th>
                                <th class="p-3 border-0 text-end">Amount</th>
                                <th class="p-3 border-0 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ( $txns->have_posts() ) : $txns->the_post();
                                $status = get_post_meta( get_the_ID(), '_txn_status', true );
                                $color = $status === 'completed' ? 'success' : 'warning';
                            ?>
                                <tr>
                                    <td class="p-3 border-bottom-0"><?php echo get_the_date(); ?></td>
                                    <td class="p-3 border-bottom-0"><?php the_excerpt(); ?></td>
                                    <td class="p-3 border-bottom-0 text-end fw-bold">₱ <?php echo number_format( get_post_meta( get_the_ID(), '_txn_amount', true ), 2 ); ?></td>
                                    <td class="p-3 border-bottom-0 text-center"><span class="badge bg-<?php echo $color; ?> rounded-pill px-3"><?php echo esc_html( ucfirst( $status ) ); ?></span></td>
                                </tr>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="text-center py-5 bg-white rounded-4 border border-dashed">
                    <p class="text-muted mb-0"><?php _e( 'No payment records found.', 'org-ecosystem' ); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tab 2: Earnings -->
        <div class="tab-pane fade" id="earnings" role="tabpanel">
            <?php
            $earnings = new WP_Query( array(
                'post_type' => 'org_transaction',
                'meta_query' => array(
                    array( 'key' => '_txn_user_id', 'value' => $user_id ),
                    array( 'key' => '_txn_type', 'value' => 'commission' ),
                )
            ) );

            if ( $earnings->have_posts() ) : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle bg-white rounded-3 shadow-sm border overflow-hidden">
                        <thead class="bg-light">
                            <tr>
                                <th class="p-3 border-0">Date</th>
                                <th class="p-3 border-0">Source</th>
                                <th class="p-3 border-0 text-end">Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ( $earnings->have_posts() ) : $earnings->the_post(); ?>
                                <tr>
                                    <td class="p-3 border-bottom-0"><?php echo get_the_date(); ?></td>
                                    <td class="p-3 border-bottom-0"><?php the_title(); ?></td>
                                    <td class="p-3 border-bottom-0 text-end text-success fw-bold">+ ₱ <?php echo number_format( get_post_meta( get_the_ID(), '_txn_amount', true ), 2 ); ?></td>
                                </tr>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="text-center py-5 bg-white rounded-4 border border-dashed">
                    <p class="text-muted mb-0"><?php _e( 'Start referring members to see commissions here!', 'org-ecosystem' ); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
