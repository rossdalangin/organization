<?php
/**
 * The template for displaying the member directory archive
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="directory-header bg-primary text-white py-5 mb-5">
	<div class="container text-center">
		<h1 class="display-4 fw-bold"><?php _e( 'Member Directory', 'org-ecosystem' ); ?></h1>
		<p class="lead"><?php _e( 'Connect with our professional members and businesses.', 'org-ecosystem' ); ?></p>
	</div>
</div>

<div class="container pb-5">
	<div class="row">
		<!-- Filters Sidebar -->
		<div class="col-lg-3">
			<aside class="directory-filters bg-white p-4 shadow-sm border rounded mb-4">
				<h5 class="mb-4"><?php _e( 'Filter Results', 'org-ecosystem' ); ?></h5>
				<form id="directory-filter-form">
					<div class="mb-3">
						<label class="form-label small fw-bold"><?php _e( 'Category/Industry', 'org-ecosystem' ); ?></label>
						<?php
						wp_dropdown_categories( array(
							'show_option_all' => __( 'All Industries', 'org-ecosystem' ),
							'taxonomy'        => 'industry',
							'name'            => 'industry',
							'class'           => 'form-select',
						) );
						?>
					</div>

					<div class="mb-3">
						<label class="form-label small fw-bold"><?php _e( 'Location', 'org-ecosystem' ); ?></label>
						<?php
						wp_dropdown_categories( array(
							'show_option_all' => __( 'All Locations', 'org-ecosystem' ),
							'taxonomy'        => 'location',
							'name'            => 'location',
							'class'           => 'form-select',
						) );
						?>
					</div>

					<div class="mb-3">
						<label class="form-label small fw-bold"><?php _e( 'Membership Type', 'org-ecosystem' ); ?></label>
						<?php
						wp_dropdown_categories( array(
							'show_option_all' => __( 'All Types', 'org-ecosystem' ),
							'taxonomy'        => 'membership_level',
							'name'            => 'membership_level',
							'class'           => 'form-select',
						) );
						?>
					</div>

					<div class="mb-3">
						<label class="form-label small fw-bold"><?php _e( 'Products Offered', 'org-ecosystem' ); ?></label>
						<?php
						wp_dropdown_categories( array(
							'show_option_all' => __( 'All Products', 'org-ecosystem' ),
							'taxonomy'        => 'product_cat',
							'name'            => 'product_cat',
							'class'           => 'form-select',
						) );
						?>
					</div>

					<div class="mb-4">
						<label class="form-label small fw-bold"><?php _e( 'Search Name', 'org-ecosystem' ); ?></label>
						<input type="text" name="search" class="form-control" placeholder="<?php _e( 'Enter name...', 'org-ecosystem' ); ?>">
					</div>

					<button type="submit" class="btn btn-primary w-100"><?php _e( 'Apply Filters', 'org-ecosystem' ); ?></button>
				</form>
			</aside>
		</div>

		<!-- Members Grid -->
		<div class="col-lg-9" id="directory-results">
			<div class="row g-4">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						?>
						<div class="col-md-6 col-xl-4 animate-fade-in-up">
							<div class="card h-100 shadow-sm border-0 member-card-hover">
								<div class="card-body text-center p-4">
									<div class="mb-3">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'rounded-circle shadow-sm', 'style' => 'width: 80px; height: 80px; object-fit: cover;' ) ); ?>
										<?php else : ?>
											<div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 80px; height: 80px;">
												<i class="bi bi-person text-secondary h2 mb-0"></i>
											</div>
										<?php endif; ?>
									</div>
									<h5 class="card-title mb-1">
										<?php the_title(); ?>
										<?php if ( get_post_meta( get_the_ID(), '_member_is_verified', true ) ) : ?>
											<i class="bi bi-patch-check-fill text-primary ms-1" title="Verified Member"></i>
										<?php endif; ?>
									</h5>
									<p class="text-muted small mb-2">
										<?php echo esc_html( get_post_meta( get_the_ID(), '_member_business_name', true ) ); ?>
										<?php if ( get_post_meta( get_the_ID(), '_member_is_featured', true ) ) : ?>
											<span class="badge bg-warning text-dark ms-1 small" style="font-size: 0.65rem;"><?php _e( 'FEATURED', 'org-ecosystem' ); ?></span>
										<?php endif; ?>
									</p>
									<div class="mb-3">
										<?php the_terms( get_the_ID(), 'industry', '<span class="badge bg-light text-dark border me-1">', '</span> <span class="badge bg-light text-dark border me-1">', '</span>' ); ?>
									</div>
									<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm"><?php _e( 'View Profile', 'org-ecosystem' ); ?></a>
								</div>
							</div>
						</div>
						<?php
					endwhile;
				else :
					echo '<div class="col-12"><p class="text-center py-5">' . __( 'No members found matching your criteria.', 'org-ecosystem' ) . '</p></div>';
				endif;
				?>
			</div>

			<div class="pagination-area mt-5">
				<?php the_posts_pagination( array( 'class' => 'pagination justify-content-center' ) ); ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
