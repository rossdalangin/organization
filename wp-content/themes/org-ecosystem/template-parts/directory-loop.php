<?php
/**
 * Template part for displaying the member directory loop
 *
 * @package OrgEcosystem
 */

$directory_query = isset( $args['query'] ) ? $args['query'] : $GLOBALS['wp_query'];
?>

<div class="row g-4">
    <?php
    if ( $directory_query->have_posts() ) :
        while ( $directory_query->have_posts() ) :
            $directory_query->the_post();
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
        wp_reset_postdata();
    else :
        echo '<div class="col-12"><div class="bg-white p-5 rounded-3 shadow-sm text-center">' . __( 'No members found.', 'org-ecosystem' ) . '</div></div>';
    endif;
    ?>
</div>

<div class="pagination-area mt-5">
    <?php
    echo paginate_links( array(
        'total'   => $directory_query->max_num_pages,
        'current' => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
        'format'  => '?paged=%#%',
    ) );
    ?>
</div>
