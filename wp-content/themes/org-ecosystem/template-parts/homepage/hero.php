<?php
/**
 * Homepage Hero Section
 */
?>
<section class="hero-section bg-primary text-white py-5 position-relative overflow-hidden">
	<div class="container py-5 position-relative z-index-1">
		<div class="row align-items-center">
			<div class="col-lg-6 animate-fade-in-up">
				<h1 class="display-3 fw-bold mb-4"><?php echo esc_html( get_theme_mod( 'hero_title', __( 'Empowering Our Professional Community', 'org-ecosystem' ) ) ); ?></h1>
				<p class="lead mb-5"><?php echo esc_html( get_theme_mod( 'hero_subtitle', __( 'Join the ultimate digital ecosystem for organizations, businesses, and professionals to grow together.', 'org-ecosystem' ) ) ); ?></p>
				<div class="d-flex flex-wrap gap-3">
					<a href="<?php echo esc_url( home_url( '/join' ) ); ?>" class="btn btn-light btn-lg px-4 fw-bold"><?php _e( 'Join Now', 'org-ecosystem' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/members' ) ); ?>" class="btn btn-outline-light btn-lg px-4"><?php _e( 'Explore Members', 'org-ecosystem' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/donate' ) ); ?>" class="btn btn-warning btn-lg px-4 text-dark fw-bold"><?php _e( 'Donate', 'org-ecosystem' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-info btn-lg px-4 text-white fw-bold"><?php _e( 'Contact', 'org-ecosystem' ); ?></a>
				</div>
			</div>
			<div class="col-lg-6 d-none d-lg-block">
				<!-- Hero Image/Graphic -->
				<img src="<?php echo esc_url( get_theme_mod( 'hero_image', ORG_ECOSYSTEM_URI . '/assets/images/hero-placeholder.png' ) ); ?>" alt="Hero" class="img-fluid rounded shadow-lg">
			</div>
		</div>
	</div>
</section>
