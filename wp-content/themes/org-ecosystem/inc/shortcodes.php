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
    ob_start();
    include ORG_ECOSYSTEM_DIR . '/archive-member.php';
    return ob_get_clean();
}
add_shortcode( 'org_directory', 'org_shortcode_directory' );

/**
 * [org_pricing_table] - Pricing Table Shortcode
 */
function org_shortcode_pricing_table( $atts ) {
    ob_start();
    include ORG_ECOSYSTEM_DIR . '/page-plans.php';
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
    include ORG_ECOSYSTEM_DIR . '/page-donation.php';
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
    );
    if ( $a['featured'] ) {
        $args['meta_query'] = array(
            array( 'key' => '_product_is_featured', 'value' => '1' )
        );
    }

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) : ?>
        <div class="row g-4">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="col-md-<?php echo 12 / $a['columns']; ?>">
                    <div class="org-card p-0">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body p-3 text-center">
                            <h6 class="fw-bold mb-1"><?php the_title(); ?></h6>
                            <p class="text-primary fw-bold small mb-3">₱ <?php echo get_post_meta(get_the_ID(), '_product_price', true); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm rounded-pill w-100"><?php _e( 'View', 'org-ecosystem' ); ?></a>
                        </div>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    <?php endif;
    return ob_get_clean();
}
add_shortcode( 'org_product_grid', 'org_shortcode_product_grid' );
