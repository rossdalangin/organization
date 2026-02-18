<?php
/**
 * Theme Shortcodes
 *
 * @package OrgEcosystem
 */

/**
 * [org_directory] - Member Directory Shortcode
 */
function org_shortcode_directory( $atts ) {
    $paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
    $query = new WP_Query( array(
        'post_type' => 'member',
        'posts_per_page' => get_option( 'org_directory_per_page', 12 ),
        'post_status' => 'publish',
        'paged' => $paged,
        'meta_query' => array(
            array(
                'key' => '_member_status',
                'value' => 'active',
            ),
        ),
    ) );

    ob_start();
    get_template_part( 'template-parts/directory-loop', null, array( 'query' => $query ) );
    return ob_get_clean();
}
add_shortcode( 'org_directory', 'org_shortcode_directory' );

/**
 * [org_pricing_table] - Pricing Table Shortcode
 */
function org_shortcode_pricing_table( $atts ) {
    ob_start();
    get_template_part( 'template-parts/plans-table' );
    return ob_get_clean();
}
add_shortcode( 'org_pricing_table', 'org_shortcode_pricing_table' );

/**
 * [org_latest_announcements] - Announcements Grid
 */
function org_shortcode_announcements( $atts ) {
    $a = shortcode_atts( array(
        'count' => 3,
        'columns' => 3,
    ), $atts );

    ob_start();
    $query = new WP_Query( array(
        'post_type' => 'announcement',
        'posts_per_page' => $a['count'],
    ) );

    if ( $query->have_posts() ) : ?>
        <div class="row g-4">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="col-md-<?php echo 12 / $a['columns']; ?>">
                    <div class="card h-100 shadow-sm border-0 bg-white rounded-4 overflow-hidden border-start border-primary border-4">
                        <div class="card-body p-4">
                            <span class="badge bg-light text-primary mb-2"><?php echo get_the_date(); ?></span>
                            <h5 class="fw-bold mb-3"><?php the_title(); ?></h5>
                            <p class="text-muted small"><?php echo wp_trim_words( get_the_content(), 15 ); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-link p-0 text-decoration-none small fw-bold"><?php _e( 'Read More', 'org-ecosystem' ); ?></a>
                        </div>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    <?php endif;
    return ob_get_clean();
}
add_shortcode( 'org_latest_announcements', 'org_shortcode_announcements' );

/**
 * [org_donation_form] - Donation Form Shortcode
 */
function org_shortcode_donation_form( $atts ) {
    ob_start();
    get_template_part( 'template-parts/donation-form' );
    return ob_get_clean();
}
add_shortcode( 'org_donation_form', 'org_shortcode_donation_form' );

/**
 * [org_product_grid] - Product Grid Shortcode
 */
function org_shortcode_product_grid( $atts ) {
    $a = shortcode_atts( array(
        'count' => 4,
        'columns' => 4,
        'featured' => false,
    ), $atts );

    ob_start();
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $a['count'],
        'meta_query' => array(
            array(
                'key' => '_member_status', // Linked status check
                'value' => 'active',
            ),
        ),
    );
    if ( $a['featured'] ) {
        $args['meta_query'] = array(
            array( 'key' => '_product_is_featured', 'value' => '1' )
        );
    }

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        get_template_part( 'template-parts/product-loop', null, array( 'query' => $query ) );
    } else {
        echo '<p class="text-center">' . __( 'No products listed.', 'org-ecosystem' ) . '</p>';
    }

    return ob_get_clean();
}
add_shortcode( 'org_product_grid', 'org_shortcode_product_grid' );

/**
 * [org_business_grid] - Business Directory Grid
 */
function org_shortcode_business_grid( $atts ) {
    $a = shortcode_atts( array(
        'count' => 9,
        'paged' => true,
    ), $atts );

    $paged = $a['paged'] ? max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ) : 1;
    $query = new WP_Query( array(
        'post_type' => 'business',
        'posts_per_page' => $a['count'],
        'paged' => $paged,
        'meta_query' => array(
            array(
                'key' => '_member_status', // Inherited status logic or manual assignment
                'value' => 'active',
            ),
        ),
    ) );

    ob_start();
    get_template_part( 'template-parts/business-loop', null, array( 'query' => $query ) );
    return ob_get_clean();
}
add_shortcode( 'org_business_grid', 'org_shortcode_business_grid' );

/**
 * [org_event_grid] - Upcoming Events Grid
 */
function org_shortcode_event_grid( $atts ) {
    $a = shortcode_atts( array(
        'count' => 6,
    ), $atts );

    $query = new WP_Query( array(
        'post_type' => 'event',
        'posts_per_page' => $a['count'],
        'meta_key' => '_event_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_event_date',
                'value' => date('Y-m-d'),
                'compare' => '>=',
                'type' => 'DATE'
            )
        )
    ) );

    ob_start();
    get_template_part( 'template-parts/event-loop', null, array( 'query' => $query ) );
    return ob_get_clean();
}
add_shortcode( 'org_event_grid', 'org_shortcode_event_grid' );

/**
 * [org_resource_grid] - Resources Library Grid
 */
function org_shortcode_resource_grid( $atts ) {
    $a = shortcode_atts( array(
        'count' => 12,
    ), $atts );

    $query = new WP_Query( array(
        'post_type' => 'resource',
        'posts_per_page' => $a['count'],
    ) );

    ob_start();
    get_template_part( 'template-parts/resource-loop', null, array( 'query' => $query ) );
    return ob_get_clean();
}
add_shortcode( 'org_resource_grid', 'org_shortcode_resource_grid' );

/**
 * [org_job_list] - Job Board List
 */
function org_shortcode_job_list( $atts ) {
    $a = shortcode_atts( array(
        'count' => 10,
    ), $atts );

    $query = new WP_Query( array(
        'post_type' => 'job',
        'posts_per_page' => $a['count'],
    ) );

    ob_start();
    get_template_part( 'template-parts/job-loop', null, array( 'query' => $query ) );
    return ob_get_clean();
}
add_shortcode( 'org_job_list', 'org_shortcode_job_list' );
