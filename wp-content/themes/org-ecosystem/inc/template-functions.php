<?php
/**
 * Template Functions and Stats Tracking
 *
 * @package OrgEcosystem
 */

/**
 * Increment Post View Count
 */
function org_ecosystem_track_post_views() {
	if ( is_singular( array( 'member', 'business', 'product' ) ) ) {
		global $post;
		$view_count = get_post_meta( $post->ID, '_member_view_count', true ) ?: 0;
		if ( is_singular( 'product' ) ) {
			// For products, we also increment product clicks for the owner
			$business_id = get_post_meta( $post->ID, '_product_business_id', true );
			if ( $business_id ) {
				$product_clicks = get_post_meta( $business_id, '_member_product_clicks', true ) ?: 0;
				update_post_meta( $business_id, '_member_product_clicks', $product_clicks + 1 );
			}
		}
		update_post_meta( $post->ID, '_member_view_count', $view_count + 1 );
	}
}
add_action( 'wp_head', 'org_ecosystem_track_post_views' );

/**
 * Handle Inquiries and Increment Inquiry Count
 */
function org_ecosystem_handle_inquiry() {
	if ( ! isset( $_POST['org_inquiry_nonce'] ) || ! wp_verify_nonce( $_POST['org_inquiry_nonce'], 'org_submit_inquiry' ) ) {
		return;
	}

	$post_id = intval( $_POST['post_id'] );
	if ( ! $post_id ) return;

	// Increment inquiry count for the target post
	$inquiry_count = get_post_meta( $post_id, '_member_inquiry_count', true ) ?: 0;
	update_post_meta( $post_id, '_member_inquiry_count', $inquiry_count + 1 );

	// Redirect with success message
	wp_redirect( add_query_arg( 'inquiry', 'sent', get_permalink( $post_id ) ) );
	exit;
}
add_action( 'admin_post_org_submit_inquiry', 'org_ecosystem_handle_inquiry' );
add_action( 'admin_post_nopriv_org_submit_inquiry', 'org_ecosystem_handle_inquiry' );

/**
 * Output Inquiry Form
 */
function org_ecosystem_inquiry_form( $post_id ) {
	?>
	<div id="inquiry-form-wrapper" class="mt-4">
		<?php if ( isset( $_GET['inquiry'] ) && $_GET['inquiry'] === 'sent' ) : ?>
			<div class="alert alert-success"><?php _e( 'Your inquiry has been sent successfully!', 'org-ecosystem' ); ?></div>
		<?php else : ?>
			<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" id="inquiry-form">
				<input type="hidden" name="action" value="org_submit_inquiry">
				<input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ); ?>">
				<?php wp_nonce_field( 'org_submit_inquiry', 'org_inquiry_nonce' ); ?>

				<div class="mb-3">
					<label class="form-label fw-bold"><?php _e( 'Your Name', 'org-ecosystem' ); ?></label>
					<input type="text" name="name" class="form-control" required>
				</div>
				<div class="mb-3">
					<label class="form-label fw-bold"><?php _e( 'Email Address', 'org-ecosystem' ); ?></label>
					<input type="email" name="email" class="form-control" required>
				</div>
				<div class="mb-3">
					<label class="form-label fw-bold"><?php _e( 'Message', 'org-ecosystem' ); ?></label>
					<textarea name="message" class="form-control" rows="4" required></textarea>
				</div>
				<button type="submit" class="btn btn-primary w-100"><?php _e( 'Send Inquiry', 'org-ecosystem' ); ?></button>
			</form>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Filter Nav Menu Items based on User Role and Status
 */
function org_ecosystem_filter_nav_menu( $items ) {
	$is_logged_in = is_user_logged_in();
	$user_role = $is_logged_in ? current_user_can( 'manage_options' ) ? 'admin' : 'member' : 'guest';

	foreach ( $items as $key => $item ) {
		$classes = $item->classes;

		// Hide 'Login' or 'Join' if already logged in
		if ( $is_logged_in && ( in_array( 'menu-item-login', $classes ) || in_array( 'menu-item-join', $classes ) ) ) {
			unset( $items[$key] );
		}

		// Hide 'Dashboard' or 'Logout' if guest
		if ( ! $is_logged_in && ( in_array( 'menu-item-dashboard', $classes ) || in_array( 'menu-item-logout', $classes ) ) ) {
			unset( $items[$key] );
		}

		// Role-based visibility using custom CSS classes added in WP Admin
		if ( in_array( 'logged-in-only', $classes ) && ! $is_logged_in ) {
			unset( $items[$key] );
		}

		if ( in_array( 'admin-only', $classes ) && ! current_user_can( 'manage_options' ) ) {
			unset( $items[$key] );
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'org_ecosystem_filter_nav_menu' );
