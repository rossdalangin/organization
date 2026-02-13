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

	<?php if ( get_theme_mod( 'show_stats', true ) ) : ?>
		<?php get_template_part( 'template-parts/homepage/stats' ); ?>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'show_about', true ) ) : ?>
	<section class="section-about py-5 bg-white">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<h2 class="fw-bold mb-4"><?php echo esc_html( get_theme_mod( 'about_title', __( 'About Our Organization', 'org-ecosystem' ) ) ); ?></h2>
					<p class="lead mb-4"><?php echo esc_html( get_theme_mod( 'about_subtitle', __( 'We are dedicated to fostering growth and collaboration within our professional community.', 'org-ecosystem' ) ) ); ?></p>
					<p><?php echo wp_kses_post( get_theme_mod( 'about_text', __( 'Our mission is to provide a platform where members can showcase their businesses, products, and services while gaining access to exclusive resources and networking opportunities.', 'org-ecosystem' ) ) ); ?></p>
					<div class="d-flex gap-3 mt-4">
						<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="btn btn-primary"><?php _e( 'Learn More About Us', 'org-ecosystem' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/mission' ) ); ?>" class="btn btn-outline-primary"><?php _e( 'Our Mission & Vision', 'org-ecosystem' ); ?></a>
					</div>
				</div>
				<div class="col-lg-6">
					<img src="<?php echo esc_url( get_theme_mod( 'about_image', ORG_ECOSYSTEM_URI . '/assets/images/about-placeholder.png' ) ); ?>" alt="About Us" class="img-fluid rounded shadow">
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'show_featured_mem', true ) ) : ?>
		<?php get_template_part( 'template-parts/homepage/featured-members' ); ?>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'show_featured_prod', true ) ) : ?>
		<?php get_template_part( 'template-parts/homepage/featured-products' ); ?>
	<?php endif; ?>

	<section class="membership-cta py-5 bg-primary text-white text-center">
		<div class="container py-4">
			<h2 class="display-5 fw-bold mb-4"><?php _e( 'Ready to Grow Your Business?', 'org-ecosystem' ); ?></h2>
			<p class="lead mb-5 px-lg-5"><?php _e( 'Join hundreds of professionals who are already benefiting from our exclusive network, tools, and community support.', 'org-ecosystem' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/join' ) ); ?>" class="btn btn-light btn-lg px-5 fw-bold shadow-sm"><?php _e( 'Become a Member Today', 'org-ecosystem' ); ?></a>
		</div>
	</section>

	<?php if ( get_theme_mod( 'show_events', true ) ) : ?>
		<?php get_template_part( 'template-parts/homepage/upcoming-events' ); ?>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'show_testimonials', true ) ) : ?>
		<?php get_template_part( 'template-parts/homepage/testimonials' ); ?>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'show_announcements', true ) ) : ?>
		<?php get_template_part( 'template-parts/homepage/latest-announcements' ); ?>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'show_news', true ) ) : ?>
		<?php get_template_part( 'template-parts/homepage/latest-news' ); ?>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'show_partners', true ) ) : ?>
	<section class="section-partners py-5 bg-light border-top">
		<div class="container text-center">
			<h5 class="text-muted text-uppercase mb-5 small fw-bold letter-spacing-1"><?php _e( 'Our Partners & Sponsors', 'org-ecosystem' ); ?></h5>
			<div class="d-flex flex-wrap justify-content-center gap-5 opacity-50 align-items-center">
				<?php
				$partners = explode( ',', get_theme_mod( 'org_partner_list', 'PARTNER 1, PARTNER 2, PARTNER 3, PARTNER 4, PARTNER 5' ) );
				foreach ( $partners as $partner ) : ?>
					<span class="h3 fw-bold mb-0"><?php echo esc_html( trim( $partner ) ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="newsletter-cta py-5 bg-white">
		<div class="container py-4 text-center">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<h2 class="fw-bold mb-3"><?php _e( 'Stay in the Loop', 'org-ecosystem' ); ?></h2>
					<?php if ( isset( $_GET['subscribed'] ) ) : ?>
						<div class="alert alert-success"><?php _e( 'Thank you for subscribing!', 'org-ecosystem' ); ?></div>
					<?php else : ?>
						<p class="text-muted mb-4"><?php _e( 'Subscribe to our newsletter for the latest updates, event news, and member spotlights.', 'org-ecosystem' ); ?></p>
						<form class="row g-2 justify-content-center" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
							<input type="hidden" name="action" value="org_newsletter">
							<div class="col-md-8">
								<input type="email" name="newsletter_email" class="form-control form-control-lg" placeholder="<?php _e( 'Enter your email address', 'org-ecosystem' ); ?>" required>
							</div>
							<div class="col-md-auto">
								<button type="submit" class="btn btn-primary btn-lg px-4 fw-bold"><?php _e( 'Subscribe', 'org-ecosystem' ); ?></button>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
