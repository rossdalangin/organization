<?php
/**
 * Dashboard Overview Part
 */
$user_id = get_current_user_id();
$member_id = get_user_meta( $user_id, '_member_profile_id', true );
$stats = org_ecosystem_get_member_stats( $member_id );
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
	<div class="col-md-4">
		<div class="card bg-white shadow-sm text-center p-4 border-0 border-top border-primary border-4">
			<div class="text-primary mb-2"><i class="bi bi-eye h1"></i></div>
			<h6 class="text-muted text-uppercase small fw-bold"><?php _e( 'Profile Views', 'org-ecosystem' ); ?></h6>
			<h2 class="fw-bold mb-0"><?php echo esc_html( $stats['views'] ); ?></h2>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card bg-white shadow-sm text-center p-4 border-0 border-top border-success border-4">
			<div class="text-success mb-2"><i class="bi bi-chat-dots h1"></i></div>
			<h6 class="text-muted text-uppercase small fw-bold"><?php _e( 'Direct Inquiries', 'org-ecosystem' ); ?></h6>
			<h2 class="fw-bold mb-0"><?php echo esc_html( $stats['inquiries'] ); ?></h2>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card bg-white shadow-sm text-center p-4 border-0 border-top border-info border-4">
			<div class="text-info mb-2"><i class="bi bi-cursor h1"></i></div>
			<h6 class="text-muted text-uppercase small fw-bold"><?php _e( 'Product Interest', 'org-ecosystem' ); ?></h6>
			<h2 class="fw-bold mb-0"><?php echo esc_html( $stats['product_clicks'] ); ?></h2>
		</div>
	</div>
</div>

<div class="promotion-cta card bg-light border-0 shadow-sm mb-5">
	<div class="card-body p-4">
		<div class="row align-items-center">
			<div class="col-md-8">
				<h5 class="fw-bold mb-2"><?php _e( 'Want more visibility?', 'org-ecosystem' ); ?></h5>
				<p class="text-muted mb-0"><?php _e( 'Promote your profile to the top of the directory and get 3x more views.', 'org-ecosystem' ); ?></p>
			</div>
			<div class="col-md-4 text-md-end mt-3 mt-md-0">
				<?php
				$is_featured = get_post_meta( $member_id, '_member_is_featured', true );
				if ( ! $is_featured ) : ?>
					<a href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'org_promote_listing', 'item_id' => $member_id, 'type' => 'member' ), admin_url( 'admin-post.php' ) ), 'org_promote_listing_action' ); ?>" class="btn btn-warning fw-bold">
						<?php printf( __( 'Promote Profile - ₱ %s', 'org-ecosystem' ), get_theme_mod( 'promotion_price', '500' ) ); ?>
					</a>
				<?php else : ?>
					<span class="badge bg-success p-2 px-3"><i class="bi bi-star-fill me-1"></i> <?php _e( 'Featured Profile', 'org-ecosystem' ); ?></span>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<div class="announcements mt-5">
	<h5 class="mb-3"><?php _e( 'Latest Announcements', 'org-ecosystem' ); ?></h5>
	<?php
	$announcements = new WP_Query( array( 'post_type' => 'announcement', 'posts_per_page' => 3 ) );
	if ( $announcements->have_posts() ) :
		while ( $announcements->have_posts() ) : $announcements->the_post();
			?>
			<div class="alert alert-light border shadow-sm mb-3">
				<strong><?php the_title(); ?></strong> - <small class="text-muted"><?php echo get_the_date(); ?></small>
				<p class="mb-0 mt-2 small"><?php echo wp_trim_words( get_the_content(), 20 ); ?></p>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
	else :
		echo '<p>' . __( 'No announcements at this time.', 'org-ecosystem' ) . '</p>';
	endif;
	?>
</div>
