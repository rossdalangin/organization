<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header id="masthead" class="site-header sticky-top bg-white shadow-sm">
		<div class="container d-flex justify-content-between align-items-center py-3">
			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) :
					the_custom_logo();
				else :
					?>
					<h1 class="site-title mb-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				endif;
				?>
			</div>
			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle d-md-none" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'org-ecosystem' ); ?></button>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'menu_class'     => 'nav main-menu d-none d-md-flex',
				) );
				?>
			</nav>
			<div class="header-actions d-flex align-items-center">
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( home_url( '/dashboard' ) ); ?>" class="btn btn-outline-primary btn-sm me-2"><?php esc_html_e( 'Dashboard', 'org-ecosystem' ); ?></a>
					<a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn-link btn-sm"><?php esc_html_e( 'Logout', 'org-ecosystem' ); ?></a>
				<?php else : ?>
					<a href="<?php echo esc_url( wp_login_url() ); ?>" class="btn btn-link btn-sm me-2"><?php esc_html_e( 'Login', 'org-ecosystem' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/join' ) ); ?>" class="btn btn-primary btn-sm"><?php esc_html_e( 'Join Now', 'org-ecosystem' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</header>
