<?php
/**
 * Theme Customizer Settings
 *
 * @package OrgEcosystem
 */

function org_ecosystem_customize_register( $wp_customize ) {
	// Branding Section
	$wp_customize->add_section( 'org_branding', array(
		'title' => __( 'Organization Branding', 'org-ecosystem' ),
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'primary_color', array(
		'default' => '#0d6efd',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
		'label' => __( 'Primary Brand Color', 'org-ecosystem' ),
		'section' => 'org_branding',
	) ) );

	// Homepage Section
	$wp_customize->add_section( 'org_homepage', array(
		'title' => __( 'Homepage Settings', 'org-ecosystem' ),
		'priority' => 40,
	) );

	$wp_customize->add_setting( 'hero_title', array(
		'default' => __( 'Empowering Our Professional Community', 'org-ecosystem' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'hero_title', array(
		'label' => __( 'Hero Title', 'org-ecosystem' ),
		'section' => 'org_homepage',
		'type' => 'text',
	) );

	// Contact Info Section
	$wp_customize->add_section( 'org_contact_info', array(
		'title' => __( 'Organization Contact Info', 'org-ecosystem' ),
		'priority' => 50,
	) );

	$wp_customize->add_setting( 'org_address', array(
		'default' => '123 Org St, City, Country',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'org_address', array(
		'label' => __( 'Address', 'org-ecosystem' ),
		'section' => 'org_contact_info',
	) );

	$wp_customize->add_setting( 'org_phone', array(
		'default' => '+1 234 567 890',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'org_phone', array(
		'label' => __( 'Phone', 'org-ecosystem' ),
		'section' => 'org_contact_info',
	) );

	$wp_customize->add_setting( 'org_email', array(
		'default' => 'info@example.org',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'org_email', array(
		'label' => __( 'Email', 'org-ecosystem' ),
		'section' => 'org_contact_info',
	) );

	// Social Links Section
	$wp_customize->add_section( 'org_social_links', array(
		'title' => __( 'Social Media Links', 'org-ecosystem' ),
		'priority' => 60,
	) );

	$socials = array(
		'facebook'  => 'Facebook',
		'twitter'   => 'Twitter/X',
		'linkedin'  => 'LinkedIn',
		'instagram' => 'Instagram',
		'youtube'   => 'YouTube',
	);

	foreach ( $socials as $key => $label ) {
		$wp_customize->add_setting( 'org_social_' . $key, array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( 'org_social_' . $key, array(
			'label' => $label . ' URL',
			'section' => 'org_social_links',
			'type' => 'url',
		) );
	}
}
add_action( 'customize_register', 'org_ecosystem_customize_register' );

/**
 * Output Customizer CSS
 */
function org_ecosystem_customizer_css() {
	$primary_color = get_theme_mod( 'primary_color', '#0d6efd' );
	?>
	<style type="text/css">
		:root {
			--bs-primary: <?php echo esc_attr( $primary_color ); ?>;
			--bs-primary-rgb: <?php echo implode(',', sscanf($primary_color, "#%02x%02x%02x")); ?>;
		}
		.btn-primary {
			background-color: var(--bs-primary);
			border-color: var(--bs-primary);
		}
		.text-primary {
			color: var(--bs-primary) !important;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'org_ecosystem_customizer_css' );
