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
?>

<div class="member-dashboard py-5 bg-light">
	<div class="container">
		<div class="row">
			<!-- Dashboard Sidebar -->
			<div class="col-lg-3">
				<div class="card shadow-sm border-0 mb-4">
					<div class="card-body p-0">
						<div class="p-4 text-center border-bottom">
							<?php echo get_avatar( $user_id, 80, '', '', array( 'class' => 'rounded-circle mb-3' ) ); ?>
							<h5 class="mb-0"><?php echo wp_get_current_user()->display_name; ?></h5>
							<span class="badge bg-primary mt-2"><?php echo esc_html( ucfirst( $membership_level ) ); ?> Member</span>
						</div>
						<div class="list-group list-group-flush">
							<a href="?action=overview" class="list-group-item list-group-item-action active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
							<a href="?action=edit-profile" class="list-group-item list-group-item-action"><i class="bi bi-person-gear me-2"></i> Edit Profile</a>
							<a href="?action=my-products" class="list-group-item list-group-item-action"><i class="bi bi-box-seam me-2"></i> My Products</a>
							<a href="?action=billing" class="list-group-item list-group-item-action"><i class="bi bi-credit-card me-2"></i> Billing & Renewal</a>
							<a href="?action=resources" class="list-group-item list-group-item-action"><i class="bi bi-download me-2"></i> Exclusive Resources</a>
							<a href="?action=support" class="list-group-item list-group-item-action"><i class="bi bi-sos me-2"></i> Support & Messaging</a>
							<a href="<?php echo wp_logout_url( home_url() ); ?>" class="list-group-item list-group-item-action text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
						</div>
					</div>
				</div>
			</div>

			<!-- Dashboard Content -->
			<div class="col-lg-9">
				<div class="dashboard-content card shadow-sm border-0 p-4">
					<?php
					$action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : 'overview';

					switch ( $action ) {
						case 'edit-profile':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/edit-profile.php';
							break;
						case 'my-products':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/my-products.php';
							break;
						case 'billing':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/billing.php';
							break;
						case 'resources':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/resources.php';
							break;
						case 'support':
							include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/support.php';
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

<?php
get_footer();
