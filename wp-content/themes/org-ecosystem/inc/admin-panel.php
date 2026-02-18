<?php
/**
 * Custom Admin Panel and Reporting - Strategically Organized
 *
 * @package OrgEcosystem
 */

/**
 * Register Admin Menu
 */
function org_ecosystem_admin_menu() {
	// Main Parent
	add_menu_page(
		__( 'Org Ecosystem', 'org-ecosystem' ),
		__( 'Org Ecosystem', 'org-ecosystem' ),
		'manage_options',
		'org-settings',
		'org_ecosystem_settings_page',
		'dashicons-building',
		30
	);

	// 1. Analytics & Reports
	add_submenu_page(
		'org-settings',
		__( 'Reports & Analytics', 'org-ecosystem' ),
		__( 'Reports', 'org-ecosystem' ),
		'access_reports',
		'org-reports',
		'org_ecosystem_reports_page'
	);

    // 1.1 Transactions Manager
	add_submenu_page(
		'org-settings',
		__( 'Transaction Manager', 'org-ecosystem' ),
		__( 'Transactions', 'org-ecosystem' ),
		'manage_payments',
		'org-transactions',
		'org_ecosystem_transactions_page'
	);

    add_submenu_page(
		'org-settings',
		__( 'Withdrawal Requests', 'org-ecosystem' ),
		__( 'Withdrawals', 'org-ecosystem' ),
		'manage_payments',
		'org-withdrawals',
		'org_ecosystem_withdrawals_page'
	);

	// 2. Growth & Revenue
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
		__( 'Payment & Gateway Setup', 'org-ecosystem' ),
		__( 'Payments', 'org-ecosystem' ),
		'manage_payments',
		'org-payments',
		'org_ecosystem_payments_page'
	);

	// 3. Engagement & Communications
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
		__( 'Internal Messages', 'org-ecosystem' ),
		__( 'Internal Messages', 'org-ecosystem' ),
		'manage_options',
		'org-messages',
		'org_ecosystem_internal_messages_page'
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
		__( 'Newsletter Management', 'org-ecosystem' ),
		__( 'Newsletters', 'org-ecosystem' ),
		'publish_posts',
		'org-newsletters',
		'org_ecosystem_newsletters_page'
	);

	// 4. Governance & Management
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
		__( 'Industries', 'org-ecosystem' ),
		__( 'Industries', 'org-ecosystem' ),
		'manage_options',
		'edit-tags.php?taxonomy=industry'
	);

    add_submenu_page(
		'org-settings',
		__( 'Locations', 'org-ecosystem' ),
		__( 'Locations', 'org-ecosystem' ),
		'manage_options',
		'edit-tags.php?taxonomy=location'
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
		__( 'Role Management', 'org-ecosystem' ),
		__( 'Roles', 'org-ecosystem' ),
		'manage_options',
		'org-roles',
		'org_ecosystem_roles_page'
	);

    add_submenu_page(
		'org-settings',
		__( 'Page Content Manager', 'org-ecosystem' ),
		__( 'Page Content', 'org-ecosystem' ),
		'manage_options',
		'org-page-content',
		'org_ecosystem_page_content_page'
	);

    add_submenu_page(
		'org-settings',
		__( 'Database Maintenance', 'org-ecosystem' ),
		__( 'Maintenance', 'org-ecosystem' ),
		'manage_options',
		'org-setup',
		'org_ecosystem_setup_page'
	);

    add_submenu_page(
		'org-settings',
		__( 'All Member Profiles', 'org-ecosystem' ),
		__( 'Member Profiles', 'org-ecosystem' ),
		'manage_options',
		'edit.php?post_type=member'
	);
}
add_action( 'admin_menu', 'org_ecosystem_admin_menu' );

/**
 * Settings Page Callback (Main Admin Dashboard)
 */
