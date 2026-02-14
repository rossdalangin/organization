<?php
/**
 * The template for displaying the events archive
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="archive-header bg-warning text-dark py-5 mb-5">
	<div class="container text-center">
		<h1 class="display-4 fw-bold"><?php _e( 'Upcoming Events', 'org-ecosystem' ); ?></h1>
		<p class="lead"><?php _e( 'Join us for networking, training, and community events.', 'org-ecosystem' ); ?></p>
	</div>
</div>

<div class="container pb-5">
    <?php get_template_part( 'template-parts/event-loop' ); ?>
</div>

<?php
get_footer();
