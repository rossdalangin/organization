<?php
/**
 * The template for displaying the jobs archive
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="archive-header bg-info text-white py-5 mb-5">
	<div class="container text-center">
		<h1 class="display-4 fw-bold"><?php _e( 'Job Board', 'org-ecosystem' ); ?></h1>
		<p class="lead"><?php _e( 'Explore career opportunities within our organization network.', 'org-ecosystem' ); ?></p>
	</div>
</div>

<div class="container pb-5">
	<div class="row g-4">
		<?php
		// Re-query to prioritize featured jobs if on first page
		if ( ! is_paged() ) {
			$featured_jobs = new WP_Query( array(
				'post_type' => 'job',
				'meta_key'  => '_job_is_featured',
				'meta_value'=> '1',
				'posts_per_page' => 5
			) );

			if ( $featured_jobs->have_posts() ) {
				while ( $featured_jobs->have_posts() ) {
					$featured_jobs->the_post();
					?>
					<div class="col-12 animate-fade-in-up">
						<div class="card shadow border-primary mb-3" style="border-left: 5px solid var(--bs-primary) !important;">
							<div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
								<div class="mb-3 mb-md-0">
									<div class="badge bg-primary mb-2"><?php _e( 'FEATURED', 'org-ecosystem' ); ?></div>
									<h5 class="card-title fw-bold mb-1"><?php the_title(); ?></h5>
									<?php the_terms( get_the_ID(), 'location', '<span class="text-muted small me-3"><i class="bi bi-geo-alt"></i> ', '</span>', '</span>' ); ?>
									<span class="text-muted small"><i class="bi bi-briefcase"></i> <?php _e( 'Full-time', 'org-ecosystem' ); ?></span>
								</div>
								<div>
									<a href="<?php the_permalink(); ?>" class="btn btn-primary px-4 fw-bold"><?php _e( 'Apply Now', 'org-ecosystem' ); ?></a>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
				wp_reset_postdata();
			}
		}

		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				// Skip if already shown in featured (simpler logic: just show all in normal list too, or exclude)
				if ( get_post_meta( get_the_ID(), '_job_is_featured', true ) === '1' && ! is_paged() ) continue;
				?>
				<div class="col-12">
					<div class="card shadow-sm border-0 mb-3">
						<div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
							<div class="mb-3 mb-md-0">
								<h5 class="card-title fw-bold mb-1"><?php the_title(); ?></h5>
								<?php the_terms( get_the_ID(), 'location', '<span class="text-muted small me-3"><i class="bi bi-geo-alt"></i> ', '</span>', '</span>' ); ?>
								<span class="text-muted small"><i class="bi bi-briefcase"></i> Full-time</span>
							</div>
							<div>
								<a href="<?php the_permalink(); ?>" class="btn btn-outline-info"><?php _e( 'Apply Now', 'org-ecosystem' ); ?></a>
							</div>
						</div>
					</div>
				</div>
				<?php
			endwhile;
			the_posts_pagination( array( 'class' => 'pagination justify-content-center mt-5' ) );
		else :
			echo '<div class="col-12 text-center py-5"><p>' . __( 'No job openings at the moment.', 'org-ecosystem' ) . '</p></div>';
		endif;
		?>
	</div>
</div>

<?php
get_footer();
