<?php
/**
 * Template part for displaying the job loop
 *
 * @package OrgEcosystem
 */

$job_query = isset( $args['query'] ) ? $args['query'] : $GLOBALS['wp_query'];
?>

<div class="row g-4">
    <?php
    if ( $job_query->have_posts() ) :
        while ( $job_query->have_posts() ) :
            $job_query->the_post();
            $salary = get_post_meta( get_the_ID(), '_job_salary', true );
            $type = get_post_meta( get_the_ID(), '_job_type', true );
            ?>
            <div class="col-12 animate-on-scroll">
                <div class="card shadow-sm border-0 rounded-4 p-4 job-list-item">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="fw-bold mb-0 me-3"><?php the_title(); ?></h5>
                                <span class="badge bg-success-subtle text-success me-2"><?php echo esc_html( ucfirst($type) ); ?></span>
                                <?php if ( get_post_meta( get_the_ID(), '_job_is_featured', true ) === '1' ) : ?>
                                    <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i> <?php _e( 'Featured', 'org-ecosystem' ); ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="text-muted small mb-0"><i class="bi bi-building me-1"></i><?php echo get_the_author(); ?> &bull; <i class="bi bi-geo-alt me-1"></i><?php
                                $locations = get_the_terms( get_the_ID(), 'location' );
                                echo ( $locations && ! is_wp_error( $locations ) ) ? esc_html( $locations[0]->name ) : 'Remote';
                            ?></p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <?php if ( $salary ) : ?>
                                <div class="fw-bold text-dark mb-2">₱ <?php echo esc_html( $salary ); ?></div>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary rounded-pill px-4"><?php _e( 'Apply Now', 'org-ecosystem' ); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<div class="col-12"><div class="bg-white p-5 rounded-3 shadow-sm text-center">' . __( 'No job openings at this time.', 'org-ecosystem' ) . '</div></div>';
    endif;
    ?>
</div>
