<?php
/**
 * Template Name: Member Dashboard
 *
 * @package OrgEcosystem
 */

if ( ! is_user_logged_in() ) {
	wp_redirect( wp_login_url() );
	exit;
}

get_header();

$user_id = get_current_user_id();
$member_id = get_user_meta( $user_id, '_member_profile_id', true );
$membership_level = get_user_meta( $user_id, '_membership_level', true );
$status = get_post_meta( $member_id, '_member_status', true );
$action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : 'overview';

function is_dash_active($slug, $action) {
    return $slug === $action ? 'active' : '';
}
?>

<div class="member-dashboard py-5 bg-light">
	<div class="container">
		<div class="row">
			<!-- Dashboard Sidebar -->
			<div class="col-lg-3">
				<div class="card shadow-sm border-0 mb-4 rounded-4 overflow-hidden">
					<div class="card-body p-0">
						<div class="p-4 text-center border-bottom bg-white">
							<?php echo get_avatar( $user_id, 80, '', '', array( 'class' => 'rounded-circle mb-3 border border-3 border-light shadow-sm' ) ); ?>
							<h5 class="mb-1 fw-bold"><?php echo wp_get_current_user()->display_name; ?></h5>
							<span class="badge bg-primary rounded-pill px-3"><?php echo esc_html( ucfirst( $membership_level ) ); ?> Member</span>
						</div>
						<div class="list-group list-group-flush dashboard-nav-list">
							<div class="px-4 py-3 small text-muted text-uppercase fw-bold bg-light border-bottom"><?php _e( 'Overview', 'org-ecosystem' ); ?></div>
                            <a href="?action=overview" class="list-group-item list-group-item-action <?php echo is_dash_active('overview', $action); ?> border-0"><i class="bi bi-speedometer2 me-3"></i> <?php _e( 'Insights', 'org-ecosystem' ); ?></a>
							<a href="?action=analytics" class="list-group-item list-group-item-action <?php echo is_dash_active('analytics', $action); ?> border-0"><i class="bi bi-bar-chart me-3"></i> <?php _e( 'Visibility Stats', 'org-ecosystem' ); ?></a>

                            <div class="px-4 py-3 small text-muted text-uppercase fw-bold bg-light border-bottom border-top"><?php _e( 'Communication', 'org-ecosystem' ); ?></div>
                            <a href="?action=group-chat" class="list-group-item list-group-item-action <?php echo is_dash_active('group-chat', $action); ?> border-0"><i class="bi bi-people me-3"></i> <?php _e( 'Community Chat', 'org-ecosystem' ); ?></a>
                            <a href="?action=messages" class="list-group-item list-group-item-action <?php echo is_dash_active('messages', $action); ?> border-0"><i class="bi bi-chat-left-text me-3"></i> <?php _e( 'Internal Inbox', 'org-ecosystem' ); ?></a>

                            <div class="px-4 py-3 small text-muted text-uppercase fw-bold bg-light border-bottom border-top"><?php _e( 'Professional Hub', 'org-ecosystem' ); ?></div>
							<?php if ( org_ecosystem_can_user_do( 'publish_profile' ) ) : ?>
                                <a href="?action=edit-profile" class="list-group-item list-group-item-action <?php echo is_dash_active('edit-profile', $action); ?> border-0"><i class="bi bi-person-bounding-box me-3"></i> <?php _e( 'Profile & Bio', 'org-ecosystem' ); ?></a>
                            <?php endif; ?>

                            <?php if ( org_ecosystem_can_user_do( 'manage_products' ) ) : ?>
							    <a href="?action=my-products" class="list-group-item list-group-item-action <?php echo is_dash_active('my-products', $action); ?> border-0"><i class="bi bi-box-seam me-3"></i> <?php _e( 'My Offerings', 'org-ecosystem' ); ?></a>
                            <?php endif; ?>

							<a href="?action=my-jobs" class="list-group-item list-group-item-action <?php echo is_dash_active('my-jobs', $action); ?> border-0"><i class="bi bi-briefcase me-3"></i> <?php _e( 'My Openings', 'org-ecosystem' ); ?></a>
							<a href="?action=my-events" class="list-group-item list-group-item-action <?php echo is_dash_active('my-events', $action); ?> border-0"><i class="bi bi-calendar-check me-3"></i> <?php _e( 'Registered Events', 'org-ecosystem' ); ?></a>

                            <div class="px-4 py-3 small text-muted text-uppercase fw-bold bg-light border-bottom border-top"><?php _e( 'Financials & Tools', 'org-ecosystem' ); ?></div>
                            <a href="?action=transactions" class="list-group-item list-group-item-action <?php echo is_dash_active('transactions', $action); ?> border-0"><i class="bi bi-wallet2 me-3"></i> <?php _e( 'Earnings & Ledger', 'org-ecosystem' ); ?></a>
                            <a href="?action=payments" class="list-group-item list-group-item-action <?php echo is_dash_active('payments', $action); ?> border-0"><i class="bi bi-cash me-3"></i> <?php _e( 'Payments & Payouts', 'org-ecosystem' ); ?></a>
                            <a href="?action=referrals" class="list-group-item list-group-item-action <?php echo is_dash_active('referrals', $action); ?> border-0"><i class="bi bi-share me-3"></i> <?php _e( 'Referral Center', 'org-ecosystem' ); ?></a>
                            <a href="?action=billing" class="list-group-item list-group-item-action <?php echo is_dash_active('billing', $action); ?> border-0"><i class="bi bi-credit-card me-3"></i> <?php _e( 'Subscription', 'org-ecosystem' ); ?></a>
							<a href="?action=resources" class="list-group-item list-group-item-action <?php echo is_dash_active('resources', $action); ?> border-0"><i class="bi bi-file-earmark-arrow-down me-3"></i> <?php _e( 'Downloads', 'org-ecosystem' ); ?></a>
							<a href="?action=support" class="list-group-item list-group-item-action <?php echo is_dash_active('support', $action); ?> border-0"><i class="bi bi-life-preserver me-3"></i> <?php _e( 'Support Tickets', 'org-ecosystem' ); ?></a>

                            <div class="px-4 py-3 bg-light border-top">
							    <a href="<?php echo wp_logout_url( home_url() ); ?>" class="list-group-item list-group-item-action text-danger bg-transparent border-0 p-0"><i class="bi bi-box-arrow-right me-3"></i> Logout</a>
                            </div>
						</div>
					</div>
				</div>
			</div>

			<!-- Dashboard Content -->
			<div class="col-lg-9">
				<div class="dashboard-content card shadow-sm border-0 p-4 rounded-4 min-vh-70">
					<?php
					switch ( $action ) {
						case 'edit-profile':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/edit-profile.php';
							break;
						case 'my-products':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/my-products.php';
							break;
						case 'my-jobs':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/my-jobs.php';
							break;
						case 'billing':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/billing.php';
							break;
						case 'resources':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/resources.php';
							break;
						case 'analytics':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/analytics.php';
							break;
						case 'support':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/support.php';
							break;
                        case 'messages':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/messages.php';
							break;
                        case 'group-chat':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/group-chat.php';
							break;
                        case 'transactions':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/transactions.php';
							break;
                        case 'payments':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/payments.php';
							break;
                        case 'referrals':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/referrals.php';
							break;
						case 'gdpr':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/gdpr.php';
							break;
						case 'my-events':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/my-events.php';
							break;
						case 'my-applications':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/my-applications.php';
							break;
						default:
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/overview.php';
							break;
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
    .dashboard-nav-list .list-group-item { padding: 0.8rem 1.5rem; transition: all 0.2s; }
    .dashboard-nav-list .list-group-item.active { background: rgba(13, 110, 253, 0.05); color: #0d6efd; border-right: 4px solid #0d6efd !important; font-weight: 600; }
    .dashboard-nav-list .list-group-item:hover:not(.active) { background: #f8fafc; padding-left: 1.8rem; }
    .min-vh-70 { min-height: 70vh; }
</style>

<?php
get_footer();
