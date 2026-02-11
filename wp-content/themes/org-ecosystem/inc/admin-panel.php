<?php
/**
 * Custom Admin Panel and Reporting
 *
 * @package OrgEcosystem
 */

/**
 * Register Admin Menu
 */
function org_ecosystem_admin_menu() {
	add_menu_page(
		__( 'Organization Settings', 'org-ecosystem' ),
		__( 'Org Settings', 'org-ecosystem' ),
		'manage_options',
		'org-settings',
		'org_ecosystem_settings_page',
		'dashicons-building',
		30
	);

	add_submenu_page(
		'org-settings',
		__( 'Membership Settings', 'org-ecosystem' ),
		__( 'Membership', 'org-ecosystem' ),
		'manage_options',
		'org-membership',
		'org_ecosystem_membership_page'
	);

	add_submenu_page(
		'org-settings',
		__( 'Reports & Analytics', 'org-ecosystem' ),
		__( 'Reports', 'org-ecosystem' ),
		'manage_options',
		'org-reports',
		'org_ecosystem_reports_page'
	);
}
add_action( 'admin_menu', 'org_ecosystem_admin_menu' );

/**
 * Settings Page Callback
 */
function org_ecosystem_settings_page() {
	?>
	<div class="wrap">
		<h1><?php _e( 'Organization Settings', 'org-ecosystem' ); ?></h1>
		<div class="notice notice-info">
			<p><?php _e( 'Configure your organization profile and global preferences here.', 'org-ecosystem' ); ?></p>
		</div>
		<form method="post" action="options.php">
			<?php
			// We would use settings API here
			_e( 'Placeholder for general settings...', 'org-ecosystem' );
			?>
		</form>
	</div>
	<?php
}

/**
 * Membership Page Callback
 */
function org_ecosystem_membership_page() {
	?>
	<div class="wrap">
		<h1><?php _e( 'Membership Management', 'org-ecosystem' ); ?></h1>
		<div class="card p-3" style="background: #fff; border: 1px solid #ccd0d4; margin-bottom: 20px;">
			<h3><?php _e( 'Onboarding Guide', 'org-ecosystem' ); ?></h3>
			<ol>
				<li><?php _e( 'Define your membership levels in the table below.', 'org-ecosystem' ); ?></li>
				<li><?php _e( 'Configure Stripe or PayPal in the Payments tab.', 'org-ecosystem' ); ?></li>
				<li><?php _e( 'Pending members will appear in the "Pending" status list for approval.', 'org-ecosystem' ); ?></li>
			</ol>
			<p><strong><?php _e( 'Example:', 'org-ecosystem' ); ?></strong> <?php _e( 'Enter ₱1,500 for Annual Membership Fee.', 'org-ecosystem' ); ?></p>
		</div>
		<p><?php _e( 'Manage plans, approval workflows, and automated reminders.', 'org-ecosystem' ); ?></p>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th>Plan Name</th>
					<th>Price</th>
					<th>Duration</th>
					<th>Active Members</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$levels = org_ecosystem_get_membership_levels();
				foreach ( $levels as $key => $level ) : ?>
					<tr>
						<td><strong><?php echo esc_html( $level['name'] ); ?></strong></td>
						<td><?php echo esc_html( $level['price'] ); ?></td>
						<td><?php echo esc_html( ucfirst( $level['duration'] ) ); ?></td>
						<td>
							<?php
							$count = count( get_users( array( 'meta_key' => '_membership_level', 'meta_value' => $key ) ) );
							echo esc_html( $count );
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

/**
 * Reports Page Callback
 */
function org_ecosystem_reports_page() {
	?>
	<div class="wrap">
		<h1><?php _e( 'Reports & Analytics', 'org-ecosystem' ); ?></h1>
		<div class="row" style="display: flex; gap: 20px; margin-top: 20px;">
			<div class="card" style="flex: 1; background: #fff; padding: 20px; border-left: 4px solid #0d6efd;">
				<h3><?php _e( 'Total Members', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 24px; font-weight: bold;">
					<?php echo count( get_posts( array( 'post_type' => 'member', 'posts_per_page' => -1 ) ) ); ?>
				</p>
			</div>
			<div class="card" style="flex: 1; background: #fff; padding: 20px; border-left: 4px solid #198754;">
				<h3><?php _e( 'Total Revenue', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 24px; font-weight: bold;">
					<?php
					// Placeholder calculation
					_e( '₱ 0.00', 'org-ecosystem' );
					?>
				</p>
			</div>
			<div class="card" style="flex: 1; background: #fff; padding: 20px; border-left: 4px solid #ffc107;">
				<h3><?php _e( 'Event Registrations', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 24px; font-weight: bold;">0</p>
			</div>
		</div>
	</div>
	<?php
}
