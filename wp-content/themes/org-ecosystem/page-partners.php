<?php
/**
 * Template Name: Partner With Us
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main">
    <header class="page-header py-5 bg-primary text-white mb-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3"><?php the_title(); ?></h1>
            <p class="lead opacity-75"><?php _e( 'Collaborate with our community and grow your brand visibility.', 'org-ecosystem' ); ?></p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-content bg-white p-5 rounded-4 shadow-sm border mb-5">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>

                <div class="partnership-tiers row g-4 text-center">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                            <h4 class="fw-bold text-secondary"><?php _e( 'Bronze Partner', 'org-ecosystem' ); ?></h4>
                            <p class="text-muted small"><?php _e( 'Directory logo placement & 1 Event guest pass.', 'org-ecosystem' ); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-primary shadow p-4 rounded-4 border-2">
                            <h4 class="fw-bold text-primary"><?php _e( 'Gold Partner', 'org-ecosystem' ); ?></h4>
                            <p class="text-muted small"><?php _e( 'Main footer logo, 5 guest passes, & Newsletter spotlight.', 'org-ecosystem' ); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                            <h4 class="fw-bold text-warning"><?php _e( 'Platinum Partner', 'org-ecosystem' ); ?></h4>
                            <p class="text-muted small"><?php _e( 'Exclusive homepage hero banner placement & Board seat access.', 'org-ecosystem' ); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
