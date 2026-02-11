<?php
/**
 * Dashboard My Applications Part
 */
$user_id = get_current_user_id();
$applications = new WP_Query( array(
	'post_type' => 'resource', // Placeholder for applications
	'author'    => $user_id,
	'meta_query' => array(
		array(
			'key' => '_app_job_id',
			'compare' => 'EXISTS'
		)
	)
) );
?>
<h2 class="h4 mb-4"><?php _e( 'My Job Applications', 'org-ecosystem' ); ?></h2>

<?php if ( isset( $_GET['submitted'] ) ) : ?>
	<div class="alert alert-success">Application submitted successfully!</div>
<?php endif; ?>

<div class="table-responsive">
	<table class="table table-hover border">
		<thead class="table-light">
			<tr>
				<th>Job Position</th>
				<th>Date Applied</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php if ( $applications->have_posts() ) : ?>
				<?php while ( $applications->have_posts() ) : $applications->the_post(); ?>
					<tr>
						<td><?php echo get_the_title( get_post_meta( get_the_ID(), '_app_job_id', true ) ); ?></td>
						<td><?php echo get_the_date(); ?></td>
						<td><span class="badge bg-secondary">Pending Review</span></td>
					</tr>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<tr>
					<td colspan="3" class="text-center py-4 text-muted"><?php _e( 'No applications found.', 'org-ecosystem' ); ?></td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
