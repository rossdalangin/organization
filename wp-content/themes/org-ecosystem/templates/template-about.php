<?php
/**
 * Template Name: About Page
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="section-about py-5">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 animate-fade-in-up">
                    <h1 class="display-4 fw-bold mb-4"><?php echo esc_html( get_theme_mod( 'about_title', __( 'Our Story & Purpose', 'org-ecosystem' ) ) ); ?></h1>
                    <div class="fs-5 text-muted mb-5">
                        <?php echo wp_kses_post( get_theme_mod( 'about_text', __( 'We are building a future where professional organizations leverage technology to empower every member.', 'org-ecosystem' ) ) ); ?>
                    </div>

                    <div class="row g-4">
                        <div class="col-6">
                            <h2 class="h1 fw-bold text-primary mb-0">15+</h2>
                            <p class="text-muted small fw-bold text-uppercase"><?php _e( 'Years of Impact', 'org-ecosystem' ); ?></p>
                        </div>
                        <div class="col-6">
                            <h2 class="h1 fw-bold text-primary mb-0">500+</h2>
                            <p class="text-muted small fw-bold text-uppercase"><?php _e( 'Active Members', 'org-ecosystem' ); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <img src="<?php echo esc_url( get_theme_mod( 'about_image', ORG_ECOSYSTEM_URI . '/assets/images/about-placeholder.png' ) ); ?>" class="img-fluid rounded-4 shadow-lg border p-2 bg-white" alt="About Us">
                </div>
            </div>
        </div>
    </div>

    <!-- Mission/Vision Mini Section -->
    <div class="section-mission py-5 bg-light">
        <div class="container py-5 text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <i class="bi bi-bullseye display-1 text-primary mb-4"></i>
                    <h2 class="fw-bold mb-4"><?php _e( 'Our Mission', 'org-ecosystem' ); ?></h2>
                    <p class="lead text-muted"><?php echo esc_html( get_theme_mod( 'mission_text', __( 'To empower professional communities through structured networking, business showcasing, and digital growth tools.', 'org-ecosystem' ) ) ); ?></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
