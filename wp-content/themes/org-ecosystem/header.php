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
		<div class="offcanvas-header border-bottom py-4">
			<div class="d-flex align-items-center">
				<?php if ( has_custom_logo() ) :
					the_custom_logo();
				else : ?>
					<h5 class="offcanvas-title fw-bold mb-0" id="mobileMenuLabel"><?php bloginfo( 'name' ); ?></h5>
				<?php endif; ?>
			</div>
			<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body px-0">
			<div class="px-4 mb-4">
				<?php if ( is_user_logged_in() ) :
					$curr_user = wp_get_current_user(); ?>
					<div class="d-flex align-items-center p-3 bg-light rounded-4">
						<div class="me-3">
							<?php echo get_avatar( $curr_user->ID, 48, '', '', array('class' => 'rounded-circle') ); ?>
						</div>
						<div>
							<h6 class="mb-0 fw-bold"><?php echo esc_html( $curr_user->display_name ); ?></h6>
							<span class="small text-muted"><?php _e( 'Member', 'org-ecosystem' ); ?></span>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="mobile-nav-container px-3">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav flex-column mobile-nav-list mb-4',
				) );
				?>
			</div>

			<div class="mobile-actions px-4 d-grid gap-2 mt-auto pb-4">
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( home_url( '/dashboard' ) ); ?>" class="btn btn-primary"><i class="bi bi-speedometer2 me-2"></i> <?php esc_html_e( 'Dashboard', 'org-ecosystem' ); ?></a>
					<a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn-outline-danger"><i class="bi bi-box-arrow-right me-2"></i> <?php esc_html_e( 'Logout', 'org-ecosystem' ); ?></a>
				<?php else : ?>
					<a href="<?php echo esc_url( wp_login_url() ); ?>" class="btn btn-outline-primary"><i class="bi bi-person me-2"></i> <?php esc_html_e( 'Login', 'org-ecosystem' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/join' ) ); ?>" class="btn btn-primary"><i class="bi bi-person-plus me-2"></i> <?php esc_html_e( 'Join Now', 'org-ecosystem' ); ?></a>
				<?php endif; ?>

				<div class="social-links d-flex justify-content-center gap-3 mt-4">
					<?php
					$socials = array('facebook', 'twitter', 'linkedin', 'instagram');
					foreach ( $socials as $social ) :
						$url = get_theme_mod( 'org_social_' . $social );
						if ( $url ) : ?>
							<a href="<?php echo esc_url( $url ); ?>" class="text-muted h4"><i class="bi bi-<?php echo $social; ?>"></i></a>
						<?php endif;
					endforeach; ?>
				</div>
			</div>
		</div>
	</div>
