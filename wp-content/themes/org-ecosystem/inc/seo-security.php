<?php
/**
 * SEO, Security, and GDPR Logic
 *
 * @package OrgEcosystem
 */

/**
 * Add Schema.org Markup to Header
 */
function org_ecosystem_seo_meta_tags() {
	$description = get_bloginfo( 'description' );
	$title = get_bloginfo( 'name' );
	$url = home_url( '/' );
	$image = get_site_icon_url();

	if ( is_singular() ) {
		global $post;
		$title = get_the_title() . ' - ' . get_bloginfo( 'name' );
		$url = get_permalink();
		$description = wp_trim_words( strip_shortcodes( $post->post_content ), 25 );
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( $post->ID, 'large' );
		}
	}
	?>
	<meta name="description" content="<?php echo esc_attr( $description ); ?>">

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>">
	<meta property="og:url" content="<?php echo esc_url( $url ); ?>">
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
	<meta property="og:image" content="<?php echo esc_url( $image ); ?>">

	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="<?php echo esc_url( $url ); ?>">
	<meta property="twitter:title" content="<?php echo esc_attr( $title ); ?>">
	<meta property="twitter:description" content="<?php echo esc_attr( $description ); ?>">
	<meta property="twitter:image" content="<?php echo esc_url( $image ); ?>">
	<?php
}
add_action( 'wp_head', 'org_ecosystem_seo_meta_tags', 1 );

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

	if ( is_singular( 'event' ) ) {
		$schema = array(
			'@context'   => 'https://schema.org',
			'@type'      => 'Event',
			'name'       => get_the_title(),
			'startDate'  => get_post_meta( get_the_ID(), '_event_date', true ),
			'location'   => array(
				'@type' => 'Place',
				'name'  => get_post_meta( get_the_ID(), '_event_venue', true ),
			),
			'description' => get_the_excerpt(),
		);
		echo '<script type="application/ld+json">' . json_encode( $schema ) . '</script>';
	}

	if ( is_singular( 'job' ) ) {
		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'JobPosting',
			'title'    => get_the_title(),
			'description' => get_the_content(),
			'datePosted'  => get_the_date( 'c' ),
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

/**
 * Register Custom Fields for REST API
 */
function org_ecosystem_register_rest_fields() {
	// Member Profile Meta
	register_rest_field( 'member', 'profile_details', array(
		'get_callback' => function( $post_arr ) {
			$post_id = $post_arr['id'];
			return array(
				'business_name' => get_post_meta( $post_id, '_member_business_name', true ),
				'bio'           => get_post_meta( $post_id, '_member_bio', true ),
				'phone'         => get_post_meta( $post_id, '_member_phone', true ),
				'email'         => get_post_meta( $post_id, '_member_email', true ),
				'website'       => get_post_meta( $post_id, '_member_website', true ),
				'status'        => get_post_meta( $post_id, '_member_status', true ),
				'is_verified'   => get_post_meta( $post_id, '_member_is_verified', true ) === '1',
				'is_featured'   => get_post_meta( $post_id, '_member_is_featured', true ) === '1',
				'join_date'     => get_post_meta( $post_id, '_member_join_date', true ),
				'renewal_date'  => get_post_meta( $post_id, '_member_renewal_date', true ),
			);
		},
		'schema' => null,
	) );

	// Business Profile Meta
	register_rest_field( 'business', 'business_details', array(
		'get_callback' => function( $post_arr ) {
			$post_id = $post_arr['id'];
			return array(
				'phone'    => get_post_meta( $post_id, '_business_phone', true ),
				'location' => get_the_terms( $post_id, 'location' ),
				'industry' => get_the_terms( $post_id, 'industry' ),
			);
		},
		'schema' => null,
	) );
}
add_action( 'rest_api_init', 'org_ecosystem_register_rest_fields' );
