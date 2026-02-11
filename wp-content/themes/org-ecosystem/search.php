<?php
/**
 * The template for displaying search results pages
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main container py-5">
	<header class="page-header mb-5">
		<h1 class="page-title">
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'org-ecosystem' ), '<span>' . get_search_query() . '</span>' );
			?>
		</h1>
	</header>

	<div class="row">
		<div class="col-lg-8">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-4 p-4 bg-white shadow-sm border rounded' ); ?>>
						<div class="small text-muted mb-2 text-uppercase letter-spacing-1"><?php echo get_post_type(); ?></div>
						<h3 class="fw-bold"><a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark"><?php the_title(); ?></a></h3>
						<p class="text-muted small mb-0"><?php echo wp_trim_words( get_the_excerpt(), 25 ); ?></p>
					</article>
				<?php endwhile; ?>

				<?php the_posts_pagination( array( 'class' => 'pagination justify-content-center' ) ); ?>

			<?php else : ?>
				<div class="no-results p-5 text-center bg-light border rounded">
					<h3><?php _e( 'Nothing Found', 'org-ecosystem' ); ?></h3>
					<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'org-ecosystem' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="col-lg-4">
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>

<?php
get_footer();
