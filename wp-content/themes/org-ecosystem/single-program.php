<?php
/**
 * The template for displaying single programs
 *
 * @package OrgEcosystem
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'program-single py-5' ); ?>>
		<div class="container">
			<?php org_ecosystem_breadcrumbs(); ?>
			<div class="row g-5">
				<div class="col-lg-8">
					<header class="program-header mb-5">
						<h1 class="display-4 fw-bold mb-4"><?php the_title(); ?></h1>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="program-image mb-4">
								<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded shadow' ) ); ?>
							</div>
						<?php endif; ?>
					</header>

					<div class="program-content bg-white p-5 shadow-sm border rounded">
						<?php the_content(); ?>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="program-sidebar sticky-top" style="top: 100px;">
						<div class="card shadow-sm border-0 mb-4 bg-primary text-white">
							<div class="card-body p-4">
								<h4 class="fw-bold mb-3"><?php _e( 'Get Involved', 'org-ecosystem' ); ?></h4>
								<p><?php _e( 'Would you like to support or participate in this program?', 'org-ecosystem' ); ?></p>
								<div class="d-grid mt-4">
									<a href="<?php echo home_url( '/contact' ); ?>" class="btn btn-light fw-bold"><?php _e( 'Join Program', 'org-ecosystem' ); ?></a>
								</div>
							</div>
						</div>

						<div class="card shadow-sm border-0 mb-4">
							<div class="card-body p-4">
								<h5 class="fw-bold mb-3"><?php _e( 'Share this Project', 'org-ecosystem' ); ?></h5>
								<div class="d-flex gap-2">
									<a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="bi bi-facebook"></i></a>
									<a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="bi bi-twitter"></i></a>
									<a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="bi bi-linkedin"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>

<?php
endwhile;

get_footer();
