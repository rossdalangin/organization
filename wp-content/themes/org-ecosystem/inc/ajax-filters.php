<?php
/**
 * AJAX Filtering for Member Directory
 *
 * @package OrgEcosystem
 */

function org_ecosystem_directory_filter() {
	$industry = isset( $_POST['industry'] ) ? sanitize_text_field( $_POST['industry'] ) : '';
	$location = isset( $_POST['location'] ) ? sanitize_text_field( $_POST['location'] ) : '';
	$level = isset( $_POST['membership_level'] ) ? sanitize_text_field( $_POST['membership_level'] ) : '';
	$prod_cat = isset( $_POST['product_cat'] ) ? sanitize_text_field( $_POST['product_cat'] ) : '';
	$search = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';

	$args = array(
		'post_type' => 'member',
		'posts_per_page' => 12,
		'post_status' => 'publish',
		's' => $search,
		'tax_query' => array( 'relation' => 'AND' ),
	);

	if ( $industry && $industry !== '0' ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'industry',
			'field' => 'term_id',
			'terms' => $industry,
		);
	}

	if ( $location && $location !== '0' ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'location',
			'field' => 'term_id',
			'terms' => $location,
		);
	}

	if ( $level && $level !== '0' ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'membership_level',
			'field' => 'term_id',
			'terms' => $level,
		);
	}

	if ( $prod_cat && $prod_cat !== '0' ) {
		// To filter members by products they offer, we need a meta query or a specialized taxonomy.
		// Since we have a 'product' CPT linked to 'member' via '_product_business_id',
		// we first find all products in that category, get their business IDs, and then filter members.
		$product_query = new WP_Query( array(
			'post_type' => 'product',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'term_id',
					'terms' => $prod_cat,
				)
			),
			'fields' => 'ids',
		) );

		$business_ids = array();
		if ( $product_query->have_posts() ) {
			foreach ( $product_query->posts as $prod_id ) {
				$bid = get_post_meta( $prod_id, '_product_business_id', true );
				if ( $bid ) $business_ids[] = $bid;
			}
		}

		if ( ! empty( $business_ids ) ) {
			$args['post__in'] = array_unique( $business_ids );
		} else {
			$args['post__in'] = array( 0 ); // Return no results
		}
	}

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) :
		echo '<div class="row g-4">';
		while ( $query->have_posts() ) : $query->the_post();
			?>
			<div class="col-md-6 col-xl-4">
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
		echo '</div>';

		// Return Pagination
		echo '<div class="pagination-area mt-5">';
		echo paginate_links( array(
			'total'   => $query->max_num_pages,
			'current' => max( 1, get_query_var( 'paged' ) ),
			'format'  => '?paged=%#%',
			'type'    => 'list',
		) );
		echo '</div>';

		wp_reset_postdata();
	else :
		echo '<div class="col-12"><p class="text-center py-5">' . __( 'No members found matching your criteria.', 'org-ecosystem' ) . '</p></div>';
	endif;

	wp_die();
}
add_action( 'wp_ajax_directory_filter', 'org_ecosystem_directory_filter' );
add_action( 'wp_ajax_nopriv_directory_filter', 'org_ecosystem_directory_filter' );
