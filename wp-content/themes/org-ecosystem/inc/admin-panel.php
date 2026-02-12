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
	<div class="wrap">
		<h1 class="wp-heading-inline"><?php _e( 'Organization Settings', 'org-ecosystem' ); ?></h1>
		<hr class="wp-header-end">

		<div class="welcome-panel" style="padding: 20px; margin-top: 20px;">
			<div class="welcome-panel-content">
				<h2><?php _e( 'Welcome to Your Digital Ecosystem', 'org-ecosystem' ); ?></h2>
				<p class="about-description"><?php _e( 'This theme is designed to empower your organization. Follow the steps below to get started.', 'org-ecosystem' ); ?></p>
				<div class="welcome-panel-column-container">
					<div class="welcome-panel-column">
						<h3><?php _e( '1. Brand Your Site', 'org-ecosystem' ); ?></h3>
						<p><?php _e( 'Upload your logo and set your brand colors in the Customizer.', 'org-ecosystem' ); ?></p>
						<a class="button button-primary button-hero" href="<?php echo admin_url( 'customize.php' ); ?>"><?php _e( 'Open Customizer', 'org-ecosystem' ); ?></a>
					</div>
					<div class="welcome-panel-column">
						<h3><?php _e( '2. Setup Membership', 'org-ecosystem' ); ?></h3>
						<p><?php _e( 'Configure your plans, prices, and approval workflows.', 'org-ecosystem' ); ?></p>
						<a class="button button-secondary" href="<?php echo admin_url( 'admin.php?page=org-membership' ); ?>"><?php _e( 'Manage Plans', 'org-ecosystem' ); ?></a>
					</div>
					<div class="welcome-panel-column welcome-panel-last-column">
						<h3><?php _e( '3. Populate Content', 'org-ecosystem' ); ?></h3>
						<p><?php _e( 'Add members, businesses, and products to your directory.', 'org-ecosystem' ); ?></p>
						<a class="button button-secondary" href="<?php echo admin_url( 'edit.php?post_type=member' ); ?>"><?php _e( 'Add Members', 'org-ecosystem' ); ?></a>
					</div>
				</div>
			</div>
		</div>

		<div class="card p-4" style="background: #fff; margin-top: 20px; border: 1px solid #ccd0d4;">
			<h2><span class="dashicons dashicons-editor-help"></span> <?php _e( 'Admin Field Explanations', 'org-ecosystem' ); ?></h2>
			<table class="widefat striped">
				<thead>
					<tr>
						<th><?php _e( 'Section', 'org-ecosystem' ); ?></th>
						<th><?php _e( 'Explanation', 'org-ecosystem' ); ?></th>
						<th><?php _e( 'Usage Tip', 'org-ecosystem' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><strong>Membership Levels</strong></td>
						<td>Defines the tiers of membership (Free, Basic, Premium).</td>
						<td><em>Tip: Use Premium for your most loyal members to grant exclusive resource access.</em></td>
					</tr>
					<tr>
						<td><strong>Stripe API Key</strong></td>
						<td>The secret key from your Stripe dashboard used to process credit cards.</td>
						<td><em>Example: Enter ₱1,500 for Annual Membership Fee in Stripe dashboard.</em></td>
					</tr>
					<tr>
						<td><strong>Industry Taxonomy</strong></td>
						<td>Categories used to group businesses and members (e.g., Tech, Health).</td>
						<td><em>Tip: Be descriptive to help visitors find the right businesses in the directory.</em></td>
					</tr>
				</tbody>
			</table>
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
/**
 * Directory Settings Page Callback
 */
function org_ecosystem_directory_settings_page() {
	if ( isset( $_POST['org_save_directory'] ) ) {
		check_admin_referer( 'org_save_directory_action' );
		update_option( 'org_directory_per_page', intval( $_POST['per_page'] ) );
		update_option( 'org_directory_show_badges', isset( $_POST['show_badges'] ) ? '1' : '0' );
		echo '<div class="updated"><p>Directory settings saved.</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php _e( 'Directory Settings', 'org-ecosystem' ); ?></h1>
		<p><?php _e( 'Configure how the member and business directories behave.', 'org-ecosystem' ); ?></p>

		<form method="post" action="">
			<?php wp_nonce_field( 'org_save_directory_action' ); ?>
			<div class="card p-4 bg-white border mb-4 shadow-sm">
				<div class="mb-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Members Per Page', 'org-ecosystem' ); ?></label>
					<input type="number" name="per_page" class="small-text" value="<?php echo esc_attr( get_option( 'org_directory_per_page', 12 ) ); ?>">
					<p class="description"><?php _e( 'Number of items to show before pagination.', 'org-ecosystem' ); ?></p>
				</div>
				<div class="mb-3">
					<label class="form-label d-block fw-bold">
						<input type="checkbox" name="show_badges" value="1" <?php checked( get_option( 'org_directory_show_badges', '1' ), '1' ); ?>>
						<?php _e( 'Show Verification & Featured Badges', 'org-ecosystem' ); ?>
					</label>
				</div>
			</div>

			<p class="submit">
				<input type="submit" name="org_save_directory" class="button button-primary" value="Save Settings">
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

		<?php if ( isset( $_GET['approved'] ) ) : ?>
			<div class="updated"><p><?php _e( 'Member approved successfully!', 'org-ecosystem' ); ?></p></div>
		<?php endif; ?>

		<div class="card p-4 mb-4 bg-white border">
			<h3 class="mt-0"><?php _e( 'Pending Approvals', 'org-ecosystem' ); ?></h3>
			<?php
			$pending_members = new WP_Query( array(
				'post_type' => 'member',
				'post_status' => 'pending',
				'posts_per_page' => -1,
			) );

			if ( $pending_members->have_posts() ) : ?>
				<table class="wp-list-table widefat fixed striped">
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
									<a href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=org_approve_member&member_id=' . get_the_ID() ), 'org_approve_member_action' ); ?>" class="button button-primary">Approve</a>
								</td>
							</tr>
						<?php endwhile; wp_reset_postdata(); ?>
					</tbody>
				</table>
			<?php else : ?>
				<p class="text-muted"><?php _e( 'No members awaiting approval.', 'org-ecosystem' ); ?></p>
			<?php endif; ?>
		</div>
		<div class="card p-4" style="background: #fff; border: 1px solid #ccd0d4; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
			<h3 style="margin-top: 0;"><i class="dashicons dashicons-welcome-learn-more" style="vertical-align: middle; margin-right: 10px;"></i> <?php _e( 'Organization Onboarding Guide', 'org-ecosystem' ); ?></h3>
			<p class="description mb-4"><?php _e( 'Follow these steps to set up your digital ecosystem correctly.', 'org-ecosystem' ); ?></p>

			<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
				<div>
					<h4 style="margin-bottom: 10px;"><?php _e( '1. Core Configuration', 'org-ecosystem' ); ?></h4>
					<ul class="ul-disc">
						<li><strong><?php _e( 'Member Profiles:', 'org-ecosystem' ); ?></strong> <?php _e( 'Go to "Members" to manually add or approve professional profiles.', 'org-ecosystem' ); ?></li>
						<li><strong><?php _e( 'Taxonomies:', 'org-ecosystem' ); ?></strong> <?php _e( 'Define Industries and Locations to enable powerful directory filtering.', 'org-ecosystem' ); ?></li>
						<li><strong><?php _e( 'Branding:', 'org-ecosystem' ); ?></strong> <?php _e( 'Use the Customizer to upload your logo and set brand colors.', 'org-ecosystem' ); ?></li>
					</ul>
				</div>
				<div>
					<h4 style="margin-bottom: 10px;"><?php _e( '2. Revenue & Growth', 'org-ecosystem' ); ?></h4>
					<ul class="ul-disc">
						<li><strong><?php _e( 'Membership Levels:', 'org-ecosystem' ); ?></strong> <?php _e( 'Review your plans below. Each level grants different dashboard permissions.', 'org-ecosystem' ); ?></li>
						<li><strong><?php _e( 'Products/Services:', 'org-ecosystem' ); ?></strong> <?php _e( 'Encourage members to list their offerings to increase ecosystem value.', 'org-ecosystem' ); ?></li>
						<li><strong><?php _e( 'Donations:', 'org-ecosystem' ); ?></strong> <?php _e( 'Configure your donation page to accept community contributions.', 'org-ecosystem' ); ?></li>
					</ul>
				</div>
			</div>

			<hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
			<p><strong><?php _e( 'Expert Tip:', 'org-ecosystem' ); ?></strong> <?php _e( 'Use the "Import Sample Data" button in General Settings to see a live example of how members and businesses are structured.', 'org-ecosystem' ); ?></p>
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
		update_option( 'org_reminder_email_subject', sanitize_text_field( $_POST['reminder_subject'] ) );
		update_option( 'org_reminder_email_body', sanitize_textarea_field( $_POST['reminder_body'] ) );
		update_option( 'org_expiry_email_subject', sanitize_text_field( $_POST['expiry_subject'] ) );
		update_option( 'org_expiry_email_body', sanitize_textarea_field( $_POST['expiry_body'] ) );
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
					<textarea name="welcome_body" rows="6" class="widefat"><?php echo esc_textarea( get_option( 'org_welcome_email_body', 'Hi {user_name}, thank you for joining our professional ecosystem! Please verify your email here: {verify_url}' ) ); ?></textarea>
					<p class="description"><?php _e( 'Available tags: {user_name}, {site_name}, {verify_url}', 'org-ecosystem' ); ?></p>
				</div>
			</div>

			<div class="card p-4 bg-white border mb-4 shadow-sm">
				<h3><?php _e( 'Renewal Reminder', 'org-ecosystem' ); ?></h3>
				<div class="mb-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Subject', 'org-ecosystem' ); ?></label>
					<input type="text" name="reminder_subject" class="widefat" value="<?php echo esc_attr( get_option( 'org_reminder_email_subject', 'Membership Renewal Reminder' ) ); ?>">
				</div>
				<div class="mb-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Message Body', 'org-ecosystem' ); ?></label>
					<textarea name="reminder_body" rows="6" class="widefat"><?php echo esc_textarea( get_option( 'org_reminder_email_body', 'Hi {user_name}, your membership at {site_name} will expire in 7 days. Don\'t forget to renew!' ) ); ?></textarea>
					<p class="description"><?php _e( 'Available tags: {user_name}, {site_name}', 'org-ecosystem' ); ?></p>
				</div>
			</div>

			<div class="card p-4 bg-white border mb-4 shadow-sm">
				<h3><?php _e( 'Membership Expired', 'org-ecosystem' ); ?></h3>
				<div class="mb-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Subject', 'org-ecosystem' ); ?></label>
					<input type="text" name="expiry_subject" class="widefat" value="<?php echo esc_attr( get_option( 'org_expiry_email_subject', 'Your Membership has Expired' ) ); ?>">
				</div>
				<div class="mb-3">
					<label class="form-label d-block fw-bold"><?php _e( 'Message Body', 'org-ecosystem' ); ?></label>
					<textarea name="expiry_body" rows="6" class="widefat"><?php echo esc_textarea( get_option( 'org_expiry_email_body', 'Hi {user_name}, your membership at {site_name} has expired. Please renew to keep your benefits.' ) ); ?></textarea>
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
		<h1><?php _e( 'Payment Settings', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Configure how your organization collects membership fees and donations.', 'org-ecosystem' ); ?></p>

		<form method="post" action="">
			<?php wp_nonce_field( 'org_save_payments_action' ); ?>
			<div class="card p-4 bg-white border mb-4 shadow-sm">
				<h3>Stripe Gateway</h3>
				<p class="description mb-3"><?php _e( 'Connect your site to Stripe for secure credit card processing.', 'org-ecosystem' ); ?></p>
				<div class="mb-3">
					<label><input type="checkbox" name="stripe_enabled" value="1" <?php checked( get_option( 'org_stripe_enabled' ), '1' ); ?>> <strong>Enable Stripe</strong></label>
				</div>
				<div class="mb-3">
					<label class="form-label d-block fw-bold">API Secret Key <span class="dashicons dashicons-editor-help" title="Enter your live or test secret key from your Stripe Dashboard (Developers > API Keys)."></span></label>
					<input type="password" name="stripe_api_key" class="widefat" value="<?php echo esc_attr( get_option( 'org_stripe_api_key' ) ); ?>" placeholder="Example: sk_test_51Mz...">
					<p class="description">Example: Enter your 32-character secret key.</p>
				</div>
			</div>

			<div class="card p-4 bg-white border mb-4 shadow-sm">
				<h3>PayPal</h3>
				<p class="description mb-3"><?php _e( 'Accept payments via PayPal accounts and major credit cards.', 'org-ecosystem' ); ?></p>
				<div class="mb-3">
					<label class="form-label d-block fw-bold">PayPal Email Address <span class="dashicons dashicons-editor-help" title="The email address associated with your PayPal Business account."></span></label>
					<input type="email" name="paypal_email" class="widefat" value="<?php echo esc_attr( get_option( 'org_paypal_email' ) ); ?>" placeholder="Example: payments@your-org.com">
				</div>
			</div>

			<div class="card p-4 bg-white border mb-4 shadow-sm">
				<h3>Offline / Manual Payment</h3>
				<p class="description mb-3"><?php _e( 'Provide instructions for bank transfers, checks, or cash payments.', 'org-ecosystem' ); ?></p>
				<div class="mb-3">
					<label class="form-label d-block fw-bold">Payment Instructions <span class="dashicons dashicons-editor-help" title="These instructions will be shown to members who choose the offline payment method."></span></label>
					<textarea name="offline_instructions" rows="4" class="widefat" placeholder="Example: Please transfer ₱1,500 for Annual Membership Fee to Bank Name, Account: 123-456-789."><?php echo esc_textarea( get_option( 'org_offline_instructions', 'Please transfer ₱1,500 to our Bank Account: XYZ-123-456' ) ); ?></textarea>
				</div>
			</div>

			<p class="submit">
				<input type="submit" name="org_save_payments" class="button button-primary button-large" value="Save All Payment Settings">
			</p>
		</form>
	</div>
	<?php
}

function org_ecosystem_roles_page() {
	if ( isset( $_POST['org_save_roles'] ) ) {
		check_admin_referer( 'org_save_roles_action' );
		// Logic to update capabilities
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
						<th>Publish Content</th>
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
							<td><strong><?php echo esc_html( ucfirst( str_replace('_', ' ', $role_slug ) ) ); ?></strong></td>
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
		<h1><?php _e( 'Reports & Analytics', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Overview of organization performance and engagement.', 'org-ecosystem' ); ?></p>

		<div class="row" style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">
			<div class="card" style="flex: 1; min-width: 200px; background: #fff; padding: 20px; border-left: 4px solid #0d6efd; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
				<h3 style="margin-top: 0;"><?php _e( 'Active Members', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 32px; font-weight: bold; margin: 10px 0;"><?php echo esc_html( $active_members ); ?></p>
				<div class="d-flex justify-content-between">
					<span class="small text-warning"><?php echo esc_html( $pending_members ); ?> <?php _e( 'pending', 'org-ecosystem' ); ?></span>
					<span class="small text-danger"><?php echo esc_html( $expired_members ); ?> <?php _e( 'expired', 'org-ecosystem' ); ?></span>
				</div>
			</div>
			<div class="card" style="flex: 1; min-width: 200px; background: #fff; padding: 20px; border-left: 4px solid #198754; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
				<h3 style="margin-top: 0;"><?php _e( 'Businesses', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 32px; font-weight: bold; margin: 10px 0;"><?php echo esc_html( $total_businesses ); ?></p>
				<span class="small text-muted"><?php echo esc_html( $total_products ); ?> <?php _e( 'products listed', 'org-ecosystem' ); ?></span>
			</div>
			<div class="card" style="flex: 1; min-width: 200px; background: #fff; padding: 20px; border-left: 4px solid #ffc107; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
				<h3 style="margin-top: 0;"><?php _e( 'Total Revenue', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 32px; font-weight: bold; margin: 10px 0;">₱ <?php echo number_format( $total_revenue, 2 ); ?></p>
				<div class="d-flex justify-content-between">
					<span class="small text-muted">Subs: ₱<?php echo number_format( $membership_revenue ); ?></span>
					<span class="small text-muted">Donations: ₱<?php echo number_format( $donation_revenue ); ?></span>
				</div>
			</div>
		</div>

		<div class="mt-5" style="margin-top: 40px; background: #fff; padding: 20px; border: 1px solid #ccd0d4;">
			<h3><?php _e( 'Event Registrations', 'org-ecosystem' ); ?></h3>
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th>Event Name</th>
						<th>Date</th>
						<th>Registrations</th>
						<th>Actions</th>
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
								<td><?php echo esc_html( get_post_meta( get_the_ID(), '_event_date', true ) ); ?></td>
								<td><?php echo count( $attendees ); ?></td>
								<td><a href="<?php echo admin_url( 'post.php?post=' . get_the_ID() . '&action=edit' ); ?>" class="button">View Details</a></td>
							</tr>
						<?php endwhile; wp_reset_postdata();
					else : ?>
						<tr><td colspan="4"><?php _e( 'No events found.', 'org-ecosystem' ); ?></td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>

		<div class="mt-5" style="margin-top: 40px; background: #fff; padding: 20px; border: 1px solid #ccd0d4;">
			<h3><?php _e( 'Top Performing Members', 'org-ecosystem' ); ?></h3>
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th>Member</th>
						<th>Profile Views</th>
						<th>Inquiries</th>
						<th>Product Clicks</th>
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
								<td><?php echo get_post_meta( get_the_ID(), '_member_inquiry_count', true ) ?: 0; ?></td>
								<td><?php echo get_post_meta( get_the_ID(), '_member_product_clicks', true ) ?: 0; ?></td>
							</tr>
						<?php endwhile; wp_reset_postdata();
					else : ?>
						<tr><td colspan="4"><?php _e( 'No data available.', 'org-ecosystem' ); ?></td></tr>
					<?php endif; ?>
				</tbody>
			</table>
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

	// Create Sample Testimonial
	wp_insert_post( array(
		'post_title' => 'Jane Smith',
		'post_type'  => 'testimonial',
		'post_status'=> 'publish',
		'post_content' => 'The resources provided by this organization have been a game-changer for my startup.'
	) );

	// Create Sample Resource
	$res_id = wp_insert_post( array(
		'post_title' => 'Member Growth Handbook',
		'post_type'  => 'resource',
		'post_status'=> 'publish',
	) );
	update_post_meta( $res_id, '_resource_file_url', 'https://example.com/handbook.pdf' );

	// Create Sample Job
	wp_insert_post( array(
		'post_title' => 'Senior Community Manager',
		'post_type'  => 'job',
		'post_status'=> 'publish',
		'post_content' => 'Join our team to help grow our digital ecosystem.'
	) );

	// Create Sample Program
	wp_insert_post( array(
		'post_title' => 'Entrepreneurship Mentorship 2024',
		'post_type'  => 'program',
		'post_status'=> 'publish',
		'post_content' => 'Matching seasoned professionals with rising entrepreneurs.'
	) );

	wp_redirect( add_query_arg( array( 'import' => 'success' ), admin_url( 'admin.php?page=org-settings' ) ) );
	exit;
}
add_action( 'admin_post_org_import_demo', 'org_ecosystem_handle_demo_import' );
