<?php
/**
 * Theme Customizer Settings - Organized Hierarchy
 *
 * @package OrgEcosystem
 */

function org_ecosystem_customize_register( $wp_customize ) {

	// =========================================================================
	// PANEL: GLOBAL BRAND STYLES
	// =========================================================================
	$wp_customize->add_panel( 'org_panel_global_styles', array(
		'title'    => __( '1. Global Brand Styles', 'org-ecosystem' ),
		'priority' => 30,
	) );

	// Section: Identity & Colors
	$wp_customize->add_section( 'org_branding', array(
		'title' => __( 'Identity & Colors', 'org-ecosystem' ),
		'panel' => 'org_panel_global_styles',
	) );

	$global_colors = array(
		'primary_color'    => array( 'label' => __( 'Primary Brand Color', 'org-ecosystem' ), 'default' => '#0d6efd' ),
		'secondary_color'  => array( 'label' => __( 'Secondary Color', 'org-ecosystem' ), 'default' => '#6c757d' ),
		'accent_color'     => array( 'label' => __( 'Accent Color', 'org-ecosystem' ), 'default' => '#0dcaf0' ),
	);

	foreach ( $global_colors as $id => $data ) {
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

	// Section: Global Typography
	$wp_customize->add_section( 'org_typography', array(
		'title' => __( 'Global Typography', 'org-ecosystem' ),
		'panel' => 'org_panel_global_styles',
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

	$wp_customize->add_setting( 'body_font_family', array( 'default' => 'Inter', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'body_font_family', array( 'label' => __( 'Body Font Family', 'org-ecosystem' ), 'section' => 'org_typography', 'type' => 'select', 'choices' => $font_choices ) );

	$wp_customize->add_setting( 'heading_font_family', array( 'default' => 'Plus Jakarta Sans', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'heading_font_family', array( 'label' => __( 'Heading Font Family', 'org-ecosystem' ), 'section' => 'org_typography', 'type' => 'select', 'choices' => $font_choices ) );

	// =========================================================================
	// PANEL: HOMEPAGE & LAYOUT
	// =========================================================================
	$wp_customize->add_panel( 'org_panel_homepage', array(
		'title'    => __( '2. Homepage & Layout', 'org-ecosystem' ),
		'priority' => 35,
	) );

	// Section: Visibility
	$wp_customize->add_section( 'org_homepage_visibility', array(
		'title' => __( 'Section Visibility', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$visibility_toggles = array(
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

	foreach ( $visibility_toggles as $id => $label ) {
		$wp_customize->add_setting( $id, array( 'default' => true, 'sanitize_callback' => 'org_ecosystem_sanitize_checkbox' ) );
		$wp_customize->add_control( $id, array( 'label' => $label, 'section' => 'org_homepage_visibility', 'type' => 'checkbox' ) );
	}

	// Section: Hero Content
	$wp_customize->add_section( 'org_hero_content', array(
		'title' => __( 'Hero Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$wp_customize->add_setting( 'hero_title', array( 'default' => 'Empowering Our Community', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'hero_title', array( 'label' => 'Hero Title', 'section' => 'org_hero_content' ) );

	$wp_customize->add_setting( 'hero_subtitle', array( 'default' => 'Join our professional network.', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'hero_subtitle', array( 'label' => 'Hero Subtitle', 'section' => 'org_hero_content', 'type' => 'textarea' ) );

	// =========================================================================
	// GRANULAR STYLING (Inside individual sections for better UX)
	// =========================================================================
	// Instead of a separate panel, we can move the styling sections into the Homepage panel.

	$styling_sections = array(
		'header'            => array( 'title' => 'Header Styling', 'priority' => 10 ),
		'footer'            => array( 'title' => 'Footer Styling', 'priority' => 11 ),
		'hero'              => array( 'title' => 'Hero Section Styling', 'priority' => 12 ),
		'stats'             => array( 'title' => 'Stats Section Styling', 'priority' => 13 ),
		'about'             => array( 'title' => 'About Section Styling', 'priority' => 14 ),
		'featured_members'  => array( 'title' => 'Featured Members Styling', 'priority' => 15 ),
		'featured_products' => array( 'title' => 'Featured Products Styling', 'priority' => 16 ),
		'events'            => array( 'title' => 'Events Section Styling', 'priority' => 17 ),
		'testimonials'      => array( 'title' => 'Testimonials Styling', 'priority' => 18 ),
		'announcements'     => array( 'title' => 'Announcements Styling', 'priority' => 19 ),
		'news'              => array( 'title' => 'News Section Styling', 'priority' => 20 ),
		'partners'          => array( 'title' => 'Partners Section Styling', 'priority' => 21 ),
	);

	foreach ( $styling_sections as $sec_id => $sec_data ) {
		$section_key = 'org_style_' . $sec_id;

		$wp_customize->add_section( $section_key, array(
			'title' => $sec_data['title'],
			'panel' => 'org_panel_homepage',
			'priority' => $sec_data['priority'] + 50, // After visibility and content
		) );

		// Background
		$wp_customize->add_setting( $sec_id . '_bg_color', array( 'default' => '', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $sec_id . '_bg_color', array( 'label' => 'Background Color', 'section' => $section_key ) ) );

		$wp_customize->add_setting( $sec_id . '_bg_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $sec_id . '_bg_image', array( 'label' => 'Background Image', 'section' => $section_key ) ) );

		// Text & Headings
		$wp_customize->add_setting( $sec_id . '_text_color', array( 'default' => '', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $sec_id . '_text_color', array( 'label' => 'Text Color', 'section' => $section_key ) ) );

		$wp_customize->add_setting( $sec_id . '_h_color', array( 'default' => '', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $sec_id . '_h_color', array( 'label' => 'Heading Color', 'section' => $section_key ) ) );

		// Typography
		$wp_customize->add_setting( $sec_id . '_font_size', array( 'default' => '', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_font_size', array( 'label' => 'Base Font Size (px)', 'section' => $section_key, 'type' => 'number' ) );

		$wp_customize->add_setting( $sec_id . '_h_font_size', array( 'default' => '', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_h_font_size', array( 'label' => 'Heading Font Size (px)', 'section' => $section_key, 'type' => 'number' ) );

		$wp_customize->add_setting( $sec_id . '_line_height', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_line_height', array( 'label' => 'Line Height', 'section' => $section_key, 'type' => 'text' ) );

		// Spacing
		$wp_customize->add_setting( $sec_id . '_padding_top', array( 'default' => '', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_padding_top', array( 'label' => 'Padding Top (px)', 'section' => $section_key, 'type' => 'number' ) );

		$wp_customize->add_setting( $sec_id . '_padding_bottom', array( 'default' => '', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_padding_bottom', array( 'label' => 'Padding Bottom (px)', 'section' => $section_key, 'type' => 'number' ) );

		$wp_customize->add_setting( $sec_id . '_margin_top', array( 'default' => '', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_margin_top', array( 'label' => 'Margin Top (px)', 'section' => $section_key, 'type' => 'number' ) );

		$wp_customize->add_setting( $sec_id . '_margin_bottom', array( 'default' => '', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_margin_bottom', array( 'label' => 'Margin Bottom (px)', 'section' => $section_key, 'type' => 'number' ) );

		// Borders
		$wp_customize->add_setting( $sec_id . '_border_width', array( 'default' => '', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_border_width', array( 'label' => 'Border Width (px)', 'section' => $section_key, 'type' => 'number' ) );

		$wp_customize->add_setting( $sec_id . '_border_color', array( 'default' => '', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $sec_id . '_border_color', array( 'label' => 'Border Color', 'section' => $section_key ) ) );

		$wp_customize->add_setting( $sec_id . '_border_radius', array( 'default' => '', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_border_radius', array( 'label' => 'Border Radius (px)', 'section' => $section_key, 'type' => 'number' ) );
	}

	// =========================================================================
	// PANEL: MONETIZATION & REVENUE
	// =========================================================================
	$wp_customize->add_panel( 'org_panel_revenue', array(
		'title'    => __( '3. Monetization & Revenue', 'org-ecosystem' ),
		'priority' => 40,
	) );

	// Section: Membership Plans & Pricing
	$wp_customize->add_section( 'org_membership_plans', array(
		'title' => __( 'Plans & Pricing', 'org-ecosystem' ),
		'panel' => 'org_panel_revenue',
	) );

	$wp_customize->add_setting( 'basic_plan_price', array( 'default' => '1500', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'basic_plan_price', array(
        'label' => 'Basic Plan Price (₱)',
        'description' => __( 'Example: Enter 1500 for ₱1,500.00 Annual Membership Fee.', 'org-ecosystem' ),
        'section' => 'org_membership_plans'
    ) );

	$wp_customize->add_setting( 'premium_plan_price', array( 'default' => '5000', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'premium_plan_price', array(
        'label' => 'Premium Plan Price (₱)',
        'description' => __( 'Example: Enter 5000 for ₱5,000.00 Annual Membership Fee.', 'org-ecosystem' ),
        'section' => 'org_membership_plans'
    ) );

	// Section: Lead Protection & Promotions
	$wp_customize->add_section( 'org_revenue', array(
		'title' => __( 'Lead Gating & Promotions', 'org-ecosystem' ),
		'panel' => 'org_panel_revenue',
	) );

	$wp_customize->add_setting( 'protect_leads', array( 'default' => false, 'sanitize_callback' => 'org_ecosystem_sanitize_checkbox' ) );
	$wp_customize->add_control( 'protect_leads', array( 'label' => __( 'Enable Lead Gating', 'org-ecosystem' ), 'section' => 'org_revenue', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'promotion_price', array( 'default' => '500', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'promotion_price', array( 'label' => __( 'Featured Promotion Price (₱)', 'org-ecosystem' ), 'section' => 'org_revenue' ) );

	// Section: Sponsor Ads
	$wp_customize->add_section( 'org_sponsor_ads', array(
		'title' => __( 'Sidebar Sponsor Ads', 'org-ecosystem' ),
		'panel' => 'org_panel_revenue',
	) );

	$wp_customize->add_setting( 'sponsor_banner_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sponsor_banner_image', array( 'label' => 'Sponsor Banner Image', 'section' => 'org_sponsor_ads' ) ) );

	$wp_customize->add_setting( 'sponsor_banner_link', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( 'sponsor_banner_link', array( 'label' => 'Sponsor Target URL', 'section' => 'org_sponsor_ads', 'type' => 'url' ) );
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

	$sections = array(
		'header'            => '.site-header',
		'footer'            => '.site-footer',
		'hero'              => '.section-hero',
		'stats'             => '.section-stats',
		'about'             => '.section-about',
		'featured_members'  => '.section-featured-members',
		'featured_products' => '.section-featured-products',
		'events'            => '.section-events',
		'testimonials'      => '.section-testimonials',
		'announcements'     => '.section-announcements',
		'news'              => '.section-news',
		'partners'          => '.section-partners',
	);

	?>
	<style type="text/css">
		:root {
			--primary-color: <?php echo esc_attr( $primary_color ); ?>;
			--secondary-color: <?php echo esc_attr( $secondary_color ); ?>;
			--accent-color: <?php echo esc_attr( $accent_color ); ?>;
			--body-font: '<?php echo esc_attr( $body_font ); ?>', sans-serif;
			--heading-font: '<?php echo esc_attr( $heading_font ); ?>', sans-serif;
		}
		body { font-family: var(--body-font); }
		h1, h2, h3, h4, h5, h6 { font-family: var(--heading-font); }
		.btn-primary, .bg-primary { background-color: var(--primary-color) !important; border-color: var(--primary-color) !important; }
		.text-primary { color: var(--primary-color) !important; }

		<?php foreach ( $sections as $id => $selector ) :
			$bg_color     = get_theme_mod( $id . '_bg_color' );
			$text_color   = get_theme_mod( $id . '_text_color' );
			$h_color      = get_theme_mod( $id . '_h_color' );
			$font_size    = get_theme_mod( $id . '_font_size' );
			$h_font_size  = get_theme_mod( $id . '_h_font_size' );
			$line_height  = get_theme_mod( $id . '_line_height' );
			$p_top        = get_theme_mod( $id . '_padding_top' );
			$p_bottom     = get_theme_mod( $id . '_padding_bottom' );
			$m_top        = get_theme_mod( $id . '_margin_top' );
			$m_bottom     = get_theme_mod( $id . '_margin_bottom' );
			$bg_image     = get_theme_mod( $id . '_bg_image' );
			$b_width      = get_theme_mod( $id . '_border_width' );
			$b_color      = get_theme_mod( $id . '_border_color' );
			$b_radius     = get_theme_mod( $id . '_border_radius' );
		?>
			<?php echo $selector; ?> {
				<?php if ( $bg_color ) echo "background-color: $bg_color !important;"; ?>
				<?php if ( $text_color ) echo "color: $text_color !important;"; ?>
				<?php if ( $font_size ) echo "font-size: {$font_size}px !important;"; ?>
				<?php if ( $line_height ) echo "line-height: $line_height !important;"; ?>
				<?php if ( $p_top ) echo "padding-top: {$p_top}px !important;"; ?>
				<?php if ( $p_bottom ) echo "padding-bottom: {$p_bottom}px !important;"; ?>
				<?php if ( $m_top ) echo "margin-top: {$m_top}px !important;"; ?>
				<?php if ( $m_bottom ) echo "margin-bottom: {$m_bottom}px !important;"; ?>
				<?php if ( $bg_image ) echo "background-image: url(" . esc_url($bg_image) . ") !important; background-size: cover; background-position: center;"; ?>
				<?php if ( $b_width ) echo "border-top: {$b_width}px solid " . ($b_color ? $b_color : '#eee') . " !important; border-bottom: {$b_width}px solid " . ($b_color ? $b_color : '#eee') . " !important;"; ?>
				<?php if ( $b_radius ) echo "border-radius: {$b_radius}px !important;"; ?>
			}
			<?php if ( $h_color || $h_font_size ) : ?>
				<?php echo $selector; ?> h1, <?php echo $selector; ?> h2, <?php echo $selector; ?> h3, <?php echo $selector; ?> h4 {
					<?php if ( $h_color ) echo "color: $h_color !important;"; ?>
					<?php if ( $h_font_size ) echo "font-size: {$h_font_size}px !important;"; ?>
				}
			<?php endif; ?>
		<?php endforeach; ?>
	</style>
	<?php
}
add_action( 'wp_head', 'org_ecosystem_customizer_css' );

/**
 * Live Preview Script
 */
function org_ecosystem_customize_preview_js() {
	wp_enqueue_script( 'org-ecosystem-customize-preview', get_template_directory_uri() . '/assets/js/customize-preview.js', array( 'customize-preview', 'jquery' ), '1.1', true );
}
add_action( 'customize_preview_init', 'org_ecosystem_customize_preview_js' );

/**
 * Sanitize Checkbox
 */
function org_ecosystem_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
