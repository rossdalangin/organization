<?php
/**
 * The template for displaying the member directory archive
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="directory-header bg-primary text-white py-5 mb-5 position-relative overflow-hidden">
	<div class="container text-center py-4 position-relative z-index-1">
		<h1 class="display-3 fw-bold mb-3"><?php _e( 'Member Directory', 'org-ecosystem' ); ?></h1>
		<p class="lead fs-4 opacity-75"><?php _e( 'Connect with our professional members and businesses across the globe.', 'org-ecosystem' ); ?></p>
	</div>
</div>

<div class="container pb-5">
	<div class="row">
		<!-- Filters Sidebar -->
		<div class="col-lg-3">
			<aside class="filter-sidebar mb-4 sticky-top" style="top: 100px;">
				<h5 class="filter-group-title"><?php _e( 'Advanced Filtering', 'org-ecosystem' ); ?></h5>
				<form id="directory-filter-form">
					<div class="mb-4">
						<label class="form-label small fw-bold text-uppercase letter-spacing-1"><?php _e( 'Search by Name', 'org-ecosystem' ); ?></label>
						<div class="input-group">
							<span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
							<input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="<?php _e( 'Member name...', 'org-ecosystem' ); ?>">
						</div>
					</div>

					<div class="mb-3">
						<label class="form-label small fw-bold text-uppercase"><?php _e( 'Industry', 'org-ecosystem' ); ?></label>
						<?php
						wp_dropdown_categories( array(
							'show_option_all' => __( 'All Industries', 'org-ecosystem' ),
							'taxonomy'        => 'industry',
							'name'            => 'industry',
							'class'           => 'form-select shadow-none',
						) );
						?>
					</div>

					<div class="mb-3">
						<label class="form-label small fw-bold text-uppercase"><?php _e( 'Location', 'org-ecosystem' ); ?></label>
						<?php
						wp_dropdown_categories( array(
							'show_option_all' => __( 'All Locations', 'org-ecosystem' ),
							'taxonomy'        => 'location',
							'name'            => 'location',
							'class'           => 'form-select shadow-none',
						) );
						?>
					</div>

					<div class="mb-3">
						<label class="form-label small fw-bold text-uppercase"><?php _e( 'Membership Tier', 'org-ecosystem' ); ?></label>
						<?php
						wp_dropdown_categories( array(
							'show_option_all' => __( 'All Levels', 'org-ecosystem' ),
							'taxonomy'        => 'membership_level',
							'name'            => 'membership_level',
							'class'           => 'form-select shadow-none',
						) );
						?>
					</div>

					<button type="submit" class="btn btn-primary w-100 mt-3 py-2 fw-bold"><?php _e( 'Find Members', 'org-ecosystem' ); ?></button>
					<button type="reset" class="btn btn-link w-100 mt-2 text-decoration-none text-muted small" onclick="window.location.reload();"><?php _e( 'Clear All Filters', 'org-ecosystem' ); ?></button>
				</form>
			</aside>
		</div>

		<!-- Members Grid -->
		<div class="col-lg-9" id="directory-results">
			<div class="directory-grid">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						?>
						<div class="animate-fade-in-up">
							<div class="org-card p-0">
								<div class="org-card-body text-center">
									<div class="member-avatar-wrapper mb-3 position-relative d-inline-block">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'rounded-circle shadow-sm border p-1 bg-white', 'style' => 'width: 100px; height: 100px; object-fit: cover;' ) ); ?>
										<?php else : ?>
											<div class="bg-light rounded-circle d-flex align-items-center justify-content-center shadow-sm border p-1" style="width: 100px; height: 100px;">
												<i class="bi bi-person text-secondary display-6"></i>
											</div>
										<?php endif; ?>

										<?php if ( get_post_meta( get_the_ID(), '_member_is_verified', true ) ) : ?>
											<span class="position-absolute bottom-0 end-0 bg-white rounded-circle p-1 shadow-sm" style="width: 30px; height: 30px;" title="Verified">
												<i class="bi bi-patch-check-fill text-primary"></i>
											</span>
										<?php endif; ?>
									</div>

									<h4 class="h5 mb-1"><?php the_title(); ?></h4>
									<p class="text-primary fw-bold small mb-3"><?php echo esc_html( get_post_meta( get_the_ID(), '_member_business_name', true ) ); ?></p>

									<div class="mb-4">
										<?php
										$industries = get_the_terms( get_the_ID(), 'industry' );
										if ( $industries ) :
											foreach ( $industries as $ind ) : ?>
												<span class="badge bg-light text-dark border-0 shadow-none py-2 px-3 rounded-pill me-1 mb-1"><?php echo esc_html( $ind->name ); ?></span>
											<?php endforeach;
										endif; ?>
									</div>

									<div class="d-grid">
										<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary rounded-pill"><?php _e( 'View Full Profile', 'org-ecosystem' ); ?></a>
									</div>

									<?php if ( get_post_meta( get_the_ID(), '_member_is_featured', true ) ) : ?>
										<div class="mt-3">
											<span class="badge-featured"><?php _e( 'Partner Spotlight', 'org-ecosystem' ); ?></span>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<?php
					endwhile;
				else :
					echo '<div class="col-12"><div class="bg-white p-5 rounded-3 shadow-sm text-center">' . __( 'No members found matching your search.', 'org-ecosystem' ) . '</div></div>';
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
