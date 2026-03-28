<?php
/**
 * Template Name: Sales Letter & Landing Page
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="sales-letter-wrapper">
    <!-- Hero Section -->
    <section class="sl-hero py-5 text-white bg-primary position-relative overflow-hidden">
        <div class="container py-5 text-center position-relative z-index-1 animate-on-scroll">
            <h1 class="display-3 fw-bold mb-4">A Unified Ecosystem for <span class="text-accent">Elite Professionals</span></h1>
            <p class="lead mb-5 fs-4 opacity-90 mx-auto" style="max-width: 800px;">
                Bridge the gap between directory listings and real business results. Our platform automates your management while scaling your members' visibility.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#pricing" class="btn btn-light btn-lg px-5 py-3 fw-bold shadow">Get Started Today</a>
                <a href="#benefits" class="btn btn-outline-light btn-lg px-4 py-3">Learn More</a>
            </div>
        </div>
        <!-- Decorative Elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 pointer-events-none">
            <div class="position-absolute" style="top: 10%; left: 5%; font-size: 200px;"><i class="bi bi-shield-check"></i></div>
            <div class="position-absolute" style="bottom: 10%; right: 5%; font-size: 200px;"><i class="bi bi-graph-up-arrow"></i></div>
        </div>
    </section>

    <!-- Problem & Solution -->
    <section id="benefits" class="sl-benefits py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0 animate-on-scroll">
                    <h2 class="display-5 fw-bold mb-4">Why Professional Organizations Choose Us</h2>
                    <p class="lead text-muted mb-4">Traditional directories are static and boring. We provide a living, breathing ecosystem that drives actual growth.</p>

                    <div class="benefit-item d-flex gap-3 mb-4">
                        <div class="benefit-icon bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                            <i class="bi bi-patch-check-fill fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Trust by Verification</h5>
                            <p class="text-muted">Show visitors that your members are vetted with "Verified" trust badges, instantly building credibility.</p>
                        </div>
                    </div>

                    <div class="benefit-item d-flex gap-3 mb-4">
                        <div class="benefit-icon bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                            <i class="bi bi-lightning-charge-fill fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Search at Speed</h5>
                            <p class="text-muted">Users find solutions instantly with lightning-fast AJAX filtering. No more clunky, slow-loading member lists.</p>
                        </div>
                    </div>

                    <div class="benefit-item d-flex gap-3">
                        <div class="benefit-icon bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                            <i class="bi bi-shop fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Built-in Marketplace</h5>
                            <p class="text-muted">Every member gets a digital storefront, increasing ecosystem activity and providing direct ROI for their membership.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 animate-on-scroll delay-2">
                    <div class="position-relative">
                        <img src="<?php echo esc_url( get_theme_mod( 'about_image', ORG_ECOSYSTEM_URI . '/assets/images/about-placeholder.png' ) ); ?>" alt="Modern Ecosystem" class="img-fluid rounded-4 shadow-lg border border-light">
                        <div class="position-absolute bottom-0 end-0 bg-white p-4 m-4 rounded-4 shadow-sm border border-primary-soft d-none d-md-block animate-on-scroll delay-3">
                            <h6 class="fw-bold text-primary mb-2"><i class="bi bi-graph-up me-2"></i> 24% Growth</h6>
                            <p class="small text-muted mb-0">Average engagement increase for new communities.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof / Testimonials -->
    <?php if ( get_theme_mod( 'show_testimonials', true ) ) : ?>
        <section class="sl-social-proof py-5 bg-light">
            <div class="container py-5">
                <div class="text-center mb-5 animate-on-scroll">
                    <h2 class="fw-bold">Trusted by Industry Leaders</h2>
                    <p class="text-muted">Join hundreds of professional organizations scaling their impact.</p>
                </div>
                <?php get_template_part( 'template-parts/homepage/testimonials' ); ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Pricing Section -->
    <section id="pricing" class="sl-pricing py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5 animate-on-scroll">
                <h6 class="text-primary text-uppercase fw-bold letter-spacing-2 mb-2">Flexible Plans</h6>
                <h2 class="display-5 fw-bold mb-3">Choose Your Growth Path</h2>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">Transparent pricing designed for professional organizations of all sizes.</p>
            </div>
            <?php get_template_part( 'template-parts/plans-table' ); ?>
        </div>
    </section>

    <!-- Final Call to Action -->
    <section class="sl-cta py-5 bg-primary text-white text-center">
        <div class="container py-5 animate-on-scroll">
            <h2 class="display-4 fw-bold mb-4">Ready to Transform Your Organization?</h2>
            <p class="lead mb-5 opacity-90 mx-auto" style="max-width: 700px;">
                Start building your professional ecosystem today and unlock the full potential of your membership base.
            </p>
            <a href="<?php echo esc_url( org_ecosystem_get_page_url( 'page-join.php' ) ); ?>" class="btn btn-light btn-lg px-5 py-3 fw-bold">Become a Member Today</a>
        </div>
    </section>

    <!-- FAQ Section -->
    <?php if ( get_theme_mod( 'show_faq_cta', true ) ) : ?>
    <section class="sl-faq py-5 bg-light">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5 animate-on-scroll">
                        <h2 class="fw-bold">Frequently Asked Questions</h2>
                        <p class="text-muted">Got questions? We've got answers.</p>
                    </div>

                    <div class="accordion accordion-flush rounded-4 shadow-sm border overflow-hidden" id="slAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#sl-q1">
                                    How does verification work?
                                </button>
                            </h2>
                            <div id="sl-q1" class="accordion-collapse collapse" data-bs-parent="#slAccordion">
                                <div class="accordion-body text-muted">
                                    Our administrative team reviews member submissions manually to ensure all criteria are met before issuing the "Verified" badge.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#sl-q2">
                                    Can I change my plan later?
                                </button>
                            </h2>
                            <div id="sl-q2" class="accordion-collapse collapse" data-bs-parent="#slAccordion">
                                <div class="accordion-body text-muted">
                                    Yes! You can upgrade your membership level at any time from your member dashboard.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#sl-q3">
                                    Is there a limit on product listings?
                                </button>
                            </h2>
                            <div id="sl-q3" class="accordion-collapse collapse" data-bs-parent="#slAccordion">
                                <div class="accordion-body text-muted">
                                    Vendor tier members can list unlimited products in our marketplace.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-5 animate-on-scroll">
                        <p class="mb-3 text-muted">Still have questions?</p>
                        <a href="<?php echo esc_url( org_ecosystem_get_page_url( 'page-contact.php' ) ); ?>" class="btn btn-outline-primary rounded-pill">Contact Support</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</div>

<?php
get_footer();
