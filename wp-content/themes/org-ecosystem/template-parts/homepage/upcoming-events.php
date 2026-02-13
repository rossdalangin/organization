<?php
/**
 * Homepage Upcoming Events Section
 */
?>
<section class="section-events upcoming-events py-5 bg-light">
	<div class="container">
		<div class="section-header text-center mb-5">
			<h2 class="fw-bold"><?php _e( 'Upcoming Events', 'org-ecosystem' ); ?></h2>
			<p class="text-muted"><?php _e( 'Join us for networking, learning, and community growth.', 'org-ecosystem' ); ?></p>
		</div>

		<div class="row g-4">
			<?php
			$events = new WP_Query( array(
				'post_type' => 'event',
				'posts_per_page' => 3,
				'meta_key' => '_event_date',
				'orderby' => 'meta_value',
				'order' => 'ASC',
			) );

			if ( $events->have_posts() ) :
				while ( $events->have_posts() ) : $events->the_post();
					$date = get_post_meta( get_the_ID(), '_event_date', true );
					$venue = get_post_meta( get_the_ID(), '_event_venue', true );
					?>
					<div class="col-lg-4">
						<div class="card h-100 shadow-sm border-0">
							<div class="card-body p-4">
								<div class="text-primary fw-bold mb-2"><i class="bi bi-calendar-event me-2"></i><?php echo date_i18n( get_option( 'date_format' ), strtotime( $date ) ); ?></div>
								<h5 class="fw-bold mb-3"><?php the_title(); ?></h5>
								<p class="text-muted small mb-4"><i class="bi bi-geo-alt me-1"></i><?php echo esc_html( $venue ); ?></p>
								<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary w-100"><?php _e( 'Event Details', 'org-ecosystem' ); ?></a>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				echo '<p class="text-center">' . __( 'No upcoming events scheduled.', 'org-ecosystem' ) . '</p>';
			endif;
			?>
		</div>
	</div>
</section>
