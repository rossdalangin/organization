<?php
/**
 * Template Name: About Us
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main container py-5">
	<header class="page-header text-center mb-5">
		<h1 class="display-4 fw-bold"><?php the_title(); ?></h1>
		<hr class="mx-auto" style="width: 50px; height: 3px; background-color: var(--bs-primary);">
	</header>

	<div class="row">
		<div class="col-lg-10 mx-auto">
			<div class="page-content bg-white p-5 shadow-sm border rounded">
				<?php
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
				?>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
