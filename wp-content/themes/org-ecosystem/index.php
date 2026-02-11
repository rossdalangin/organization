<?php
/**
 * The main template file
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main container py-5">
	<div class="row">
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
