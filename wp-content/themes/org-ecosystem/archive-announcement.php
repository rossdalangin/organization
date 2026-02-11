<?php
/**
 * The template for displaying announcement archives
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="archive-header bg-primary text-white py-5 mb-5">
	<div class="container text-center">
		<h1 class="display-4 fw-bold"><?php _e( 'Latest Announcements', 'org-ecosystem' ); ?></h1>
		<p class="lead"><?php _e( 'Stay updated with the latest news and important notices from our organization.', 'org-ecosystem' ); ?></p>
	</div>
</div>

<div class="container pb-5">
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'card shadow-sm border-0 mb-4 overflow-hidden' ); ?>>
						<div class="row g-0">
							<div class="col-md-3 bg-light d-flex flex-column align-items-center justify-content-center p-3 border-end">
								<div class="h4 fw-bold mb-0"><?php echo get_the_date( 'd' ); ?></div>
								<div class="small text-uppercase text-muted"><?php echo get_the_date( 'M Y' ); ?></div>
							</div>
							<div class="col-md-9">
								<div class="card-body p-4">
									<h3 class="h5 fw-bold mb-3"><a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark"><?php the_title(); ?></a></h3>
									<div class="card-text text-muted mb-3"><?php echo wp_trim_words( get_the_content(), 30 ); ?></div>
									<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm fw-bold"><?php _e( 'Read Full Announcement', 'org-ecosystem' ); ?></a>
								</div>
							</div>
						</div>
					</article>
					<?php
				endwhile;
				the_posts_pagination( array( 'class' => 'pagination justify-content-center mt-5' ) );
			else :
				echo '<p class="text-center py-5">' . __( 'No announcements found.', 'org-ecosystem' ) . '</p>';
			endif;
			?>
		</div>
	</div>
</div>

<?php
get_footer();
