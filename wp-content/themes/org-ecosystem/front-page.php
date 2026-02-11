<?php
/**
 * The front page template file
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php get_template_part( 'template-parts/homepage/hero' ); ?>

	<?php get_template_part( 'template-parts/homepage/stats' ); ?>

	<section class="about-organization py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<h2 class="fw-bold mb-4"><?php echo esc_html( get_theme_mod( 'about_title', __( 'About Our Organization', 'org-ecosystem' ) ) ); ?></h2>
					<p class="lead mb-4"><?php echo esc_html( get_theme_mod( 'about_subtitle', __( 'We are dedicated to fostering growth and collaboration within our professional community.', 'org-ecosystem' ) ) ); ?></p>
					<p><?php echo wp_kses_post( get_theme_mod( 'about_text', __( 'Our mission is to provide a platform where members can showcase their businesses, products, and services while gaining access to exclusive resources and networking opportunities.', 'org-ecosystem' ) ) ); ?></p>
					<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="btn btn-primary mt-3"><?php _e( 'Learn More About Us', 'org-ecosystem' ); ?></a>
				</div>
				<div class="col-lg-6">
					<img src="<?php echo esc_url( get_theme_mod( 'about_image', ORG_ECOSYSTEM_URI . '/assets/images/about-placeholder.png' ) ); ?>" alt="About Us" class="img-fluid rounded shadow">
				</div>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/homepage/featured-members' ); ?>

	<section class="membership-cta py-5 bg-primary text-white text-center">
		<div class="container py-4">
			<h2 class="display-5 fw-bold mb-4"><?php _e( 'Ready to Grow Your Business?', 'org-ecosystem' ); ?></h2>
			<p class="lead mb-5 px-lg-5"><?php _e( 'Join hundreds of professionals who are already benefiting from our exclusive network, tools, and community support.', 'org-ecosystem' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/join' ) ); ?>" class="btn btn-light btn-lg px-5 fw-bold"><?php _e( 'Become a Member Today', 'org-ecosystem' ); ?></a>
		</div>
	</section>

	<?php get_template_part( 'template-parts/homepage/latest-news' ); ?>

	<section class="partner-logos py-5 bg-white border-top">
		<div class="container text-center">
			<h5 class="text-muted text-uppercase mb-5 small fw-bold"><?php _e( 'Our Partners & Sponsors', 'org-ecosystem' ); ?></h5>
			<div class="d-flex flex-wrap justify-content-center gap-5 opacity-50">
				<!-- Placeholder for partner logos -->
				<span class="h3 fw-bold">PARTNER 1</span>
				<span class="h3 fw-bold">PARTNER 2</span>
				<span class="h3 fw-bold">PARTNER 3</span>
				<span class="h3 fw-bold">PARTNER 4</span>
				<span class="h3 fw-bold">PARTNER 5</span>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
