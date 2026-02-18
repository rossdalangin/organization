<?php
/**
 * Dashboard My Job Postings Part
 */
$user_id = get_current_user_id();
$jobs = new WP_Query( array(
	'post_type' => 'job',
	'author' => $user_id,
	'posts_per_page' => -1,
	'post_status' => array('publish', 'pending', 'draft')
) );

$edit_id = isset( $_GET['edit_job'] ) ? intval( $_GET['edit_job'] ) : 0;
$job_to_edit = $edit_id ? get_post( $edit_id ) : null;

if ( $job_to_edit && (int) $job_to_edit->post_author !== (int) $user_id ) {
	$job_to_edit = null;
}

$is_vendor = current_user_can( 'vendor' );
$listing_fee = get_theme_mod( 'job_listing_price', '1000' );
?>

<div class="d-flex justify-content-between align-items-center mb-4">
	<h2 class="h4 mb-0"><?php _e( 'My Job Postings', 'org-ecosystem' ); ?></h2>
	<?php if ( ! $job_to_edit ) : ?>
		<a href="?action=my-jobs&add_new=1" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> <?php _e( 'Post a Job', 'org-ecosystem' ); ?></a>
	<?php else : ?>
		<a href="?action=my-jobs" class="btn btn-secondary btn-sm"><?php _e( 'Back to List', 'org-ecosystem' ); ?></a>
	<?php endif; ?>
</div>

<?php if ( isset( $_GET['add_new'] ) || $job_to_edit ) : ?>
	<div class="card bg-white border p-4 shadow-sm mb-5">
		<h3 class="h5 mb-4"><?php echo $job_to_edit ? __( 'Edit Job Posting', 'org-ecosystem' ) : __( 'Post a New Job', 'org-ecosystem' ); ?></h3>

		<?php if ( ! $job_to_edit && $is_vendor ) : ?>
			<div class="alert alert-info border-0 shadow-sm mb-4">
				<i class="bi bi-info-circle me-2"></i>
				<?php printf( __( 'Job postings for Vendors require a one-time listing fee of ₱ %s.', 'org-ecosystem' ), $listing_fee ); ?>
			</div>
		<?php endif; ?>

		<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
			<input type="hidden" name="action" value="org_save_job">
			<?php if ( $job_to_edit ) : ?>
				<input type="hidden" name="job_id" value="<?php echo $job_to_edit->ID; ?>">
			<?php endif; ?>
			<?php wp_nonce_field( 'org_save_job_action', 'org_job_nonce' ); ?>

			<div class="mb-3">
				<label class="form-label fw-bold small"><?php _e( 'Job Title', 'org-ecosystem' ); ?></label>
				<input type="text" name="job_title" class="form-control" value="<?php echo $job_to_edit ? esc_attr( $job_to_edit->post_title ) : ''; ?>" required>
			</div>
			<div class="mb-3">
				<label class="form-label fw-bold small"><?php _e( 'Description', 'org-ecosystem' ); ?></label>
				<textarea name="job_description" class="form-control" rows="6" required><?php echo $job_to_edit ? esc_textarea( $job_to_edit->post_content ) : ''; ?></textarea>
			</div>

			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label fw-bold small"><?php _e( 'Location', 'org-ecosystem' ); ?></label>
					<?php
					wp_dropdown_categories( array(
						'show_option_none' => __( 'Select Location', 'org-ecosystem' ),
						'taxonomy'         => 'location',
						'name'             => 'job_location',
						'class'            => 'form-select',
						'hide_empty'       => false,
						'selected'         => $job_to_edit ? (get_the_terms($job_to_edit->ID, 'location') ? get_the_terms($job_to_edit->ID, 'location')[0]->term_id : 0) : 0,
					) );
					?>
				</div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold small"><?php _e( 'Job Type', 'org-ecosystem' ); ?></label>
                    <select name="job_type" class="form-select">
                        <option value="full-time" <?php selected($job_to_edit ? get_post_meta($job_to_edit->ID, '_job_type', true) : 'full-time', 'full-time'); ?>>Full-time</option>
                        <option value="part-time" <?php selected($job_to_edit ? get_post_meta($job_to_edit->ID, '_job_type', true) : '', 'part-time'); ?>>Part-time</option>
                        <option value="contract" <?php selected($job_to_edit ? get_post_meta($job_to_edit->ID, '_job_type', true) : '', 'contract'); ?>>Contract</option>
                        <option value="remote" <?php selected($job_to_edit ? get_post_meta($job_to_edit->ID, '_job_type', true) : '', 'remote'); ?>>Remote</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold small"><?php _e( 'Salary Range', 'org-ecosystem' ); ?></label>
                    <input type="text" name="job_salary" class="form-control" value="<?php echo $job_to_edit ? esc_attr( get_post_meta($job_to_edit->ID, '_job_salary', true) ) : ''; ?>" placeholder="e.g. 50k - 80k">
                </div>
			</div>

            <div class="mb-4">
                <label class="form-label d-block fw-bold small">
                    <input type="checkbox" name="job_promote" value="1" <?php checked( $job_to_edit ? get_post_meta($job_to_edit->ID, '_job_is_featured', true) : false, '1' ); ?>>
                    <?php printf( __( 'Feature this job (+ ₱ %s)', 'org-ecosystem' ), get_theme_mod( 'promotion_price', '500' ) ); ?>
                </label>
            </div>

			<button type="submit" class="btn btn-primary px-4 fw-bold">
				<?php echo $job_to_edit ? __( 'Update Job', 'org-ecosystem' ) : ( $is_vendor ? __( 'Pay & Post Job', 'org-ecosystem' ) : __( 'Post Job', 'org-ecosystem' ) ); ?>
			</button>
		</form>
	</div>
<?php endif; ?>

<div class="table-responsive">
	<table class="table table-hover border bg-white shadow-sm">
		<thead class="table-light">
			<tr>
				<th>Job Title</th>
				<th>Status</th>
				<th>Featured</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if ( $jobs->have_posts() ) : ?>
				<?php while ( $jobs->have_posts() ) : $jobs->the_post(); ?>
					<tr>
						<td><strong><?php the_title(); ?></strong></td>
						<td>
							<?php
							$status = get_post_status();
							$badge = ($status === 'publish') ? 'bg-success' : 'bg-warning text-dark';
							?>
							<span class="badge <?php echo $badge; ?>"><?php echo esc_html( ucfirst($status) ); ?></span>
						</td>
						<td>
							<?php if ( get_post_meta( get_the_ID(), '_job_is_featured', true ) ) : ?>
								<span class="badge bg-info text-dark"><i class="bi bi-star-fill"></i> Featured</span>
							<?php else : ?>
								<span class="text-muted small">No</span>
							<?php endif; ?>
						</td>
						<td>
							<a href="?action=my-jobs&edit_job=<?php the_ID(); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
							<a href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'org_delete_job', 'job_id' => get_the_ID() ), admin_url( 'admin-post.php' ) ), 'org_delete_job_action' ); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
						</td>
					</tr>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<tr>
					<td colspan="4" class="text-center py-5 text-muted"><?php _e( 'No job postings found.', 'org-ecosystem' ); ?></td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
