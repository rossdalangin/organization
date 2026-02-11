<?php
/**
 * SEO, Security, and GDPR Logic
 *
 * @package OrgEcosystem
 */

/**
 * Add Schema.org Markup to Header
 */
function org_ecosystem_schema_markup() {
	if ( is_front_page() ) {
		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Organization',
			'name'     => get_bloginfo( 'name' ),
			'url'      => home_url( '/' ),
			'logo'     => get_site_icon_url(),
			'contactPoint' => array(
				'@type'       => 'ContactPoint',
				'telephone'   => get_theme_mod( 'org_phone' ),
				'contactType' => 'customer service'
			)
		);
		echo '<script type="application/ld+json">' . json_encode( $schema ) . '</script>';
	}

	if ( is_singular( 'member' ) || is_singular( 'business' ) ) {
		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'LocalBusiness',
			'name'     => get_the_title(),
			'description' => get_the_excerpt(),
			'image'    => get_the_post_thumbnail_url(),
			'address'  => array(
				'@type' => 'PostalAddress',
				'streetAddress' => get_post_meta( get_the_ID(), '_member_address', true ) ?: ''
			)
		);
		echo '<script type="application/ld+json">' . json_encode( $schema ) . '</script>';
	}
}
add_action( 'wp_head', 'org_ecosystem_schema_markup' );

/**
 * Security Hardening
 */
function org_ecosystem_security_hardening() {
	// Remove WP version
	remove_action( 'wp_head', 'wp_generator' );

	// Disable XML-RPC
	add_filter( 'xmlrpc_enabled', '__return_false' );

	// Remove RSD link
	remove_action( 'wp_head', 'rsd_link' );

	// Remove wlwmanifest link
	remove_action( 'wp_head', 'wlwmanifest_link' );
}
add_action( 'init', 'org_ecosystem_security_hardening' );

/**
 * GDPR Compliance Tools
 */
function org_ecosystem_gdpr_notice() {
	if ( ! isset( $_COOKIE['org_cookie_consent'] ) ) :
		?>
		<div id="gdpr-cookie-notice" class="fixed-bottom bg-dark text-white p-3 shadow-lg" style="z-index: 9999;">
			<div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
				<p class="mb-2 mb-md-0 small">
					<?php _e( 'We use cookies to improve your experience. By continuing to visit this site you agree to our use of cookies.', 'org-ecosystem' ); ?>
					<a href="<?php echo get_privacy_policy_url(); ?>" class="text-white text-decoration-underline"><?php _e( 'Privacy Policy', 'org-ecosystem' ); ?></a>
				</p>
				<button id="accept-cookies" class="btn btn-primary btn-sm"><?php _e( 'Accept', 'org-ecosystem' ); ?></button>
			</div>
		</div>
		<script>
			document.getElementById('accept-cookies').addEventListener('click', function() {
				document.cookie = "org_cookie_consent=true; max-age=" + (365 * 24 * 60 * 60) + "; path=/";
				document.getElementById('gdpr-cookie-notice').style.display = 'none';
			});
		</script>
		<?php
	endif;
}
add_action( 'wp_footer', 'org_ecosystem_gdpr_notice' );
