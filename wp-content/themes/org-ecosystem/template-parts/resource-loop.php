<?php
/**
 * Template part for displaying the resource loop
 *
 * @package OrgEcosystem
 */

$resource_query = isset( $args['query'] ) ? $args['query'] : $GLOBALS['wp_query'];
?>

<div class="row g-4">
    <?php
    if ( $resource_query->have_posts() ) :
        while ( $resource_query->have_posts() ) :
            $resource_query->the_post();
            $file_url = get_post_meta( get_the_ID(), '_resource_file_url', true );
            ?>
            <div class="col-md-6 col-lg-4 animate-on-scroll">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden border-top border-primary border-4">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                                <i class="bi bi-file-earmark-pdf h3 mb-0"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0"><?php the_title(); ?></h5>
                                <span class="badge bg-light text-muted fw-normal"><?php echo get_the_date(); ?></span>
                            </div>
                        </div>
                        <p class="text-muted small mb-4"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                        <div class="mt-auto d-flex gap-2">
                            <a href="<?php the_permalink(); ?>" class="btn btn-outline-secondary btn-sm flex-fill"><?php _e( 'Details', 'org-ecosystem' ); ?></a>
                            <?php if ( $file_url ) : ?>
                                <a href="<?php echo esc_url( $file_url ); ?>" class="btn btn-primary btn-sm flex-fill" target="_blank"><i class="bi bi-download me-1"></i><?php _e( 'Download', 'org-ecosystem' ); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<div class="col-12"><div class="bg-white p-5 rounded-3 shadow-sm text-center">' . __( 'No resources available.', 'org-ecosystem' ) . '</div></div>';
    endif;
    ?>
</div>
