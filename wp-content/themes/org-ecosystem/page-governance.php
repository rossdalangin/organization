<?php
/**
 * Template Name: Governance & Leadership
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main">
    <header class="page-header py-5 bg-light border-bottom mb-5">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3"><?php the_title(); ?></h1>
            <p class="lead text-muted"><?php _e( 'The leaders and governance structure driving our organization forward.', 'org-ecosystem' ); ?></p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="page-content bg-white p-5 rounded-4 shadow-sm border">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary text-white mb-4">
                    <h5 class="fw-bold mb-3"><?php _e( 'Our Mission', 'org-ecosystem' ); ?></h5>
                    <p class="small opacity-75"><?php echo wp_kses_post( get_option( 'org_mission_text' ) ); ?></p>
                    <a href="<?php echo esc_url( org_ecosystem_get_page_url( 'page-mission.php' ) ); ?>" class="btn btn-light btn-sm fw-bold"><?php _e( 'Read Vision Statement', 'org-ecosystem' ); ?></a>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <h5 class="fw-bold mb-3"><?php _e( 'Contact Secretariat', 'org-ecosystem' ); ?></h5>
                    <p class="small text-muted mb-4"><?php _e( 'For inquiries regarding governance or official matters.', 'org-ecosystem' ); ?></p>
                    <a href="<?php echo esc_url( org_ecosystem_get_page_url( 'page-contact.php' ) ); ?>" class="btn btn-outline-primary w-100"><?php _e( 'Official Contact', 'org-ecosystem' ); ?></a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
