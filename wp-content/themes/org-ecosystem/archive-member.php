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
                                    <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm rounded-pill"><?php _e( 'View Profile', 'org-ecosystem' ); ?></a>
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
