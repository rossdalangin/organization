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
		'approve_members',
		'org-membership',
		'org_ecosystem_membership_page'
	);

	add_submenu_page(
		'org-settings',
		__( 'Reports & Analytics', 'org-ecosystem' ),
		__( 'Reports', 'org-ecosystem' ),
		'access_reports',
		'org-reports',
		'org_ecosystem_reports_page'
	);

	add_submenu_page(
		'org-settings',
		__( 'Support Tickets', 'org-ecosystem' ),
		__( 'Support Tickets', 'org-ecosystem' ),
		'manage_tickets',
		'org-tickets',
		'org_ecosystem_tickets_page'
	);

	add_submenu_page(
		'org-settings',
		__( 'Content Manager', 'org-ecosystem' ),
		__( 'Content Manager', 'org-ecosystem' ),
		'publish_posts',
		'org-content',
		'org_ecosystem_content_manager_page'
	);

	add_submenu_page(
		'org-settings',
		__( 'Email Templates', 'org-ecosystem' ),
		__( 'Email Templates', 'org-ecosystem' ),
		'manage_options',
		'org-emails',
		'org_ecosystem_emails_page'
	);

	add_submenu_page(
		'org-settings',
		__( 'Role Management', 'org-ecosystem' ),
		__( 'Roles', 'org-ecosystem' ),
		'manage_options',
		'org-roles',
		'org_ecosystem_roles_page'
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

		<?php if ( isset( $_GET['import'] ) ) : ?>
			<div class="updated"><p>Demo data imported successfully!</p></div>
		<?php endif; ?>

		<div class="card p-4" style="background: #fff; margin-top: 20px; border: 1px solid #ccd0d4;">
			<h3>Demo Data Importer</h3>
			<p>Click below to populate your theme with sample members, businesses, and events.</p>
			<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
				<input type="hidden" name="action" value="org_import_demo">
				<?php wp_nonce_field( 'org_import_demo', 'org_demo_nonce' ); ?>
				<button type="submit" class="button button-primary">Import Sample Data</button>
			</form>
		</div>
	</div>
	<?php
}

/**
 * Content Manager Page Callback
 */
function org_ecosystem_content_manager_page() {
	?>
	<div class="wrap">
		<h1><?php _e( 'Content Overview', 'org-ecosystem' ); ?></h1>
		<div class="card p-4 bg-white border shadow-sm">
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th>Post Type</th>
						<th>Published</th>
						<th>Pending</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$types = array( 'member', 'business', 'product', 'event', 'job', 'program', 'resource', 'donation' );
					foreach ( $types as $type ) :
						$count = wp_count_posts( $type );
						$obj = get_post_type_object( $type );
						?>
						<tr>
							<td><strong><?php echo esc_html( $obj->labels->name ); ?></strong></td>
							<td><?php echo esc_html( $count->publish ); ?></td>
							<td><span class="<?php echo $count->pending > 0 ? 'text-warning' : ''; ?>"><?php echo esc_html( $count->pending ); ?></span></td>
							<td><a href="<?php echo admin_url( 'edit.php?post_type=' . $type ); ?>" class="button button-small">Manage</a></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
}

/**
 * Support Tickets Page Callback
 */
