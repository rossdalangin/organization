<?php
/**
 * Template part for displaying event loop
 */
$event_query = isset( $args['query'] ) ? $args['query'] : $GLOBALS['wp_query'];
?>
<div class="row g-4">
    <?php
    if ( $event_query->have_posts() ) :
        while ( $event_query->have_posts() ) :
            $event_query->the_post();
            $date = get_post_meta( get_the_ID(), '_event_date', true );
            ?>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0 overflow-hidden position-relative">
                    <?php if ( get_post_meta( get_the_ID(), '_event_is_upcoming', true ) ) : ?>
                        <span class="position-absolute top-0 end-0 m-3 badge bg-danger text-white shadow-sm" style="z-index: 5;"><i class="bi bi-fire me-1"></i> <?php _e( 'NEXT UP', 'org-ecosystem' ); ?></span>
                    <?php endif; ?>
                    <div class="row g-0">
                        <div class="col-md-4">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium', array( 'class' => 'img-fluid h-100 w-100', 'style' => 'object-fit: cover;' ) ); ?>
                            <?php else : ?>
                                <div class="bg-light h-100 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-event text-warning display-4"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <?php if ( $date ) : ?>
                                    <div class="text-primary fw-bold small mb-2"><i class="bi bi-clock me-1"></i> <?php echo date( 'F j, Y', strtotime( $date ) ); ?></div>
                                <?php endif; ?>
                                <h5 class="card-title fw-bold"><?php the_title(); ?></h5>
                                <p class="card-text text-muted small"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-warning btn-sm text-dark fw-bold"><?php _e( 'Event Details', 'org-ecosystem' ); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<div class="col-12 text-center py-5"><p>' . __( 'No events found.', 'org-ecosystem' ) . '</p></div>';
    endif;
    ?>
</div>

<div class="pagination-area mt-5 w-100">
    <?php echo paginate_links( array( 'total' => $event_query->max_num_pages ) ); ?>
</div>
