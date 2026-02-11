<?php
/**
 * The template for displaying the business directory archive
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="directory-header bg-dark text-white py-5 mb-5">
	<div class="container text-center">
		<h1 class="display-4 fw-bold"><?php _e( 'Business Directory', 'org-ecosystem' ); ?></h1>
		<p class="lead"><?php _e( 'Discover and connect with local businesses in our network.', 'org-ecosystem' ); ?></p>
	</div>
</div>

<div class="container pb-5">
	<div class="row">
		<div class="col-lg-3">
			<aside class="filters bg-white p-4 shadow-sm border rounded mb-4">
				<h5 class="mb-4"><?php _e( 'Filter Businesses', 'org-ecosystem' ); ?></h5>
				<form action="<?php echo esc_url( get_post_type_archive_link( 'business' ) ); ?>" method="get">
					<div class="mb-3">
						<label class="form-label small fw-bold"><?php _e( 'Industry', 'org-ecosystem' ); ?></label>
						<?php
						wp_dropdown_categories( array(
							'show_option_all' => __( 'All Industries', 'org-ecosystem' ),
							'taxonomy'        => 'industry',
							'name'            => 'industry',
							'class'           => 'form-select',
							'selected'        => get_query_var( 'industry' ),
						) );
						?>
					</div>
					<button type="submit" class="btn btn-primary w-100"><?php _e( 'Filter', 'org-ecosystem' ); ?></button>
				</form>
			</aside>
		</div>

		<div class="col-lg-9">
			<div class="row g-4">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						?>
						<div class="col-md-6">
							<div class="card h-100 shadow-sm border-0">
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'medium', array( 'class' => 'card-img-top' ) ); ?>
									</a>
								<?php endif; ?>
								<div class="card-body">
									<h5 class="card-title fw-bold"><?php the_title(); ?></h5>
									<p class="card-text text-muted small"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
									<?php the_terms( get_the_ID(), 'industry', '<div class="mb-3">', ' ', '</div>' ); ?>
									<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm"><?php _e( 'View Details', 'org-ecosystem' ); ?></a>
								</div>
							</div>
						</div>
						<?php
					endwhile;
					the_posts_pagination( array( 'class' => 'pagination justify-content-center mt-5' ) );
				else :
					echo '<div class="col-12"><p class="text-center py-5">' . __( 'No businesses found.', 'org-ecosystem' ) . '</p></div>';
				endif;
				?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
