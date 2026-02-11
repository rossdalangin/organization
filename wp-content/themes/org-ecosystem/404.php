<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main container py-5 text-center">
	<section class="error-404 not-found py-5">
		<header class="page-header mb-4">
			<h1 class="display-1 text-primary"><?php esc_html_e( '404', 'org-ecosystem' ); ?></h1>
			<h2 class="page-title h3"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'org-ecosystem' ); ?></h2>
		</header>

		<div class="page-content">
			<p class="lead mb-4"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'org-ecosystem' ); ?></p>
			<div class="row justify-content-center">
				<div class="col-md-6">
					<?php get_search_form(); ?>
				</div>
			</div>
			<div class="mt-5">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Back to Home', 'org-ecosystem' ); ?></a>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
