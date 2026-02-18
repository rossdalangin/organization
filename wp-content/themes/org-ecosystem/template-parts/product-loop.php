<?php
/**
 * Template part for displaying product loop
 */
$product_query = isset( $args['query'] ) ? $args['query'] : $GLOBALS['wp_query'];
?>
<div class="row g-4">
    <?php
    if ( $product_query->have_posts() ) :
        while ( $product_query->have_posts() ) :
            $product_query->the_post();
            ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm border-0 position-relative">
                    <?php if ( get_post_meta( get_the_ID(), '_product_is_featured', true ) ) : ?>
                        <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark shadow-sm" style="z-index: 5;"><i class="bi bi-star-fill me-1"></i> <?php _e( 'Featured', 'org-ecosystem' ); ?></span>
                    <?php endif; ?>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'medium', array( 'class' => 'card-img-top' ) ); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title fw-bold h6">
                            <?php the_title(); ?>
                            <?php if ( get_post_meta( get_the_ID(), '_product_is_solution', true ) ) : ?>
                                <i class="bi bi-patch-check-fill text-primary ms-1" title="Enterprise Solution"></i>
                            <?php endif; ?>
                        </h5>
                        <?php
                        $business_id = get_post_meta( get_the_ID(), '_product_business_id', true );
                        if ( $business_id ) : ?>
                            <p class="small text-muted mb-2"><?php _e( 'By', 'org-ecosystem' ); ?> <?php echo get_the_title( $business_id ); ?></p>
                        <?php endif; ?>
                        <p class="card-text text-muted small mb-3"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold text-primary">₱<?php echo number_format(floatval(get_post_meta(get_the_ID(), '_product_price', true)), 2); ?></span>
                            <?php if ( get_post_meta(get_the_ID(), '_product_stock', true) === 'outofstock' ) : ?>
                                <span class="badge bg-danger"><?php _e( 'Sold Out', 'org-ecosystem' ); ?></span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn btn-outline-success btn-sm w-100"><?php _e( 'View Product', 'org-ecosystem' ); ?></a>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<div class="col-12 text-center py-5"><p>' . __( 'No products found.', 'org-ecosystem' ) . '</p></div>';
    endif;
    ?>
</div>

<div class="pagination-area mt-5 w-100">
    <?php echo paginate_links( array( 'total' => $product_query->max_num_pages ) ); ?>
</div>
