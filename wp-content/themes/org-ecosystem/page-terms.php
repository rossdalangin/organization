<?php
/**
 * Template Name: Terms & Conditions
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main">
    <header class="page-header py-5 bg-dark text-white mb-5">
        <div class="container">
            <h1 class="fw-bold mb-2"><?php the_title(); ?></h1>
            <p class="small text-muted mb-0"><?php printf( __( 'Effective Date: %s', 'org-ecosystem' ), get_the_date() ); ?></p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="legal-content bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
