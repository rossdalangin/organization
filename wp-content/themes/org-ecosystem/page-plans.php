<?php
/**
 * Template Name: Membership Plans
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main py-5 bg-light">
	<div class="container">
		<header class="page-header text-center mb-5">
			<h1 class="display-4 fw-bold"><?php _e( 'Membership Plans', 'org-ecosystem' ); ?></h1>
			<div class="lead text-muted">
                <?php
                $plans_intro = get_option( 'org_plans_intro' );
                if ( $plans_intro ) {
                    echo wp_kses_post( $plans_intro );
                } else {
                    _e( 'Choose the right level of access and benefits for your professional growth.', 'org-ecosystem' );
                }
                ?>
            </div>
		</header>

		<?php get_template_part( 'template-parts/plans-table' ); ?>

		<?php if ( get_theme_mod( 'show_plans_custom_cta', true ) ) : ?>
		<div class="mt-5 text-center p-5 bg-white border rounded shadow-sm">
			<h4 class="fw-bold mb-3"><?php _e( 'Need a custom solution for your team?', 'org-ecosystem' ); ?></h4>
			<p class="text-muted"><?php _e( 'We offer customized corporate packages tailored to your specific organizational needs.', 'org-ecosystem' ); ?></p>
			<a href="<?php echo esc_url( org_ecosystem_get_page_url( 'page-contact.php' ) ); ?>" class="btn btn-link text-decoration-none fw-bold"><?php _e( 'Talk to our Sales Team', 'org-ecosystem' ); ?> <i class="bi bi-arrow-right"></i></a>
		</div>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
