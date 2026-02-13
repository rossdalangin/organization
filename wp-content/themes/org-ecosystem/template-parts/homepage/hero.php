<?php
/**
 * Homepage Hero Section
 */
$hero_bg = get_theme_mod( 'hero_bg_image' );
$style = $hero_bg ? 'style="background-image: linear-gradient(rgba(13, 110, 253, 0.9), rgba(13, 110, 253, 0.9)), url(' . esc_url( $hero_bg ) . '); background-size: cover; background-position: center;"' : '';
?>
<section class="section-hero hero-section bg-primary text-white position-relative overflow-hidden" <?php echo $style; ?>>
	<div class="container py-5 position-relative z-index-1">
		<div class="row align-items-center py-5">
			<div class="col-lg-7 animate-fade-in-up">
				<h1 class="display-3 fw-bold mb-4"><?php echo esc_html( get_theme_mod( 'hero_title', __( 'Empowering Our Professional Community', 'org-ecosystem' ) ) ); ?></h1>
				<p class="lead mb-5 opacity-75 fs-4"><?php echo esc_html( get_theme_mod( 'hero_subtitle', __( 'The complete digital ecosystem for professional organizations, business networking, and member growth.', 'org-ecosystem' ) ) ); ?></p>
				<div class="d-flex flex-wrap gap-3">
					<a href="<?php echo esc_url( home_url( '/join' ) ); ?>" class="btn btn-light btn-lg px-5 fw-bold"><?php echo esc_html( get_theme_mod( 'hero_primary_cta_text', 'Join Now' ) ); ?></a>
					<a href="<?php echo esc_url( home_url( '/members' ) ); ?>" class="btn btn-outline-light btn-lg px-4"><?php echo esc_html( get_theme_mod( 'hero_secondary_cta_text', 'Explore Members' ) ); ?></a>
				</div>
			</div>
			<div class="col-lg-5 d-none d-lg-block">
				<?php
				$hero_img = get_theme_mod( 'hero_image' );
				if ( $hero_img ) : ?>
					<img src="<?php echo esc_url( $hero_img ); ?>" alt="Hero" class="img-fluid rounded-3 shadow-lg">
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
