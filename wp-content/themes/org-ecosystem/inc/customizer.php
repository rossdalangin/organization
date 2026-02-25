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
		'primary_color'    => array( 'label' => __( 'Primary Brand Color', 'org-ecosystem' ), 'default' => '#2563eb' ),
		'secondary_color'  => array( 'label' => __( 'Secondary Color', 'org-ecosystem' ), 'default' => '#475569' ),
		'accent_color'     => array( 'label' => __( 'Accent Color', 'org-ecosystem' ), 'default' => '#38bdf8' ),
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

	// Section: Social Links
	$wp_customize->add_section( 'org_social', array(
		'title' => __( 'Social Links', 'org-ecosystem' ),
		'panel' => 'org_panel_global_styles',
	) );

	$socials = array( 'facebook', 'twitter', 'linkedin', 'instagram', 'youtube' );
	foreach ( $socials as $social ) {
		$wp_customize->add_setting( 'social_' . $social, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( 'social_' . $social, array( 'label' => ucfirst( $social ) . ' URL', 'section' => 'org_social' ) );
	}

	// Section: Contact Info
	$wp_customize->add_section( 'org_contact_footer', array(
		'title' => __( 'Footer Contact Info', 'org-ecosystem' ),
		'panel' => 'org_panel_global_styles',
	) );

	$wp_customize->add_setting( 'org_address', array( 'default' => '123 Org St, City, Country', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'org_address', array( 'label' => 'Address', 'section' => 'org_contact_footer' ) );

	$wp_customize->add_setting( 'org_phone', array( 'default' => '+1 234 567 890', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'org_phone', array( 'label' => 'Phone', 'section' => 'org_contact_footer' ) );

	$wp_customize->add_setting( 'org_email', array( 'default' => 'info@example.org', 'sanitize_callback' => 'sanitize_email' ) );
	$wp_customize->add_control( 'org_email', array( 'label' => 'Email', 'section' => 'org_contact_footer' ) );

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
		'show_hero'          => __( 'Show Hero Section', 'org-ecosystem' ),
		'show_stats'         => __( 'Show Impact Stats', 'org-ecosystem' ),
		'show_expertise'     => __( 'Show Expertise Grid', 'org-ecosystem' ),
		'show_about'         => __( 'Show About Organization', 'org-ecosystem' ),
		'show_featured_mem'  => __( 'Show Featured Members', 'org-ecosystem' ),
		'show_featured_prod' => __( 'Show Featured Products', 'org-ecosystem' ),
		'show_cta'           => __( 'Show Membership CTA', 'org-ecosystem' ),
		'show_events'        => __( 'Show Upcoming Events', 'org-ecosystem' ),
		'show_testimonials'  => __( 'Show Testimonials', 'org-ecosystem' ),
		'show_announcements' => __( 'Show Announcements', 'org-ecosystem' ),
		'show_news'          => __( 'Show Latest News', 'org-ecosystem' ),
		'show_donation_cta'  => __( 'Show Donation CTA', 'org-ecosystem' ),
		'show_partners'      => __( 'Show Partner Logos', 'org-ecosystem' ),
		'show_newsletter'    => __( 'Show Newsletter Section', 'org-ecosystem' ),
        'show_about_cards'   => __( 'Show About Page Goal Cards', 'org-ecosystem' ),
        'show_partner_tiers' => __( 'Show Partner Page Tiers', 'org-ecosystem' ),
        'show_faq_cta'       => __( 'Show FAQ Contact CTA', 'org-ecosystem' ),
        'show_referral_how'  => __( 'Show Referral How-It-Works', 'org-ecosystem' ),
        'show_plans_custom_cta' => __( 'Show Plans Custom Team CTA', 'org-ecosystem' ),
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

	$wp_customize->add_setting( 'hero_primary_cta_text', array( 'default' => 'Join Now', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'hero_primary_cta_text', array( 'label' => 'Primary CTA Text', 'section' => 'org_hero_content' ) );

	$wp_customize->add_setting( 'hero_secondary_cta_text', array( 'default' => 'Explore Members', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'hero_secondary_cta_text', array( 'label' => 'Secondary CTA Text', 'section' => 'org_hero_content' ) );

	$wp_customize->add_setting( 'hero_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_image', array( 'label' => 'Hero Side Image', 'section' => 'org_hero_content' ) ) );

	// Section: About Section Content
	$wp_customize->add_section( 'org_about_content', array(
		'title' => __( 'About Section Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$wp_customize->add_setting( 'about_title', array( 'default' => 'About Our Organization', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'about_title', array( 'label' => 'About Title', 'section' => 'org_about_content' ) );

	$wp_customize->add_setting( 'about_subtitle', array( 'default' => 'We are dedicated to fostering growth...', 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'about_subtitle', array( 'label' => 'About Subtitle', 'section' => 'org_about_content', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'about_text', array( 'default' => 'Our mission is to provide a platform...', 'sanitize_callback' => 'wp_kses_post' ) );
	$wp_customize->add_control( 'about_text', array( 'label' => 'About Text', 'section' => 'org_about_content', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'about_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'about_image', array( 'label' => 'About Image', 'section' => 'org_about_content' ) ) );

	$wp_customize->add_setting( 'about_btn_1_text', array( 'default' => 'Learn More About Us', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'about_btn_1_text', array( 'label' => 'About Button 1 Text', 'section' => 'org_about_content' ) );

	$wp_customize->add_setting( 'about_btn_2_text', array( 'default' => 'Our Mission & Vision', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'about_btn_2_text', array( 'label' => 'About Button 2 Text', 'section' => 'org_about_content' ) );

	// Section: Donation CTA Content
	$wp_customize->add_section( 'org_donation_cta_content', array(
		'title' => __( 'Donation CTA Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$wp_customize->add_setting( 'donation_cta_title', array( 'default' => 'Support Our Collective Growth', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'donation_cta_title', array( 'label' => 'Donation Title', 'section' => 'org_donation_cta_content' ) );

	$wp_customize->add_setting( 'donation_cta_text', array( 'default' => 'Your contributions help us expand our resources and advocacy for the entire professional community.', 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'donation_cta_text', array( 'label' => 'Donation Text', 'section' => 'org_donation_cta_content', 'type' => 'textarea' ) );

	// Section: Newsletter Content
	$wp_customize->add_section( 'org_newsletter_content', array(
		'title' => __( 'Newsletter Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$wp_customize->add_setting( 'newsletter_title', array( 'default' => 'Stay in the Loop', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'newsletter_title', array( 'label' => 'Newsletter Title', 'section' => 'org_newsletter_content' ) );

	$wp_customize->add_setting( 'newsletter_text', array( 'default' => 'Subscribe to our newsletter for the latest updates, event news, and member spotlights.', 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'newsletter_text', array( 'label' => 'Newsletter Text', 'section' => 'org_newsletter_content', 'type' => 'textarea' ) );

	// Section: Stats Content
	$wp_customize->add_section( 'org_stats_content', array(
		'title' => __( 'Stats Section Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$wp_customize->add_setting( 'stats_title', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'stats_title', array( 'label' => 'Stats Section Title (Optional)', 'section' => 'org_stats_content' ) );

	$wp_customize->add_setting( 'stats_subtitle', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'stats_subtitle', array( 'label' => 'Stats Section Subtitle (Optional)', 'section' => 'org_stats_content' ) );

	for($i=1; $i<=4; $i++) {
		$defaults = array(
			1 => array('label' => 'Active Members', 'value' => '500'),
			2 => array('label' => 'Businesses', 'value' => '120'),
			3 => array('label' => 'Events Yearly', 'value' => '50'),
			4 => array('label' => 'Years of Impact', 'value' => '15'),
		);
		$wp_customize->add_setting( "stat_{$i}_label", array( 'default' => $defaults[$i]['label'], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "stat_{$i}_label", array( 'label' => "Stat {$i} Label", 'section' => 'org_stats_content' ) );
		$wp_customize->add_setting( "stat_{$i}_value", array( 'default' => $defaults[$i]['value'], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "stat_{$i}_value", array( 'label' => "Stat {$i} Value", 'section' => 'org_stats_content' ) );
	}

	// Section: Expertise Content
	$wp_customize->add_section( 'org_expertise_content', array(
		'title' => __( 'Expertise Section Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$wp_customize->add_setting( 'expertise_title', array( 'default' => 'Service Excellence for Growth', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'expertise_title', array( 'label' => 'Expertise Title', 'section' => 'org_expertise_content' ) );

	$wp_customize->add_setting( 'expertise_subtitle', array( 'default' => 'Our Expertise', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'expertise_subtitle', array( 'label' => 'Expertise Subtitle', 'section' => 'org_expertise_content' ) );

	for($i=1; $i<=4; $i++) {
		$defaults = array(
			1 => array('title' => 'Verified Directory', 'text' => 'Every member is vetted to ensure a high-trust professional ecosystem for all participants.', 'icon' => 'shield-check'),
			2 => array('title' => 'Fast Connections', 'text' => 'Our AJAX-powered search allows you to find partners, vendors, and clients in milliseconds.', 'icon' => 'lightning-charge'),
			3 => array('title' => 'Growth Tools', 'text' => 'Access exclusive resources, job boards, and lead protection features designed for scale.', 'icon' => 'graph-up-arrow'),
			4 => array('title' => 'Community First', 'text' => 'Internal messaging and group chats foster real relationships beyond simple business listings.', 'icon' => 'people'),
		);
		$wp_customize->add_setting( "expertise_{$i}_title", array( 'default' => $defaults[$i]['title'], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "expertise_{$i}_title", array( 'label' => "Expertise {$i} Title", 'section' => 'org_expertise_content' ) );
		$wp_customize->add_setting( "expertise_{$i}_text", array( 'default' => $defaults[$i]['text'], 'sanitize_callback' => 'sanitize_textarea_field' ) );
		$wp_customize->add_control( "expertise_{$i}_text", array( 'label' => "Expertise {$i} Text", 'section' => 'org_expertise_content', 'type' => 'textarea' ) );
		$wp_customize->add_setting( "expertise_{$i}_icon", array( 'default' => $defaults[$i]['icon'], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "expertise_{$i}_icon", array( 'label' => "Expertise {$i} Bootstrap Icon Name", 'section' => 'org_expertise_content' ) );
	}

	// Section: Featured Members Content
	$wp_customize->add_section( 'org_featured_members_content', array(
		'title' => __( 'Featured Members Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$wp_customize->add_setting( 'featured_members_title', array( 'default' => 'Featured Members', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'featured_members_title', array( 'label' => 'Featured Members Title', 'section' => 'org_featured_members_content' ) );

	$wp_customize->add_setting( 'featured_members_subtitle', array( 'default' => 'Meet some of our top-tier professional members.', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'featured_members_subtitle', array( 'label' => 'Featured Members Subtitle', 'section' => 'org_featured_members_content' ) );

	// Section: Featured Solutions Content
	$wp_customize->add_section( 'org_featured_solutions_content', array(
		'title' => __( 'Featured Solutions Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$wp_customize->add_setting( 'featured_solutions_title', array( 'default' => 'Featured Solutions', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'featured_solutions_title', array( 'label' => 'Featured Solutions Title', 'section' => 'org_featured_solutions_content' ) );

	$wp_customize->add_setting( 'featured_solutions_subtitle', array( 'default' => 'Discover high-quality products and services offered by our members.', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'featured_solutions_subtitle', array( 'label' => 'Featured Solutions Subtitle', 'section' => 'org_featured_solutions_content' ) );

	// Section: Events Content
	$wp_customize->add_section( 'org_events_content', array(
		'title' => __( 'Events Section Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$wp_customize->add_setting( 'events_title', array( 'default' => 'Upcoming Events', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'events_title', array( 'label' => 'Events Title', 'section' => 'org_events_content' ) );

	$wp_customize->add_setting( 'events_subtitle', array( 'default' => 'Join us for networking, learning, and community growth.', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'events_subtitle', array( 'label' => 'Events Subtitle', 'section' => 'org_events_content' ) );

	// Section: Testimonials Content
	$wp_customize->add_section( 'org_testimonials_content', array(
		'title' => __( 'Testimonials Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$wp_customize->add_setting( 'testimonials_title', array( 'default' => 'Community Voices', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'testimonials_title', array( 'label' => 'Testimonials Title', 'section' => 'org_testimonials_content' ) );

	$wp_customize->add_setting( 'testimonials_subtitle', array( 'default' => 'What our members say about their experience with us.', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'testimonials_subtitle', array( 'label' => 'Testimonials Subtitle', 'section' => 'org_testimonials_content' ) );

	// Section: Partners Content
	$wp_customize->add_section( 'org_partners_content', array(
		'title' => __( 'Partners Section Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$wp_customize->add_setting( 'partners_title', array( 'default' => 'Our Partners & Sponsors', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'partners_title', array( 'label' => 'Partners Title', 'section' => 'org_partners_content' ) );

	$wp_customize->add_setting( 'org_partner_list', array( 'default' => 'PARTNER 1, PARTNER 2, PARTNER 3, PARTNER 4, PARTNER 5', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'org_partner_list', array( 'label' => 'Partner Names (Comma separated)', 'section' => 'org_partners_content' ) );

	// Section: CTA Content
	$wp_customize->add_section( 'org_cta_content', array(
		'title' => __( 'Membership CTA Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

    $wp_customize->add_setting( 'cta_title', array( 'default' => 'Ready to Grow Your Business?', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'cta_title', array( 'label' => 'CTA Title', 'section' => 'org_cta_content' ) );

    $wp_customize->add_setting( 'cta_text', array( 'default' => 'Join hundreds of professionals who are already benefiting from our exclusive network, tools, and community support.', 'sanitize_callback' => 'sanitize_textarea_field' ) );
    $wp_customize->add_control( 'cta_text', array( 'label' => 'CTA Text', 'section' => 'org_cta_content', 'type' => 'textarea' ) );

    $wp_customize->add_setting( 'cta_btn_text', array( 'default' => 'Become a Member Today', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'cta_btn_text', array( 'label' => 'CTA Button Text', 'section' => 'org_cta_content' ) );

	// Section: Mission/Vision Content
	$wp_customize->add_section( 'org_mission_content', array(
		'title' => __( 'Mission & Vision Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

	$wp_customize->add_setting( 'mission_text', array( 'default' => 'To empower organizations and professionals by providing a robust digital ecosystem that fosters collaboration, growth, and community engagement.', 'sanitize_callback' => 'wp_kses_post' ) );
	$wp_customize->add_control( 'mission_text', array( 'label' => 'Mission Statement', 'section' => 'org_mission_content', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'vision_text', array( 'default' => 'To become the global standard for organizational networking, enabling seamless member interactions and sustainable growth for all partners.', 'sanitize_callback' => 'wp_kses_post' ) );
	$wp_customize->add_control( 'vision_text', array( 'label' => 'Vision Statement', 'section' => 'org_mission_content', 'type' => 'textarea' ) );

	// Section: News Content
	$wp_customize->add_section( 'org_news_content', array(
		'title' => __( 'News & Announcements Content', 'org-ecosystem' ),
		'panel' => 'org_panel_homepage',
	) );

    $wp_customize->add_setting( 'news_title', array( 'default' => 'Inside Our Community', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'news_title', array( 'label' => 'News Title', 'section' => 'org_news_content' ) );

	$wp_customize->add_setting( 'news_subtitle', array( 'default' => 'The latest stories, news, and insights from our members.', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'news_subtitle', array( 'label' => 'News Subtitle', 'section' => 'org_news_content' ) );

    $wp_customize->add_setting( 'announcements_title', array( 'default' => 'Important Announcements', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'announcements_title', array( 'label' => 'Announcements Title', 'section' => 'org_news_content' ) );

	$wp_customize->add_setting( 'announcements_subtitle', array( 'default' => 'Stay updated with the latest news and updates from the organization.', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'announcements_subtitle', array( 'label' => 'Announcements Subtitle', 'section' => 'org_news_content' ) );

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
		$wp_customize->add_setting( $sec_id . '_bg_color', array( 'default' => ( in_array($sec_id, array('header', 'hero', 'footer')) ? '#ffffff' : '#f8fafc' ), 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $sec_id . '_bg_color', array( 'label' => 'Background Color', 'section' => $section_key ) ) );

		$wp_customize->add_setting( $sec_id . '_bg_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $sec_id . '_bg_image', array( 'label' => 'Background Image', 'section' => $section_key ) ) );

		// Text & Headings
		$wp_customize->add_setting( $sec_id . '_text_color', array( 'default' => '#334155', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $sec_id . '_text_color', array( 'label' => 'Text Color', 'section' => $section_key ) ) );

		$wp_customize->add_setting( $sec_id . '_h_color', array( 'default' => '#1e293b', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $sec_id . '_h_color', array( 'label' => 'Heading Color', 'section' => $section_key ) ) );

		// Typography
		$wp_customize->add_setting( $sec_id . '_font_size', array( 'default' => '16', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_font_size', array( 'label' => 'Base Font Size (px)', 'section' => $section_key, 'type' => 'number' ) );

		$wp_customize->add_setting( $sec_id . '_h_font_size', array( 'default' => '32', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_h_font_size', array( 'label' => 'Heading Font Size (px)', 'section' => $section_key, 'type' => 'number' ) );

		$wp_customize->add_setting( $sec_id . '_line_height', array( 'default' => '1.6', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_line_height', array( 'label' => 'Line Height', 'section' => $section_key, 'type' => 'text' ) );

		// Spacing
		$wp_customize->add_setting( $sec_id . '_padding_top', array( 'default' => '80', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_padding_top', array( 'label' => 'Padding Top (px)', 'section' => $section_key, 'type' => 'number' ) );

		$wp_customize->add_setting( $sec_id . '_padding_bottom', array( 'default' => '80', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_padding_bottom', array( 'label' => 'Padding Bottom (px)', 'section' => $section_key, 'type' => 'number' ) );

		$wp_customize->add_setting( $sec_id . '_margin_top', array( 'default' => '0', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_margin_top', array( 'label' => 'Margin Top (px)', 'section' => $section_key, 'type' => 'number' ) );

		$wp_customize->add_setting( $sec_id . '_margin_bottom', array( 'default' => '0', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_margin_bottom', array( 'label' => 'Margin Bottom (px)', 'section' => $section_key, 'type' => 'number' ) );

		// Borders
		$wp_customize->add_setting( $sec_id . '_border_width', array( 'default' => '0', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( $sec_id . '_border_width', array( 'label' => 'Border Width (px)', 'section' => $section_key, 'type' => 'number' ) );

		$wp_customize->add_setting( $sec_id . '_border_color', array( 'default' => '#e2e8f0', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $sec_id . '_border_color', array( 'label' => 'Border Color', 'section' => $section_key ) ) );

		$wp_customize->add_setting( $sec_id . '_border_radius', array( 'default' => '0', 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
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
