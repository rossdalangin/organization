<?php
/**
 * Dashboard Overview Part
 */
$user_id = get_current_user_id();
$member_id = get_user_meta( $user_id, '_member_profile_id', true );
$stats = org_ecosystem_get_member_stats( $member_id );
?>
<h2 class="h4 mb-4"><?php _e( 'Dashboard Overview', 'org-ecosystem' ); ?></h2>
<div class="row g-4 mb-4">
	<div class="col-md-4">
		<div class="card bg-primary text-white text-center p-3 border-0">
			<h6 class="mb-1"><?php _e( 'Profile Views', 'org-ecosystem' ); ?></h6>
			<h2 class="mb-0"><?php echo esc_html( $stats['views'] ); ?></h2>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card bg-success text-white text-center p-3 border-0">
			<h6 class="mb-1"><?php _e( 'Inquiries', 'org-ecosystem' ); ?></h6>
			<h2 class="mb-0"><?php echo esc_html( $stats['inquiries'] ); ?></h2>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card bg-info text-white text-center p-3 border-0">
			<h6 class="mb-1"><?php _e( 'Product Clicks', 'org-ecosystem' ); ?></h6>
			<h2 class="mb-0"><?php echo esc_html( $stats['product_clicks'] ); ?></h2>
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
