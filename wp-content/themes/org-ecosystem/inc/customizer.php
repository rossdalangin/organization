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

	// Typography Section
	$wp_customize->add_section( 'org_typography', array(
		'title' => __( 'Typography', 'org-ecosystem' ),
		'priority' => 35,
	) );

	$wp_customize->add_setting( 'body_font_size', array(
		'default' => '16px',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'body_font_size', array(
		'label' => __( 'Base Font Size', 'org-ecosystem' ),
		'section' => 'org_typography',
		'type' => 'text',
	) );

	// Header & Footer Layouts
	$wp_customize->add_section( 'org_layout', array(
		'title' => __( 'Header & Footer Styles', 'org-ecosystem' ),
		'priority' => 38,
	) );

	$wp_customize->add_setting( 'header_style', array(
		'default' => 'sticky',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'header_style', array(
		'label'   => __( 'Header Style', 'org-ecosystem' ),
		'section' => 'org_layout',
		'type'    => 'select',
		'choices' => array(
			'sticky' => 'Sticky Header',
			'static' => 'Static Header',
		),
	) );

	$wp_customize->add_setting( 'footer_columns', array(
		'default' => '4',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'footer_columns', array(
		'label'   => __( 'Footer Columns', 'org-ecosystem' ),
		'section' => 'org_layout',
		'type'    => 'select',
		'choices' => array(
			'1' => '1 Column',
			'2' => '2 Columns',
			'3' => '3 Columns',
			'4' => '4 Columns',
		),
	) );

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

	// Homepage Section Toggles
	$sections = array(
		'show_stats'         => __( 'Show Impact Stats', 'org-ecosystem' ),
		'show_about'         => __( 'Show About Organization', 'org-ecosystem' ),
		'show_featured_mem'  => __( 'Show Featured Members', 'org-ecosystem' ),
		'show_featured_prod' => __( 'Show Featured Products', 'org-ecosystem' ),
		'show_events'        => __( 'Show Upcoming Events', 'org-ecosystem' ),
		'show_testimonials'  => __( 'Show Testimonials', 'org-ecosystem' ),
		'show_announcements' => __( 'Show Announcements', 'org-ecosystem' ),
		'show_news'          => __( 'Show Latest News', 'org-ecosystem' ),
		'show_partners'      => __( 'Show Partner Logos', 'org-ecosystem' ),
	);

	foreach ( $sections as $id => $label ) {
		$wp_customize->add_setting( $id, array(
			'default' => true,
			'sanitize_callback' => 'org_ecosystem_sanitize_checkbox',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $label,
			'section' => 'org_homepage',
			'type'    => 'checkbox',
		) );
	}

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

	$wp_customize->add_setting( 'org_partner_list', array(
		'default' => 'PARTNER 1, PARTNER 2, PARTNER 3, PARTNER 4, PARTNER 5',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'org_partner_list', array(
		'label' => __( 'Partner Names (Comma separated)', 'org-ecosystem' ),
		'section' => 'org_contact_info',
		'type' => 'textarea',
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

	// Directory Controls
	$wp_customize->add_section( 'org_directory_controls', array(
		'title' => __( 'Directory Controls', 'org-ecosystem' ),
		'priority' => 70,
	) );

	$wp_customize->add_setting( 'directory_per_page', array(
		'default' => '12',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'directory_per_page', array(
		'label' => __( 'Members Per Page', 'org-ecosystem' ),
		'section' => 'org_directory_controls',
		'type' => 'number',
	) );

	// Membership Plans in Customizer
	$wp_customize->add_section( 'org_membership_controls', array(
		'title' => __( 'Membership Plans', 'org-ecosystem' ),
		'priority' => 80,
	) );

	$wp_customize->add_setting( 'basic_plan_price', array(
		'default' => '1500',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'basic_plan_price', array(
		'label' => __( 'Basic Plan Price', 'org-ecosystem' ),
		'section' => 'org_membership_controls',
	) );

	$wp_customize->add_setting( 'premium_plan_price', array(
		'default' => '5000',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'premium_plan_price', array(
		'label' => __( 'Premium Plan Price', 'org-ecosystem' ),
		'section' => 'org_membership_controls',
	) );
}
add_action( 'customize_register', 'org_ecosystem_customize_register' );

/**
 * Output Customizer CSS
 */
function org_ecosystem_customizer_css() {
	$primary_color = get_theme_mod( 'primary_color', '#0d6efd' );
	$body_font_size = get_theme_mod( 'body_font_size', '16px' );
	?>
	<style type="text/css">
		:root {
			--bs-primary: <?php echo esc_attr( $primary_color ); ?>;
			--bs-primary-rgb: <?php echo implode(',', sscanf($primary_color, "#%02x%02x%02x")); ?>;
			--org-body-size: <?php echo esc_attr( $body_font_size ); ?>;
		}
		body {
			font-size: var(--org-body-size);
		}
		.btn-primary {
			background-color: var(--bs-primary);
			border-color: var(--bs-primary);
		}
		.text-primary {
			color: var(--bs-primary) !important;
		}
		<?php if ( get_theme_mod( 'header_style', 'sticky' ) === 'static' ) : ?>
		.site-header { position: static !important; }
		<?php endif; ?>
	</style>
	<?php
}
add_action( 'wp_head', 'org_ecosystem_customizer_css' );

/**
 * Sanitize Checkbox
 */
function org_ecosystem_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