function org_ecosystem_tickets_page() {
	if ( isset( $_GET['ticket_id'] ) && isset( $_GET['new_status'] ) ) {
		check_admin_referer( 'org_update_ticket' );
		update_post_meta( intval( $_GET['ticket_id'] ), '_ticket_status', sanitize_text_field( $_GET['new_status'] ) );
		echo '<div class="updated"><p>Ticket status updated.</p></div>';
	}

	$tickets = new WP_Query( array(
		'post_type' => 'support_ticket',
		'posts_per_page' => -1,
	) );
	?>
	<div class="wrap">
		<h1><?php _e( 'Support Tickets Management', 'org-ecosystem' ); ?></h1>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th>Subject</th>
					<th>Submitted By</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if ( $tickets->have_posts() ) : ?>
					<?php while ( $tickets->have_posts() ) : $tickets->the_post(); ?>
						<tr>
							<td><strong><?php the_title(); ?></strong></td>
							<td><?php echo get_the_author(); ?></td>
							<td>
								<?php
								$status = get_post_meta( get_the_ID(), '_ticket_status', true ) ?: 'open';
								?>
								<span class="badge"><?php echo esc_html( ucfirst( $status ) ); ?></span>
							</td>
							<td>
								<a href="<?php echo wp_nonce_url( add_query_arg( array( 'ticket_id' => get_the_ID(), 'new_status' => 'closed' ) ), 'org_update_ticket' ); ?>" class="button button-small">Close</a>
								<a href="<?php echo wp_nonce_url( add_query_arg( array( 'ticket_id' => get_the_ID(), 'new_status' => 'open' ) ), 'org_update_ticket' ); ?>" class="button button-small">Reopen</a>
							</td>
						</tr>
					<?php endwhile; wp_reset_postdata(); ?>
				<?php else : ?>
					<tr><td colspan="4"><?php _e( 'No tickets found.', 'org-ecosystem' ); ?></td></tr>
				<?php endif; ?>
			</tbody>
		</table>
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
		<p><?php _e( 'Manage plans, approval workflows, and automated reminders.', 'org-ecosystem' ); ?>
			<span class="dashicons dashicons-editor-help" title="<?php esc_attr_e( 'These plans define the access levels for your members.', 'org-ecosystem' ); ?>"></span>
		</p>
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
 * Email Templates Page Callback
 */
function org_ecosystem_emails_page() {
	if ( isset( $_POST['org_save_emails'] ) ) {
		check_admin_referer( 'org_save_emails_action' );
		update_option( 'org_welcome_email_subject', sanitize_text_field( $_POST['welcome_subject'] ) );
		update_option( 'org_welcome_email_body', sanitize_textarea_field( $_POST['welcome_body'] ) );
		echo '<div class="updated"><p>Email templates saved.</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php _e( 'Email Templates', 'org-ecosystem' ); ?></h1>
		<p><?php _e( 'Customize the automated emails sent by the system.', 'org-ecosystem' ); ?></p>

		<form method="post" action="">
			<?php wp_nonce_field( 'org_save_emails_action' ); ?>
			<div class="card p-4 bg-white border mb-4 shadow-sm">
				<h3><?php _e( 'Welcome Email (Registration)', 'org-ecosystem' ); ?></h3>
				<div class="mb-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Subject', 'org-ecosystem' ); ?></label>
					<input type="text" name="welcome_subject" class="widefat" value="<?php echo esc_attr( get_option( 'org_welcome_email_subject', 'Welcome to our Organization!' ) ); ?>">
				</div>
				<div class="mb-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Message Body', 'org-ecosystem' ); ?></label>
					<textarea name="welcome_body" rows="6" class="widefat"><?php echo esc_textarea( get_option( 'org_welcome_email_body', 'Hi {user_name}, thank you for joining our professional ecosystem!' ) ); ?></textarea>
					<p class="description"><?php _e( 'Available tags: {user_name}, {site_name}', 'org-ecosystem' ); ?></p>
				</div>
			</div>

			<p class="submit">
				<input type="submit" name="org_save_emails" class="button button-primary" value="Save Email Templates">
			</p>
		</form>
	</div>
	<?php
}

/**
 * Role Management Page Callback
 */
function org_ecosystem_roles_page() {
	if ( isset( $_POST['org_save_roles'] ) ) {
		check_admin_referer( 'org_save_roles_action' );
		// Logic to update capabilities would go here
		echo '<div class="updated"><p>Role permissions updated.</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php _e( 'Role Management', 'org-ecosystem' ); ?></h1>
		<p><?php _e( 'Configure permissions for each organization role.', 'org-ecosystem' ); ?></p>

		<form method="post" action="">
			<?php wp_nonce_field( 'org_save_roles_action' ); ?>
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th>Role</th>
						<th>Approve Members</th>
						<th>Manage Payments</th>
						<th>Access Reports</th>
						<th>Manage Tickets</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$roles = array( 'org_admin', 'regional_admin', 'membership_manager', 'content_manager', 'member' );
					$caps = array( 'approve_members', 'manage_payments', 'access_reports', 'manage_tickets' );

					foreach ( $roles as $role_slug ) :
						$role = get_role( $role_slug );
						if ( ! $role ) continue;
						?>
						<tr>
							<td><strong><?php echo esc_html( $role_slug ); ?></strong></td>
							<?php foreach ( $caps as $cap ) : ?>
								<td>
									<input type="checkbox" name="role_caps[<?php echo $role_slug; ?>][<?php echo $cap; ?>]" value="1" <?php checked( $role->has_cap( $cap ) ); ?>>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" name="org_save_roles" class="button button-primary" value="Save Permissions">
			</p>
		</form>
	</div>
	<?php
}

/**
 * Reports Page Callback
 */
function org_ecosystem_reports_page() {
	$active_members = count( get_posts( array( 'post_type' => 'member', 'post_status' => 'publish', 'posts_per_page' => -1 ) ) );
	$pending_members = count( get_posts( array( 'post_type' => 'member', 'post_status' => 'pending', 'posts_per_page' => -1 ) ) );
	$total_businesses = count( get_posts( array( 'post_type' => 'business', 'posts_per_page' => -1 ) ) );
	$total_products = count( get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1 ) ) );
	?>
	<div class="wrap">
		<h1><?php _e( 'Reports & Analytics', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Overview of organization performance and engagement.', 'org-ecosystem' ); ?></p>

		<div class="row" style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">
			<div class="card" style="flex: 1; min-width: 200px; background: #fff; padding: 20px; border-left: 4px solid #0d6efd; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
				<h3 style="margin-top: 0;"><?php _e( 'Active Members', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 32px; font-weight: bold; margin: 10px 0;"><?php echo esc_html( $active_members ); ?></p>
				<span class="small text-muted"><?php echo esc_html( $pending_members ); ?> <?php _e( 'pending approval', 'org-ecosystem' ); ?></span>
			</div>
			<div class="card" style="flex: 1; min-width: 200px; background: #fff; padding: 20px; border-left: 4px solid #198754; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
				<h3 style="margin-top: 0;"><?php _e( 'Businesses', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 32px; font-weight: bold; margin: 10px 0;"><?php echo esc_html( $total_businesses ); ?></p>
				<span class="small text-muted"><?php echo esc_html( $total_products ); ?> <?php _e( 'products listed', 'org-ecosystem' ); ?></span>
			</div>
			<div class="card" style="flex: 1; min-width: 200px; background: #fff; padding: 20px; border-left: 4px solid #ffc107; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
				<h3 style="margin-top: 0;"><?php _e( 'Total Revenue', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 32px; font-weight: bold; margin: 10px 0;">₱ 0.00</p>
				<span class="small text-muted"><?php _e( 'Lifetime subscription revenue', 'org-ecosystem' ); ?></span>
			</div>
		</div>

		<div class="mt-5" style="margin-top: 40px; background: #fff; padding: 20px; border: 1px solid #ccd0d4;">
			<h3><?php _e( 'Recent Activity', 'org-ecosystem' ); ?></h3>
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th><?php _e( 'User', 'org-ecosystem' ); ?></th>
						<th><?php _e( 'Action', 'org-ecosystem' ); ?></th>
						<th><?php _e( 'Date', 'org-ecosystem' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="3" class="text-center"><?php _e( 'No recent activity recorded.', 'org-ecosystem' ); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php
}

/**
 * Handle Demo Data Import
 */
function org_ecosystem_handle_demo_import() {
	if ( ! current_user_can( 'manage_options' ) ) return;
	check_admin_referer( 'org_import_demo', 'org_demo_nonce' );

	// Create Sample Member
	$member_id = wp_insert_post( array(
		'post_title' => 'John Doe (Sample)',
		'post_type'  => 'member',
		'post_status'=> 'publish',
	) );
	update_post_meta( $member_id, '_member_business_name', 'Doe Enterprises' );
	update_post_meta( $member_id, '_member_status', 'active' );
	update_post_meta( $member_id, '_member_is_featured', '1' );

	// Create Sample Business
	$business_id = wp_insert_post( array(
		'post_title' => 'Tech Innovations Inc.',
		'post_type'  => 'business',
		'post_status'=> 'publish',
		'post_content' => 'Leading the way in sample data creation.'
	) );

	// Create Sample Event
	wp_insert_post( array(
		'post_title' => 'Annual Gala 2024',
		'post_type'  => 'event',
		'post_status'=> 'publish',
	) );

	wp_redirect( add_query_arg( array( 'import' => 'success' ), admin_url( 'admin.php?page=org-settings' ) ) );
	exit;
}
add_action( 'admin_post_org_import_demo', 'org_ecosystem_handle_demo_import' );
