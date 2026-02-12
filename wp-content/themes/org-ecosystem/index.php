<?php
/**
 * The main template file
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="blog-header bg-dark text-white py-5 mb-5">
	<div class="container text-center py-4">
		<h1 class="display-4 fw-bold"><?php echo is_home() ? get_the_title( get_option('page_for_posts', true) ) : __( 'Our News', 'org-ecosystem' ); ?></h1>
		<p class="lead opacity-75"><?php _e( 'Stay updated with latest news and stories from our organization.', 'org-ecosystem' ); ?></p>
	</div>
</div>

<main id="primary" class="site-main container pb-5">
	<div class="row g-5">
		<div class="col-lg-8">
			<?php
			if ( have_posts() ) :
				if ( is_home() && ! is_front_page() ) :
					?>
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
					<?php
				endif;

				/* Start the Loop */
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', get_post_type() );
				endwhile;

				the_posts_navigation();

			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
			?>
		</div>
		<div class="col-lg-4">
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>

<?php
get_footer();
