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
	<header id="masthead" class="site-header sticky-top">
		<div class="container d-flex justify-content-between align-items-center">
			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) :
					the_custom_logo();
				else :
					?>
					<h1 class="site-title mb-0 h4"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-decoration-none text-dark fw-bold"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				endif;
				?>
			</div>

			<nav id="site-navigation" class="main-navigation d-none d-lg-block">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'menu_class'     => 'nav main-menu',
				) );
				?>
			</nav>

			<div class="header-actions d-flex align-items-center gap-2">
				<div class="d-none d-md-flex gap-2">
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( home_url( '/dashboard' ) ); ?>" class="btn btn-primary btn-sm px-4 rounded-pill"><?php esc_html_e( 'Dashboard', 'org-ecosystem' ); ?></a>
						<a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn-outline-secondary btn-sm px-4 rounded-pill"><?php esc_html_e( 'Logout', 'org-ecosystem' ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( wp_login_url() ); ?>" class="btn btn-link btn-sm text-decoration-none text-dark fw-bold"><?php esc_html_e( 'Login', 'org-ecosystem' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/join' ) ); ?>" class="btn btn-primary btn-sm px-4 rounded-pill shadow-sm"><?php esc_html_e( 'Join Now', 'org-ecosystem' ); ?></a>
					<?php endif; ?>
				</div>
				<button class="btn btn-light d-lg-none rounded-circle shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" style="width: 45px; height: 45px;">
					<i class="bi bi-list fs-4"></i>
				</button>
			</div>
		</div>
	</header>

	<!-- Mobile Menu Offcanvas -->
	<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
		<div class="offcanvas-header border-bottom">
			<div class="d-flex align-items-center">
				<?php if ( has_custom_logo() ) :
					the_custom_logo();
				else : ?>
					<h5 class="offcanvas-title fw-bold mb-0" id="mobileMenuLabel"><?php bloginfo( 'name' ); ?></h5>
				<?php endif; ?>
			</div>
			<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body p-0">
			<div class="p-4 border-bottom mb-3">
				<?php if ( is_user_logged_in() ) :
					$curr_user = wp_get_current_user(); ?>
					<div class="d-flex align-items-center p-3 bg-light rounded-4">
						<div class="me-3">
							<?php echo get_avatar( $curr_user->ID, 50, '', '', array('class' => 'rounded-circle border border-2 border-white shadow-sm') ); ?>
						</div>
						<div>
							<h6 class="mb-0 fw-bold"><?php echo esc_html( $curr_user->display_name ); ?></h6>
							<span class="small text-muted"><?php _e( 'Professional Member', 'org-ecosystem' ); ?></span>
						</div>
					</div>
				<?php else : ?>
					<div class="bg-primary text-white p-4 rounded-4 shadow-sm mb-2">
						<h6 class="fw-bold mb-2"><?php _e( 'Welcome to our Community', 'org-ecosystem' ); ?></h6>
						<p class="small mb-3 opacity-75"><?php _e( 'Join us to access exclusive resources and networking.', 'org-ecosystem' ); ?></p>
						<a href="<?php echo esc_url( home_url( '/join' ) ); ?>" class="btn btn-light btn-sm w-100 fw-bold rounded-pill"><?php _e( 'Join Now', 'org-ecosystem' ); ?></a>
					</div>
				<?php endif; ?>
			</div>

			<div class="mobile-nav-container py-2">
				<?php
				// We'll use a custom walker or just standard menu, but let's ensure it has icons via CSS or filter
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav flex-column mobile-nav-list',
					'fallback_cb'    => false,
				) );
				?>
			</div>

			<div class="mobile-footer mt-auto p-4 border-top bg-light">
				<div class="d-grid gap-2 mb-4">
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( home_url( '/dashboard' ) ); ?>" class="btn btn-primary rounded-pill"><i class="bi bi-grid-fill me-2"></i> <?php esc_html_e( 'Dashboard', 'org-ecosystem' ); ?></a>
						<a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn-outline-danger rounded-pill"><i class="bi bi-box-arrow-right me-2"></i> <?php esc_html_e( 'Logout', 'org-ecosystem' ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( wp_login_url() ); ?>" class="btn btn-outline-primary rounded-pill"><i class="bi bi-person-fill me-2"></i> <?php esc_html_e( 'Sign In', 'org-ecosystem' ); ?></a>
					<?php endif; ?>
				</div>

				<div class="social-links d-flex justify-content-center gap-4">
					<?php
					$socials = array('facebook', 'twitter', 'linkedin', 'instagram');
					foreach ( $socials as $social ) :
						$url = get_theme_mod( 'org_social_' . $social );
						if ( $url ) : ?>
							<a href="<?php echo esc_url( $url ); ?>" class="text-secondary fs-4"><i class="bi bi-<?php echo $social; ?>"></i></a>
						<?php endif;
					endforeach; ?>
				</div>
			</div>
		</div>
	</div>
