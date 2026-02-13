<?php
/**
 * Theme Customizer Settings
 *
 * @package OrgEcosystem
 */

function org_ecosystem_customize_register( $wp_customize ) {
	// 1. Branding Section
	$wp_customize->add_section( 'org_branding', array(
		'title' => __( 'Brand Identity & Colors', 'org-ecosystem' ),
		'priority' => 30,
	) );

	$colors = array(
		'primary_color'    => array( 'label' => __( 'Primary Brand Color', 'org-ecosystem' ), 'default' => '#0d6efd' ),
		'secondary_color'  => array( 'label' => __( 'Secondary Color', 'org-ecosystem' ), 'default' => '#6c757d' ),
		'accent_color'     => array( 'label' => __( 'Accent Color', 'org-ecosystem' ), 'default' => '#0dcaf0' ),
		'header_bg_color'  => array( 'label' => __( 'Header Background', 'org-ecosystem' ), 'default' => '#ffffff' ),
		'footer_bg_color'  => array( 'label' => __( 'Footer Background', 'org-ecosystem' ), 'default' => '#111111' ),
		'hero_text_color'  => array( 'label' => __( 'Hero Text Color', 'org-ecosystem' ), 'default' => '#ffffff' ),
	);

	foreach ( $colors as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default' => $data['default'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
			'label' => $data['label'],
			'section' => 'org_branding',
		) ) );
	}

	// 2. Typography (Professional Expansion)
	$wp_customize->add_section( 'org_typography', array(
		'title' => __( 'Typography & Google Fonts', 'org-ecosystem' ),
		'priority' => 35,
	) );

	$font_choices = array(
		'Inter' => 'Inter',
		'Plus Jakarta Sans' => 'Plus Jakarta Sans',
		'Poppins' => 'Poppins',
		'Montserrat' => 'Montserrat',
		'Roboto' => 'Roboto',
		'Open Sans' => 'Open Sans',
		'Playfair Display' => 'Playfair Display',
		'Lato' => 'Lato',
		'Oswald' => 'Oswald',
		'Lora' => 'Lora',
		'Work Sans' => 'Work Sans',
		'Quicksand' => 'Quicksand',
	);

	// Body Font
	$wp_customize->add_setting( 'body_font_family', array(
		'default' => 'Inter',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'body_font_family', array(
		'label'   => __( 'Body Font Family', 'org-ecosystem' ),
		'section' => 'org_typography',
		'type'    => 'select',
		'choices' => $font_choices,
	) );

	$wp_customize->add_setting( 'body_font_size', array(
		'default' => '16',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'body_font_size', array(
		'label' => __( 'Body Font Size (px)', 'org-ecosystem' ),
		'section' => 'org_typography',
		'type' => 'number',
	) );

	$wp_customize->add_setting( 'body_line_height', array(
		'default' => '1.6',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'body_line_height', array(
		'label' => __( 'Body Line Height', 'org-ecosystem' ),
		'section' => 'org_typography',
		'type' => 'text',
	) );

	// Heading Font
	$wp_customize->add_setting( 'heading_font_family', array(
		'default' => 'Plus Jakarta Sans',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'heading_font_family', array(
		'label'   => __( 'Heading Font Family', 'org-ecosystem' ),
		'section' => 'org_typography',
		'type'    => 'select',
		'choices' => $font_choices,
	) );

	$wp_customize->add_setting( 'heading_font_weight', array(
		'default' => '800',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'heading_font_weight', array(
		'label'   => __( 'Heading Font Weight', 'org-ecosystem' ),
		'section' => 'org_typography',
		'type'    => 'select',
		'choices' => array(
			'400' => 'Regular',
			'500' => 'Medium',
			'600' => 'Semi-Bold',
			'700' => 'Bold',
			'800' => 'Extra-Bold',
			'900' => 'Black',
		),
	) );

	// 3. Layout & Spacing
	$wp_customize->add_section( 'org_layout', array(
		'title' => __( 'Layout & Spacing', 'org-ecosystem' ),
		'priority' => 38,
	) );

	$wp_customize->add_setting( 'container_width', array(
		'default' => '1200',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'container_width', array(
		'label' => __( 'Max Container Width (px)', 'org-ecosystem' ),
		'section' => 'org_layout',
		'type' => 'number',
	) );

	// 4. Homepage Content
	$wp_customize->add_section( 'org_homepage', array(
		'title' => __( 'Homepage Content', 'org-ecosystem' ),
		'priority' => 40,
	) );

	$wp_customize->add_setting( 'hero_title', array(
		'default' => __( 'Empowering Our Professional Community', 'org-ecosystem' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	) );
	$wp_customize->add_control( 'hero_title', array(
		'label' => __( 'Hero Title', 'org-ecosystem' ),
		'section' => 'org_homepage',
		'type' => 'text',
	) );

	$wp_customize->add_setting( 'hero_subtitle', array(
		'default' => __( 'The complete digital ecosystem for professional organizations, business networking, and member growth.', 'org-ecosystem' ),
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport' => 'postMessage',
	) );
	$wp_customize->add_control( 'hero_subtitle', array(
		'label' => __( 'Hero Subtitle', 'org-ecosystem' ),
		'section' => 'org_homepage',
		'type' => 'textarea',
	) );

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

	// 5. Revenue
	$wp_customize->add_section( 'org_revenue', array(
		'title' => __( 'Revenue & Lead Protection', 'org-ecosystem' ),
		'priority' => 90,
	) );

	$wp_customize->add_setting( 'protect_leads', array(
		'default' => false,
		'sanitize_callback' => 'org_ecosystem_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'protect_leads', array(
		'label' => __( 'Enable Lead Gating', 'org-ecosystem' ),
		'section' => 'org_revenue',
		'type'    => 'checkbox',
	) );

	// Sponsor Ads
	$wp_customize->add_section( 'org_sponsor_ads', array(
		'title' => __( 'Sidebar Sponsor Ads', 'org-ecosystem' ),
		'priority' => 100,
	) );

	$wp_customize->add_setting( 'sponsor_banner_image', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sponsor_banner_image', array(
		'label' => __( 'Sponsor Banner Image', 'org-ecosystem' ),
		'section' => 'org_sponsor_ads',
	) ) );

	$wp_customize->add_setting( 'sponsor_banner_link', array(
		'default' => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'sponsor_banner_link', array(
		'label' => __( 'Sponsor Target URL', 'org-ecosystem' ),
		'section' => 'org_sponsor_ads',
		'type' => 'url',
	) );
}
add_action( 'customize_register', 'org_ecosystem_customize_register' );

/**
 * Output Dynamic Customizer CSS
 */
function org_ecosystem_customizer_css() {
	$primary_color = get_theme_mod( 'primary_color', '#0d6efd' );
	$secondary_color = get_theme_mod( 'secondary_color', '#6c757d' );
	$accent_color = get_theme_mod( 'accent_color', '#0dcaf0' );

	$body_font = get_theme_mod( 'body_font_family', 'Inter' );
	$heading_font = get_theme_mod( 'heading_font_family', 'Plus Jakarta Sans' );
	$heading_weight = get_theme_mod( 'heading_font_weight', '800' );

	$body_size = get_theme_mod( 'body_font_size', '16' );
	$body_lh = get_theme_mod( 'body_line_height', '1.6' );
	$container_width = get_theme_mod( 'container_width', '1200' );
	?>
	<style type="text/css">
		:root {
			--primary-color: <?php echo esc_attr( $primary_color ); ?>;
			--secondary-color: <?php echo esc_attr( $secondary_color ); ?>;
			--accent-color: <?php echo esc_attr( $accent_color ); ?>;
			--body-font: '<?php echo esc_attr( $body_font ); ?>', sans-serif;
			--heading-font: '<?php echo esc_attr( $heading_font ); ?>', sans-serif;
			--heading-weight: <?php echo esc_attr( $heading_weight ); ?>;
			--container-width: <?php echo esc_attr( $container_width ); ?>px;
		}
		body {
			font-family: var(--body-font);
			font-size: <?php echo esc_attr( $body_size ); ?>px;
			line-height: <?php echo esc_attr( $body_lh ); ?>;
		}
		h1, h2, h3, h4, h5, h6 {
			font-family: var(--heading-font);
			font-weight: var(--heading-weight);
		}
		.container { max-width: var(--container-width); }
		.btn-primary, .bg-primary { background-color: var(--primary-color) !important; border-color: var(--primary-color) !important; }
		.text-primary { color: var(--primary-color) !important; }

		.site-header { background-color: <?php echo esc_attr( get_theme_mod( 'header_bg_color', '#ffffff' ) ); ?>; }
		.site-footer { background-color: <?php echo esc_attr( get_theme_mod( 'footer_bg_color', '#111111' ) ); ?>; }
		.hero-section { color: <?php echo esc_attr( get_theme_mod( 'hero_text_color', '#ffffff' ) ); ?>; }
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
