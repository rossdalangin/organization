<?php
/**
 * The template for displaying single announcements
 *
 * @package OrgEcosystem
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'announcement-single py-5' ); ?>>
		<div class="container">
			<?php org_ecosystem_breadcrumbs(); ?>
			<div class="row">
				<div class="col-lg-8 mx-auto">
					<div class="card shadow-sm border-0 mb-5">
						<div class="card-header bg-primary text-white py-4 px-5">
							<div class="small text-uppercase opacity-75 mb-2"><?php _e( 'Important Announcement', 'org-ecosystem' ); ?></div>
							<h1 class="h2 fw-bold mb-0"><?php the_title(); ?></h1>
						</div>
						<div class="card-body p-5 bg-white">
							<div class="announcement-meta mb-4 text-muted small">
								<i class="bi bi-calendar3 me-2"></i> <?php echo get_the_date( 'F j, Y' ); ?>
							</div>
							<div class="announcement-content lead">
								<?php the_content(); ?>
							</div>
						</div>
						<div class="card-footer bg-light py-3 px-5 border-0">
							<a href="<?php echo esc_url( get_post_type_archive_link( 'announcement' ) ); ?>" class="btn btn-link text-decoration-none p-0 fw-bold"><i class="bi bi-arrow-left me-2"></i> <?php _e( 'Back to Announcements', 'org-ecosystem' ); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>

<?php
endwhile;

get_footer();
