<?php
/**
 * Organization Ecosystem functions and definitions
 *
 * @package OrgEcosystem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define Constants
define( 'ORG_ECOSYSTEM_VERSION', '1.0.1' );
define( 'ORG_ECOSYSTEM_DIR', get_template_directory() );
define( 'ORG_ECOSYSTEM_URI', get_template_directory_uri() );

/**
 * Setup Theme
 */
function org_ecosystem_setup() {
	load_theme_textdomain( 'org-ecosystem', ORG_ECOSYSTEM_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'org-ecosystem' ),
		'footer'  => esc_html__( 'Footer Menu', 'org-ecosystem' ),
		'member'  => esc_html__( 'Member Dashboard Menu', 'org-ecosystem' ),
	) );

	add_theme_support( 'elementor-full-width' );
}
add_action( 'after_setup_theme', 'org_ecosystem_setup' );

/**
 * Register widget area.
 */
function org_ecosystem_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'org-ecosystem' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'org-ecosystem' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s mb-4 p-4 bg-white shadow-sm border rounded">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title mb-3 fw-bold">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'org_ecosystem_widgets_init' );

/**
 * Get Dynamic Google Fonts URL
 */
function org_ecosystem_fonts_url() {
	$fonts = array();
	$body_font = get_theme_mod( 'body_font_family', 'Inter' );
	$heading_font = get_theme_mod( 'heading_font_family', 'Plus Jakarta Sans' );

	$fonts[] = $body_font . ':wght@300;400;500;600;700';
	if ( $body_font !== $heading_font ) {
		$fonts[] = $heading_font . ':wght@400;500;600;700;800;900';
	}

	$fonts_url = add_query_arg( array(
		'family' => implode( '&family=', array_map( 'urlencode', $fonts ) ),
		'display' => 'swap',
	), 'https://fonts.googleapis.com/css2' );

	// Fix standard implode adding &family= wrongly for multiple fonts in some cases
	$fonts_url = str_replace( '%3A', ':', $fonts_url );

	return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 */
function org_ecosystem_scripts() {
	// Dynamic Google Fonts
	wp_enqueue_style( 'org-ecosystem-fonts', org_ecosystem_fonts_url(), array(), null );

	// Bootstrap 5
	wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), '5.3.0' );
	wp_enqueue_script( 'bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), '5.3.0', true );

	// Bootstrap Icons
	wp_enqueue_style( 'bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css', array(), '1.10.0' );

	wp_enqueue_style( 'org-ecosystem-style', get_stylesheet_uri(), array( 'bootstrap' ), ORG_ECOSYSTEM_VERSION );
	wp_enqueue_style( 'org-ecosystem-main', ORG_ECOSYSTEM_URI . '/assets/css/main.css', array( 'org-ecosystem-style' ), ORG_ECOSYSTEM_VERSION );

	wp_enqueue_script( 'org-ecosystem-navigation', ORG_ECOSYSTEM_URI . '/assets/js/navigation.js', array( 'jquery', 'bootstrap-bundle' ), ORG_ECOSYSTEM_VERSION, true );
	wp_enqueue_script( 'org-ecosystem-main', ORG_ECOSYSTEM_URI . '/assets/js/main.js', array( 'jquery' ), ORG_ECOSYSTEM_VERSION, true );
	wp_localize_script( 'org-ecosystem-main', 'org_ajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'org_ecosystem_scripts' );

/**
 * Register Roles on Theme Activation
 */
function org_ecosystem_activation() {
	if ( function_exists( 'org_ecosystem_register_roles' ) ) {
		org_ecosystem_register_roles();
	}
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'org_ecosystem_activation' );

/**
 * Include required files
 */
require ORG_ECOSYSTEM_DIR . '/inc/cpt.php';
require ORG_ECOSYSTEM_DIR . '/inc/taxonomies.php';
require ORG_ECOSYSTEM_DIR . '/inc/customizer.php';
require ORG_ECOSYSTEM_DIR . '/inc/membership.php';
require ORG_ECOSYSTEM_DIR . '/inc/dashboard.php';
require ORG_ECOSYSTEM_DIR . '/inc/template-functions.php';
require ORG_ECOSYSTEM_DIR . '/inc/ajax-filters.php';
require ORG_ECOSYSTEM_DIR . '/inc/admin-panel.php';
require ORG_ECOSYSTEM_DIR . '/inc/seo-security.php';
require ORG_ECOSYSTEM_DIR . '/inc/patterns.php';
