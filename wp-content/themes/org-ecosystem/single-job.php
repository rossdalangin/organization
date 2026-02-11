<?php
/**
 * The template for displaying single jobs
 *
 * @package OrgEcosystem
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'job-single py-5' ); ?>>
		<div class="container">
			<?php org_ecosystem_breadcrumbs(); ?>
			<div class="row">
				<div class="col-lg-8 mx-auto">
					<header class="job-header mb-5 text-center">
						<h1 class="display-4 fw-bold mb-3"><?php the_title(); ?></h1>
						<div class="d-flex justify-content-center gap-3">
							<?php the_terms( get_the_ID(), 'location', '<span class="badge bg-light text-dark border p-2 px-3"><i class="bi bi-geo-alt me-1"></i> ', '</span>', '</span>' ); ?>
							<span class="badge bg-light text-dark border p-2 px-3"><i class="bi bi-briefcase me-1"></i> <?php _e( 'Full-time', 'org-ecosystem' ); ?></span>
						</div>
					</header>

					<div class="job-content bg-white p-5 shadow-sm border rounded mb-5">
						<h3 class="fw-bold mb-4"><?php _e( 'Job Description', 'org-ecosystem' ); ?></h3>
						<?php the_content(); ?>

						<hr class="my-5">

						<h3 class="fw-bold mb-4"><?php _e( 'Apply for this Position', 'org-ecosystem' ); ?></h3>
						<form id="job-application-form" action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="action" value="org_job_apply">
							<input type="hidden" name="job_id" value="<?php the_ID(); ?>">
							<?php wp_nonce_field( 'org_job_apply', 'org_job_nonce' ); ?>

							<div class="row g-3">
								<div class="col-md-6">
									<label class="form-label fw-bold"><?php _e( 'Full Name', 'org-ecosystem' ); ?></label>
									<input type="text" name="app_name" class="form-control" required>
								</div>
								<div class="col-md-6">
									<label class="form-label fw-bold"><?php _e( 'Email Address', 'org-ecosystem' ); ?></label>
									<input type="email" name="app_email" class="form-control" required>
								</div>
								<div class="col-12">
									<label class="form-label fw-bold"><?php _e( 'Resume (PDF)', 'org-ecosystem' ); ?></label>
									<input type="file" name="app_resume" class="form-control" accept=".pdf" required>
								</div>
								<div class="col-12">
									<label class="form-label fw-bold"><?php _e( 'Cover Letter', 'org-ecosystem' ); ?></label>
									<textarea name="app_message" class="form-control" rows="5" required></textarea>
								</div>
								<div class="col-12 mt-4 text-center">
									<button type="submit" class="btn btn-primary btn-lg px-5"><?php _e( 'Submit Application', 'org-ecosystem' ); ?></button>
								</div>
							</div>
						</form>
					</div>

					<div class="related-jobs mt-5">
						<h4 class="fw-bold mb-4 text-center"><?php _e( 'More Job Opportunities', 'org-ecosystem' ); ?></h4>
						<div class="row g-3">
							<?php
							$related_jobs = new WP_Query( array( 'post_type' => 'job', 'posts_per_page' => 3, 'post__not_in' => array( get_the_ID() ) ) );
							while ( $related_jobs->have_posts() ) : $related_jobs->the_post();
								?>
								<div class="col-12">
									<div class="card border-0 shadow-sm">
										<div class="card-body d-flex justify-content-between align-items-center">
											<h6 class="mb-0 fw-bold"><?php the_title(); ?></h6>
											<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-info"><?php _e( 'View Job', 'org-ecosystem' ); ?></a>
										</div>
									</div>
								</div>
								<?php
							endwhile; wp_reset_postdata();
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>

<?php
endwhile;

get_footer();
