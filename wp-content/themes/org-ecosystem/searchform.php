<?php
/**
 * The search form template
 *
 * @package OrgEcosystem
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<input type="search" class="form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'org-ecosystem' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
		<button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
	</div>
</form>
