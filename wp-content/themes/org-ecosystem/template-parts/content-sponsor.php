<?php
/**
 * Template part for displaying a sponsor banner
 */

$image = get_theme_mod( 'sponsor_banner_image' );
$link = get_theme_mod( 'sponsor_banner_link', '#' );

if ( $image ) :
?>
<div class="sponsor-banner mb-4 text-center">
	<p class="small text-muted text-uppercase fw-bold mb-2"><?php _e( 'Sponsored', 'org-ecosystem' ); ?></p>
	<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="nofollow">
		<img src="<?php echo esc_url( $image ); ?>" alt="Sponsor" class="img-fluid rounded shadow-sm border">
	</a>
</div>
<?php endif; ?>
