<?php
/**
 * Gutenberg Block Patterns
 *
 * @package OrgEcosystem
 */

function org_ecosystem_register_block_patterns() {
	if ( function_exists( 'register_block_pattern' ) ) {
		// Pricing Table Pattern
		register_block_pattern(
			'org-ecosystem/pricing-table',
			array(
				'title'       => __( 'Membership Pricing Table', 'org-ecosystem' ),
				'description' => _x( 'A professional pricing table for membership plans.', 'Block pattern description', 'org-ecosystem' ),
				'categories'  => array( 'buttons' ),
				'content'     => '<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}}},"backgroundColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-white-background-color has-background"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="has-text-align-center">Basic</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong>₱ 1,500 / year</strong></p>
<!-- /wp:paragraph -->
<!-- wp:list -->
<ul><li>Member Directory Access</li><li>Basic Profile</li><li>Networking Events</li></ul>
<!-- /wp:list -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Select Plan</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}}},"backgroundColor":"primary","textColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-primary-background-color has-white-color has-text-color has-background"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="has-text-align-center">Premium</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong>₱ 5,000 / year</strong></p>
<!-- /wp:paragraph -->
<!-- wp:list -->
<ul><li>Featured Profile Listing</li><li>Product Showcase</li><li>VIP Events</li><li>Resource Library</li></ul>
<!-- /wp:list -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"white","textColor":"primary"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-primary-color has-white-background-color has-text-color has-background wp-element-button">Select Plan</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
			)
		);
	}
}
add_action( 'init', 'org_ecosystem_register_block_patterns' );
