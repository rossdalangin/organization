<?php
/**
 * Template Name: Resource Library
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main container py-5">
	<header class="page-header text-center mb-5">
		<h1 class="display-4 fw-bold"><?php _e( 'Resource Library', 'org-ecosystem' ); ?></h1>
		<p class="lead text-muted"><?php _e( 'Exclusive tools, guides, and documents for our members.', 'org-ecosystem' ); ?></p>
	</header>

	<div class="row g-4">
		<?php
		$resources = new WP_Query( array(
			'post_type' => 'resource',
			'posts_per_page' => 12,
		) );

		if ( $resources->have_posts() ) :
			while ( $resources->have_posts() ) : $resources->the_post();
				?>
				<div class="col-md-4 col-lg-3">
					<div class="card h-100 shadow-sm border-0 resource-card">
						<div class="card-body p-4 text-center">
							<div class="resource-icon mb-3">
								<i class="bi bi-file-earmark-pdf text-danger h1"></i>
							</div>
							<h5 class="card-title fw-bold mb-3"><?php the_title(); ?></h5>
							<?php if ( is_user_logged_in() ) :
								$file_url = get_post_meta( get_the_ID(), '_resource_file_url', true ) ?: '#';
								?>
								<a href="<?php echo esc_url( $file_url ); ?>" class="btn btn-primary btn-sm" target="_blank"><?php _e( 'Download', 'org-ecosystem' ); ?></a>
							<?php else : ?>
								<span class="badge bg-secondary"><?php _e( 'Members Only', 'org-ecosystem' ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
		else :
			echo '<div class="col-12 text-center py-5"><p>' . __( 'No resources available at this time.', 'org-ecosystem' ) . '</p></div>';
		endif;
		?>
	</div>
</main>

<?php
get_footer();
