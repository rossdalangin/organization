<?php
/**
 * Template Name: Our Mission
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main py-5">
	<div class="container">
		<header class="page-header text-center mb-5">
			<h1 class="display-4 fw-bold"><?php _e( 'Our Mission & Vision', 'org-ecosystem' ); ?></h1>
		</header>

		<div class="row g-5">
			<div class="col-md-6">
				<div class="mission-card p-5 bg-white shadow-sm border rounded h-100">
					<div class="icon mb-4"><i class="bi bi-bullseye h1 text-primary"></i></div>
					<h2 class="fw-bold"><?php _e( 'Our Mission', 'org-ecosystem' ); ?></h2>
					<p class="lead"><?php echo wp_kses_post( get_option( 'org_mission_text', get_theme_mod( 'mission_text', __( 'To empower organizations and professionals by providing a robust digital ecosystem that fosters collaboration, growth, and community engagement.', 'org-ecosystem' ) ) ) ); ?></p>
				</div>
			</div>
			<div class="col-md-6">
				<div class="vision-card p-5 bg-primary text-white shadow-sm border rounded h-100">
					<div class="icon mb-4"><i class="bi bi-eye h1 text-white"></i></div>
					<h2 class="fw-bold"><?php _e( 'Our Vision', 'org-ecosystem' ); ?></h2>
					<p class="lead"><?php echo wp_kses_post( get_option( 'org_vision_text', get_theme_mod( 'vision_text', __( 'To become the global standard for organizational networking, enabling seamless member interactions and sustainable growth for all partners.', 'org-ecosystem' ) ) ) ); ?></p>
				</div>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
