<?php
/**
 * Register Custom Taxonomies
 *
 * @package OrgEcosystem
 */

function org_ecosystem_register_taxonomies() {
	// Industry
	register_taxonomy( 'industry', array( 'member', 'business', 'job' ), array(
		'labels' => array(
			'name' => __( 'Industries', 'org-ecosystem' ),
			'singular_name' => __( 'Industry', 'org-ecosystem' ),
		),
		'hierarchical' => true,
		'show_in_rest' => true,
	) );

	// Skills
	register_taxonomy( 'skill', array( 'member' ), array(
		'labels' => array(
			'name' => __( 'Skills', 'org-ecosystem' ),
			'singular_name' => __( 'Skill', 'org-ecosystem' ),
		),
		'hierarchical' => false,
		'show_in_rest' => true,
	) );

	// Location
	register_taxonomy( 'location', array( 'member', 'business', 'event', 'job' ), array(
		'labels' => array(
			'name' => __( 'Locations', 'org-ecosystem' ),
			'singular_name' => __( 'Location', 'org-ecosystem' ),
		),
		'hierarchical' => true,
		'show_in_rest' => true,
	) );

	// Membership Level
	register_taxonomy( 'membership_level', array( 'member' ), array(
		'labels' => array(
			'name' => __( 'Membership Levels', 'org-ecosystem' ),
			'singular_name' => __( 'Membership Level', 'org-ecosystem' ),
		),
		'hierarchical' => true,
		'show_in_rest' => true,
	) );

	// Product Categories
	register_taxonomy( 'product_cat', array( 'product' ), array(
		'labels' => array(
			'name' => __( 'Product Categories', 'org-ecosystem' ),
			'singular_name' => __( 'Product Category', 'org-ecosystem' ),
		),
		'hierarchical' => true,
		'show_in_rest' => true,
	) );

	// Organization Tags
	register_taxonomy( 'org_tag', array( 'member', 'business', 'product', 'event', 'resource' ), array(
		'labels' => array(
			'name' => __( 'Tags', 'org-ecosystem' ),
			'singular_name' => __( 'Tag', 'org-ecosystem' ),
		),
		'hierarchical' => false,
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'org_ecosystem_register_taxonomies' );
