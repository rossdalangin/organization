<?php
/**
 * Dashboard Resources Part
 */
?>
<h2 class="h4 mb-4"><?php _e( 'Exclusive Resources', 'org-ecosystem' ); ?></h2>
<p class="text-muted mb-4"><?php _e( 'As a member, you have access to these exclusive documents and tools.', 'org-ecosystem' ); ?></p>

<div class="row g-4">
	<?php
	$resources = new WP_Query( array( 'post_type' => 'resource', 'posts_per_page' => -1 ) );
	if ( $resources->have_posts() ) :
		while ( $resources->have_posts() ) : $resources->the_post();
			?>
			<div class="col-md-6 col-lg-4">
				<div class="card h-100 border-0 shadow-sm bg-white">
					<div class="card-body p-4 text-center">
						<i class="bi bi-file-earmark-pdf text-danger display-5 mb-3 d-block"></i>
						<h6 class="fw-bold mb-3"><?php the_title(); ?></h6>
						<a href="#" class="btn btn-outline-primary btn-sm w-100"><i class="bi bi-download me-1"></i> <?php _e( 'Download', 'org-ecosystem' ); ?></a>
					</div>
				</div>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
	else :
		echo '<div class="col-12 text-center py-5"><p class="text-muted">' . __( 'No exclusive resources available at this time.', 'org-ecosystem' ) . '</p></div>';
	endif;
	?>
</div>
