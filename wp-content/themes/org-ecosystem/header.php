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
			<nav id="site-navigation" class="main-navigation d-none d-md-block">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'menu_class'     => 'nav main-menu d-flex',
				) );
				?>
			</nav>

			<div class="header-actions d-flex align-items-center">
				<div class="d-md-none me-2">
					<button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
						<i class="bi bi-list"></i> <?php esc_html_e( 'Menu', 'org-ecosystem' ); ?>
					</button>
				</div>
				<div class="d-none d-md-flex">
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( home_url( '/dashboard' ) ); ?>" class="btn btn-outline-primary btn-sm me-2"><?php esc_html_e( 'Dashboard', 'org-ecosystem' ); ?></a>
						<a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn-link btn-sm"><?php esc_html_e( 'Logout', 'org-ecosystem' ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( wp_login_url() ); ?>" class="btn btn-link btn-sm me-2"><?php esc_html_e( 'Login', 'org-ecosystem' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/join' ) ); ?>" class="btn btn-primary btn-sm"><?php esc_html_e( 'Join Now', 'org-ecosystem' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</header>

	<!-- Mobile Menu Offcanvas -->
	<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
		<div class="offcanvas-header">
			<h5 class="offcanvas-title fw-bold" id="mobileMenuLabel"><?php bloginfo( 'name' ); ?></h5>
			<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav flex-column mobile-nav-list mb-4',
			) );
			?>
			<hr>
			<div class="mobile-actions d-grid gap-2">
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( home_url( '/dashboard' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Dashboard', 'org-ecosystem' ); ?></a>
					<a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn-outline-danger"><?php esc_html_e( 'Logout', 'org-ecosystem' ); ?></a>
				<?php else : ?>
					<a href="<?php echo esc_url( wp_login_url() ); ?>" class="btn btn-outline-primary"><?php esc_html_e( 'Login', 'org-ecosystem' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/join' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Join Now', 'org-ecosystem' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
