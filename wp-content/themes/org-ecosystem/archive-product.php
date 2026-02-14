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
	<div class="row g-4">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<div class="col-md-6 col-lg-4 col-xl-3">
					<div class="card h-100 shadow-sm border-0 position-relative">
                        <?php
                        if ( get_post_meta( get_the_ID(), '_product_is_featured', true ) ) : ?>
                            <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark shadow-sm" style="z-index: 5;"><i class="bi bi-star-fill me-1"></i> <?php _e( 'Featured', 'org-ecosystem' ); ?></span>
                        <?php endif; ?>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium', array( 'class' => 'card-img-top' ) ); ?>
							</a>
						<?php endif; ?>
						<div class="card-body">
							<h5 class="card-title fw-bold h6">
                                <?php the_title(); ?>
                                <?php if ( get_post_meta( get_the_ID(), '_product_is_solution', true ) ) : ?>
                                    <i class="bi bi-patch-check-fill text-primary ms-1" title="Enterprise Solution"></i>
                                <?php endif; ?>
                            </h5>
							<?php
							$business_id = get_post_meta( get_the_ID(), '_product_business_id', true );
							if ( $business_id ) : ?>
								<p class="small text-muted mb-2"><?php _e( 'By', 'org-ecosystem' ); ?> <?php echo get_the_title( $business_id ); ?></p>
							<?php endif; ?>
							<p class="card-text text-muted small"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
							<a href="<?php the_permalink(); ?>" class="btn btn-outline-success btn-sm w-100"><?php _e( 'View Product', 'org-ecosystem' ); ?></a>
						</div>
					</div>
				</div>
				<?php
			endwhile;
			the_posts_pagination( array( 'class' => 'pagination justify-content-center mt-5 w-100' ) );
		else :
			echo '<div class="col-12 text-center py-5"><p>' . __( 'No products found.', 'org-ecosystem' ) . '</p></div>';
		endif;
		?>
	</div>
</div>

<?php
get_footer();
