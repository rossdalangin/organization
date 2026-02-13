<?php
/**
 * Homepage Latest Announcements
 */
?>
<section class="section-announcements latest-announcements py-5 bg-light">
	<div class="container">
		<div class="section-header text-center mb-5">
			<h2 class="fw-bold"><?php _e( 'Announcements', 'org-ecosystem' ); ?></h2>
			<p class="text-muted"><?php _e( 'Important updates and notices from the organization.', 'org-ecosystem' ); ?></p>
		</div>

		<div class="row g-4">
			<?php
			$announcements = new WP_Query( array(
				'post_type' => 'announcement',
				'posts_per_page' => 3,
			) );

			if ( $announcements->have_posts() ) :
				while ( $announcements->have_posts() ) : $announcements->the_post();
					?>
					<div class="col-lg-4">
						<div class="card h-100 shadow-sm border-0 bg-white border-start border-primary border-4">
							<div class="card-body p-4">
								<span class="badge bg-primary mb-3"><?php echo get_the_date(); ?></span>
								<h5 class="fw-bold mb-3"><?php the_title(); ?></h5>
								<p class="text-muted small"><?php echo wp_trim_words( get_the_content(), 20 ); ?></p>
								<a href="<?php the_permalink(); ?>" class="btn btn-link p-0 text-decoration-none small fw-bold"><?php _e( 'Read More', 'org-ecosystem' ); ?></a>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>
	</div>
</section>
