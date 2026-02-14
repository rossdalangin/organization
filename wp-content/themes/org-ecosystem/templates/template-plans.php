<?php
/**
 * Template Name: Membership Plans Page
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="section-plans py-5">
        <div class="container py-5">
            <div class="text-center mb-5 animate-fade-in-up">
                <h1 class="display-3 fw-bold mb-3"><?php _e( 'Choose Your Path', 'org-ecosystem' ); ?></h1>
                <p class="lead text-muted mx-auto" style="max-width: 700px;"><?php _e( 'Unlock exclusive networking opportunities, professional resources, and community growth tools by selecting a membership plan that fits your needs.', 'org-ecosystem' ); ?></p>
            </div>

            <?php
            // Include the plans logic
            include ORG_ECOSYSTEM_DIR . '/page-plans.php';
            ?>
        </div>
    </div>
</main>

<?php
get_footer();
