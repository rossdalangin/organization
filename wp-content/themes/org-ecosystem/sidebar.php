<?php
/**
 * The sidebar containing the main widget area
 *
 * @package OrgEcosystem
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php
	if ( get_theme_mod( 'show_sponsor_in_sidebar', true ) ) {
		get_template_part( 'template-parts/content', 'sponsor' );
	}

	dynamic_sidebar( 'sidebar-1' );
	?>
</aside>
