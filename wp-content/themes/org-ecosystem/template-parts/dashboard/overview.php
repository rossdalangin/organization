<?php
/**
 * Dashboard Overview Part
 */
$user_id = get_current_user_id();
$member_id = get_user_meta( $user_id, '_member_profile_id', true );
$stats = org_ecosystem_get_member_stats( $member_id );

// Ensure Referral Code
$ref_code = get_user_meta( $user_id, '_org_referral_code', true );
if ( ! $ref_code ) {
    $ref_code = strtoupper( substr( md5( $user_id . time() ), 0, 8 ) );
    update_user_meta( $user_id, '_org_referral_code', $ref_code );
}
?>
<div class="d-flex justify-content-between align-items-center mb-4">
	<h2 class="h4 mb-0"><?php _e( 'Dashboard Overview', 'org-ecosystem' ); ?></h2>
	<div class="text-muted small"><?php echo date( 'l, F j, Y' ); ?></div>
</div>

<?php if ( isset( $_GET['promoted'] ) ) : ?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<?php _e( 'Success! Your listing has been promoted to Featured status.', 'org-ecosystem' ); ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
<?php endif; ?>

<div class="row g-4 mb-5">
	<div class="col-md-3">
		<div class="card bg-white shadow-sm text-center p-4 border-0 border-top border-primary border-4 rounded-4">
			<div class="text-primary mb-2"><i class="bi bi-eye h1"></i></div>
			<h6 class="text-muted text-uppercase small fw-bold"><?php _e( 'Profile Views', 'org-ecosystem' ); ?></h6>
			<h2 class="fw-bold mb-0"><?php echo esc_html( $stats['views'] ); ?></h2>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card bg-white shadow-sm text-center p-4 border-0 border-top border-success border-4 rounded-4">
			<div class="text-success mb-2"><i class="bi bi-chat-dots h1"></i></div>
			<h6 class="text-muted text-uppercase small fw-bold"><?php _e( 'Direct Inquiries', 'org-ecosystem' ); ?></h6>
			<h2 class="fw-bold mb-0"><?php echo esc_html( $stats['inquiries'] ); ?></h2>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card bg-white shadow-sm text-center p-4 border-0 border-top border-info border-4 rounded-4">
			<div class="text-info mb-2"><i class="bi bi-cursor h1"></i></div>
			<h6 class="text-muted text-uppercase small fw-bold"><?php _e( 'Product Clicks', 'org-ecosystem' ); ?></h6>
			<h2 class="fw-bold mb-0"><?php echo esc_html( $stats['product_clicks'] ); ?></h2>
		</div>
	</div>
    <div class="col-md-3">
		<div class="card bg-white shadow-sm text-center p-4 border-0 border-top border-warning border-4 rounded-4">
			<div class="text-warning mb-2"><i class="bi bi-currency-dollar h1"></i></div>
			<h6 class="text-muted text-uppercase small fw-bold"><?php _e( 'Commissions', 'org-ecosystem' ); ?></h6>
			<h2 class="fw-bold mb-0"><?php echo esc_html( $stats['commissions'] ); ?></h2>
		</div>
	</div>
</div>

<div class="row g-4 mb-5">
    <div class="col-lg-6">
        <div class="promotion-cta card bg-white border-0 shadow-sm h-100 rounded-4 overflow-hidden">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-2"><?php _e( 'Want more visibility?', 'org-ecosystem' ); ?></h5>
                <p class="text-muted mb-4 small"><?php _e( 'Promote your profile to the top of the directory and get 3x more views.', 'org-ecosystem' ); ?></p>
                <?php
                $is_featured = get_post_meta( $member_id, '_member_is_featured', true );
                if ( ! $is_featured && $member_id ) : ?>
                    <a href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'org_promote_listing', 'item_id' => $member_id, 'type' => 'member' ), admin_url( 'admin-post.php' ) ), 'org_promote_listing_action' ); ?>" class="btn btn-primary w-100 py-2 fw-bold">
                        <?php printf( __( 'Promote Profile - ₱ %s', 'org-ecosystem' ), get_theme_mod( 'promotion_price', '500' ) ); ?>
                    </a>
                <?php elseif ( $is_featured ) : ?>
                    <div class="bg-success-subtle text-success p-2 rounded text-center small fw-bold"><i class="bi bi-star-fill me-1"></i> <?php _e( 'Featured Active', 'org-ecosystem' ); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="referral-card card border-0 shadow-sm h-100 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-2"><?php _e( 'Refer a Friend', 'org-ecosystem' ); ?></h5>
                <p class="small opacity-75 mb-4"><?php _e( 'Share your unique code and earn 10% commission on every product sale they make!', 'org-ecosystem' ); ?></p>
                <div class="bg-white bg-opacity-25 p-3 rounded-3 text-center mb-0">
                    <span class="small d-block mb-1 text-uppercase fw-bold letter-spacing-1"><?php _e( 'Your Referral Code', 'org-ecosystem' ); ?></span>
                    <span class="h3 fw-bold mb-0 letter-spacing-2"><?php echo esc_html( $ref_code ); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="announcements mt-5">
	<h5 class="fw-bold mb-3"><?php _e( 'Global Announcements', 'org-ecosystem' ); ?></h5>
	<?php
	$announcements = new WP_Query( array( 'post_type' => 'announcement', 'posts_per_page' => 3 ) );
	if ( $announcements->have_posts() ) :
		while ( $announcements->have_posts() ) : $announcements->the_post();
			?>
			<div class="alert alert-light border-0 shadow-sm mb-3 p-3">
				<div class="d-flex justify-content-between align-items-center mb-2">
                    <strong class="text-dark"><?php the_title(); ?></strong>
                    <span class="badge bg-light text-muted fw-normal"><?php echo get_the_date(); ?></span>
                </div>
				<p class="mb-0 small text-muted"><?php echo wp_trim_words( get_the_content(), 20 ); ?></p>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
	else :
		echo '<p class="text-muted">' . __( 'No announcements at this time.', 'org-ecosystem' ) . '</p>';
	endif;
	?>
</div>
