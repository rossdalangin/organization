<?php
/**
 * The template for displaying single events
 *
 * @package OrgEcosystem
 */

get_header();

while ( have_posts() ) :
	the_post();
	$date = get_post_meta( get_the_ID(), '_event_date', true );
	$time = get_post_meta( get_the_ID(), '_event_time', true );
	$venue = get_post_meta( get_the_ID(), '_event_venue', true );
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'event-single py-5' ); ?>>
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="event-featured-image mb-4">
						<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded shadow' ) ); ?>
					</div>
					<h1 class="display-4 fw-bold mb-4"><?php the_title(); ?></h1>
					<div class="event-content bg-white p-4 shadow-sm border rounded mb-4">
						<?php the_content(); ?>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="event-sidebar sticky-top" style="top: 100px;">
						<div class="card shadow-sm border-0 mb-4">
							<div class="card-body p-4">
								<h5 class="fw-bold mb-4"><?php _e( 'Event Details', 'org-ecosystem' ); ?></h5>
								<ul class="list-unstyled">
									<li class="mb-3 d-flex">
										<i class="bi bi-calendar-check text-primary me-3 h4 mb-0"></i>
										<div>
											<div class="small text-muted"><?php _e( 'Date', 'org-ecosystem' ); ?></div>
											<div class="fw-bold"><?php echo $date ? date( 'F j, Y', strtotime( $date ) ) : __( 'TBA', 'org-ecosystem' ); ?></div>
										</div>
									</li>
									<li class="mb-3 d-flex">
										<i class="bi bi-clock text-primary me-3 h4 mb-0"></i>
										<div>
											<div class="small text-muted"><?php _e( 'Time', 'org-ecosystem' ); ?></div>
											<div class="fw-bold"><?php echo $time ? esc_html( $time ) : __( 'TBA', 'org-ecosystem' ); ?></div>
										</div>
									</li>
									<li class="mb-3 d-flex">
										<i class="bi bi-geo-alt text-primary me-3 h4 mb-0"></i>
										<div>
											<div class="small text-muted"><?php _e( 'Venue', 'org-ecosystem' ); ?></div>
											<div class="fw-bold"><?php echo $venue ? esc_html( $venue ) : __( 'TBA', 'org-ecosystem' ); ?></div>
										</div>
									</li>
								</ul>
								<hr>
								<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
									<input type="hidden" name="action" value="org_event_register">
									<input type="hidden" name="event_id" value="<?php the_ID(); ?>">
									<?php wp_nonce_field( 'org_event_register', 'org_event_nonce' ); ?>
									<div class="d-grid mt-4">
										<button type="submit" class="btn btn-primary btn-lg"><?php _e( 'Register for Event', 'org-ecosystem' ); ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>

<?php
endwhile;

get_footer();
