<?php
/**
 * Dashboard My Events Part
 */
$user_id = get_current_user_id();
$registrations = get_user_meta( $user_id, '_registered_events', true ) ?: array();

$events = new WP_Query( array(
	'post_type' => 'event',
	'post__in'  => ! empty( $registrations ) ? $registrations : array( 0 ),
	'posts_per_page' => -1,
) );
?>
<h2 class="h4 mb-4"><?php _e( 'My Registered Events', 'org-ecosystem' ); ?></h2>

<?php if ( isset( $_GET['registered'] ) ) : ?>
	<div class="alert alert-success">Successfully registered for the event!</div>
<?php endif; ?>

<div class="row g-4">
	<?php if ( $events->have_posts() ) : ?>
		<?php while ( $events->have_posts() ) : $events->the_post(); ?>
			<div class="col-md-6">
				<div class="card h-100 border shadow-sm">
					<div class="card-body">
						<h5 class="card-title fw-bold"><?php the_title(); ?></h5>
						<p class="text-primary small fw-bold"><i class="bi bi-calendar-event me-1"></i> <?php echo get_post_meta( get_the_ID(), '_event_date', true ); ?></p>
						<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm"><?php _e( 'View Details', 'org-ecosystem' ); ?></a>
					</div>
				</div>
			</div>
		<?php endwhile; wp_reset_postdata(); ?>
	<?php else : ?>
		<div class="col-12 text-center py-5">
			<p class="text-muted"><?php _e( 'You haven\'t registered for any events yet.', 'org-ecosystem' ); ?></p>
			<a href="<?php echo get_post_type_archive_link( 'event' ); ?>" class="btn btn-primary"><?php _e( 'Browse Events', 'org-ecosystem' ); ?></a>
		</div>
	<?php endif; ?>
</div>
