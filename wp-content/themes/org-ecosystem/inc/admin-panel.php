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
		__( 'Directory Settings', 'org-ecosystem' ),
		__( 'Directory', 'org-ecosystem' ),
		'manage_options',
		'org-directory',
		'org_ecosystem_directory_settings_page'
	);

	add_submenu_page(
		'org-settings',
		__( 'Payment Settings', 'org-ecosystem' ),
		__( 'Payments', 'org-ecosystem' ),
		'manage_payments',
		'org-payments',
		'org_ecosystem_payments_page'
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
	<div class="wrap org-admin-wrap">
		<h1 class="wp-heading-inline"><?php _e( 'Organization Settings', 'org-ecosystem' ); ?></h1>
		<hr class="wp-header-end">

		<div class="welcome-panel" style="padding: 30px; margin-top: 20px; border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
			<div class="welcome-panel-content">
				<h2 style="font-size: 28px; margin-bottom: 10px;"><?php _e( 'Welcome to Your Digital Ecosystem', 'org-ecosystem' ); ?></h2>
				<p class="about-description" style="font-size: 18px; color: #666;"><?php _e( 'This theme is designed to empower your organization with member directories, business listings, and revenue-generating features.', 'org-ecosystem' ); ?></p>

				<div class="welcome-panel-column-container" style="margin-top: 40px;">
					<div class="welcome-panel-column">
						<div style="padding: 20px; background: #f0f7ff; border-radius: 10px; height: 100%;">
							<h3 style="margin-top: 0;"><span class="dashicons dashicons-art"></span> <?php _e( '1. Brand Your Identity', 'org-ecosystem' ); ?></h3>
							<p><?php _e( 'Set your global colors, typography, and logos to match your organization\'s branding.', 'org-ecosystem' ); ?></p>
							<a class="button button-primary button-hero" href="<?php echo admin_url( 'customize.php' ); ?>"><?php _e( 'Start Branding', 'org-ecosystem' ); ?></a>
						</div>
					</div>
					<div class="welcome-panel-column">
						<div style="padding: 20px; background: #f0fff4; border-radius: 10px; height: 100%;">
							<h3 style="margin-top: 0;"><span class="dashicons dashicons-groups"></span> <?php _e( '2. Setup Membership', 'org-ecosystem' ); ?></h3>
							<p><?php _e( 'Define your membership levels, set pricing, and configure the approval workflow for new members.', 'org-ecosystem' ); ?></p>
							<a class="button button-secondary button-hero" href="<?php echo admin_url( 'admin.php?page=org-membership' ); ?>"><?php _e( 'Manage Plans', 'org-ecosystem' ); ?></a>
						</div>
					</div>
					<div class="welcome-panel-column welcome-panel-last-column">
						<div style="padding: 20px; background: #fff5f5; border-radius: 10px; height: 100%;">
							<h3 style="margin-top: 0;"><span class="dashicons dashicons-admin-links"></span> <?php _e( '3. Connect Payments', 'org-ecosystem' ); ?></h3>
							<p><?php _e( 'Integrate Stripe or PayPal to automate membership renewals and accept donations securely.', 'org-ecosystem' ); ?></p>
							<a class="button button-secondary button-hero" href="<?php echo admin_url( 'admin.php?page=org-payments' ); ?>"><?php _e( 'Configure Payments', 'org-ecosystem' ); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="grid-container" style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-top: 30px;">
			<div class="card-main">
				<div class="card p-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
					<h2 style="margin-top: 0;"><span class="dashicons dashicons-editor-help" style="color: #0d6efd;"></span> <?php _e( 'Detailed Field Explanations', 'org-ecosystem' ); ?></h2>
					<p class="description"><?php _e( 'Understand how each core setting impacts your site and your members.', 'org-ecosystem' ); ?></p>

					<table class="widefat striped" style="border: none; margin-top: 20px;">
						<thead>
							<tr>
								<th style="font-weight: 700;"><?php _e( 'Section', 'org-ecosystem' ); ?></th>
								<th style="font-weight: 700;"><?php _e( 'What it does', 'org-ecosystem' ); ?></th>
								<th style="font-weight: 700;"><?php _e( 'Best Practice / Example', 'org-ecosystem' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><strong><?php _e( 'Lead Protection', 'org-ecosystem' ); ?></strong></td>
								<td><?php _e( 'Hides contact details from non-members.', 'org-ecosystem' ); ?></td>
								<td><em><?php _e( 'Enable this to increase the value of your Premium memberships.', 'org-ecosystem' ); ?></em></td>
							</tr>
							<tr>
								<td><strong><?php _e( 'Featured Listings', 'org-ecosystem' ); ?></strong></td>
								<td><?php _e( 'Shows members at the top of the directory.', 'org-ecosystem' ); ?></td>
								<td><em><?php _e( 'Charge ₱500/month for members to be "Featured".', 'org-ecosystem' ); ?></em></td>
							</tr>
							<tr>
								<td><strong><?php _e( 'Role Capabilities', 'org-ecosystem' ); ?></strong></td>
								<td><?php _e( 'Controls who can approve members or edit jobs.', 'org-ecosystem' ); ?></td>
								<td><em><?php _e( 'Assign "Regional Admin" to local chapter leaders.', 'org-ecosystem' ); ?></em></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="card-sidebar">
				<div class="card p-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
					<h3 style="margin-top: 0;"><?php _e( 'Quick Actions', 'org-ecosystem' ); ?></h3>
					<ul style="list-style: none; padding: 0;">
						<li style="margin-bottom: 10px;"><a href="<?php echo admin_url('edit.php?post_type=member'); ?>" class="button w-100" style="display: block; text-align: center;"><span class="dashicons dashicons-plus"></span> <?php _e( 'Add New Member', 'org-ecosystem' ); ?></a></li>
						<li style="margin-bottom: 10px;"><a href="<?php echo admin_url('edit.php?post_type=event'); ?>" class="button w-100" style="display: block; text-align: center;"><span class="dashicons dashicons-calendar-alt"></span> <?php _e( 'Post an Event', 'org-ecosystem' ); ?></a></li>
						<li style="margin-bottom: 10px;"><a href="<?php echo admin_url('admin.php?page=org-reports'); ?>" class="button button-primary w-100" style="display: block; text-align: center;"><span class="dashicons dashicons-chart-bar"></span> <?php _e( 'View Analytics', 'org-ecosystem' ); ?></a></li>
					</ul>

					<hr>

					<h3><?php _e( 'Demo Data Importer', 'org-ecosystem' ); ?></h3>
					<p class="description"><?php _e( 'Populate your system with 20+ records to see the design in action.', 'org-ecosystem' ); ?></p>
					<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
						<input type="hidden" name="action" value="org_import_demo">
						<?php wp_nonce_field( 'org_import_demo', 'org_demo_nonce' ); ?>
						<button type="submit" class="button button-secondary w-100" style="display: block; width: 100%;"><?php _e( 'Import Demo Content', 'org-ecosystem' ); ?></button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<style>
		.org-admin-wrap .button.w-100 { width: 100%; box-sizing: border-box; }
		.org-admin-wrap .card { transition: all 0.3s ease; }
		.org-admin-wrap .card:hover { border-color: #0d6efd !important; }
	</style>
	<?php
}

/**
 * Content Manager Page Callback
 */
function org_ecosystem_content_manager_page() {
	?>
	<div class="wrap">
		<h1><?php _e( 'Content Overview', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Quickly manage all post types across the organization.', 'org-ecosystem' ); ?></p>

		<div class="card p-4 bg-white border shadow-sm mt-3" style="border-radius: 12px; border: 1px solid #e2e8f0;">
			<table class="wp-list-table widefat fixed striped" style="border: none;">
				<thead>
					<tr>
						<th style="font-weight: 700;">Post Type</th>
						<th style="font-weight: 700;">Published</th>
						<th style="font-weight: 700;">Pending Review</th>
						<th style="font-weight: 700;">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$types = array( 'member', 'business', 'product', 'event', 'job', 'program', 'resource', 'donation', 'announcement' );
					foreach ( $types as $type ) :
						$count = wp_count_posts( $type );
						$obj = get_post_type_object( $type );
						if ( ! $obj ) continue;
						?>
						<tr>
							<td><strong><?php echo esc_html( $obj->labels->name ); ?></strong></td>
							<td><span class="badge" style="background: #eef2ff; color: #4338ca; padding: 4px 8px; border-radius: 4px;"><?php echo esc_html( $count->publish ); ?></span></td>
							<td>
								<?php if ( $count->pending > 0 ) : ?>
									<span class="badge" style="background: #fff7ed; color: #c2410c; padding: 4px 8px; border-radius: 4px;"><?php echo esc_html( $count->pending ); ?></span>
								<?php else : ?>
									<span style="color: #cbd5e1;">0</span>
								<?php endif; ?>
							</td>
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
 * Directory Settings Page Callback
 */
function org_ecosystem_directory_settings_page() {
	if ( isset( $_POST['org_save_directory'] ) ) {
		check_admin_referer( 'org_save_directory_action' );
		update_option( 'org_directory_per_page', intval( $_POST['per_page'] ) );
		update_option( 'org_directory_show_badges', isset( $_POST['show_badges'] ) ? '1' : '0' );
		update_option( 'org_lead_protection', isset( $_POST['lead_protection'] ) ? '1' : '0' );
		echo '<div class="updated"><p>Directory settings saved.</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php _e( 'Directory & UI Settings', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Customize the search and display behavior of your directories.', 'org-ecosystem' ); ?></p>

		<form method="post" action="">
			<?php wp_nonce_field( 'org_save_directory_action' ); ?>
			<div class="card p-4 bg-white border mb-4 shadow-sm" style="border-radius: 12px; max-width: 800px;">
				<div class="mb-4">
					<label class="form-label d-block fw-bold" style="font-size: 1.1rem;"><?php _e( 'Results Per Page', 'org-ecosystem' ); ?></label>
					<input type="number" name="per_page" class="small-text" value="<?php echo esc_attr( get_option( 'org_directory_per_page', 12 ) ); ?>" style="padding: 5px 10px; border-radius: 4px;">
					<p class="description"><?php _e( 'How many member/business cards to show before pagination kicks in.', 'org-ecosystem' ); ?></p>
				</div>

				<hr>

				<div class="mb-4">
					<label class="form-label d-block fw-bold" style="font-size: 1.1rem;">
						<input type="checkbox" name="show_badges" value="1" <?php checked( get_option( 'org_directory_show_badges', '1' ), '1' ); ?>>
						<?php _e( 'Enable Directory Badges', 'org-ecosystem' ); ?>
					</label>
					<p class="description"><?php _e( 'Display "Verified" and "Featured" badges on directory cards.', 'org-ecosystem' ); ?></p>
				</div>

				<hr>

				<div class="mb-4">
					<label class="form-label d-block fw-bold" style="font-size: 1.1rem;">
						<input type="checkbox" name="lead_protection" value="1" <?php checked( get_option( 'org_lead_protection', '0' ), '1' ); ?>>
						<?php _e( 'Enable Lead Protection (Gating)', 'org-ecosystem' ); ?>
					</label>
					<p class="description"><?php _e( 'Hide sensitive contact details (email, phone) from visitors and basic members. Users will be prompted to upgrade to see this info.', 'org-ecosystem' ); ?></p>
				</div>
			</div>

			<p class="submit">
				<input type="submit" name="org_save_directory" class="button button-primary button-large" value="Save Directory Settings">
			</p>
		</form>
	</div>
	<?php
}

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
		<div class="card p-4 mt-3" style="border-radius: 12px; background: #fff; border: 1px solid #e2e8f0;">
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th>Subject</th>
						<th>Submitted By</th>
						<th>Current Status</th>
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
									$color = $status === 'open' ? '#dc3545' : '#198754';
									?>
									<span class="badge" style="background: <?php echo $color; ?>; color: #fff; padding: 4px 8px; border-radius: 12px; font-size: 10px; text-transform: uppercase;"><?php echo esc_html( $status ); ?></span>
								</td>
								<td>
									<a href="<?php echo admin_url('post.php?post='.get_the_ID().'&action=edit'); ?>" class="button button-small">View Thread</a>
									<a href="<?php echo wp_nonce_url( add_query_arg( array( 'ticket_id' => get_the_ID(), 'new_status' => 'closed' ) ), 'org_update_ticket' ); ?>" class="button button-small">Close</a>
								</td>
							</tr>
						<?php endwhile; wp_reset_postdata(); ?>
					<?php else : ?>
						<tr><td colspan="4"><?php _e( 'No active tickets.', 'org-ecosystem' ); ?></td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
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

		<?php if ( isset( $_GET['approved'] ) ) : ?>
			<div class="updated"><p><?php _e( 'Member approved successfully!', 'org-ecosystem' ); ?></p></div>
		<?php endif; ?>

		<div class="card p-4 mb-4 bg-white border" style="border-radius: 12px; border: 1px solid #e2e8f0;">
			<h3 class="mt-0"><span class="dashicons dashicons-clock"></span> <?php _e( 'Pending Approvals', 'org-ecosystem' ); ?></h3>
			<p class="description"><?php _e( 'These users have registered but are not yet active in the directory.', 'org-ecosystem' ); ?></p>
			<?php
			$pending_members = new WP_Query( array(
				'post_type' => 'member',
				'post_status' => 'pending',
				'posts_per_page' => -1,
			) );

			if ( $pending_members->have_posts() ) : ?>
				<table class="wp-list-table widefat fixed striped mt-3">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Joined</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php while ( $pending_members->have_posts() ) : $pending_members->the_post(); ?>
							<tr>
								<td><strong><?php the_title(); ?></strong></td>
								<td><?php echo get_the_author_meta( 'user_email' ); ?></td>
								<td><?php echo get_the_date(); ?></td>
								<td>
									<a href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=org_approve_member&member_id=' . get_the_ID() ), 'org_approve_member_action' ); ?>" class="button button-primary">Approve Member</a>
								</td>
							</tr>
						<?php endwhile; wp_reset_postdata(); ?>
					</tbody>
				</table>
			<?php else : ?>
				<p class="text-muted" style="background: #f8fafc; padding: 20px; border-radius: 8px;"><?php _e( 'No members awaiting approval.', 'org-ecosystem' ); ?></p>
			<?php endif; ?>
		</div>

		<div class="card p-4" style="background: #fff; border: 1px solid #e2e8f0; margin-bottom: 20px; border-radius: 12px;">
			<h3 style="margin-top: 0;"><span class="dashicons dashicons-money" style="color: #198754;"></span> <?php _e( 'Membership Tier Overview', 'org-ecosystem' ); ?></h3>
			<p class="description"><?php _e( 'Configure prices and durations in the Customizer.', 'org-ecosystem' ); ?></p>

			<table class="wp-list-table widefat fixed striped mt-3">
				<thead>
					<tr>
						<th>Plan Name</th>
						<th>Standard Price</th>
						<th>Billing Cycle</th>
						<th>Active Base</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$levels = org_ecosystem_get_membership_levels();
					foreach ( $levels as $key => $level ) : ?>
						<tr>
							<td><strong><?php echo esc_html( $level['name'] ); ?></strong></td>
							<td>₱ <?php echo number_format( $level['price'], 2 ); ?></td>
							<td><?php echo esc_html( ucfirst( $level['duration'] ) ); ?></td>
							<td>
								<span class="badge" style="background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 4px;">
									<?php
									$count = count( get_users( array( 'meta_key' => '_membership_level', 'meta_value' => $key ) ) );
									echo esc_html( $count );
									?>
								</span>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
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
		update_option( 'org_reminder_email_subject', sanitize_text_field( $_POST['reminder_subject'] ) );
		update_option( 'org_reminder_email_body', sanitize_textarea_field( $_POST['reminder_body'] ) );
		update_option( 'org_expiry_email_subject', sanitize_text_field( $_POST['expiry_subject'] ) );
		update_option( 'org_expiry_email_body', sanitize_textarea_field( $_POST['expiry_body'] ) );
		echo '<div class="updated"><p>Email templates saved.</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php _e( 'Automated Email Campaigns', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Customize the messages your members receive during their lifecycle.', 'org-ecosystem' ); ?></p>

		<form method="post" action="" style="max-width: 900px; margin-top: 20px;">
			<?php wp_nonce_field( 'org_save_emails_action' ); ?>

			<div class="email-card" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; margin-bottom: 25px;">
				<h3 style="margin-top: 0;"><span class="dashicons dashicons-email-alt" style="color: #0d6efd;"></span> <?php _e( '1. The Welcome Email', 'org-ecosystem' ); ?></h3>
				<p class="description"><?php _e( 'Sent immediately after a user registers.', 'org-ecosystem' ); ?></p>
				<div class="mb-3 mt-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Subject Line', 'org-ecosystem' ); ?></label>
					<input type="text" name="welcome_subject" class="widefat" value="<?php echo esc_attr( get_option( 'org_welcome_email_subject', 'Welcome to our Organization!' ) ); ?>" style="padding: 10px; border-radius: 6px;">
				</div>
				<div class="mb-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Message Content', 'org-ecosystem' ); ?></label>
					<textarea name="welcome_body" rows="8" class="widefat" style="padding: 10px; border-radius: 6px;"><?php echo esc_textarea( get_option( 'org_welcome_email_body', 'Hi {user_name}, thank you for joining our professional ecosystem! Please verify your email here: {verify_url}' ) ); ?></textarea>
					<p class="description"><?php _e( 'Smart tags: {user_name}, {site_name}, {verify_url}', 'org-ecosystem' ); ?></p>
				</div>
			</div>

			<div class="email-card" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; margin-bottom: 25px;">
				<h3 style="margin-top: 0;"><span class="dashicons dashicons-clock" style="color: #f59e0b;"></span> <?php _e( '2. Renewal Reminders', 'org-ecosystem' ); ?></h3>
				<p class="description"><?php _e( 'Sent 7 days before membership expires.', 'org-ecosystem' ); ?></p>
				<div class="mb-3 mt-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Subject Line', 'org-ecosystem' ); ?></label>
					<input type="text" name="reminder_subject" class="widefat" value="<?php echo esc_attr( get_option( 'org_reminder_email_subject', 'Membership Renewal Reminder' ) ); ?>" style="padding: 10px; border-radius: 6px;">
				</div>
				<div class="mb-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Message Content', 'org-ecosystem' ); ?></label>
					<textarea name="reminder_body" rows="8" class="widefat" style="padding: 10px; border-radius: 6px;"><?php echo esc_textarea( get_option( 'org_reminder_email_body', 'Hi {user_name}, your membership at {site_name} will expire in 7 days. Don\'t forget to renew!' ) ); ?></textarea>
				</div>
			</div>

			<p class="submit">
				<input type="submit" name="org_save_emails" class="button button-primary button-large" value="Save All Campaigns">
			</p>
		</form>
	</div>
	<?php
}

/**
 * Payment Settings Page Callback
 */
function org_ecosystem_payments_page() {
	if ( isset( $_POST['org_save_payments'] ) ) {
		check_admin_referer( 'org_save_payments_action' );
		update_option( 'org_stripe_enabled', isset( $_POST['stripe_enabled'] ) ? '1' : '0' );
		update_option( 'org_stripe_api_key', sanitize_text_field( $_POST['stripe_api_key'] ) );
		update_option( 'org_paypal_email', sanitize_email( $_POST['paypal_email'] ) );
		update_option( 'org_offline_instructions', sanitize_textarea_field( $_POST['offline_instructions'] ) );
		echo '<div class="updated"><p>Payment settings saved.</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php _e( 'Revenue & Payment Gateway Settings', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Connect your bank accounts to start collecting membership dues and listing fees.', 'org-ecosystem' ); ?></p>

		<form method="post" action="" style="max-width: 800px; margin-top: 20px;">
			<?php wp_nonce_field( 'org_save_payments_action' ); ?>
			<div class="card p-4 bg-white border mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
				<h3 style="margin-top: 0;"><img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" height="25" alt="Stripe" style="vertical-align: middle;"></h3>
				<div class="mb-4 mt-3">
					<label style="font-weight: 600;"><input type="checkbox" name="stripe_enabled" value="1" <?php checked( get_option( 'org_stripe_enabled' ), '1' ); ?>> <?php _e( 'Enable Stripe Checkout', 'org-ecosystem' ); ?></label>
				</div>
				<div class="mb-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Secret API Key', 'org-ecosystem' ); ?> <span class="dashicons dashicons-info" title="Find this in Stripe Dashboard > Developers > API Keys."></span></label>
					<input type="password" name="stripe_api_key" class="widefat" value="<?php echo esc_attr( get_option( 'org_stripe_api_key' ) ); ?>" placeholder="sk_live_..." style="padding: 10px; border-radius: 6px;">
					<p class="description"><?php _e( 'Example: Enter ₱1,500 for Annual Membership Fee in your Stripe product settings.', 'org-ecosystem' ); ?></p>
				</div>
			</div>

			<div class="card p-4 bg-white border mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
				<h3 style="margin-top: 0;"><img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" height="25" alt="PayPal" style="vertical-align: middle;"></h3>
				<div class="mb-3 mt-3">
					<label class="form-label d-block fw-bold"><?php _e( 'PayPal Business Email', 'org-ecosystem' ); ?></label>
					<input type="email" name="paypal_email" class="widefat" value="<?php echo esc_attr( get_option( 'org_paypal_email' ) ); ?>" placeholder="payments@your-org.com" style="padding: 10px; border-radius: 6px;">
				</div>
			</div>

			<div class="card p-4 bg-white border mb-4 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
				<h3 style="margin-top: 0;"><span class="dashicons dashicons-bank" style="color: #64748b;"></span> <?php _e( 'Offline / Manual Payments', 'org-ecosystem' ); ?></h3>
				<div class="mb-3 mt-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Instructions for Members', 'org-ecosystem' ); ?></label>
					<textarea name="offline_instructions" rows="4" class="widefat" style="padding: 10px; border-radius: 6px;" placeholder="Example: Please deposit to BDO Account 12345..."><?php echo esc_textarea( get_option( 'org_offline_instructions', 'Please transfer ₱1,500 to our Bank Account: XYZ-123-456' ) ); ?></textarea>
				</div>
			</div>

			<p class="submit">
				<input type="submit" name="org_save_payments" class="button button-primary button-large" value="Save Gateway Configuration">
			</p>
		</form>
	</div>
	<?php
}

function org_ecosystem_roles_page() {
	if ( isset( $_POST['org_save_roles'] ) ) {
		check_admin_referer( 'org_save_roles_action' );
		if ( isset( $_POST['role_caps'] ) && is_array( $_POST['role_caps'] ) ) {
			foreach ( $_POST['role_caps'] as $role_slug => $caps ) {
				$role = get_role( $role_slug );
				if ( ! $role ) continue;
				foreach ( $caps as $cap => $value ) {
					if ( $value == '1' ) {
						$role->add_cap( $cap );
					} else {
						$role->remove_cap( $cap );
					}
				}
			}
		}
		echo '<div class="updated"><p>Role permissions updated.</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php _e( 'User Roles & Permission Control', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Fine-tune what each user group can do within the ecosystem.', 'org-ecosystem' ); ?></p>

		<form method="post" action="" style="margin-top: 20px;">
			<?php wp_nonce_field( 'org_save_roles_action' ); ?>
			<div class="card p-0 bg-white border shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
				<table class="wp-list-table widefat fixed striped" style="border: none;">
					<thead>
						<tr>
							<th style="padding: 15px; font-weight: 700;">Role Name</th>
							<th style="padding: 15px; font-weight: 700;">Approve Members</th>
							<th style="padding: 15px; font-weight: 700;">Manage Payments</th>
							<th style="padding: 15px; font-weight: 700;">Access Reports</th>
							<th style="padding: 15px; font-weight: 700;">Manage Tickets</th>
							<th style="padding: 15px; font-weight: 700;">Publish Content</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$roles = array( 'org_admin', 'regional_admin', 'membership_manager', 'content_manager', 'member', 'vendor', 'volunteer' );
						$caps = array( 'approve_members', 'manage_payments', 'access_reports', 'manage_tickets', 'publish_posts' );

						foreach ( $roles as $role_slug ) :
							$role = get_role( $role_slug );
							if ( ! $role ) continue;
							?>
							<tr>
								<td style="padding: 15px;"><strong><?php echo esc_html( ucfirst( str_replace('_', ' ', $role_slug ) ) ); ?></strong></td>
								<?php foreach ( $caps as $cap ) : ?>
									<td style="padding: 15px; text-align: center;">
										<input type="checkbox" name="role_caps[<?php echo $role_slug; ?>][<?php echo $cap; ?>]" value="1" <?php checked( $role->has_cap( $cap ) ); ?>>
									</td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<p class="submit">
				<input type="submit" name="org_save_roles" class="button button-primary button-large" value="Save Capability Map">
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
	$expired_members = count( get_posts( array(
		'post_type' => 'member',
		'posts_per_page' => -1,
		'meta_query' => array( array( 'key' => '_member_status', 'value' => 'expired' ) )
	) ) );
	$total_businesses = count( get_posts( array( 'post_type' => 'business', 'posts_per_page' => -1 ) ) );
	$total_products = count( get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1 ) ) );
	$total_events = count( get_posts( array( 'post_type' => 'event', 'posts_per_page' => -1 ) ) );

	// Calculate Total Revenue
	$membership_revenue = 0;
	$all_users = get_users( array( 'fields' => 'ID' ) );
	foreach ( $all_users as $uid ) {
		$history = get_user_meta( $uid, '_payment_history', true );
		if ( is_array( $history ) ) {
			foreach ( $history as $item ) {
				$membership_revenue += floatval( $item['amount'] );
			}
		}
	}

	$donation_revenue = 0;
	$donations_query = new WP_Query( array( 'post_type' => 'donation', 'posts_per_page' => -1 ) );
	if ( $donations_query->have_posts() ) {
		foreach ( $donations_query->posts as $d ) {
			$donation_revenue += floatval( get_post_meta( $d->ID, '_donation_amount', true ) );
		}
	}
	$total_revenue = $membership_revenue + $donation_revenue;

	?>
	<div class="wrap">
		<h1><?php _e( 'Ecosystem Performance Dashboard', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Real-time metrics for your organization\'s growth and revenue.', 'org-ecosystem' ); ?></p>

		<div class="row" style="display: flex; gap: 20px; margin-top: 25px; flex-wrap: wrap;">
			<div class="card" style="flex: 1; min-width: 280px; background: #fff; padding: 25px; border-left: 5px solid #0d6efd; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
				<h3 style="margin-top: 0; color: #64748b; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;"><?php _e( 'Growth Metric', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 36px; font-weight: 800; margin: 15px 0; color: #1e293b;"><?php echo esc_html( $active_members ); ?> <span style="font-size: 14px; font-weight: 400; color: #64748b;">Members</span></p>
				<div style="display: flex; gap: 15px;">
					<span style="font-size: 12px; background: #fff7ed; color: #c2410c; padding: 2px 8px; border-radius: 4px;"><?php echo esc_html( $pending_members ); ?> pending</span>
					<span style="font-size: 12px; background: #fef2f2; color: #b91c1c; padding: 2px 8px; border-radius: 4px;"><?php echo esc_html( $expired_members ); ?> expired</span>
				</div>
			</div>
			<div class="card" style="flex: 1; min-width: 280px; background: #fff; padding: 25px; border-left: 5px solid #10b981; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
				<h3 style="margin-top: 0; color: #64748b; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;"><?php _e( 'Community Value', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 36px; font-weight: 800; margin: 15px 0; color: #1e293b;"><?php echo esc_html( $total_businesses ); ?> <span style="font-size: 14px; font-weight: 400; color: #64748b;">Businesses</span></p>
				<span style="font-size: 12px; color: #64748b;"><?php echo esc_html( $total_products ); ?> products showcased</span>
			</div>
			<div class="card" style="flex: 1; min-width: 280px; background: #fff; padding: 25px; border-left: 5px solid #f59e0b; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
				<h3 style="margin-top: 0; color: #64748b; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;"><?php _e( 'Total Revenue', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 36px; font-weight: 800; margin: 15px 0; color: #1e293b;">₱ <?php echo number_format( $total_revenue, 2 ); ?></p>
				<div style="font-size: 12px; color: #64748b;">
					Subs: ₱<?php echo number_format( $membership_revenue ); ?> | Donations: ₱<?php echo number_format( $donation_revenue ); ?>
				</div>
			</div>
		</div>

		<div class="grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 40px;">
			<div class="card p-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
				<h3 style="margin-top: 0;"><?php _e( 'Recent Events', 'org-ecosystem' ); ?></h3>
				<table class="wp-list-table widefat fixed striped mt-3" style="border: none;">
					<thead>
						<tr>
							<th>Event</th>
							<th>Registrations</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$events_query = new WP_Query( array( 'post_type' => 'event', 'posts_per_page' => 5 ) );
						if ( $events_query->have_posts() ) :
							while ( $events_query->have_posts() ) : $events_query->the_post();
								$attendees = get_post_meta( get_the_ID(), '_event_attendees', true ) ?: array();
								?>
								<tr>
									<td><strong><?php the_title(); ?></strong></td>
									<td><?php echo count( $attendees ); ?></td>
								</tr>
							<?php endwhile; wp_reset_postdata();
						else : ?>
							<tr><td colspan="2">No events scheduled.</td></tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

			<div class="card p-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
				<h3 style="margin-top: 0;"><?php _e( 'Top Profiles', 'org-ecosystem' ); ?></h3>
				<table class="wp-list-table widefat fixed striped mt-3" style="border: none;">
					<thead>
						<tr>
							<th>Member</th>
							<th>Views</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$top_members = new WP_Query( array(
							'post_type' => 'member',
							'posts_per_page' => 5,
							'meta_key' => '_member_view_count',
							'orderby' => 'meta_value_num',
							'order' => 'DESC'
						) );
						if ( $top_members->have_posts() ) :
							while ( $top_members->have_posts() ) : $top_members->the_post();
								?>
								<tr>
									<td><strong><?php the_title(); ?></strong></td>
									<td><?php echo get_post_meta( get_the_ID(), '_member_view_count', true ) ?: 0; ?></td>
								</tr>
							<?php endwhile; wp_reset_postdata();
						else : ?>
							<tr><td colspan="2">No visibility data yet.</td></tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Handle Member Approval from Admin
 */
function org_ecosystem_handle_admin_approve_member() {
	if ( ! current_user_can( 'approve_members' ) ) return;
	check_admin_referer( 'org_approve_member_action' );

	$member_id = isset( $_GET['member_id'] ) ? intval( $_GET['member_id'] ) : 0;
	if ( $member_id ) {
		org_ecosystem_approve_member( $member_id );
	}

	wp_redirect( add_query_arg( array( 'approved' => 'true' ), admin_url( 'admin.php?page=org-membership' ) ) );
	exit;
}
add_action( 'admin_post_org_approve_member', 'org_ecosystem_handle_admin_approve_member' );

/**
 * Handle Demo Data Import
 */
function org_ecosystem_handle_demo_import() {
	if ( ! current_user_can( 'manage_options' ) ) return;
	check_admin_referer( 'org_import_demo', 'org_demo_nonce' );

	// Import 10 Members
	for ( $i = 1; $i <= 10; $i++ ) {
		$member_id = wp_insert_post( array(
			'post_title' => "Sample Member $i",
			'post_type'  => 'member',
			'post_status'=> 'publish',
		) );
		update_post_meta( $member_id, '_member_business_name', "Business $i Inc." );
		update_post_meta( $member_id, '_member_status', 'active' );
		update_post_meta( $member_id, '_member_view_count', rand(100, 1000) );
		if ( $i <= 3 ) update_post_meta( $member_id, '_member_is_featured', '1' );
	}

	// Import 5 Businesses
	for ( $i = 1; $i <= 5; $i++ ) {
		wp_insert_post( array(
			'post_title' => "Organization $i",
			'post_type'  => 'business',
			'post_status'=> 'publish',
		) );
	}

	// Import 3 Events
	$events = array( 'Networking Night', 'Business Summit 2024', 'Tech Workshop' );
	foreach ( $events as $event ) {
		wp_insert_post( array(
			'post_title' => $event,
			'post_type'  => 'event',
			'post_status'=> 'publish',
		) );
	}

	wp_redirect( add_query_arg( array( 'import' => 'success' ), admin_url( 'admin.php?page=org-settings' ) ) );
	exit;
}
add_action( 'admin_post_org_import_demo', 'org_ecosystem_handle_demo_import' );
