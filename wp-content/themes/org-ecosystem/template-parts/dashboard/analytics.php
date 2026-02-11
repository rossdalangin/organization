<?php
/**
 * Dashboard Engagement Analytics Part
 */
$user_id = get_current_user_id();
$member_id = get_user_meta( $user_id, '_member_profile_id', true );
$stats = org_ecosystem_get_member_stats( $member_id );

// Get trend data (mocked for demo, would be pulled from a tracking table in a real system)
$trends = array(
	'Mon' => rand(10, 50),
	'Tue' => rand(10, 50),
	'Wed' => rand(10, 50),
	'Thu' => rand(10, 50),
	'Fri' => rand(10, 50),
	'Sat' => rand(10, 50),
	'Sun' => rand(10, 50),
);
?>
<h2 class="h4 mb-4"><?php _e( 'Engagement Analytics', 'org-ecosystem' ); ?></h2>
<p class="text-muted mb-4"><?php _e( 'Track how people are interacting with your profile and offerings.', 'org-ecosystem' ); ?></p>

<div class="row g-4 mb-5">
	<div class="col-md-4">
		<div class="card border-0 shadow-sm p-4 text-center bg-white">
			<div class="text-primary h1 mb-2"><i class="bi bi-eye"></i></div>
			<h6 class="text-uppercase small fw-bold text-muted"><?php _e( 'Total Profile Views', 'org-ecosystem' ); ?></h6>
			<h2 class="display-6 fw-bold mb-0"><?php echo esc_html( $stats['views'] ); ?></h2>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card border-0 shadow-sm p-4 text-center bg-white">
			<div class="text-success h1 mb-2"><i class="bi bi-chat-dots"></i></div>
			<h6 class="text-uppercase small fw-bold text-muted"><?php _e( 'Direct Inquiries', 'org-ecosystem' ); ?></h6>
			<h2 class="display-6 fw-bold mb-0"><?php echo esc_html( $stats['inquiries'] ); ?></h2>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card border-0 shadow-sm p-4 text-center bg-white">
			<div class="text-info h1 mb-2"><i class="bi bi-cursor"></i></div>
			<h6 class="text-uppercase small fw-bold text-muted"><?php _e( 'Product Interest', 'org-ecosystem' ); ?></h6>
			<h2 class="display-6 fw-bold mb-0"><?php echo esc_html( $stats['product_clicks'] ); ?></h2>
		</div>
	</div>
</div>

<div class="card border-0 shadow-sm mb-4">
	<div class="card-header bg-white py-3">
		<h5 class="mb-0 fw-bold"><?php _e( 'Weekly View Trend', 'org-ecosystem' ); ?></h5>
	</div>
	<div class="card-body">
		<div class="d-flex align-items-end justify-content-between" style="height: 200px;">
			<?php foreach ( $trends as $day => $val ) :
				$height = ( $val / 50 ) * 100;
				?>
				<div class="text-center" style="width: 12%;">
					<div class="bg-primary rounded-top mx-auto" style="height: <?php echo $height; ?>%; width: 30px;" title="<?php echo $val; ?> views"></div>
					<div class="small mt-2"><?php echo $day; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<div class="alert alert-info">
	<i class="bi bi-info-circle me-2"></i>
	<?php _e( 'Pro Tip: Featured members typically receive 3x more views and inquiries. Upgrade your plan to get featured!', 'org-ecosystem' ); ?>
</div>
