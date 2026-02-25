<?php
/**
 * Template Name: About Us
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main py-5">
	<div class="container">
		<header class="page-header text-center mb-5">
			<h1 class="display-4 fw-bold"><?php echo esc_html( get_theme_mod( 'about_title', get_the_title() ) ); ?></h1>
			<hr class="mx-auto" style="width: 50px; height: 3px; background-color: var(--bs-primary);">
		</header>

		<div class="row g-5 align-items-center mb-5">
			<div class="col-lg-6">
				<div class="page-content lead">
					<?php
                    $about_content = get_option( 'org_about_text' ) ?: get_theme_mod( 'about_text' );
                    if ( $about_content ) {
                        echo wp_kses_post( $about_content );
                    } else {
                        while ( have_posts() ) :
                            the_post();
                            the_content();
                        endwhile;
                    }
					?>
				</div>
			</div>
			<div class="col-lg-6">
				<img src="<?php echo esc_url( get_theme_mod( 'about_image', ORG_ECOSYSTEM_URI . '/assets/images/about-placeholder.png' ) ); ?>" class="img-fluid rounded shadow" alt="About Us">
			</div>
		</div>

		<?php if ( get_theme_mod( 'show_about_cards', true ) ) : ?>
		<div class="row g-4 mt-5">
			<?php if ( $who_we_are = get_option( 'org_about_who_we_are' ) ) : ?>
			<div class="col-md-4">
				<div class="card border-0 shadow-sm p-4 text-center h-100">
					<div class="h1 text-primary mb-3"><i class="bi bi-people"></i></div>
					<h4 class="fw-bold"><?php _e( 'Who We Are', 'org-ecosystem' ); ?></h4>
					<p class="text-muted"><?php echo wp_kses_post( $who_we_are ); ?></p>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( $our_values = get_option( 'org_about_our_values' ) ) : ?>
			<div class="col-md-4">
				<div class="card border-0 shadow-sm p-4 text-center h-100">
					<div class="h1 text-primary mb-3"><i class="bi bi-shield-check"></i></div>
					<h4 class="fw-bold"><?php _e( 'Our Values', 'org-ecosystem' ); ?></h4>
					<p class="text-muted"><?php echo wp_kses_post( $our_values ); ?></p>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( $our_impact = get_option( 'org_about_our_impact' ) ) : ?>
			<div class="col-md-4">
				<div class="card border-0 shadow-sm p-4 text-center h-100">
					<div class="h1 text-primary mb-3"><i class="bi bi-graph-up-arrow"></i></div>
					<h4 class="fw-bold"><?php _e( 'Our Impact', 'org-ecosystem' ); ?></h4>
					<p class="text-muted"><?php echo wp_kses_post( $our_impact ); ?></p>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
