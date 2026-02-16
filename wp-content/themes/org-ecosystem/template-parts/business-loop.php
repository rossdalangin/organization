<?php
/**
 * Template part for displaying the business loop
 *
 * @package OrgEcosystem
 */

$business_query = isset( $args['query'] ) ? $args['query'] : $GLOBALS['wp_query'];
?>

<div class="row g-4">
    <?php
    if ( $business_query->have_posts() ) :
        while ( $business_query->have_posts() ) :
            $business_query->the_post();
            ?>
            <div class="col-md-6 col-lg-4 animate-on-scroll">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium_large', array( 'class' => 'card-img-top', 'style' => 'height: 200px; object-fit: cover;' ) ); ?>
                    <?php else : ?>
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-shop h1 text-secondary opacity-25"></i>
                        </div>
                    <?php endif; ?>
                    <div class="card-body p-4">
                        <div class="mb-2">
                            <?php the_terms( get_the_ID(), 'industry', '<span class="badge bg-primary-subtle text-primary border-0 me-1">', '</span>', '</span>' ); ?>
                        </div>
                        <h5 class="fw-bold mb-3"><?php the_title(); ?></h5>
                        <p class="text-muted small mb-4"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="small text-muted"><i class="bi bi-geo-alt me-1"></i><?php echo esc_html( get_post_meta( get_the_ID(), '_business_location', true ) ?: __( 'Global', 'org-ecosystem' ) ); ?></span>
                            <a href="<?php the_permalink(); ?>" class="btn btn-link p-0 text-decoration-none fw-bold"><?php _e( 'View Profile', 'org-ecosystem' ); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<div class="col-12"><div class="bg-white p-5 rounded-3 shadow-sm text-center">' . __( 'No businesses found.', 'org-ecosystem' ) . '</div></div>';
    endif;
    ?>
</div>

<div class="pagination-area mt-5">
    <?php
    echo paginate_links( array(
        'total'   => $business_query->max_num_pages,
        'current' => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
        'format'  => '?paged=%#%',
    ) );
    ?>
</div>
