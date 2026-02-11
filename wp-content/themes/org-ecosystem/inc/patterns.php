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

		// Stats Counter Pattern
		register_block_pattern(
			'org-ecosystem/stats-counters',
			array(
				'title'       => __( 'Impact Statistics Counters', 'org-ecosystem' ),
				'categories'  => array( 'columns' ),
				'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"primary","textColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-primary-background-color has-white-color has-text-color has-background"><div class="wp-block-group__inner-container"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"3rem"}}} -->
<p class="has-text-align-center" style="font-size:3rem"><strong>500+</strong></p>
<!-- /wp:paragraph --><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Active Members</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"3rem"}}} -->
<p class="has-text-align-center" style="font-size:3rem"><strong>120+</strong></p>
<!-- /wp:paragraph --><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Businesses Listed</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"3rem"}}} -->
<p class="has-text-align-center" style="font-size:3rem"><strong>₱ 2M+</strong></p>
<!-- /wp:paragraph --><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Community Impact</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:group -->',
			)
		);

		// Member Spotlight Pattern
		register_block_pattern(
			'org-ecosystem/member-spotlight',
			array(
				'title'       => __( 'Member Spotlight', 'org-ecosystem' ),
				'categories'  => array( 'featured' ),
				'content'     => '<!-- wp:media-text {"mediaId":1,"mediaLink":"#","mediaType":"image","mediaWidth":35} -->
<div class="wp-block-media-text alignwide is-stacked-on-mobile" style="grid-template-columns:35% auto"><figure class="wp-block-media-text__media"><img src="' . ORG_ECOSYSTEM_URI . '/assets/images/about-placeholder.png" alt=""/></figure><div class="wp-block-media-text__content"><!-- wp:heading -->
<h2>Member Spotlight: Jane Doe</h2>
<!-- /wp:heading --><!-- wp:paragraph -->
<p>Discover how Jane transformed her local business using our organization\'s resources and networking platform. "The community support has been invaluable to my growth," says Jane.</p>
<!-- /wp:paragraph --><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Read Full Story</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:group -->',
			)
		);
	}
}
add_action( 'init', 'org_ecosystem_register_block_patterns' );
