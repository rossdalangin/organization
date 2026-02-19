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
 * Handle Site Contact Form
 */
function org_ecosystem_handle_contact_form() {
	if ( ! isset( $_POST['org_contact_nonce'] ) || ! wp_verify_nonce( $_POST['org_contact_nonce'], 'org_submit_contact' ) ) {
		return;
	}

	$first_name = sanitize_text_field( $_POST['first_name'] );
	$last_name = sanitize_text_field( $_POST['last_name'] );
	$email = sanitize_email( $_POST['email'] );
	$subject = sanitize_text_field( $_POST['subject'] );
	$message = sanitize_textarea_field( $_POST['message'] );

	// Mock sending email or saving to database
	// wp_mail( get_option('admin_email'), 'New Contact Form Submission: ' . $subject, $message );

	wp_redirect( add_query_arg( 'contact_sent', 'true', org_ecosystem_get_page_url( 'page-contact.php' ) ) );
	exit;
}
add_action( 'admin_post_org_submit_contact', 'org_ecosystem_handle_contact_form' );
add_action( 'admin_post_nopriv_org_submit_contact', 'org_ecosystem_handle_contact_form' );

/**
 * Handle Newsletter Signup
 */
function org_ecosystem_handle_newsletter() {
	if ( isset( $_POST['newsletter_email'] ) ) {
		$email = sanitize_email( $_POST['newsletter_email'] );
		// Mock signup logic
		wp_redirect( add_query_arg( 'subscribed', 'true', home_url( '/' ) ) );
		exit;
	}
}
add_action( 'admin_post_org_newsletter', 'org_ecosystem_handle_newsletter' );
add_action( 'admin_post_nopriv_org_newsletter', 'org_ecosystem_handle_newsletter' );

/**
 * Handle Archive Filtering
 */
function org_ecosystem_archive_filters( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {
		if ( is_post_type_archive( 'business' ) ) {
			if ( isset( $_GET['industry'] ) && $_GET['industry'] !== '0' ) {
				$query->set( 'tax_query', array(
					array(
						'taxonomy' => 'industry',
						'field'    => 'term_id',
						'terms'    => intval( $_GET['industry'] ),
					),
				) );
			}
		}
	}
}
add_action( 'pre_get_posts', 'org_ecosystem_archive_filters' );

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

/**
 * Output Breadcrumbs
 */
function org_ecosystem_breadcrumbs() {
	if ( is_front_page() ) return;

	echo '<nav aria-label="breadcrumb" class="mb-4">';
	echo '<ol class="breadcrumb bg-light p-3 rounded shadow-sm">';
	echo '<li class="breadcrumb-item"><a href="' . esc_url( home_url( '/' ) ) . '" class="text-decoration-none text-primary"><i class="bi bi-house-door me-1"></i> ' . __( 'Home', 'org-ecosystem' ) . '</a></li>';

	if ( is_archive() ) {
		echo '<li class="breadcrumb-item active" aria-current="page">' . post_type_archive_title( '', false ) . '</li>';
	} elseif ( is_singular() ) {
		$post_type = get_post_type();
		$obj = get_post_type_object( $post_type );
		if ( $obj && $obj->has_archive ) {
			echo '<li class="breadcrumb-item"><a href="' . get_post_type_archive_link( $post_type ) . '" class="text-decoration-none text-primary">' . $obj->labels->name . '</a></li>';
		}
		echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
	} elseif ( is_search() ) {
		echo '<li class="breadcrumb-item active" aria-current="page">' . __( 'Search Results', 'org-ecosystem' ) . '</li>';
	}

	echo '</ol>';
	echo '</nav>';
}

/**
 * Custom Comment Callback
 */
/**
 * Get Page URL by Template
 */
function org_ecosystem_get_page_url( $template_path ) {
    // 1. Try to find by meta _wp_page_template
    $basename = basename($template_path);
    $search_templates = array(
        $template_path,
        $basename,
        'templates/' . $basename,
        '/' . $template_path,
        '/' . $basename
    );

    $pages = get_posts( array(
        'post_type'  => 'page',
        'meta_key'   => '_wp_page_template',
        'meta_value' => $search_templates,
        'posts_per_page' => 1,
        'post_status' => array('publish', 'private')
    ) );

    if ( ! empty($pages) ) {
        return get_permalink( $pages[0]->ID );
    }

    // 2. Fallback to slugs based on common keywords
    $slug_map = array(
        'dashboard' => 'dashboard',
        'join'      => 'join',
        'contact'   => 'contact',
        'donate'    => 'donate',
        'plans'     => 'membership-plans',
        'directory' => 'directory',
        'about'     => 'about',
        'mission'   => 'mission',
    );

    foreach ( $slug_map as $key => $slug ) {
        if ( strpos( $template_path, $key ) !== false ) {
            $page = get_page_by_path( $slug );
            if ( $page ) return get_permalink( $page->ID );

            // Try alternative slug
            $page = get_page_by_path( $key );
            if ( $page ) return get_permalink( $page->ID );

            // Try by title
            $page = get_page_by_title( 'Member Dashboard' );
            if ( $page && $key === 'dashboard' ) return get_permalink( $page->ID );
        }
    }

    // 3. Last resort home URL
    return home_url('/');
}

function org_ecosystem_comment_callback( $comment, $args, $depth ) {
	?>
	<li <?php comment_class( 'mb-4' ); ?> id="comment-<?php comment_ID(); ?>">
		<div class="card shadow-sm border-0">
			<div class="card-body p-3">
				<div class="d-flex align-items-center mb-3">
					<div class="me-3">
						<?php echo get_avatar( $comment, $args['avatar_size'], '', '', array( 'class' => 'rounded-circle' ) ); ?>
					</div>
					<div>
						<h6 class="mb-0 fw-bold"><?php echo get_comment_author_link(); ?></h6>
						<span class="text-muted small"><?php printf( _x( '%s ago', 'relative time', 'org-ecosystem' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></span>
					</div>
				</div>
				<div class="comment-text">
					<?php comment_text(); ?>
				</div>
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation text-warning small"><?php _e( 'Your comment is awaiting moderation.', 'org-ecosystem' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	<?php
}
