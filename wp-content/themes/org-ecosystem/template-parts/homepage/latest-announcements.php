<?php
/**
 * Homepage Latest Announcements Section
 */
?>
<section class="latest-announcements py-5 bg-white">
	<div class="container">
		<div class="section-header text-center mb-5">
			<h2 class="fw-bold"><?php _e( 'Organization Announcements', 'org-ecosystem' ); ?></h2>
			<p class="text-muted"><?php _e( 'Important updates for our community members.', 'org-ecosystem' ); ?></p>
		</div>

		<div class="row justify-content-center">
			<div class="col-lg-10">
				<?php
				$announcements = new WP_Query( array(
					'post_type' => 'announcement',
					'posts_per_page' => 3
				) );

				if ( $announcements->have_posts() ) :
					while ( $announcements->have_posts() ) : $announcements->the_post();
						?>
						<div class="announcement-item border-start border-4 border-primary ps-4 mb-5">
							<div class="small text-muted mb-2"><?php echo get_the_date(); ?></div>
							<h4 class="fw-bold mb-3"><?php the_title(); ?></h4>
							<div class="announcement-content text-muted mb-3">
								<?php the_excerpt(); ?>
							</div>
							<a href="<?php the_permalink(); ?>" class="text-primary text-decoration-none fw-bold"><?php _e( 'Read Full Announcement', 'org-ecosystem' ); ?> <i class="bi bi-arrow-right"></i></a>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p class="text-center">' . __( 'No recent announcements.', 'org-ecosystem' ) . '</p>';
				endif;
				?>
			</div>
		</div>
	</div>
</section>
