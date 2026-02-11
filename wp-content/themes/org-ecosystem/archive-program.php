<?php
/**
 * The template for displaying program archives
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="archive-header bg-info text-white py-5 mb-5">
	<div class="container text-center">
		<h1 class="display-4 fw-bold"><?php _e( 'Our Programs & Projects', 'org-ecosystem' ); ?></h1>
		<p class="lead"><?php _e( 'Discover the initiatives we are driving to empower our community.', 'org-ecosystem' ); ?></p>
	</div>
</div>

<div class="container pb-5">
	<div class="row g-4">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<div class="col-md-6 col-lg-4">
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'card h-100 shadow-sm border-0 overflow-hidden' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium_large', array( 'class' => 'card-img-top', 'style' => 'height: 200px; object-fit: cover;' ) ); ?>
							</a>
						<?php endif; ?>
						<div class="card-body p-4">
							<h3 class="h5 fw-bold mb-3"><?php the_title(); ?></h3>
							<div class="card-text text-muted mb-4"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></div>
							<a href="<?php the_permalink(); ?>" class="btn btn-outline-info btn-sm fw-bold"><?php _e( 'Learn More', 'org-ecosystem' ); ?></a>
						</div>
					</article>
				</div>
				<?php
			endwhile;
			the_posts_pagination( array( 'class' => 'pagination justify-content-center mt-5 w-100' ) );
		else :
			echo '<p class="text-center py-5">' . __( 'No programs found.', 'org-ecosystem' ) . '</p>';
		endif;
		?>
	</div>
</div>

<?php
get_footer();
