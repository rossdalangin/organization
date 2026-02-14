<?php
/**
 * The template for displaying the products archive
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="archive-header bg-success text-white py-5 mb-5">
	<div class="container text-center">
		<h1 class="display-4 fw-bold"><?php _e( 'Products & Services', 'org-ecosystem' ); ?></h1>
		<p class="lead"><?php _e( 'Explore the offerings from our member businesses.', 'org-ecosystem' ); ?></p>
	</div>
</div>

<div class="container pb-5">
    <?php get_template_part( 'template-parts/product-loop' ); ?>
</div>

<?php
get_footer();