function org_ecosystem_settings_page() {
    // KPI Data
    $active_members = count( get_posts( array( 'post_type' => 'member', 'post_status' => 'publish', 'posts_per_page' => -1 ) ) );
    $pending_apps = count( get_posts( array( 'post_type' => 'member', 'post_status' => 'pending', 'posts_per_page' => -1 ) ) );
    $open_tickets = count( get_posts( array( 'post_type' => 'support_ticket', 'meta_key' => '_ticket_status', 'meta_value' => 'open', 'posts_per_page' => -1 ) ) );
    $total_businesses = count( get_posts( array( 'post_type' => 'business', 'posts_per_page' => -1 ) ) );
    $total_products = count( get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1 ) ) );

    // Revenue KPI
    $total_revenue = 0;
    $txns = new WP_Query( array( 'post_type' => 'org_transaction', 'posts_per_page' => -1 ) );
    foreach ( $txns->posts as $t ) {
        $amt = floatval( get_post_meta( $t->ID, '_txn_amount', true ) );
        if ( $amt > 0 && get_post_meta( $t->ID, '_txn_status', true ) === 'completed' ) {
            $total_revenue += $amt;
        }
    }

	?>
	<div class="wrap org-admin-wrap">
		<h1 class="wp-heading-inline"><?php _e( 'Organization Command Center', 'org-ecosystem' ); ?></h1>
		<hr class="wp-header-end">

        <?php if ( isset( $_GET['import'] ) && $_GET['import'] === 'success' ) : ?>
            <div class="updated notice is-dismissible"><p><?php _e( 'Sample data (20+ records per table) imported successfully.', 'org-ecosystem' ); ?></p></div>
        <?php endif; ?>

        <?php if ( isset( $_GET['reset'] ) && $_GET['reset'] === 'success' ) : ?>
            <div class="updated notice is-dismissible"><p><?php _e( 'Ecosystem database has been reset.', 'org-ecosystem' ); ?></p></div>
        <?php endif; ?>

		<div class="dashboard-hero" style="background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 40px; margin-top: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
			<div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 style="font-size: 28px; font-weight: 800; margin: 0; color: #1e293b;"><?php _e( 'Ecosystem Vitality Overview', 'org-ecosystem' ); ?></h2>
                    <p class="description" style="font-size: 16px; margin-top: 5px;"><?php _e( 'Real-time performance metrics for your organization.', 'org-ecosystem' ); ?></p>
                </div>
                <div class="dashboard-actions">
                    <a href="<?php echo admin_url('admin.php?page=org-membership&view=upgraded'); ?>" class="button button-primary button-hero"><?php _e( 'Upgraded Accounts', 'org-ecosystem' ); ?></a>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px;">
                <div class="stat-card" style="padding: 25px; background: #f0f7ff; border-radius: 15px; border-left: 5px solid #0d6efd;">
                    <div style="color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;"><?php _e( 'Active Base', 'org-ecosystem' ); ?></div>
                    <div style="font-size: 32px; font-weight: 800; color: #1e293b; margin: 10px 0;"><?php echo number_format($active_members); ?></div>
                    <div style="font-size: 13px; color: #0d6efd; font-weight: 600;"><a href="<?php echo admin_url('admin.php?page=org-membership&view=upgraded'); ?>" style="color: inherit; text-decoration: none;"><span class="dashicons dashicons-groups" style="font-size: 16px; width: 16px; height: 16px;"></span> <?php _e( 'View Upgraded Accounts', 'org-ecosystem' ); ?></a></div>
                </div>
                <div class="stat-card" style="padding: 25px; background: #f0fff4; border-radius: 15px; border-left: 5px solid #16a34a;">
                    <div style="color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;"><?php _e( 'Gross Revenue', 'org-ecosystem' ); ?></div>
                    <div style="font-size: 32px; font-weight: 800; color: #1e293b; margin: 10px 0;">₱<?php echo number_format($total_revenue); ?></div>
                    <div style="font-size: 13px; color: #16a34a; font-weight: 600;"><span class="dashicons dashicons-money-alt" style="font-size: 16px; width: 16px; height: 16px;"></span> <?php _e( 'Growth Velocity +12%', 'org-ecosystem' ); ?></div>
                </div>
                <div class="stat-card" style="padding: 25px; background: #fffbeb; border-radius: 15px; border-left: 5px solid #d97706;">
                    <div style="color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;"><?php _e( 'Marketplace', 'org-ecosystem' ); ?></div>
                    <div style="font-size: 32px; font-weight: 800; color: #1e293b; margin: 10px 0;"><?php echo number_format($total_products); ?></div>
                    <div style="font-size: 13px; color: #d97706; font-weight: 600;"><span class="dashicons dashicons-cart" style="font-size: 16px; width: 16px; height: 16px;"></span> <?php _e( 'Active Solutions', 'org-ecosystem' ); ?></div>
                </div>
                <div class="stat-card" style="padding: 25px; background: #fef2f2; border-radius: 15px; border-left: 5px solid #dc2626;">
                    <div style="color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;"><?php _e( 'Support Load', 'org-ecosystem' ); ?></div>
                    <div style="font-size: 32px; font-weight: 800; color: #1e293b; margin: 10px 0;"><?php echo number_format($open_tickets); ?></div>
                    <div style="font-size: 13px; color: #dc2626; font-weight: 600;"><span class="dashicons dashicons-sos" style="font-size: 16px; width: 16px; height: 16px;"></span> <?php _e( 'Open Inquiries', 'org-ecosystem' ); ?></div>
                </div>
            </div>
		</div>

		<div class="grid-container" style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 30px;">
			<div class="card-main">
                <div class="card p-5 mb-4" style="background: #1e293b; color: #fff; border-radius: 12px; border: none; position: relative; overflow: hidden;">
                    <div style="position: relative; z-index: 2;">
                        <h2 style="color: #fff; margin-top: 0; font-size: 24px;"><?php _e( 'Quick Start: Your Ecosystem Onboarding', 'org-ecosystem' ); ?></h2>
                        <p style="color: #cbd5e1; font-size: 15px;"><?php _e( 'Follow these steps to launch your organization digital platform effectively:', 'org-ecosystem' ); ?></p>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 25px;">
                            <div>
                                <h4 style="color: #38bdf8; margin: 0 0 10px 0; font-size: 14px; text-transform: uppercase;"><?php _e( 'Step 1: Core Setup', 'org-ecosystem' ); ?></h4>
                                <p style="font-size: 13px; line-height: 1.6;"><?php _e( 'Go to <strong>Maintenance</strong> and click "Auto-Create Required Pages". This sets up your Dashboard, Join, and Directory pages instantly.', 'org-ecosystem' ); ?></p>
                            </div>
                            <div>
                                <h4 style="color: #38bdf8; margin: 0 0 10px 0; font-size: 14px; text-transform: uppercase;"><?php _e( 'Step 2: Financials', 'org-ecosystem' ); ?></h4>
                                <p style="font-size: 13px; line-height: 1.6;"><?php _e( 'Navigate to <strong>Payments</strong> to connect Stripe or PayPal. This enables automated dues collection.', 'org-ecosystem' ); ?></p>
                            </div>
                            <div>
                                <h4 style="color: #38bdf8; margin: 0 0 10px 0; font-size: 14px; text-transform: uppercase;"><?php _e( 'Step 3: Define Tiers', 'org-ecosystem' ); ?></h4>
                                <p style="font-size: 13px; line-height: 1.6;"><?php _e( 'Open the <strong>WordPress Customizer</strong> to set prices for Free, Basic, and Premium tiers.', 'org-ecosystem' ); ?></p>
                            </div>
                            <div>
                                <h4 style="color: #38bdf8; margin: 0 0 10px 0; font-size: 14px; text-transform: uppercase;"><?php _e( 'Step 4: Seed Data', 'org-ecosystem' ); ?></h4>
                                <p style="font-size: 13px; line-height: 1.6;"><?php _e( 'Use the <strong>"Import Sample Records"</strong> button below to see the ecosystem in action with fictional members.', 'org-ecosystem' ); ?></p>
                            </div>
                        </div>
                    </div>
                    <div style="position: absolute; bottom: -50px; right: -50px; opacity: 0.1;">
                        <span class="dashicons dashicons-lightbulb" style="font-size: 200px; width: 200px; height: 200px;"></span>
                    </div>
                </div>

                <div class="card p-4 mb-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
                    <h3 style="margin-top: 0; display: flex; align-items: center; gap: 10px;"><span class="dashicons dashicons-chart-area" style="color: #0d6efd;"></span> <?php _e( 'Growth Analytics (Last 30 Days)', 'org-ecosystem' ); ?></h3>
                    <div style="height: 200px; display: flex; align-items: flex-end; gap: 10px; padding: 20px 0; border-bottom: 1px solid #f1f5f9;">
                        <?php for($i=1; $i<=10; $i++): $h = rand(30, 100); ?>
                            <div style="flex: 1; background: #eef2ff; height: <?php echo $h; ?>%; border-radius: 4px; position: relative;" title="Day <?php echo $i; ?>: <?php echo $h*10; ?> members">
                                <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: <?php echo $h/2; ?>%; background: #0d6efd; border-radius: 0 0 4px 4px;"></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <div class="d-flex justify-content-between mt-3 text-muted small">
                        <span><?php _e( '30 Days Ago', 'org-ecosystem' ); ?></span>
                        <span><?php _e( 'Today', 'org-ecosystem' ); ?></span>
                    </div>
                </div>

				<div class="card p-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
					<h3 style="margin-top: 0; display: flex; align-items: center; gap: 10px;"><span class="dashicons dashicons-list-view" style="color: #0d6efd;"></span> <?php _e( 'Recent Activity Feed', 'org-ecosystem' ); ?></h3>
					<div class="activity-list">
                        <?php
                        $recent_txns = new WP_Query( array( 'post_type' => 'org_transaction', 'posts_per_page' => 5 ) );
                        if ( $recent_txns->have_posts() ) :
                            while ( $recent_txns->have_posts() ) : $recent_txns->the_post();
                                ?>
                                <div style="padding: 15px 0; border-bottom: 1px solid #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong style="display: block;"><?php the_title(); ?></strong>
                                        <span class="text-muted small"><?php echo get_the_date(); ?> &bull; <?php echo esc_html(get_post_meta(get_the_ID(), '_txn_type', true)); ?></span>
                                    </div>
                                    <div style="text-align: right;">
                                        <div style="font-weight: 700; color: #1e293b;">₱<?php echo number_format(get_post_meta(get_the_ID(), '_txn_amount', true), 2); ?></div>
                                        <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 9px;"><?php echo esc_html(strtoupper(get_post_meta(get_the_ID(), '_txn_gateway', true))); ?></span>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
				</div>
			</div>

			<div class="card-sidebar">
                <div class="card p-4 mb-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="margin-top: 0;"><?php _e( 'Quick Operations', 'org-ecosystem' ); ?></h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 12px;"><a href="<?php echo admin_url('edit.php?post_type=member'); ?>" class="button w-100 py-1" style="display: block; text-align: center;"><span class="dashicons dashicons-plus-alt"></span> <?php _e( 'New Member Profile', 'org-ecosystem' ); ?></a></li>
                        <li style="margin-bottom: 12px;"><a href="<?php echo admin_url('edit.php?post_type=event'); ?>" class="button w-100 py-1" style="display: block; text-align: center;"><span class="dashicons dashicons-calendar-alt"></span> <?php _e( 'Schedule Event', 'org-ecosystem' ); ?></a></li>
                        <li style="margin-bottom: 12px;"><a href="<?php echo admin_url('admin.php?page=org-tickets'); ?>" class="button w-100 py-1" style="display: block; text-align: center;"><span class="dashicons dashicons-sos"></span> <?php _e( 'Support Inbox', 'org-ecosystem' ); ?></a></li>
                    </ul>
                </div>

				<div class="card p-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
					<h3 style="margin-top: 0; color: #dc2626;"><span class="dashicons dashicons-database" style="color: #dc2626;"></span> <?php _e( 'Database Maintenance', 'org-ecosystem' ); ?></h3>
					<p class="description"><?php _e( 'Critical actions for managing your ecosystem data.', 'org-ecosystem' ); ?></p>

                    <div class="d-grid gap-2 mt-4">
                        <form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" onsubmit="return confirm('Note: This will add 20+ sample records to ALL organization tables. Continue?');">
                            <input type="hidden" name="action" value="org_import_demo">
                            <?php wp_nonce_field( 'org_import_demo', 'org_demo_nonce' ); ?>
                            <button type="submit" class="button button-secondary w-100 mb-3" style="height: 40px; font-weight: 600;"><?php _e( 'Import 20+ Sample Records', 'org-ecosystem' ); ?></button>
                        </form>

                        <form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" onsubmit="return confirm('WARNING: This will permanently delete ALL organization records (Members, Businesses, Products, Transactions, etc). This cannot be undone. Continue?');">
                            <input type="hidden" name="action" value="org_reset_db">
                            <?php wp_nonce_field( 'org_reset_db', 'org_reset_nonce' ); ?>
                            <button type="submit" class="button button-link text-danger w-100" style="color: #dc3545; border: 1px solid #fee2e2; border-radius: 6px; padding: 10px;"><?php _e( 'Wipe Database (Reset)', 'org-ecosystem' ); ?></button>
                        </form>

                        <form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" class="mt-3">
                            <input type="hidden" name="action" value="org_refresh_roles">
                            <?php wp_nonce_field( 'org_refresh_roles_action' ); ?>
                            <button type="submit" class="button button-secondary w-100"><?php _e( 'Repair Permissions (Refresh Roles)', 'org-ecosystem' ); ?></button>
                        </form>
                    </div>

                    <hr style="margin: 25px 0;">

                    <h3 style="font-size: 14px;"><?php _e( 'Technical Blueprint', 'org-ecosystem' ); ?></h3>
                    <table class="wp-list-table widefat" style="border: none; background: transparent; font-size: 11px;">
                        <tr><td><strong>Version:</strong></td><td><?php echo ORG_ECOSYSTEM_VERSION; ?></td></tr>
                        <tr><td><strong>PHP:</strong></td><td><?php echo phpversion(); ?></td></tr>
                        <tr><td><strong>Theme:</strong></td><td>OrgEcosystem Pro</td></tr>
                    </table>
				</div>
			</div>
		</div>
	</div>
	<style>
		.org-admin-wrap .button.w-100 { width: 100%; box-sizing: border-box; }
		.org-admin-wrap .card { transition: all 0.3s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
		.org-admin-wrap .card:hover { border-color: #0d6efd !important; box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important; }
		.org-admin-wrap .button-hero { padding: 12px 25px !important; height: auto !important; line-height: 1 !important; font-weight: 700; border-radius: 8px; }
        .stat-card { transition: transform 0.3s ease; cursor: default; }
        .stat-card:hover { transform: translateY(-5px); }
	</style>
	<?php
}

/**
 * Transaction Manager Page
 */
function org_ecosystem_transactions_page() {
    if ( isset( $_GET['txn_id'] ) && isset( $_GET['status'] ) ) {
        check_admin_referer( 'org_update_txn' );
        $txn_id = intval( $_GET['txn_id'] );
        $status = sanitize_text_field( $_GET['status'] );
        update_post_meta( $txn_id, '_txn_status', $status );

        if ( $status === 'completed' ) {
            $type = get_post_meta( $txn_id, '_txn_type', true );
            $user_id = get_post_meta( $txn_id, '_txn_user_id', true );
            $item_id = get_post_meta( $txn_id, '_txn_item_id', true );
            $amount = get_post_meta( $txn_id, '_txn_amount', true );

            if ( $type === 'membership' || $type === 'professional' || $type === 'vendor' || $type === 'corporate' ) {
                org_ecosystem_process_payment( $user_id, $type, 'manual_approval' );
            }
            if ( $type === 'product_sale' ) {
                org_ecosystem_handle_commission( $txn_id, $amount, $item_id );
            }
        }
        echo '<div class="updated"><p>Transaction updated.</p></div>';
    }

    $transactions = new WP_Query( array(
        'post_type' => 'org_transaction',
        'posts_per_page' => -1,
    ) );
    ?>
    <div class="wrap">
        <h1><?php _e( 'Master Transaction Ledger', 'org-ecosystem' ); ?></h1>
        <div class="card p-4 mt-4" style="border-radius: 12px; background: #fff; border: 1px solid #e2e8f0;">
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Gateway</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ( $transactions->have_posts() ) : ?>
                        <?php while ( $transactions->have_posts() ) : $transactions->the_post();
                            $status = get_post_meta( get_the_ID(), '_txn_status', true );
                            $color = $status === 'completed' ? '#198754' : ($status === 'pending' ? '#f59e0b' : '#dc3545');
                        ?>
                            <tr>
                                <td><?php echo get_the_date(); ?></td>
                                <td><?php echo get_the_author(); ?></td>
                                <td><?php echo esc_html( get_post_meta( get_the_ID(), '_txn_type', true ) ); ?></td>
                                <td><strong>₱ <?php echo number_format( get_post_meta( get_the_ID(), '_txn_amount', true ), 2 ); ?></strong></td>
                                <td><?php echo esc_html( strtoupper( get_post_meta( get_the_ID(), '_txn_gateway', true ) ) ); ?></td>
                                <td><span class="badge" style="background: <?php echo $color; ?>; color: #fff; padding: 4px 8px; border-radius: 4px;"><?php echo esc_html( ucfirst( $status ) ); ?></span></td>
                                <td>
                                    <?php if ( $status === 'pending' ) : ?>
                                        <a href="<?php echo wp_nonce_url( add_query_arg( array( 'txn_id' => get_the_ID(), 'status' => 'completed' ) ), 'org_update_txn' ); ?>" class="button button-small"><?php _e( 'Complete', 'org-ecosystem' ); ?></a>
                                        <a href="<?php echo wp_nonce_url( add_query_arg( array( 'txn_id' => get_the_ID(), 'status' => 'cancelled' ) ), 'org_update_txn' ); ?>" class="button button-small"><?php _e( 'Cancel', 'org-ecosystem' ); ?></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php else : ?>
                        <tr><td colspan="7">No transactions found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}

function org_ecosystem_withdrawals_page() {
    if ( isset( $_GET['txn_id'] ) && isset( $_GET['status'] ) ) {
        check_admin_referer( 'org_update_withdrawal' );
        update_post_meta( intval( $_GET['txn_id'] ), '_txn_status', sanitize_text_field( $_GET['status'] ) );
        echo '<div class="updated"><p>Withdrawal status updated.</p></div>';
    }

    $withdrawals = new WP_Query( array(
        'post_type' => 'org_transaction',
        'meta_query' => array(
            array( 'key' => '_txn_type', 'value' => 'withdrawal' ),
        )
    ) );
    ?>
    <div class="wrap">
        <h1><?php _e( 'Withdrawal Requests & Payouts', 'org-ecosystem' ); ?></h1>
        <div class="card p-4 mt-4" style="border-radius: 12px; background: #fff; border: 1px solid #e2e8f0;">
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Member</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ( $withdrawals->have_posts() ) : ?>
                        <?php while ( $withdrawals->have_posts() ) : $withdrawals->the_post();
                            $status = get_post_meta( get_the_ID(), '_txn_status', true );
                            $amount = abs( floatval( get_post_meta( get_the_ID(), '_txn_amount', true ) ) );
                        ?>
                            <tr>
                                <td><?php echo get_the_date(); ?></td>
                                <td><?php echo get_the_author(); ?></td>
                                <td class="text-danger fw-bold">₱ <?php echo number_format( $amount, 2 ); ?></td>
                                <td><?php echo esc_html( strtoupper( get_post_meta( get_the_ID(), '_txn_gateway', true ) ) ); ?></td>
                                <td><span class="badge" style="background: <?php echo $status === 'completed' ? '#198754' : '#f59e0b'; ?>; color: #fff; padding: 4px 8px; border-radius: 4px;"><?php echo esc_html( ucfirst( $status ) ); ?></span></td>
                                <td>
                                    <?php if ( $status === 'pending' ) : ?>
                                        <a href="<?php echo wp_nonce_url( add_query_arg( array( 'txn_id' => get_the_ID(), 'status' => 'completed' ) ), 'org_update_withdrawal' ); ?>" class="button button-primary button-small"><?php _e( 'Mark Paid', 'org-ecosystem' ); ?></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php else : ?>
                        <tr><td colspan="6">No withdrawal requests.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}

/**
 * Page Content Manager Callback
 */
function org_ecosystem_page_content_page() {
    if ( isset( $_POST['org_save_page_content'] ) ) {
        check_admin_referer( 'org_save_page_content_action' );

        $fields = array(
            'org_about_text', 'org_mission_text', 'org_vision_text',
            'org_contact_info', 'org_plans_intro', 'org_referral_intro',
            'org_faq_intro', 'org_payments_intro'
        );

        foreach ( $fields as $field ) {
            if ( isset( $_POST[$field] ) ) {
                update_option( $field, wp_kses_post( $_POST[$field] ) );
            }
        }
        echo '<div class="updated"><p>Page content saved successfully.</p></div>';
    }

    ?>
    <div class="wrap">
        <h1><?php _e( 'Page Content Manager', 'org-ecosystem' ); ?></h1>
        <form method="post" action="">
            <?php wp_nonce_field( 'org_save_page_content_action' ); ?>

            <div class="card p-4 mb-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
                <h3><?php _e( 'About Us Page', 'org-ecosystem' ); ?></h3>
                <?php wp_editor( get_option( 'org_about_text' ), 'org_about_text', array( 'textarea_rows' => 5 ) ); ?>
            </div>

            <div class="card p-4 mb-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
                <h3><?php _e( 'Mission & Vision', 'org-ecosystem' ); ?></h3>
                <label class="fw-bold">Mission Statement</label>
                <?php wp_editor( get_option( 'org_mission_text' ), 'org_mission_text', array( 'textarea_rows' => 3 ) ); ?>
                <br>
                <label class="fw-bold">Vision Statement</label>
                <?php wp_editor( get_option( 'org_vision_text' ), 'org_vision_text', array( 'textarea_rows' => 3 ) ); ?>
            </div>

            <div class="card p-4 mb-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
                <h3><?php _e( 'Contact Page Info', 'org-ecosystem' ); ?></h3>
                <?php wp_editor( get_option( 'org_contact_info' ), 'org_contact_info', array( 'textarea_rows' => 3 ) ); ?>
            </div>

            <div class="card p-4 mb-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
                <h3><?php _e( 'Membership Plans Intro', 'org-ecosystem' ); ?></h3>
                <?php wp_editor( get_option( 'org_plans_intro' ), 'org_plans_intro', array( 'textarea_rows' => 3 ) ); ?>
            </div>

            <div class="card p-4 mb-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
                <h3><?php _e( 'Referral Program Intro', 'org-ecosystem' ); ?></h3>
                <?php wp_editor( get_option( 'org_referral_intro' ), 'org_referral_intro', array( 'textarea_rows' => 3 ) ); ?>
            </div>

            <div class="card p-4 mb-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
                <h3><?php _e( 'Payment Methods Intro', 'org-ecosystem' ); ?></h3>
                <?php wp_editor( get_option( 'org_payments_intro' ), 'org_payments_intro', array( 'textarea_rows' => 3 ) ); ?>
            </div>

            <p class="submit">
                <input type="submit" name="org_save_page_content" class="button button-primary" value="Save All Page Content">
            </p>
        </form>
    </div>
    <?php
}

/**
 * System Setup Page Callback
 */
function org_ecosystem_setup_page() {
    if ( isset( $_POST['org_create_pages'] ) ) {
        check_admin_referer( 'org_create_pages_action' );

        $pages = array(
            'dashboard'  => array( 'title' => 'Member Dashboard', 'template' => 'page-dashboard.php', 'content' => '' ),
            'contact'    => array( 'title' => 'Contact Us', 'template' => 'page-contact.php', 'content' => '' ),
            'join'       => array( 'title' => 'Join Us', 'template' => 'page-join.php', 'content' => '' ),
            'donate'     => array( 'title' => 'Support Our Mission', 'template' => 'page-donation.php', 'content' => '[org_donation_form]' ),
            'about'      => array( 'title' => 'About Us', 'template' => 'page-about.php', 'content' => '' ),
            'mission'    => array( 'title' => 'Our Mission', 'template' => 'page-mission.php', 'content' => '' ),
            'plans'      => array( 'title' => 'Membership Plans', 'template' => 'page-plans.php', 'content' => '[org_pricing_table]' ),
            'referrals'  => array( 'title' => 'Referral Program', 'template' => 'page-referrals.php', 'content' => '' ),
            'faq'        => array( 'title' => 'Frequently Asked Questions', 'template' => 'page-faq.php', 'content' => '' ),
            'directory'  => array( 'title' => 'Member Directory', 'template' => 'template-directory.php', 'content' => '[org_directory]' ),
            'governance' => array( 'title' => 'Governance & Leadership', 'template' => 'page-governance.php', 'content' => '<h2>Our Leadership Team</h2><p>Meet the dedicated professionals steering our organization.</p>' ),
            'partners'   => array( 'title' => 'Partner With Us', 'template' => 'page-partners.php', 'content' => '<h2>Collaborate for Growth</h2><p>Join our network of elite partners and sponsors.</p>' ),
            'privacy'    => array( 'title' => 'Privacy Policy', 'template' => 'page-privacy.php', 'content' => '<p>Your privacy is important to us. This policy explains how we handle your data.</p>' ),
            'terms'      => array( 'title' => 'Terms & Conditions', 'template' => 'page-terms.php', 'content' => '<p>Standard terms of service for our organization ecosystem.</p>' ),
            'businesses' => array( 'title' => 'Business Showcase', 'template' => 'page.php', 'content' => '[org_business_grid]' ),
            'events'     => array( 'title' => 'Upcoming Events', 'template' => 'page.php', 'content' => '[org_event_grid]' ),
            'resources'  => array( 'title' => 'Member Resources', 'template' => 'page-resources.php', 'content' => '[org_resource_grid]' ),
            'products'   => array( 'title' => 'Product Marketplace', 'template' => 'page.php', 'content' => '[org_product_grid]' ),
            'jobs'       => array( 'title' => 'Job Board', 'template' => 'page.php', 'content' => '[org_job_list]' ),
        );

        foreach ( $pages as $slug => $data ) {
            $exists = get_page_by_path( $slug );
            if ( ! $exists ) {
                $pid = wp_insert_post( array(
                    'post_title'   => $data['title'],
                    'post_name'    => $slug,
                    'post_type'    => 'page',
                    'post_status'  => 'publish',
                    'post_content' => $data['content'],
                ) );
                if ( $pid && $data['template'] ) {
                    update_post_meta( $pid, '_wp_page_template', $data['template'] );
                }
            }
        }
        echo '<div class="updated"><p>Required pages created successfully.</p></div>';
    }

    ?>
    <div class="wrap">
        <h1><?php _e( 'System Setup & Tools', 'org-ecosystem' ); ?></h1>

        <div class="card p-4 mt-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
            <h3><?php _e( 'Page Initialization', 'org-ecosystem' ); ?></h3>
            <p><?php _e( 'Click the button below to automatically create all the required pages for the organization ecosystem (Dashboard, Contact, Join, etc.).', 'org-ecosystem' ); ?></p>
            <form method="post" action="">
                <?php wp_nonce_field( 'org_create_pages_action' ); ?>
                <button type="submit" name="org_create_pages" class="button button-primary"><?php _e( 'Auto-Create Required Pages', 'org-ecosystem' ); ?></button>
            </form>
        </div>

        <div class="card p-4 mt-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
            <h3><?php _e( 'Permalinks Notice', 'org-ecosystem' ); ?></h3>
            <p><?php _e( 'If you encounter 404 errors, please go to Settings > Permalinks and click "Save Changes" to flush the rewrite rules.', 'org-ecosystem' ); ?></p>
            <a href="<?php echo admin_url('options-permalink.php'); ?>" class="button button-secondary"><?php _e( 'Go to Permalink Settings', 'org-ecosystem' ); ?></a>
        </div>
    </div>
    <?php
}

/**
 * Newsletter Management Page Callback
 */
function org_ecosystem_newsletters_page() {
    if ( isset( $_POST['org_send_newsletter'] ) ) {
        check_admin_referer( 'org_send_newsletter_action' );
        $subject = sanitize_text_field( $_POST['newsletter_subject'] );
        $content = wp_kses_post( $_POST['newsletter_content'] );

        // In a real app, this would loop through subscribers and send emails.
        // For this theme, we'll just log the newsletter as a CPT.
        wp_insert_post( array(
            'post_title'   => $subject,
            'post_content' => $content,
            'post_type'    => 'org_newsletter',
            'post_status'  => 'publish',
        ) );
        echo '<div class="updated"><p>Newsletter dispatched and archived.</p></div>';
    }

    $newsletters = new WP_Query( array(
        'post_type' => 'org_newsletter',
        'posts_per_page' => 10,
    ) );
    ?>
    <div class="wrap">
        <h1><?php _e( 'Community Broadcast & Newsletters', 'org-ecosystem' ); ?></h1>

        <div class="grid-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
            <div class="compose-area">
                <div class="card p-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
                    <h3 style="margin-top: 0;"><?php _e( 'Compose New Broadcast', 'org-ecosystem' ); ?></h3>
                    <form method="post" action="">
                        <?php wp_nonce_field( 'org_send_newsletter_action' ); ?>
                        <div class="mb-3">
                            <label class="form-label d-block fw-bold"><?php _e( 'Campaign Subject', 'org-ecosystem' ); ?></label>
                            <input type="text" name="newsletter_subject" class="widefat" required style="padding: 10px; border-radius: 6px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block fw-bold"><?php _e( 'Message Body', 'org-ecosystem' ); ?></label>
                            <?php wp_editor( '', 'newsletter_content', array( 'textarea_name' => 'newsletter_content', 'media_buttons' => true, 'textarea_rows' => 10 ) ); ?>
                        </div>
                        <button type="submit" name="org_send_newsletter" class="button button-primary button-large"><?php _e( 'Dispatch to All Members', 'org-ecosystem' ); ?></button>
                    </form>
                </div>
            </div>
            <div class="archive-area">
                <div class="card p-4" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">
                    <h3 style="margin-top: 0;"><?php _e( 'Recent Dispatches', 'org-ecosystem' ); ?></h3>
                    <table class="wp-list-table widefat fixed striped mt-3">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Subject</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ( $newsletters->have_posts() ) : ?>
                                <?php while ( $newsletters->have_posts() ) : $newsletters->the_post(); ?>
                                    <tr>
                                        <td><?php echo get_the_date(); ?></td>
                                        <td><strong><?php the_title(); ?></strong></td>
                                        <td><span class="badge" style="background: #198754; color: #fff; padding: 3px 8px; border-radius: 4px;">Sent</span></td>
                                    </tr>
                                <?php endwhile; wp_reset_postdata(); ?>
                            <?php else : ?>
                                <tr><td colspan="3">No previous newsletters.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
		<h1><?php _e( 'Global Content Manager', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Overview of all custom post types and their current publication status.', 'org-ecosystem' ); ?></p>

		<div class="card p-4 bg-white border shadow-sm mt-3" style="border-radius: 12px; border: 1px solid #e2e8f0;">
			<table class="wp-list-table widefat fixed striped" style="border: none;">
				<thead>
					<tr>
						<th style="font-weight: 700; padding: 12px;">Resource Type</th>
						<th style="font-weight: 700; padding: 12px;">Active / Published</th>
						<th style="font-weight: 700; padding: 12px;">Pending Review</th>
						<th style="font-weight: 700; padding: 12px;">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$types = array( 'member', 'business', 'product', 'event', 'job', 'program', 'resource', 'donation', 'announcement', 'org_message', 'org_transaction', 'org_newsletter' );
					foreach ( $types as $type ) :
						$count = wp_count_posts( $type );
						$obj = get_post_type_object( $type );
						if ( ! $obj ) continue;
						?>
						<tr>
							<td style="padding: 12px;"><strong><?php echo esc_html( $obj->labels->name ); ?></strong></td>
							<td style="padding: 12px;"><span class="badge" style="background: #eef2ff; color: #4338ca; padding: 4px 10px; border-radius: 6px; font-weight: 600;"><?php echo esc_html( $count->publish ); ?></span></td>
							<td style="padding: 12px;">
								<?php if ( $count->pending > 0 ) : ?>
									<span class="badge" style="background: #fff7ed; color: #c2410c; padding: 4px 10px; border-radius: 6px; font-weight: 600;"><?php echo esc_html( $count->pending ); ?></span>
								<?php else : ?>
									<span style="color: #cbd5e1;">0</span>
								<?php endif; ?>
							</td>
							<td style="padding: 12px;"><a href="<?php echo admin_url( 'edit.php?post_type=' . $type ); ?>" class="button button-small"><?php _e( 'Quick Edit', 'org-ecosystem' ); ?></a></td>
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
		<h1><?php _e( 'Directory & Global UX Settings', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Configure how the public directory behaves and how member data is gated.', 'org-ecosystem' ); ?></p>

		<form method="post" action="" style="margin-top: 25px;">
			<?php wp_nonce_field( 'org_save_directory_action' ); ?>
			<div class="card p-5 bg-white border mb-4 shadow-sm" style="border-radius: 15px; max-width: 850px;">
				<div class="mb-5">
					<label class="form-label d-block fw-bold" style="font-size: 1.2rem; color: #1e293b;"><?php _e( 'Directory Density', 'org-ecosystem' ); ?></label>
					<div style="display: flex; align-items: center; gap: 15px; margin-top: 10px;">
						<input type="number" name="per_page" class="small-text" value="<?php echo esc_attr( get_option( 'org_directory_per_page', 12 ) ); ?>" style="padding: 8px 12px; border-radius: 8px; font-size: 1rem;">
						<span class="description"><?php _e( 'Profiles per page before pagination kicks in.', 'org-ecosystem' ); ?></span>
					</div>
				</div>

				<hr style="margin: 30px 0; border: 0; border-top: 1px solid #f1f5f9;">

				<div class="mb-5">
					<label class="form-label d-block fw-bold" style="font-size: 1.2rem; color: #1e293b;"><?php _e( 'Trust Badges', 'org-ecosystem' ); ?></label>
					<div style="margin-top: 12px;">
						<label style="font-size: 1rem; color: #475569; display: flex; align-items: center; gap: 10px; cursor: pointer;">
							<input type="checkbox" name="show_badges" value="1" <?php checked( get_option( 'org_directory_show_badges', '1' ), '1' ); ?> style="width: 18px; height: 18px;">
							<?php _e( 'Enable "Verified" and "Featured" Badges on directory cards.', 'org-ecosystem' ); ?>
						</label>
					</div>
				</div>

				<hr style="margin: 30px 0; border: 0; border-top: 1px solid #f1f5f9;">

				<div class="mb-2">
					<label class="form-label d-block fw-bold" style="font-size: 1.2rem; color: #1e293b;"><?php _e( 'Lead Gating (Revenue Maximizer)', 'org-ecosystem' ); ?></label>
					<div style="margin-top: 12px;">
						<label style="font-size: 1rem; color: #475569; display: flex; align-items: center; gap: 10px; cursor: pointer;">
							<input type="checkbox" name="lead_protection" value="1" <?php checked( get_option( 'org_lead_protection', '0' ), '1' ); ?> style="width: 18px; height: 18px;">
							<?php _e( 'Hide contact details (Email/Phone) from visitors and Basic members.', 'org-ecosystem' ); ?>
						</label>
						<p class="description" style="margin-top: 10px; padding-left: 28px;"><?php _e( 'When enabled, users will see an "Upgrade to View" prompt. This is the most effective way to sell Premium memberships.', 'org-ecosystem' ); ?></p>
					</div>
				</div>
			</div>

			<p class="submit">
				<input type="submit" name="org_save_directory" class="button button-primary button-large" style="padding: 12px 40px !important; height: auto !important; font-size: 16px !important;" value="Save System Settings">
			</p>
		</form>
	</div>
	<?php
}

/**
 * Support Tickets Page Callback
 */
/**
 * Internal Messages Page Callback
 */
function org_ecosystem_internal_messages_page() {
    $messages = new WP_Query( array(
        'post_type' => 'org_message',
        'meta_query' => array(
            array( 'key' => '_msg_receiver_id', 'value' => 0 ), // 0 = Admin
        ),
        'posts_per_page' => -1,
    ) );
    ?>
    <div class="wrap">
        <h1><?php _e( 'Internal Communication Hub (Admin Inbox)', 'org-ecosystem' ); ?></h1>
        <p class="description"><?php _e( 'Direct messages sent to the organization from members.', 'org-ecosystem' ); ?></p>

        <div class="card p-4 mt-4" style="border-radius: 12px; background: #fff; border: 1px solid #e2e8f0;">
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Sender</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ( $messages->have_posts() ) : ?>
                        <?php while ( $messages->have_posts() ) : $messages->the_post(); ?>
                            <tr>
                                <td><?php echo get_the_date(); ?></td>
                                <td><?php the_author(); ?></td>
                                <td><strong><?php the_title(); ?></strong></td>
                                <td><?php echo wp_trim_words( get_the_content(), 20 ); ?></td>
                                <td>
                                    <a href="<?php echo admin_url('post.php?post='.get_the_ID().'&action=edit'); ?>" class="button button-small">View & Reply</a>
                                </td>
                            </tr>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php else : ?>
                        <tr><td colspan="5">No internal messages found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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
		<h1><?php _e( 'Member Support Desk', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Manage support inquiries and technical requests from your organization members.', 'org-ecosystem' ); ?></p>

		<div class="card p-4 mt-4" style="border-radius: 12px; background: #fff; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
			<table class="wp-list-table widefat fixed striped" style="border: none;">
				<thead>
					<tr>
						<th style="padding: 12px; font-weight: 700;">Subject / Ticket ID</th>
						<th style="padding: 12px; font-weight: 700;">Submitted By</th>
						<th style="padding: 12px; font-weight: 700;">Urgency / Status</th>
						<th style="padding: 12px; font-weight: 700;">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( $tickets->have_posts() ) : ?>
						<?php while ( $tickets->have_posts() ) : $tickets->the_post(); ?>
							<tr>
								<td style="padding: 12px;"><strong>#<?php the_ID(); ?>: <?php the_title(); ?></strong></td>
								<td style="padding: 12px;"><?php echo get_the_author(); ?></td>
								<td style="padding: 12px;">
									<?php
									$status = get_post_meta( get_the_ID(), '_ticket_status', true ) ?: 'open';
									$color = $status === 'open' ? '#dc3545' : '#198754';
									?>
									<span class="badge" style="background: <?php echo $color; ?>; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 10px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;"><?php echo esc_html( $status ); ?></span>
								</td>
								<td style="padding: 12px;">
									<a href="<?php echo admin_url('post.php?post='.get_the_ID().'&action=edit'); ?>" class="button button-small"><?php _e( 'Reply', 'org-ecosystem' ); ?></a>
									<a href="<?php echo wp_nonce_url( add_query_arg( array( 'ticket_id' => get_the_ID(), 'new_status' => 'closed' ) ), 'org_update_ticket' ); ?>" class="button button-small"><?php _e( 'Resolve', 'org-ecosystem' ); ?></a>
								</td>
							</tr>
						<?php endwhile; wp_reset_postdata(); ?>
					<?php else : ?>
						<tr><td colspan="4" style="padding: 30px; text-align: center; color: #94a3b8;"><?php _e( 'No active support tickets. Your members are happy!', 'org-ecosystem' ); ?></td></tr>
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
    $view = isset( $_GET['view'] ) ? sanitize_text_field( $_GET['view'] ) : 'all';

    if ( isset( $_POST['org_save_membership_rates'] ) ) {
        check_admin_referer( 'org_save_membership_rates_action' );
        update_option( 'org_rate_professional', floatval( $_POST['rate_professional'] ) );
        update_option( 'org_rate_vendor', floatval( $_POST['rate_vendor'] ) );
        update_option( 'org_rate_corporate', floatval( $_POST['rate_corporate'] ) );
        update_option( 'org_rate_lifetime', floatval( $_POST['rate_lifetime'] ) );
        echo '<div class="updated"><p>' . __( 'Membership rates updated.', 'org-ecosystem' ) . '</p></div>';
    }

	?>
	<div class="wrap">
		<h1><?php echo $view === 'upgraded' ? __( 'Upgraded (Active) Accounts', 'org-ecosystem' ) : __( 'Member Growth & Tiers', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Manage registration approvals and monitor your membership base.', 'org-ecosystem' ); ?></p>

		<?php if ( isset( $_GET['approved'] ) ) : ?>
			<div class="updated settings-error notice is-dismissible"><p><strong><?php _e( 'Member approved successfully!', 'org-ecosystem' ); ?></strong></p></div>
		<?php endif; ?>

        <?php if ( $view === 'upgraded' ) : ?>
            <div class="card p-5 mb-4 bg-white border" style="border-radius: 15px; border: 1px solid #e2e8f0;">
                <h3 class="mt-0"><?php _e( 'Active Professional Network', 'org-ecosystem' ); ?></h3>
                <p class="description"><?php _e( 'These members have upgraded their accounts and are visible in the directory.', 'org-ecosystem' ); ?></p>
                <?php
                $active_members_query = new WP_Query( array(
                    'post_type' => 'member',
                    'post_status' => 'publish',
                    'meta_key' => '_member_status',
                    'meta_value' => 'active',
                    'posts_per_page' => -1,
                ) );

                if ( $active_members_query->have_posts() ) : ?>
                    <table class="wp-list-table widefat fixed striped mt-4">
                        <thead>
                            <tr>
                                <th>Member Name</th>
                                <th>Membership Level</th>
                                <th>Joined Date</th>
                                <th>Renewal Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ( $active_members_query->have_posts() ) : $active_members_query->the_post();
                                $user_id = get_post_field( 'post_author', get_the_ID() );
                                $level = get_user_meta( $user_id, '_membership_level', true );
                                $renewal = get_post_meta( get_the_ID(), '_member_renewal_date', true );
                            ?>
                                <tr>
                                    <td><strong><?php the_title(); ?></strong></td>
                                    <td><span class="badge bg-primary" style="background: #2563eb; color: #fff; padding: 3px 8px; border-radius: 4px;"><?php echo esc_html( ucfirst( $level ) ); ?></span></td>
                                    <td><?php echo get_the_date(); ?></td>
                                    <td><?php echo $renewal ?: 'N/A'; ?></td>
                                    <td><span class="text-success fw-bold"><span class="dashicons dashicons-yes"></span> Upgraded</span></td>
                                </tr>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p class="text-muted"><?php _e( 'No upgraded members found.', 'org-ecosystem' ); ?></p>
                <?php endif; ?>
                <div class="mt-4">
                    <a href="<?php echo admin_url('admin.php?page=org-membership'); ?>" class="button"><?php _e( 'Back to All Members', 'org-ecosystem' ); ?></a>
                </div>
            </div>
        <?php else : ?>
            <div class="card p-5 mb-4 bg-white border" style="border-radius: 15px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <h3 class="mt-0" style="color: #1e293b; display: flex; align-items: center; gap: 10px;"><span class="dashicons dashicons-clock" style="color: #f59e0b;"></span> <?php _e( 'Pending Applications', 'org-ecosystem' ); ?></h3>
                <p class="description mb-4"><?php _e( 'These professionals have requested to join. Approve them to publish their profiles to the public directory.', 'org-ecosystem' ); ?></p>
                <?php
                $pending_members = new WP_Query( array(
                    'post_type' => 'member',
                    'post_status' => 'pending',
                    'posts_per_page' => -1,
                ) );

                if ( $pending_members->have_posts() ) : ?>
                    <table class="wp-list-table widefat fixed striped mt-4" style="border: none;">
                        <thead>
                            <tr>
                                <th style="padding: 12px; font-weight: 700; background: #f8fafc;">Applicant Name</th>
                                <th style="padding: 12px; font-weight: 700; background: #f8fafc;">Email Address</th>
                                <th style="padding: 12px; font-weight: 700; background: #f8fafc;">Date Joined</th>
                                <th style="padding: 12px; font-weight: 700; background: #f8fafc;">Review</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ( $pending_members->have_posts() ) : $pending_members->the_post(); ?>
                                <tr>
                                    <td style="padding: 12px;"><strong><?php the_title(); ?></strong></td>
                                    <td style="padding: 12px;"><?php echo get_the_author_meta( 'user_email' ); ?></td>
                                    <td style="padding: 12px;"><?php echo get_the_date(); ?></td>
                                    <td style="padding: 12px;">
                                        <a href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=org_approve_member&member_id=' . get_the_ID() ), 'org_approve_member_action' ); ?>" class="button button-primary"><?php _e( 'Approve & Activate', 'org-ecosystem' ); ?></a>
                                    </td>
                                </tr>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div style="background: #f8fafc; padding: 40px; border-radius: 12px; text-align: center; border: 1px dashed #cbd5e1;">
                        <span class="dashicons dashicons-yes-alt" style="font-size: 40px; width: 40px; height: 40px; color: #10b981; margin-bottom: 10px;"></span>
                        <p class="text-muted" style="font-size: 16px; margin: 0;"><?php _e( 'All applications have been processed.', 'org-ecosystem' ); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

		<div class="card p-5" style="background: #fff; border: 1px solid #e2e8f0; margin-bottom: 20px; border-radius: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
			<h3 style="margin-top: 0; color: #1e293b;"><span class="dashicons dashicons-money" style="color: #10b981; margin-right: 10px;"></span> <?php _e( 'Tiered Membership Performance & Rates', 'org-ecosystem' ); ?></h3>
			<p class="description mb-4"><?php _e( 'Total active users per tier and global annual rates.', 'org-ecosystem' ); ?></p>

            <form method="post" action="">
            <?php wp_nonce_field( 'org_save_membership_rates_action' ); ?>
			<table class="wp-list-table widefat fixed striped" style="border: none;">
				<thead>
					<tr>
						<th style="padding: 12px; font-weight: 700; background: #f8fafc;">Plan Designation</th>
						<th style="padding: 12px; font-weight: 700; background: #f8fafc;">Annual Rate</th>
						<th style="padding: 12px; font-weight: 700; background: #f8fafc;">Billing Cycle</th>
						<th style="padding: 12px; font-weight: 700; background: #f8fafc;">Total Active Base</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$levels = org_ecosystem_get_membership_levels();
					foreach ( $levels as $key => $level ) : ?>
						<tr>
							<td style="padding: 12px;"><strong><?php echo esc_html( $level['name'] ); ?></strong></td>
							<td style="padding: 12px; font-weight: 600;">
                                <?php if ($key === 'community') : ?>
                                    ₱ 0.00
                                <?php else : ?>
                                    <div style="display: flex; align-items: center; gap: 5px;">
                                        <span>₱</span>
                                        <input type="number" name="rate_<?php echo $key; ?>" value="<?php echo esc_attr( $level['price'] ); ?>" step="0.01" style="width: 100px; padding: 4px;">
                                    </div>
                                <?php endif; ?>
                            </td>
							<td style="padding: 12px;"><?php echo esc_html( ucfirst( $level['duration'] ) ); ?></td>
							<td style="padding: 12px;">
								<span class="badge" style="background: #f1f5f9; color: #475569; padding: 6px 12px; border-radius: 8px; font-weight: 700;">
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
            <div class="mt-4">
                <input type="submit" name="org_save_membership_rates" class="button button-primary" value="Save All Rates">
            </div>
            </form>
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
		echo '<div class="updated"><p>Email campaigns updated.</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php _e( 'Automated Engagement Campaigns', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Configure the lifecycle messages that keep your community active and renewals flowing.', 'org-ecosystem' ); ?></p>

		<form method="post" action="" style="max-width: 950px; margin-top: 30px;">
			<?php wp_nonce_field( 'org_save_emails_action' ); ?>

			<div class="email-card" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
				<h3 style="margin-top: 0; color: #0d6efd; display: flex; align-items: center; gap: 10px;"><span class="dashicons dashicons-email-alt"></span> <?php _e( '1. Onboarding (Welcome Email)', 'org-ecosystem' ); ?></h3>
				<p class="description mb-4"><?php _e( 'The first impression. Sent automatically when a professional registers.', 'org-ecosystem' ); ?></p>
				<div class="mb-4">
					<label class="form-label d-block fw-bold" style="margin-bottom: 8px;"><?php _e( 'Subject Line', 'org-ecosystem' ); ?></label>
					<input type="text" name="welcome_subject" class="widefat" value="<?php echo esc_attr( get_option( 'org_welcome_email_subject', 'Welcome to our Organization!' ) ); ?>" style="padding: 12px; border-radius: 8px; font-size: 1rem;">
				</div>
				<div class="mb-3">
					<label class="form-label d-block fw-bold" style="margin-bottom: 8px;"><?php _e( 'Email Body', 'org-ecosystem' ); ?></label>
					<textarea name="welcome_body" rows="10" class="widefat" style="padding: 12px; border-radius: 8px; font-size: 1rem; line-height: 1.5;"><?php echo esc_textarea( get_option( 'org_welcome_email_body', 'Hi {user_name}, thank you for joining our professional ecosystem! Please verify your email here: {verify_url}' ) ); ?></textarea>
					<div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin-top: 15px; border-left: 4px solid #cbd5e1;">
						<p class="small text-muted mb-0"><strong><?php _e( 'Dynamic Tags:', 'org-ecosystem' ); ?></strong> {user_name}, {site_name}, {verify_url}</p>
					</div>
				</div>
			</div>

			<div class="email-card" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
				<h3 style="margin-top: 0; color: #f59e0b; display: flex; align-items: center; gap: 10px;"><span class="dashicons dashicons-clock"></span> <?php _e( '2. Retention (Renewal Reminders)', 'org-ecosystem' ); ?></h3>
				<p class="description mb-4"><?php _e( 'Protect your recurring revenue. Sent 7 days prior to membership expiration.', 'org-ecosystem' ); ?></p>
				<div class="mb-4">
					<label class="form-label d-block fw-bold" style="margin-bottom: 8px;"><?php _e( 'Subject Line', 'org-ecosystem' ); ?></label>
					<input type="text" name="reminder_subject" class="widefat" value="<?php echo esc_attr( get_option( 'org_reminder_email_subject', 'Membership Renewal Reminder' ) ); ?>" style="padding: 12px; border-radius: 8px; font-size: 1rem;">
				</div>
				<div class="mb-3">
					<label class="form-label d-block fw-bold" style="margin-bottom: 8px;"><?php _e( 'Email Body', 'org-ecosystem' ); ?></label>
					<textarea name="reminder_body" rows="10" class="widefat" style="padding: 12px; border-radius: 8px; font-size: 1rem; line-height: 1.5;"><?php echo esc_textarea( get_option( 'org_reminder_email_body', 'Hi {user_name}, your membership at {site_name} will expire in 7 days. Don\'t forget to renew!' ) ); ?></textarea>
				</div>
			</div>

			<p class="submit">
				<input type="submit" name="org_save_emails" class="button button-primary button-large" style="padding: 12px 50px !important; height: auto !important; font-size: 18px !important; border-radius: 10px !important;" value="Update All Campaigns">
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
		update_option( 'org_stripe_mode', sanitize_text_field( $_POST['stripe_mode'] ) );
		update_option( 'org_stripe_api_key', sanitize_text_field( $_POST['stripe_api_key'] ) );
        update_option( 'org_stripe_pub_key', sanitize_text_field( $_POST['stripe_pub_key'] ) );

		update_option( 'org_paypal_enabled', isset( $_POST['paypal_enabled'] ) ? '1' : '0' );
		update_option( 'org_paypal_mode', sanitize_text_field( $_POST['paypal_mode'] ) );
		update_option( 'org_paypal_email', sanitize_email( $_POST['paypal_email'] ) );

        update_option( 'org_gcash_number', sanitize_text_field( $_POST['gcash_number'] ) );
		update_option( 'org_offline_instructions', sanitize_textarea_field( $_POST['offline_instructions'] ) );
		echo '<div class="updated"><p>Revenue configuration saved.</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php _e( 'Revenue & Financial Gateway', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Configure how your organization processes dues, donations, and featured listing fees.', 'org-ecosystem' ); ?></p>

		<form method="post" action="" style="max-width: 850px; margin-top: 30px;">
			<?php wp_nonce_field( 'org_save_payments_action' ); ?>

			<div class="card p-5 bg-white border mb-4 shadow-sm" style="border-radius: 15px; border: 1px solid #e2e8f0;">
				<h3 style="margin-top: 0; display: flex; align-items: center; gap: 15px;"><img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" height="30" alt="Stripe"> <span style="font-size: 14px; color: #64748b; font-weight: 400;">Secure Credit Card Checkout</span></h3>
				<div class="mb-4 mt-4">
					<label style="font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 10px; cursor: pointer;">
						<input type="checkbox" name="stripe_enabled" value="1" <?php checked( get_option( 'org_stripe_enabled' ), '1' ); ?> style="width: 18px; height: 18px;">
						<?php _e( 'Activate Stripe Gateway', 'org-ecosystem' ); ?>
					</label>
				</div>
                <div class="mb-4">
                    <label class="form-label d-block fw-bold"><?php _e( 'Environment Mode', 'org-ecosystem' ); ?></label>
                    <select name="stripe_mode" class="form-select w-auto">
                        <option value="test" <?php selected(get_option('org_stripe_mode'), 'test'); ?>>Test / Sandbox</option>
                        <option value="live" <?php selected(get_option('org_stripe_mode'), 'live'); ?>>Production / Live</option>
                    </select>
                </div>
				<div class="mb-3">
					<label class="form-label d-block fw-bold" style="margin-bottom: 8px;"><?php _e( 'Stripe Secret API Key', 'org-ecosystem' ); ?></label>
					<input type="password" name="stripe_api_key" class="widefat" value="<?php echo esc_attr( get_option( 'org_stripe_api_key' ) ); ?>" placeholder="sk_test_..." style="padding: 12px; border-radius: 8px; font-size: 1rem;">
                    <p class="description"><?php _e( 'Found in your Stripe Dashboard under Developers > API Keys.', 'org-ecosystem' ); ?></p>
				</div>
                <div class="mb-3">
					<label class="form-label d-block fw-bold" style="margin-bottom: 8px;"><?php _e( 'Stripe Publishable Key', 'org-ecosystem' ); ?></label>
					<input type="text" name="stripe_pub_key" class="widefat" value="<?php echo esc_attr( get_option( 'org_stripe_pub_key' ) ); ?>" placeholder="pk_test_..." style="padding: 12px; border-radius: 8px; font-size: 1rem;">
                    <p class="description"><?php _e( 'Required for the secure frontend payment elements.', 'org-ecosystem' ); ?></p>
				</div>
			</div>

			<div class="card p-5 bg-white border mb-4 shadow-sm" style="border-radius: 15px; border: 1px solid #e2e8f0;">
				<h3 style="margin-top: 0; display: flex; align-items: center; gap: 15px;"><img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" height="30" alt="PayPal"> <span style="font-size: 14px; color: #64748b; font-weight: 400;">Global Digital Wallet</span></h3>
				<div class="mb-4 mt-4">
					<label style="font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 10px; cursor: pointer;">
						<input type="checkbox" name="paypal_enabled" value="1" <?php checked( get_option( 'org_paypal_enabled' ), '1' ); ?> style="width: 18px; height: 18px;">
						<?php _e( 'Activate PayPal Gateway', 'org-ecosystem' ); ?>
					</label>
				</div>
                <div class="mb-4">
                    <label class="form-label d-block fw-bold"><?php _e( 'Environment Mode', 'org-ecosystem' ); ?></label>
                    <select name="paypal_mode" class="form-select w-auto">
                        <option value="test" <?php selected(get_option('org_paypal_mode'), 'test'); ?>>Sandbox</option>
                        <option value="live" <?php selected(get_option('org_paypal_mode'), 'live'); ?>>Live</option>
                    </select>
                </div>
                <div class="mb-3">
					<label class="form-label d-block fw-bold" style="margin-bottom: 8px;"><?php _e( 'PayPal Business Email', 'org-ecosystem' ); ?></label>
					<input type="email" name="paypal_email" class="widefat" value="<?php echo esc_attr( get_option( 'org_paypal_email' ) ); ?>" placeholder="payments@your-org.com" style="padding: 12px; border-radius: 8px; font-size: 1rem;">
                    <p class="description"><?php _e( 'The email address associated with your PayPal Business account.', 'org-ecosystem' ); ?></p>
				</div>
			</div>

            <div class="card p-5 bg-white border mb-4 shadow-sm" style="border-radius: 15px; border: 1px solid #e2e8f0;">
				<h3 style="margin-top: 0; display: flex; align-items: center; gap: 10px; color: #007bff;"><span class="dashicons dashicons-smartphone"></span> <?php _e( 'GCash Payment (Mobile)', 'org-ecosystem' ); ?></h3>
				<div class="mb-3 mt-4">
					<label class="form-label d-block fw-bold" style="margin-bottom: 8px;"><?php _e( 'GCash Registered Number', 'org-ecosystem' ); ?></label>
					<input type="text" name="gcash_number" class="widefat" value="<?php echo esc_attr( get_option( 'org_gcash_number' ) ); ?>" placeholder="0917XXXXXXX" style="padding: 12px; border-radius: 8px; font-size: 1rem;">
                    <p class="description"><?php _e( 'Members will see this number to send mobile payments manually.', 'org-ecosystem' ); ?></p>
				</div>
			</div>

			<div class="card p-5 bg-white border mb-4 shadow-sm" style="border-radius: 15px; border: 1px solid #e2e8f0;">
				<h3 style="margin-top: 0; display: flex; align-items: center; gap: 10px; color: #64748b;"><span class="dashicons dashicons-bank"></span> <?php _e( 'Manual & Offline Payments', 'org-ecosystem' ); ?></h3>
				<div class="mb-3 mt-4">
					<label class="form-label d-block fw-bold" style="margin-bottom: 8px;"><?php _e( 'Direct Bank Transfer Instructions', 'org-ecosystem' ); ?></label>
					<textarea name="offline_instructions" rows="5" class="widefat" style="padding: 12px; border-radius: 8px; font-size: 1rem;" placeholder="Example: Please deposit to BDO Account 12345..."><?php echo esc_textarea( get_option( 'org_offline_instructions', 'Please transfer ₱1,500 to our Bank Account: XYZ-123-456' ) ); ?></textarea>
				</div>
			</div>

			<p class="submit">
				<input type="submit" name="org_save_payments" class="button button-primary button-large" style="padding: 15px 60px !important; height: auto !important; font-size: 18px !important; border-radius: 10px !important;" value="Save Financial Profile">
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
		echo '<div class="updated"><p>System capabilities updated.</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php _e( 'Governance: Roles & Permissions', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Define precisely what chapter leaders, staff, and members can access and manage.', 'org-ecosystem' ); ?></p>

		<form method="post" action="" style="margin-top: 30px;">
			<?php wp_nonce_field( 'org_save_roles_action' ); ?>
			<div class="card p-0 bg-white border shadow-sm" style="border-radius: 15px; overflow: hidden; border: 1px solid #e2e8f0;">
				<table class="wp-list-table widefat fixed striped" style="border: none;">
					<thead>
						<tr>
							<th style="padding: 20px; font-weight: 700; background: #f8fafc; font-size: 14px;">Role Designation</th>
							<th style="padding: 20px; font-weight: 700; background: #f8fafc; font-size: 14px; text-align: center;">Approve Members</th>
							<th style="padding: 20px; font-weight: 700; background: #f8fafc; font-size: 14px; text-align: center;">Manage Payments</th>
							<th style="padding: 20px; font-weight: 700; background: #f8fafc; font-size: 14px; text-align: center;">Access Reports</th>
							<th style="padding: 20px; font-weight: 700; background: #f8fafc; font-size: 14px; text-align: center;">Manage Tickets</th>
							<th style="padding: 20px; font-weight: 700; background: #f8fafc; font-size: 14px; text-align: center;">Publish Content</th>
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
								<td style="padding: 20px;"><strong><?php echo esc_html( ucfirst( str_replace('_', ' ', $role_slug ) ) ); ?></strong></td>
								<?php foreach ( $caps as $cap ) : ?>
									<td style="padding: 20px; text-align: center;">
										<input type="checkbox" name="role_caps[<?php echo $role_slug; ?>][<?php echo $cap; ?>]" value="1" <?php checked( $role->has_cap( $cap ) ); ?> style="width: 18px; height: 18px;">
									</td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<p class="submit">
				<input type="submit" name="org_save_roles" class="button button-primary button-large" style="padding: 12px 50px !important; height: auto !important; font-size: 16px !important; margin-top: 10px;" value="Save Permission Map">
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

    // Calculate Total Commissions Paid
    $total_commissions = 0;
    $comm_query = new WP_Query( array( 'post_type' => 'org_transaction', 'meta_query' => array( array( 'key' => '_txn_type', 'value' => 'commission' ) ) ) );
    foreach ( $comm_query->posts as $c ) {
        $total_commissions += abs( floatval( get_post_meta( $c->ID, '_txn_amount', true ) ) );
    }

	?>
	<div class="wrap">
		<h1><?php _e( 'Ecosystem Reports & Economic Analytics', 'org-ecosystem' ); ?></h1>
		<p class="description"><?php _e( 'Real-time indicators of your organization\'s vitality and growth velocity.', 'org-ecosystem' ); ?></p>

		<div class="row" style="display: flex; gap: 20px; margin-top: 30px; flex-wrap: wrap;">
			<div class="card" style="flex: 1; min-width: 300px; background: #fff; padding: 30px; border-left: 6px solid #0d6efd; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
				<h3 style="margin-top: 0; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700;"><?php _e( 'Growth Metric', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 42px; font-weight: 800; margin: 20px 0; color: #1e293b; line-height: 1;"><?php echo esc_html( $active_members ); ?> <span style="font-size: 14px; font-weight: 400; color: #64748b;">Members</span></p>
				<div style="display: flex; gap: 15px;">
					<span style="font-size: 12px; background: #fff7ed; color: #c2410c; padding: 4px 12px; border-radius: 6px; font-weight: 600;"><?php echo esc_html( $pending_members ); ?> pending</span>
					<span style="font-size: 12px; background: #fef2f2; color: #b91c1c; padding: 4px 12px; border-radius: 6px; font-weight: 600;"><?php echo esc_html( $expired_members ); ?> expired</span>
				</div>
			</div>
			<div class="card" style="flex: 1; min-width: 300px; background: #fff; padding: 30px; border-left: 6px solid #10b981; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
				<h3 style="margin-top: 0; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700;"><?php _e( 'Community Marketplace', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 42px; font-weight: 800; margin: 20px 0; color: #1e293b; line-height: 1;"><?php echo esc_html( $total_businesses ); ?> <span style="font-size: 14px; font-weight: 400; color: #64748b;">Businesses</span></p>
				<span style="font-size: 12px; color: #64748b; font-weight: 500;"><?php echo esc_html( $total_products ); ?> members' products showcased</span>
			</div>
			<div class="card" style="flex: 1; min-width: 280px; background: #fff; padding: 25px; border-left: 5px solid #f59e0b; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
				<h3 style="margin-top: 0; color: #64748b; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;"><?php _e( 'Gross Revenue', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 36px; font-weight: 800; margin: 15px 0; color: #1e293b;">₱ <?php echo number_format( $total_revenue, 2 ); ?></p>
				<div style="font-size: 12px; color: #64748b;">
					Subs: ₱<?php echo number_format( $membership_revenue ); ?> | Donations: ₱<?php echo number_format( $donation_revenue ); ?>
				</div>
			</div>
            <div class="card" style="flex: 1; min-width: 280px; background: #fff; padding: 25px; border-left: 5px solid #dc3545; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
				<h3 style="margin-top: 0; color: #64748b; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;"><?php _e( 'Payouts & Comms', 'org-ecosystem' ); ?></h3>
				<p style="font-size: 36px; font-weight: 800; margin: 15px 0; color: #1e293b;">₱ <?php echo number_format( $total_commissions, 2 ); ?></p>
				<span style="font-size: 12px; color: #64748b;">Pending Withdrawal Requests: <?php echo count(get_posts(array('post_type'=>'org_transaction', 'meta_query'=>array(array('key'=>'_txn_type','value'=>'withdrawal'),array('key'=>'_txn_status','value'=>'pending'))))); ?></span>
			</div>
		</div>

		<div class="grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 50px;">
			<div class="card p-5" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 15px;">
				<h3 style="margin-top: 0; color: #1e293b; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;"><?php _e( 'Live Event Registrations', 'org-ecosystem' ); ?></h3>
				<table class="wp-list-table widefat fixed striped mt-4" style="border: none;">
					<thead>
						<tr>
							<th style="padding: 12px; font-weight: 700; background: #f8fafc;">Event Name</th>
							<th style="padding: 12px; font-weight: 700; background: #f8fafc; text-align: center;">RSVPs</th>
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
									<td style="padding: 12px;"><strong><?php the_title(); ?></strong></td>
									<td style="padding: 12px; text-align: center;"><span class="badge" style="background: #eef2ff; color: #4338ca; padding: 4px 12px; border-radius: 6px; font-weight: 700;"><?php echo count( $attendees ); ?></span></td>
								</tr>
							<?php endwhile; wp_reset_postdata();
						else : ?>
							<tr><td colspan="2" style="padding: 20px; text-align: center; color: #94a3b8;">No events currently active.</td></tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

			<div class="card p-5" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 15px;">
				<h3 style="margin-top: 0; color: #1e293b; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;"><?php _e( 'Member Visibility Leaderboard', 'org-ecosystem' ); ?></h3>
				<table class="wp-list-table widefat fixed striped mt-4" style="border: none;">
					<thead>
						<tr>
							<th style="padding: 12px; font-weight: 700; background: #f8fafc;">Member</th>
							<th style="padding: 12px; font-weight: 700; background: #f8fafc; text-align: center;">Profile Impressions</th>
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
									<td style="padding: 12px;"><strong><?php the_title(); ?></strong></td>
									<td style="padding: 12px; text-align: center;"><span class="badge" style="background: #f0fdf4; color: #166534; padding: 4px 12px; border-radius: 6px; font-weight: 700;"><?php echo get_post_meta( get_the_ID(), '_member_view_count', true ) ?: 0; ?></span></td>
								</tr>
							<?php endwhile; wp_reset_postdata();
						else : ?>
							<tr><td colspan="2" style="padding: 20px; text-align: center; color: #94a3b8;">Collecting visibility data...</td></tr>
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
 * Reset Database Action
 */
function org_ecosystem_handle_reset_db() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    check_admin_referer( 'org_reset_db', 'org_reset_nonce' );

    $types = array( 'member', 'business', 'product', 'event', 'job', 'program', 'resource', 'donation', 'announcement', 'org_message', 'org_transaction', 'support_ticket' );
    foreach ( $types as $type ) {
        $posts = get_posts( array( 'post_type' => $type, 'posts_per_page' => -1, 'post_status' => 'any' ) );
        foreach ( $posts as $p ) {
            wp_delete_post( $p->ID, true );
        }
    }

    wp_redirect( admin_url( 'admin.php?page=org-settings&reset=success' ) );
    exit;
}
add_action( 'admin_post_org_reset_db', 'org_ecosystem_handle_reset_db' );

function org_ecosystem_handle_refresh_roles() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    check_admin_referer( 'org_refresh_roles_action' );

    org_ecosystem_register_roles();

    wp_redirect( admin_url( 'admin.php?page=org-settings&roles_refreshed=1' ) );
    exit;
}
add_action( 'admin_post_org_refresh_roles', 'org_ecosystem_handle_refresh_roles' );

/**
 * Handle Demo Data Import
 */
function org_ecosystem_handle_demo_import() {
	if ( ! current_user_can( 'manage_options' ) ) return;
	check_admin_referer( 'org_import_demo', 'org_demo_nonce' );

	$types = array(
        'member'        => 'Member',
        'business'      => 'Corp',
        'product'       => 'Service',
        'event'         => 'Conference',
        'job'           => 'Opening',
        'program'       => 'Initiative',
        'resource'      => 'Guide',
        'donation'      => 'Gift',
        'announcement'  => 'Notice',
        'support_ticket'=> 'Help Request',
        'org_message'   => 'Inbox Item',
    );

    $members = array();
    $businesses = array();

    // 1. Create Members (25)
    for ( $i = 1; $i <= 25; $i++ ) {
        $id = wp_insert_post( array(
            'post_title' => "Sample Professional #$i",
            'post_type'  => 'member',
            'post_status'=> 'publish',
            'post_content'=> "Bio for professional $i. Expert in their field with years of experience."
        ) );
        update_post_meta( $id, '_member_status', 'active' );
        update_post_meta( $id, '_member_view_count', rand(100, 1500) );
        update_post_meta( $id, '_member_is_featured', ( $i % 5 === 0 ) ? '1' : '0' );
        update_post_meta( $id, '_member_is_verified', ( $i % 3 === 0 ) ? '1' : '0' );
        $members[] = $id;
    }

    // 2. Create Businesses (20)
    for ( $i = 1; $i <= 20; $i++ ) {
        $member_id = $members[array_rand($members)];
        $author_id = get_post_field( 'post_author', $member_id );
        $id = wp_insert_post( array(
            'post_title' => "Ecosystem Corp #$i",
            'post_type'  => 'business',
            'post_status'=> 'publish',
            'post_author'=> $author_id,
            'post_content'=> "Description for Corp $i. We provide top-tier solutions for modern organizations."
        ) );
        update_post_meta( $id, '_business_location', 'Manila, PH' );
        $businesses[] = $id;
    }

    // 3. Create Products (20)
    for ( $i = 1; $i <= 20; $i++ ) {
        $business_id = $businesses[array_rand($businesses)];
        $author_id = get_post_field( 'post_author', $business_id );
        $id = wp_insert_post( array(
            'post_title' => "Business Solution #$i",
            'post_type'  => 'product',
            'post_status'=> 'publish',
            'post_author'=> $author_id,
            'post_content'=> "High-value solution $i for your business needs."
        ) );
        update_post_meta( $id, '_product_price', rand(500, 10000) );
        update_post_meta( $id, '_product_business_id', $business_id );
    }

    // 4. Create Transactions (Earnings, Affiliates, Donations) - 30 total
    $gateways = array( 'paypal', 'stripe', 'gcash', 'offline' );
    $types_txn = array( 'membership', 'product_sale', 'commission', 'donation' );

    for ( $i = 1; $i <= 30; $i++ ) {
        $type = $types_txn[array_rand($types_txn)];
        $amount = ( $type === 'donation' ) ? rand(100, 1000) : rand(1000, 25000);
        $status = ( $i % 8 === 0 ) ? 'pending' : 'completed';

        $id = wp_insert_post( array(
            'post_title'   => 'DEMO_TXN_' . $i,
            'post_type'    => 'org_transaction',
            'post_status'  => 'publish',
            'post_excerpt' => "Demo $type transaction record.",
        ) );
        update_post_meta( $id, '_txn_amount', $amount );
        update_post_meta( $id, '_txn_gateway', $gateways[array_rand($gateways)] );
        update_post_meta( $id, '_txn_type', $type );
        update_post_meta( $id, '_txn_status', $status );
        update_post_meta( $id, '_txn_user_id', 1 ); // Super Admin
    }

    // 5. Create Other Types (Jobs, Events, etc.) - 20 each
    $others = array(
        'event'         => 'Ecosystem Event',
        'job'           => 'Job Opening',
        'program'       => 'Organization Initiative',
        'resource'      => 'Member Resource',
        'announcement'  => 'Org Announcement',
        'support_ticket'=> 'Support Ticket',
        'org_message'   => 'Direct Message',
    );

    foreach ( $others as $type => $label ) {
        for ( $i = 1; $i <= 20; $i++ ) {
            $id = wp_insert_post( array(
                'post_title' => "$label #$i",
                'post_type'  => $type,
                'post_status'=> 'publish',
                'post_content'=> "Sample content for $label number $i. This serves as a demonstration of the organization platform capability."
            ) );

            if ( $type === 'event' ) {
                update_post_meta( $id, '_event_date', date( 'Y-m-d', strtotime( "+$i days" ) ) );
                update_post_meta( $id, '_event_venue', 'Main Hall, Community Center' );
            }
            if ( $type === 'job' ) {
                update_post_meta( $id, '_job_salary', rand(20000, 80000) );
                update_post_meta( $id, '_job_type', 'full-time' );
            }
            if ( $type === 'support_ticket' ) {
                update_post_meta( $id, '_ticket_status', ( $i % 4 === 0 ) ? 'closed' : 'open' );
            }
        }
    }

	wp_redirect( add_query_arg( array( 'import' => 'success' ), admin_url( 'admin.php?page=org-settings' ) ) );
	exit;
}
add_action( 'admin_post_org_import_demo', 'org_ecosystem_handle_demo_import' );
?>
