<?php
/**
 * Template Name: Contact Page
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="section-contact py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-5 animate-fade-in-up">
                    <h1 class="display-4 fw-bold mb-4"><?php _e( 'Get in Touch', 'org-ecosystem' ); ?></h1>
                    <p class="lead text-muted mb-5"><?php _e( 'Have questions about our organization or membership? We are here to help you grow.', 'org-ecosystem' ); ?></p>

                    <div class="contact-info">
                        <div class="d-flex mb-4">
                            <div class="icon-box bg-primary text-white rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1"><?php _e( 'Office Address', 'org-ecosystem' ); ?></h6>
                                <p class="text-muted small mb-0"><?php echo esc_html( get_theme_mod( 'org_address', '123 Org St, City, Country' ) ); ?></p>
                            </div>
                        </div>
                        <div class="d-flex mb-4">
                            <div class="icon-box bg-primary text-white rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1"><?php _e( 'Phone Number', 'org-ecosystem' ); ?></h6>
                                <p class="text-muted small mb-0"><?php echo esc_html( get_theme_mod( 'org_phone', '+1 234 567 890' ) ); ?></p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="icon-box bg-primary text-white rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1"><?php _e( 'Official Email', 'org-ecosystem' ); ?></h6>
                                <p class="text-muted small mb-0"><?php echo esc_html( get_theme_mod( 'org_email', 'info@example.org' ) ); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5">
                        <?php
                        // Include the contact form logic
                        include ORG_ECOSYSTEM_DIR . '/page-contact.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
