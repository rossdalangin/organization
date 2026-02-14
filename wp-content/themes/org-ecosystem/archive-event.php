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
	<div class="row g-4">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				$date = get_post_meta( get_the_ID(), '_event_date', true );
				$location = get_the_terms( get_the_ID(), 'location' );
				?>
				<div class="col-md-6">
					<div class="card h-100 shadow-sm border-0 overflow-hidden position-relative">
                        <?php if ( get_post_meta( get_the_ID(), '_event_is_upcoming', true ) ) : ?>
                            <span class="position-absolute top-0 end-0 m-3 badge bg-danger text-white shadow-sm" style="z-index: 5;"><i class="bi bi-fire me-1"></i> <?php _e( 'NEXT UP', 'org-ecosystem' ); ?></span>
                        <?php endif; ?>
						<div class="row g-0">
							<div class="col-md-4">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'medium', array( 'class' => 'img-fluid h-100 w-100', 'style' => 'object-fit: cover;' ) ); ?>
								<?php else : ?>
									<div class="bg-light h-100 d-flex align-items-center justify-content-center">
										<i class="bi bi-calendar-event text-warning display-4"></i>
									</div>
								<?php endif; ?>
							</div>
							<div class="col-md-8">
								<div class="card-body">
									<?php if ( $date ) : ?>
										<div class="text-primary fw-bold small mb-2"><i class="bi bi-clock me-1"></i> <?php echo date( 'F j, Y', strtotime( $date ) ); ?></div>
									<?php endif; ?>
									<h5 class="card-title fw-bold"><?php the_title(); ?></h5>
									<p class="card-text text-muted small"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
									<a href="<?php the_permalink(); ?>" class="btn btn-warning btn-sm text-dark fw-bold"><?php _e( 'Event Details', 'org-ecosystem' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			endwhile;
			the_posts_pagination( array( 'class' => 'pagination justify-content-center mt-5 w-100' ) );
		else :
			echo '<div class="col-12 text-center py-5"><p>' . __( 'No upcoming events found.', 'org-ecosystem' ) . '</p></div>';
		endif;
		?>
	</div>
</div>

<?php
get_footer();
