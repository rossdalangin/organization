<?php
/**
 * The template for displaying the programs archive
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="archive-header bg-primary text-white py-5 mb-5">
	<div class="container text-center">
		<h1 class="display-4 fw-bold"><?php _e( 'Programs & Projects', 'org-ecosystem' ); ?></h1>
		<p class="lead"><?php _e( 'Our ongoing initiatives to support the community.', 'org-ecosystem' ); ?></p>
	</div>
</div>

<div class="container pb-5">
	<div class="row g-4">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<div class="col-md-6">
					<div class="card h-100 shadow-sm border-0">
						<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'large', array( 'class' => 'card-img-top' ) ); ?>
						<div class="card-body p-4">
							<h5 class="card-title fw-bold"><?php the_title(); ?></h5>
							<p class="card-text text-muted"><?php echo wp_trim_words( get_the_excerpt(), 25 ); ?></p>
							<a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php _e( 'Learn More', 'org-ecosystem' ); ?></a>
						</div>
					</div>
				</div>
				<?php
			endwhile;
			the_posts_pagination( array( 'class' => 'pagination justify-content-center mt-5' ) );
		else :
			echo '<div class="col-12 text-center py-5"><p>' . __( 'No programs found.', 'org-ecosystem' ) . '</p></div>';
		endif;
		?>
	</div>
</div>

<?php
get_footer();
