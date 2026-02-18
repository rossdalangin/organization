<?php
/**
 * Membership Logic and Meta Fields
 *
 * @package OrgEcosystem
 */

/**
 * Add Member Meta Boxes
 */
function org_ecosystem_add_member_meta_boxes() {
	add_meta_box(
		'member_profile_details',
		__( 'Member Profile Details', 'org-ecosystem' ),
		'org_ecosystem_member_profile_callback',
		'member',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'org_ecosystem_add_member_meta_boxes' );

/**
 * Member Profile Callback
 */
function org_ecosystem_member_profile_callback( $post ) {
	wp_nonce_field( 'org_ecosystem_save_member_meta', 'org_ecosystem_member_nonce' );

	$bio = get_post_meta( $post->ID, '_member_bio', true );
	$cover_photo = get_post_meta( $post->ID, '_member_cover_photo', true );
	$phone = get_post_meta( $post->ID, '_member_phone', true );
	$email = get_post_meta( $post->ID, '_member_email', true );
	$website = get_post_meta( $post->ID, '_member_website', true );
	$business_name = get_post_meta( $post->ID, '_member_business_name', true );
	$facebook = get_post_meta( $post->ID, '_member_facebook', true );
	$linkedin = get_post_meta( $post->ID, '_member_linkedin', true );
	$twitter = get_post_meta( $post->ID, '_member_twitter', true );
	$membership_status = get_post_meta( $post->ID, '_member_status', true );
	$join_date = get_post_meta( $post->ID, '_member_join_date', true );
	$renewal_date = get_post_meta( $post->ID, '_member_renewal_date', true );
	$is_featured = get_post_meta( $post->ID, '_member_is_featured', true );
	$is_verified = get_post_meta( $post->ID, '_member_is_verified', true );

	?>
	<table class="form-table">
		<tr>
			<th><label for="member_bio"><?php _e( 'Bio', 'org-ecosystem' ); ?></label></th>
			<td>
                <textarea id="member_bio" name="member_bio" rows="4" style="width:100%" placeholder="<?php _e( 'Example: Senior software engineer with 10+ years of experience in cloud architecture...', 'org-ecosystem' ); ?>"><?php echo esc_textarea( $bio ); ?></textarea>
                <p class="description"><?php _e( 'A compelling professional bio to attract potential clients.', 'org-ecosystem' ); ?></p>
            </td>
		</tr>
		<tr>
			<th><label for="member_cover_photo"><?php _e( 'Cover Photo URL', 'org-ecosystem' ); ?></label></th>
			<td><input type="url" id="member_cover_photo" name="member_cover_photo" value="<?php echo esc_attr( $cover_photo ); ?>" style="width:100%"></td>
		</tr>
		<tr>
			<th><label for="member_phone"><?php _e( 'Phone', 'org-ecosystem' ); ?></label></th>
			<td><input type="text" id="member_phone" name="member_phone" value="<?php echo esc_attr( $phone ); ?>" style="width:100%"></td>
		</tr>
		<tr>
			<th><label for="member_email"><?php _e( 'Email', 'org-ecosystem' ); ?></label></th>
			<td><input type="email" id="member_email" name="member_email" value="<?php echo esc_attr( $email ); ?>" style="width:100%"></td>
		</tr>
		<tr>
			<th><label for="member_website"><?php _e( 'Website', 'org-ecosystem' ); ?></label></th>
			<td><input type="url" id="member_website" name="member_website" value="<?php echo esc_attr( $website ); ?>" style="width:100%"></td>
		</tr>
		<tr>
			<th><label for="member_business_name"><?php _e( 'Business Name', 'org-ecosystem' ); ?></label></th>
			<td>
                <input type="text" id="member_business_name" name="member_business_name" value="<?php echo esc_attr( $business_name ); ?>" style="width:100%" placeholder="<?php _e( 'Example: Acme Corporation Solutions Inc.', 'org-ecosystem' ); ?>">
                <p class="description"><?php _e( 'The legal or trading name of your business.', 'org-ecosystem' ); ?></p>
            </td>
		</tr>
		<tr>
			<th><label for="member_map_location"><?php _e( 'Map Location (Google Maps Embed Link)', 'org-ecosystem' ); ?></label></th>
			<td><input type="url" id="member_map_location" name="member_map_location" value="<?php echo esc_attr( get_post_meta( $post->ID, '_member_map_location', true ) ); ?>" style="width:100%"></td>
		</tr>
		<tr>
			<th><label for="member_certifications"><?php _e( 'Certifications', 'org-ecosystem' ); ?></label></th>
			<td><textarea id="member_certifications" name="member_certifications" rows="3" style="width:100%"><?php echo esc_textarea( get_post_meta( $post->ID, '_member_certifications', true ) ); ?></textarea></td>
		</tr>
		<tr>
			<th><label for="member_gallery"><?php _e( 'Gallery Images (Comma separated URLs)', 'org-ecosystem' ); ?></label></th>
			<td><textarea id="member_gallery" name="member_gallery" rows="3" style="width:100%"><?php echo esc_textarea( get_post_meta( $post->ID, '_member_gallery', true ) ); ?></textarea></td>
		</tr>
		<tr>
			<th><label><?php _e( 'Social Media', 'org-ecosystem' ); ?></label></th>
			<td>
				<input type="url" name="member_facebook" placeholder="Facebook URL" value="<?php echo esc_attr( $facebook ); ?>" style="width:100%; margin-bottom: 5px;">
				<input type="url" name="member_linkedin" placeholder="LinkedIn URL" value="<?php echo esc_attr( $linkedin ); ?>" style="width:100%; margin-bottom: 5px;">
				<input type="url" name="member_twitter" placeholder="Twitter URL" value="<?php echo esc_attr( $twitter ); ?>" style="width:100%;">
			</td>
		</tr>
		<tr>
			<th><label for="member_status"><?php _e( 'Membership Status', 'org-ecosystem' ); ?></label></th>
			<td>
				<select id="member_status" name="member_status">
					<option value="active" <?php selected( $membership_status, 'active' ); ?>>Active</option>
					<option value="pending" <?php selected( $membership_status, 'pending' ); ?>>Pending</option>
					<option value="expired" <?php selected( $membership_status, 'expired' ); ?>>Expired</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="member_join_date"><?php _e( 'Join Date', 'org-ecosystem' ); ?></label></th>
			<td><input type="date" id="member_join_date" name="member_join_date" value="<?php echo esc_attr( $join_date ); ?>"></td>
		</tr>
		<tr>
			<th><label for="member_renewal_date"><?php _e( 'Renewal Date', 'org-ecosystem' ); ?></label></th>
			<td><input type="date" id="member_renewal_date" name="member_renewal_date" value="<?php echo esc_attr( $renewal_date ); ?>"></td>
		</tr>
		<tr>
			<th><label><?php _e( 'Badges', 'org-ecosystem' ); ?></label></th>
			<td>
				<label><input type="checkbox" name="member_is_featured" value="1" <?php checked( $is_featured, '1' ); ?>> Featured Badge</label><br>
				<label><input type="checkbox" name="member_is_verified" value="1" <?php checked( $is_verified, '1' ); ?>> Verification Badge</label>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Save Member Meta
 */
function org_ecosystem_save_member_meta( $post_id ) {
	if ( ! isset( $_POST['org_ecosystem_member_nonce'] ) || ! wp_verify_nonce( $_POST['org_ecosystem_member_nonce'], 'org_ecosystem_save_member_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array(
		'member_bio' => '_member_bio',
		'member_cover_photo' => '_member_cover_photo',
		'member_phone' => '_member_phone',
		'member_email' => '_member_email',
		'member_website' => '_member_website',
		'member_business_name' => '_member_business_name',
		'member_map_location' => '_member_map_location',
		'member_certifications' => '_member_certifications',
		'member_gallery' => '_member_gallery',
		'member_files' => '_member_files',
		'member_facebook' => '_member_facebook',
		'member_linkedin' => '_member_linkedin',
		'member_twitter' => '_member_twitter',
		'member_status' => '_member_status',
		'member_join_date' => '_member_join_date',
		'member_renewal_date' => '_member_renewal_date',
	);

	foreach ( $fields as $key => $meta_key ) {
		if ( isset( $_POST[ $key ] ) ) {
			$sanitize_fn = ( $key === 'member_bio' ) ? 'sanitize_textarea_field' : 'sanitize_text_field';
			update_post_meta( $post_id, $meta_key, $sanitize_fn( $_POST[ $key ] ) );
		}
	}

	update_post_meta( $post_id, '_member_is_featured', isset( $_POST['member_is_featured'] ) ? '1' : '0' );
	update_post_meta( $post_id, '_member_is_verified', isset( $_POST['member_is_verified'] ) ? '1' : '0' );
}
add_action( 'save_post', 'org_ecosystem_save_member_meta' );

/**
 * Register Meta for REST API
 */
function org_ecosystem_register_rest_meta() {
    $fields = array(
        '_member_bio', '_member_cover_photo', '_member_phone', '_member_email',
        '_member_website', '_member_business_name', '_member_status',
        '_member_is_featured', '_member_is_verified', '_member_view_count'
    );

    foreach ( $fields as $field ) {
        register_post_meta( 'member', $field, array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
        ) );
    }

    register_post_meta( 'product', '_product_price', array(
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'string',
    ) );
}
add_action( 'init', 'org_ecosystem_register_rest_meta' );

/**
 * Handle Member Registration
 */
function org_ecosystem_handle_registration() {
	if ( ! isset( $_POST['org_registration_nonce'] ) || ! wp_verify_nonce( $_POST['org_registration_nonce'], 'org_user_registration' ) ) {
		return;
	}

	$username = sanitize_user( $_POST['username'] );
	$email = sanitize_email( $_POST['email'] );
	$password = $_POST['password'];
	$first_name = sanitize_text_field( $_POST['first_name'] );
	$last_name = sanitize_text_field( $_POST['last_name'] );
	$plan = isset( $_POST['plan'] ) ? sanitize_text_field( $_POST['plan'] ) : 'free';

	if ( username_exists( $username ) || email_exists( $email ) ) {
		wp_redirect( add_query_arg( 'error', 'exists', org_ecosystem_get_page_url( 'page-join.php' ) ) );
		exit;
	}

	$user_id = wp_create_user( $username, $password, $email );

	if ( ! is_wp_error( $user_id ) ) {
		wp_update_user( array(
			'ID' => $user_id,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'role' => 'subscriber', // Initial role, will be updated upon approval/payment
		) );

		// Create Member CPT profile
		$member_id = wp_insert_post( array(
			'post_title' => $first_name . ' ' . $last_name,
			'post_type' => 'member',
			'post_status' => 'pending',
			'post_author' => $user_id,
		) );

		update_user_meta( $user_id, '_member_profile_id', $member_id );
		update_user_meta( $user_id, '_membership_level', $plan );
		update_post_meta( $member_id, '_member_status', 'pending' );
		update_post_meta( $member_id, '_member_join_date', date( 'Y-m-d' ) );

		// Email Verification Logic
		$token = wp_generate_password( 20, false );
		update_user_meta( $user_id, '_email_verification_token', $token );
		update_user_meta( $user_id, '_email_verified', '0' );

		$verify_url = add_query_arg( array(
			'org_action' => 'verify_email',
			'token'      => $token,
			'user_id'    => $user_id
		), home_url( '/' ) );

		$subject = get_option( 'org_welcome_email_subject', 'Verify your email' );
		$message = str_replace( '{verify_url}', $verify_url, get_option( 'org_welcome_email_body', 'Please verify your email: {verify_url}' ) );

		wp_mail( $email, $subject, $message );

		wp_redirect( add_query_arg( 'registered', 'true', org_ecosystem_get_page_url( 'templates/dashboard.php' ) ) );
		exit;
	}
}
add_action( 'admin_post_nopriv_org_register', 'org_ecosystem_handle_registration' );

/**
 * Handle Email Verification Link
 */
function org_ecosystem_handle_email_verification() {
	if ( isset( $_GET['org_action'] ) && $_GET['org_action'] === 'verify_email' && isset( $_GET['token'] ) && isset( $_GET['user_id'] ) ) {
		$user_id = intval( $_GET['user_id'] );
		$token = sanitize_text_field( $_GET['token'] );
		$saved_token = get_user_meta( $user_id, '_email_verification_token', true );

		if ( $token === $saved_token ) {
			update_user_meta( $user_id, '_email_verified', '1' );
			delete_user_meta( $user_id, '_email_verification_token' );

			// Optional: Auto-approve on email verify if configured
			// org_ecosystem_approve_member( get_user_meta( $user_id, '_member_profile_id', true ) );

			wp_redirect( add_query_arg( 'verified', 'true', org_ecosystem_get_page_url( 'templates/dashboard.php' ) ) );
			exit;
		} else {
			wp_die( __( 'Invalid or expired verification token.', 'org-ecosystem' ) );
		}
	}
}
add_action( 'init', 'org_ecosystem_handle_email_verification' );

/**
 * Auto-approve or Manual Approval Logic
 */
function org_ecosystem_approve_member( $member_id ) {
	$member = get_post( $member_id );
	if ( ! $member || $member->post_type !== 'member' ) return;

	wp_update_post( array(
		'ID' => $member_id,
		'post_status' => 'publish',
	) );

	update_post_meta( $member_id, '_member_status', 'active' );

	$user_id = $member->post_author;
	$user = new WP_User( $user_id );
	$user->set_role( 'member' ); // Assign the 'member' role upon approval

	// Notify member
	// wp_mail( get_the_author_meta('user_email', $user_id), 'Welcome!', 'Your membership has been approved.' );
}

/**
 * Define Custom Roles
 */
function org_ecosystem_register_roles() {
	$roles = array(
		'super_admin' => array(
			'name' => __( 'Super Admin', 'org-ecosystem' ),
			'capabilities' => array( 'read' => true, 'edit_posts' => true, 'manage_options' => true, 'delete_users' => true ),
		),
		'org_admin' => array(
			'name' => __( 'Organization Admin', 'org-ecosystem' ),
			'capabilities' => array( 'read' => true, 'edit_posts' => true, 'manage_options' => true ),
		),
		'regional_admin' => array(
			'name' => __( 'Regional Admin', 'org-ecosystem' ),
			'capabilities' => array( 'read' => true, 'edit_posts' => true ),
		),
		'membership_manager' => array(
			'name' => __( 'Membership Manager', 'org-ecosystem' ),
			'capabilities' => array( 'read' => true, 'edit_posts' => true ),
		),
		'content_manager' => array(
			'name' => __( 'Content Manager', 'org-ecosystem' ),
			'capabilities' => array( 'read' => true, 'edit_posts' => true, 'publish_posts' => true ),
		),
		'member' => array(
			'name' => __( 'Member', 'org-ecosystem' ),
			'capabilities' => array( 'read' => true ),
		),
		'vendor' => array(
			'name' => __( 'Vendor', 'org-ecosystem' ),
			'capabilities' => array( 'read' => true ),
		),
		'volunteer' => array(
			'name' => __( 'Volunteer', 'org-ecosystem' ),
			'capabilities' => array( 'read' => true ),
		),
	);

	foreach ( $roles as $role_key => $role_data ) {
		add_role( $role_key, $role_data['name'], $role_data['capabilities'] );
	}

	// Define Fine-grained capabilities
	$capabilities = array(
		'approve_members'   => array( 'org_admin', 'membership_manager' ),
		'manage_payments'   => array( 'org_admin', 'membership_manager' ),
		'access_reports'    => array( 'org_admin', 'regional_admin', 'membership_manager' ),
		'publish_content'   => array( 'org_admin', 'content_manager' ),
		'manage_listings'   => array( 'org_admin', 'content_manager', 'member', 'vendor' ),
		'submit_support'    => array( 'member', 'vendor', 'volunteer' ),
		'manage_tickets'    => array( 'org_admin', 'membership_manager' ),
	);

	foreach ( $capabilities as $cap => $assigned_roles ) {
		foreach ( $assigned_roles as $role_slug ) {
			$role = get_role( $role_slug );
			if ( $role ) {
				$role->add_cap( $cap );
			}
		}
	}
}

/**
 * Define Membership Levels (Static list for logic)
 */
/**
 * Check if user has capability based on membership level
 */
function org_ecosystem_can_user_do( $cap ) {
    if ( current_user_can( 'manage_options' ) ) return true;

    $user_id = get_current_user_id();
    $level = get_user_meta( $user_id, '_membership_level', true ) ?: 'community';
    $levels = org_ecosystem_get_membership_levels();

    if ( isset( $levels[$level] ) ) {
        // Corporate and Lifetime have all caps
        if ( in_array( $level, array( 'corporate', 'lifetime' ) ) ) return true;

        if ( isset( $levels[$level]['caps'] ) && in_array( $cap, $levels[$level]['caps'] ) ) {
            return true;
        }
    }
    return false;
}

function org_ecosystem_get_membership_levels() {
	return array(
		'community' => array(
			'name' => 'Community Member',
			'price' => 0,
			'duration' => 'lifetime',
            'features' => array( 'Browse Directory', 'Basic Dashboard', 'Event Access' ),
            'caps' => array( 'read' )
		),
		'professional' => array(
			'name' => 'Professional (with Profile)',
			'price' => get_theme_mod( 'basic_plan_price', '1500' ),
			'duration' => 'annual',
            'features' => array( 'Public Member Profile', 'Business Listing', 'Internal Messaging', 'Direct Inquiries' ),
            'caps' => array( 'publish_profile', 'send_messages' )
		),
		'vendor' => array(
			'name' => 'Vendor (with Products)',
			'price' => get_theme_mod( 'premium_plan_price', '5000' ),
			'duration' => 'annual',
            'features' => array( 'Product Showcase (unlimited)', 'Featured Spotlight', 'Receive Payments', 'Sales Analytics' ),
            'caps' => array( 'publish_profile', 'send_messages', 'manage_products', 'featured_listing' )
		),
		'corporate' => array(
			'name' => 'Corporate Partner',
			'price' => 25000,
			'duration' => 'annual',
            'features' => array( 'Multiple Staff Accounts', 'Homepage Logo Placement', 'Dedicated Support', 'White-label Tools' )
		),
		'lifetime' => array(
			'name' => 'Lifetime Elite',
			'price' => 100000,
			'duration' => 'lifetime',
            'features' => array( 'All Features Included', 'No Recurring Fees', 'Founder\'s Badge', 'Governance Voting' )
		),
	);
}

/**
 * Payment Processing Logic
 */
function org_ecosystem_process_payment( $user_id, $level, $gateway ) {
	$levels = org_ecosystem_get_membership_levels();
	if ( ! isset( $levels[$level] ) ) return false;

	$amount = $levels[$level]['price'];

	// Implement Gateway Logic Here (Stripe, PayPal)
	// Example: $charge = Stripe::charge($amount, $token);

	$payment_status = 'completed'; // Mocking successful payment

	if ( $payment_status === 'completed' ) {
		// Log transaction
		$transaction_id = 'TXN_' . time();

		$history = get_user_meta( $user_id, '_payment_history', true ) ?: array();
		$history[] = array(
			'date'   => date( 'Y-m-d H:i:s' ),
			'txn_id' => $transaction_id,
			'amount' => $amount,
			'level'  => $level,
			'status' => 'Paid'
		);
		update_user_meta( $user_id, '_payment_history', $history );

		update_user_meta( $user_id, '_last_transaction_id', $transaction_id );
		update_user_meta( $user_id, '_membership_level', $level );

		// Update Renewal Date
		$duration = $levels[$level]['duration'];
		$renewal_date = ( $duration === 'annual' ) ? date( 'Y-m-d', strtotime( '+1 year' ) ) : '0000-00-00';

		$member_id = get_user_meta( $user_id, '_member_profile_id', true );
		if ( $member_id ) {
			update_post_meta( $member_id, '_member_renewal_date', $renewal_date );
			org_ecosystem_approve_member( $member_id );
		}

		return true;
	}

	return false;
}

/**
 * Membership Automation - Daily Expiration Check
 */
function org_ecosystem_membership_automation_init() {
	if ( ! wp_next_scheduled( 'org_ecosystem_daily_expiration_check' ) ) {
		wp_schedule_event( time(), 'daily', 'org_ecosystem_daily_expiration_check' );
	}
}
add_action( 'wp', 'org_ecosystem_membership_automation_init' );

/**
 * Generate Invoice Data
 */
function org_ecosystem_generate_invoice( $user_id, $txn_id ) {
	$user = get_userdata( $user_id );
	$level = get_user_meta( $user_id, '_membership_level', true );
	$levels = org_ecosystem_get_membership_levels();

	if ( ! isset( $levels[$level] ) ) return false;

	return array(
		'invoice_no' => 'INV-' . strtoupper( substr( md5( $txn_id ), 0, 8 ) ),
		'date'       => date( 'M d, Y' ),
		'user'       => $user->display_name,
		'email'      => $user->user_email,
		'plan'       => $levels[$level]['name'],
		'amount'     => $levels[$level]['price'],
		'currency'   => 'PHP',
	);
}

function org_ecosystem_check_expirations() {
	$today = date( 'Y-m-d' );
	$reminder_date = date( 'Y-m-d', strtotime( '+7 days' ) );

	$members = new WP_Query( array(
		'post_type' => 'member',
		'posts_per_page' => -1,
		'meta_query' => array(
			'relation' => 'OR',
			array(
				'key' => '_member_renewal_date',
				'value' => $today,
				'compare' => '<=',
			),
			array(
				'key' => '_member_renewal_date',
				'value' => $reminder_date,
				'compare' => '=',
			),
		),
	) );

	if ( $members->have_posts() ) {
		while ( $members->have_posts() ) {
			$members->the_post();
			$member_id = get_the_ID();
			$renewal_date = get_post_meta( $member_id, '_member_renewal_date', true );
			$user_id = get_post_field( 'post_author', $member_id );
			$user_email = get_the_author_meta( 'user_email', $user_id );

			if ( $renewal_date <= $today && $renewal_date !== '0000-00-00' ) {
				// Expired
				update_post_meta( $member_id, '_member_status', 'expired' );

				$subject = get_option( 'org_expiry_email_subject', 'Your Membership has Expired' );
				$body = get_option( 'org_expiry_email_body', 'Hi {user_name}, your membership at {site_name} has expired. Please renew to keep your benefits.' );
				$body = str_replace( array('{user_name}', '{site_name}'), array(get_the_author_meta('display_name', $user_id), get_bloginfo('name')), $body );

				wp_mail( $user_email, $subject, $body );
			} elseif ( $renewal_date === $reminder_date ) {
				// Reminder
				$subject = get_option( 'org_reminder_email_subject', 'Membership Renewal Reminder' );
				$body = get_option( 'org_reminder_email_body', 'Hi {user_name}, your membership at {site_name} will expire in 7 days. Don\'t forget to renew!' );
				$body = str_replace( array('{user_name}', '{site_name}'), array(get_the_author_meta('display_name', $user_id), get_bloginfo('name')), $body );

				wp_mail( $user_email, $subject, $body );
			}
		}
		wp_reset_postdata();
	}
}
add_action( 'org_ecosystem_daily_expiration_check', 'org_ecosystem_check_expirations' );

/**
 * Handle Donation Processing
 */
function org_ecosystem_handle_donation() {
	if ( ! isset( $_POST['org_donation_nonce'] ) || ! wp_verify_nonce( $_POST['org_donation_nonce'], 'org_donation' ) ) {
		return;
	}

	$name = sanitize_text_field( $_POST['donor_name'] );
	$email = sanitize_email( $_POST['donor_email'] );
	$amount = ! empty( $_POST['custom_amount'] ) ? intval( $_POST['custom_amount'] ) : intval( $_POST['amount'] );

	// Mock donation recording
	$donation_id = wp_insert_post( array(
		'post_title'   => 'Donation from ' . $name,
		'post_type'    => 'donation',
		'post_status'  => 'publish',
		'post_content' => sprintf( 'Amount: ₱ %d | Email: %s', $amount, $email ),
	) );

	if ( $donation_id ) {
		update_post_meta( $donation_id, '_donation_amount', $amount );
		update_post_meta( $donation_id, '_donation_email', $email );
	}

	wp_redirect( add_query_arg( 'thanks', 'true', org_ecosystem_get_page_url( 'page-donation.php' ) ) );
	exit;
}
add_action( 'admin_post_org_process_donation', 'org_ecosystem_handle_donation' );
add_action( 'admin_post_nopriv_org_process_donation', 'org_ecosystem_handle_donation' );

/**
 * Handle Membership Renewal
 */
function org_ecosystem_handle_renewal() {
	if ( ! is_user_logged_in() ) return;
	check_admin_referer( 'org_renew_membership_action' );

	$user_id = get_current_user_id();
	$level = get_user_meta( $user_id, '_membership_level', true ) ?: 'basic';

	// Mock successful payment and renewal
	if ( org_ecosystem_process_payment( $user_id, $level, 'mock_gateway' ) ) {
		wp_redirect( add_query_arg( array( 'action' => 'billing', 'renewed' => 'true' ), org_ecosystem_get_page_url( 'templates/dashboard.php' ) ) );
		exit;
	}
}
add_action( 'admin_post_org_renew_membership', 'org_ecosystem_handle_renewal' );

/**
 * Handle Receipt Download
 */
function org_ecosystem_handle_receipt_download() {
	if ( isset( $_GET['action'] ) && $_GET['action'] === 'download_receipt' && isset( $_GET['txn_id'] ) ) {
		if ( ! is_user_logged_in() ) return;

		$txn_id = sanitize_text_field( $_GET['txn_id'] );
		$user_id = get_current_user_id();

		$invoice = org_ecosystem_generate_invoice( $user_id, $txn_id );

		if ( $invoice ) {
			// In a real system, we'd use a PDF library.
			// For this theme, we'll output a clean HTML receipt that can be printed.
			include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/receipt-template.php';
			exit;
		}
	}
}
add_action( 'template_redirect', 'org_ecosystem_handle_receipt_download' );

/**
 * Handle Login Redirection
 */
function org_ecosystem_login_redirect( $redirect_to, $request, $user ) {
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		if ( in_array( 'administrator', $user->roles ) || in_array( 'super_admin', $user->roles ) || in_array( 'org_admin', $user->roles ) ) {
			return admin_url( 'admin.php?page=org-settings' );
		} else {
			return org_ecosystem_get_page_url( 'templates/dashboard.php' );
		}
	}
	return $redirect_to;
}
add_filter( 'login_redirect', 'org_ecosystem_login_redirect', 10, 3 );

/**
 * Handle Membership Upgrade Action
 */
function org_ecosystem_handle_membership_upgrade() {
	if ( ! is_user_logged_in() ) return;
	check_admin_referer( 'org_upgrade_membership_action' );

	$user_id = get_current_user_id();
	$new_level = isset( $_POST['plan'] ) ? sanitize_text_field( $_POST['plan'] ) : 'professional';

	// Process Payment (Yearly Fee)
	if ( org_ecosystem_process_payment( $user_id, $new_level, 'unified_gateway' ) ) {
		wp_redirect( add_query_arg( array( 'action' => 'billing', 'upgraded' => 'true' ), org_ecosystem_get_page_url( 'templates/dashboard.php' ) ) );
		exit;
	}
}
add_action( 'admin_post_org_upgrade_membership', 'org_ecosystem_handle_membership_upgrade' );
