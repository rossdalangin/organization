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
			<td><textarea id="member_bio" name="member_bio" rows="4" style="width:100%"><?php echo esc_textarea( $bio ); ?></textarea></td>
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
			<td><input type="text" id="member_business_name" name="member_business_name" value="<?php echo esc_attr( $business_name ); ?>" style="width:100%"></td>
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
			update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $key ] ) );
		}
	}

	update_post_meta( $post_id, '_member_is_featured', isset( $_POST['member_is_featured'] ) ? '1' : '0' );
	update_post_meta( $post_id, '_member_is_verified', isset( $_POST['member_is_verified'] ) ? '1' : '0' );
}
add_action( 'save_post', 'org_ecosystem_save_member_meta' );

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

	if ( username_exists( $username ) || email_exists( $email ) ) {
		wp_redirect( home_url( '/join?error=exists' ) );
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
		update_post_meta( $member_id, '_member_status', 'pending' );

		// In a real scenario, send verification email here

		wp_redirect( home_url( '/registration-success' ) );
		exit;
	}
}
add_action( 'admin_post_nopriv_org_register', 'org_ecosystem_handle_registration' );

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
}
add_action( 'init', 'org_ecosystem_register_roles' );

/**
 * Define Membership Levels (Static list for logic)
 */
function org_ecosystem_get_membership_levels() {
	return array(
		'free' => array(
			'name' => 'Free',
			'price' => 0,
			'duration' => 'lifetime',
		),
		'basic' => array(
			'name' => 'Basic',
			'price' => 1500,
			'duration' => 'annual',
		),
		'premium' => array(
			'name' => 'Premium',
			'price' => 5000,
			'duration' => 'annual',
		),
		'corporate' => array(
			'name' => 'Corporate',
			'price' => 20000,
			'duration' => 'annual',
		),
		'lifetime' => array(
			'name' => 'Lifetime',
			'price' => 100000,
			'duration' => 'lifetime',
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
				// wp_mail( $user_email, 'Membership Expired', 'Your membership has expired. Please renew.' );
			} elseif ( $renewal_date === $reminder_date ) {
				// Reminder
				// wp_mail( $user_email, 'Membership Renewal Reminder', 'Your membership will expire in 7 days.' );
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
	wp_insert_post( array(
		'post_title'   => 'Donation from ' . $name,
		'post_type'    => 'donation',
		'post_status'  => 'publish',
		'post_content' => sprintf( 'Amount: ₱ %d | Email: %s', $amount, $email ),
	) );

	wp_redirect( add_query_arg( 'thanks', 'true', home_url( '/donate' ) ) );
	exit;
}
add_action( 'admin_post_org_process_donation', 'org_ecosystem_handle_donation' );
add_action( 'admin_post_nopriv_org_process_donation', 'org_ecosystem_handle_donation' );
