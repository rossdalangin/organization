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
			<div class="row align-items-center mb-5">
				<div class="col-lg-6">
					<h1 class="display-3 fw-bold mb-4"><?php the_title(); ?></h1>
					<p class="lead mb-0 text-primary fw-bold text-uppercase letter-spacing-1"><?php _e( 'Active Program', 'org-ecosystem' ); ?></p>
				</div>
				<div class="col-lg-6">
					<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded shadow-lg' ) ); ?>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-8">
					<div class="program-content bg-white p-5 shadow-sm border rounded mb-4">
						<?php the_content(); ?>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="card bg-primary text-white p-4 shadow border-0">
						<h4 class="fw-bold mb-4"><?php _e( 'Get Involved', 'org-ecosystem' ); ?></h4>
						<p><?php _e( 'Would you like to support or volunteer for this program? Connect with us today.', 'org-ecosystem' ); ?></p>
						<div class="d-grid mt-4">
							<a href="<?php echo home_url( '/contact' ); ?>" class="btn btn-light"><?php _e( 'Inquire Now', 'org-ecosystem' ); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>

<?php
endwhile;

get_footer();
