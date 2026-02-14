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
			<?php get_template_part( 'template-parts/directory-loop' ); ?>
		</div>
	</div>
</div>

<?php
get_footer();
