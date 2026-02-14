<?php
/**
 * Register Custom Post Types
 *
 * @package OrgEcosystem
 */

function org_ecosystem_register_cpts() {
	// Member CPT
	register_post_type( 'member', array(
		'labels' => array(
			'name' => __( 'Members', 'org-ecosystem' ),
			'singular_name' => __( 'Member', 'org-ecosystem' ),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'members' ),
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon' => 'dashicons-groups',
		'show_in_rest' => true,
	) );

	// Business CPT
	register_post_type( 'business', array(
		'labels' => array(
			'name' => __( 'Businesses', 'org-ecosystem' ),
			'singular_name' => __( 'Business', 'org-ecosystem' ),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'businesses' ),
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon' => 'dashicons-store',
		'show_in_rest' => true,
	) );

	// Product CPT
	register_post_type( 'product', array(
		'labels' => array(
			'name' => __( 'Products/Services', 'org-ecosystem' ),
			'singular_name' => __( 'Product/Service', 'org-ecosystem' ),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'products' ),
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon' => 'dashicons-cart',
		'show_in_rest' => true,
	) );

	// Event CPT
	register_post_type( 'event', array(
		'labels' => array(
			'name' => __( 'Events', 'org-ecosystem' ),
			'singular_name' => __( 'Event', 'org-ecosystem' ),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'events' ),
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon' => 'dashicons-calendar-alt',
		'show_in_rest' => true,
	) );

	// Program CPT
	register_post_type( 'program', array(
		'labels' => array(
			'name' => __( 'Programs/Projects', 'org-ecosystem' ),
			'singular_name' => __( 'Program/Project', 'org-ecosystem' ),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'programs' ),
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon' => 'dashicons-clipboard',
		'show_in_rest' => true,
	) );

	// Announcement CPT
	register_post_type( 'announcement', array(
		'labels' => array(
			'name' => __( 'Announcements', 'org-ecosystem' ),
			'singular_name' => __( 'Announcement', 'org-ecosystem' ),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'announcements' ),
		'supports' => array( 'title', 'editor' ),
		'menu_icon' => 'dashicons-megaphone',
		'show_in_rest' => true,
	) );

	// Testimonial CPT
	register_post_type( 'testimonial', array(
		'labels' => array(
			'name' => __( 'Testimonials', 'org-ecosystem' ),
			'singular_name' => __( 'Testimonial', 'org-ecosystem' ),
		),
		'public' => true,
		'has_archive' => false,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon' => 'dashicons-format-quote',
		'show_in_rest' => true,
	) );

	// Resource CPT
	register_post_type( 'resource', array(
		'labels' => array(
			'name' => __( 'Resources', 'org-ecosystem' ),
			'singular_name' => __( 'Resource', 'org-ecosystem' ),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'resources' ),
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon' => 'dashicons-pdf',
		'show_in_rest' => true,
	) );

	// Job CPT
	register_post_type( 'job', array(
		'labels' => array(
			'name' => __( 'Jobs', 'org-ecosystem' ),
			'singular_name' => __( 'Job', 'org-ecosystem' ),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'jobs' ),
		'supports' => array( 'title', 'editor', 'excerpt' ),
		'menu_icon' => 'dashicons-businessperson',
		'show_in_rest' => true,
	) );

	// Donation CPT
	register_post_type( 'donation', array(
		'labels' => array(
			'name' => __( 'Donations', 'org-ecosystem' ),
			'singular_name' => __( 'Donation', 'org-ecosystem' ),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'donations' ),
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon' => 'dashicons-heart',
		'show_in_rest' => true,
	) );

	// Support Ticket CPT
	register_post_type( 'support_ticket', array(
		'labels' => array(
			'name' => __( 'Support Tickets', 'org-ecosystem' ),
			'singular_name' => __( 'Support Ticket', 'org-ecosystem' ),
		),
		'public' => false,
		'show_ui' => true,
		'supports' => array( 'title', 'editor', 'comments' ),
		'menu_icon' => 'dashicons-sos',
		'show_in_rest' => true,
	) );

	// Message CPT (Internal Messaging)
	register_post_type( 'org_message', array(
		'labels' => array(
			'name' => __( 'Messages', 'org-ecosystem' ),
			'singular_name' => __( 'Message', 'org-ecosystem' ),
		),
		'public' => false,
		'show_ui' => true,
		'supports' => array( 'title', 'editor', 'author' ),
		'menu_icon' => 'dashicons-email-alt',
		'show_in_rest' => true,
	) );

    // Transaction CPT
	register_post_type( 'org_transaction', array(
		'labels' => array(
			'name' => __( 'Transactions', 'org-ecosystem' ),
			'singular_name' => __( 'Transaction', 'org-ecosystem' ),
		),
		'public' => false,
		'show_ui' => true,
		'supports' => array( 'title', 'excerpt' ),
		'menu_icon' => 'dashicons-money-alt',
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'org_ecosystem_register_cpts' );
