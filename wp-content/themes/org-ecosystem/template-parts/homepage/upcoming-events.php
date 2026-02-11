<?php
/**
 * Homepage Upcoming Events Section
 */
?>
<section class="upcoming-events py-5 bg-light">
	<div class="container">
		<div class="section-header d-flex justify-content-between align-items-end mb-5">
			<div>
				<h2 class="fw-bold mb-0"><?php _e( 'Upcoming Events', 'org-ecosystem' ); ?></h2>
				<p class="text-muted mb-0"><?php _e( 'Don\'t miss out on these networking and learning opportunities.', 'org-ecosystem' ); ?></p>
			</div>
			<a href="<?php echo get_post_type_archive_link( 'event' ); ?>" class="btn btn-primary d-none d-md-block"><?php _e( 'View All Events', 'org-ecosystem' ); ?></a>
		</div>

		<div class="row g-4">
			<?php
			$events = new WP_Query( array(
				'post_type' => 'event',
				'posts_per_page' => 3,
				'meta_key' => '_event_date',
				'orderby' => 'meta_value',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => '_event_date',
						'value' => date( 'Y-m-d' ),
						'compare' => '>=',
						'type' => 'DATE'
					)
				)
			) );

			if ( $events->have_posts() ) :
				while ( $events->have_posts() ) : $events->the_post();
					$date = get_post_meta( get_the_ID(), '_event_date', true );
					?>
					<div class="col-md-4">
						<div class="card h-100 border-0 shadow-sm overflow-hidden">
							<?php if ( has_post_thumbnail() ) : ?>
								<div style="height: 200px; overflow: hidden;">
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'img-fluid w-100 h-100', 'style' => 'object-fit: cover;' ) ); ?>
								</div>
							<?php endif; ?>
							<div class="card-body p-4">
								<div class="small text-primary fw-bold mb-2"><?php echo date( 'M d, Y', strtotime( $date ) ); ?></div>
								<h5 class="card-title fw-bold"><?php the_title(); ?></h5>
								<p class="card-text text-muted small"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
							</div>
							<div class="card-footer bg-white border-0 pb-4 px-4">
								<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary"><?php _e( 'Event Details', 'org-ecosystem' ); ?></a>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				echo '<div class="col-12 text-center py-4"><p>' . __( 'No upcoming events found.', 'org-ecosystem' ) . '</p></div>';
			endif;
			?>
		</div>
	</div>
</section>
