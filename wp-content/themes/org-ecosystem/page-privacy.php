<?php
/**
 * Template Name: Legal / Policy Page
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main">
    <header class="page-header py-5 bg-dark text-white mb-5">
        <div class="container">
            <h1 class="fw-bold mb-2"><?php the_title(); ?></h1>
            <p class="small text-muted mb-0"><?php printf( __( 'Last Updated: %s', 'org-ecosystem' ), get_the_modified_date() ); ?></p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="legal-content bg-white p-5 rounded-4 shadow-sm border">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
                <div class="mt-4 text-center">
                    <p class="text-muted small"><?php _e( 'Questions about our policies?', 'org-ecosystem' ); ?> <a href="<?php echo esc_url( org_ecosystem_get_page_url( 'page-contact.php' ) ); ?>"><?php _e( 'Contact Us', 'org-ecosystem' ); ?></a></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
