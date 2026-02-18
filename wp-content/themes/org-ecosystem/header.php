<?php
/**
 * The header for our theme
 *
 * @package OrgEcosystem
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="site-header sticky-top bg-white border-bottom">
	<div class="container py-3">
		<div class="d-flex align-items-center justify-content-between">
			<div class="site-branding d-flex align-items-center">
				<?php
				if ( has_custom_logo() ) :
					the_custom_logo();
				else :
					?>
					<h1 class="site-title h4 mb-0 fw-bold"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-decoration-none text-primary"><?php bloginfo( 'name' ); ?></a></h1>
				<?php endif; ?>
			</div>

			<nav id="site-navigation" class="main-navigation d-none d-lg-block">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'menu_class'     => 'nav gap-4 fw-medium small text-uppercase letter-spacing-1',
				) );
				?>
			</nav>

			<div class="header-actions d-flex align-items-center gap-3">
				<div class="d-none d-md-flex gap-2">
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( org_ecosystem_get_page_url( 'templates/dashboard.php' ) ); ?>" class="btn btn-primary btn-sm px-4 rounded-pill"><?php esc_html_e( 'Dashboard', 'org-ecosystem' ); ?></a>
						<a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn-outline-secondary btn-sm px-4 rounded-pill"><?php esc_html_e( 'Logout', 'org-ecosystem' ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( wp_login_url() ); ?>" class="btn btn-link btn-sm text-decoration-none text-dark fw-bold"><?php esc_html_e( 'Login', 'org-ecosystem' ); ?></a>
						<a href="<?php echo esc_url( org_ecosystem_get_page_url( 'page-join.php' ) ); ?>" class="btn btn-primary btn-sm px-4 rounded-pill shadow-sm"><?php esc_html_e( 'Join Now', 'org-ecosystem' ); ?></a>
					<?php endif; ?>
				</div>
				<button class="btn btn-light d-lg-none rounded-circle shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" style="width: 45px; height: 45px;">
					<i class="bi bi-list fs-4"></i>
				</button>
			</div>
		</div>
	</div>
</header>

<!-- Mobile Menu Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
	<div class="offcanvas-header border-bottom p-4">
		<h5 class="offcanvas-title fw-bold" id="mobileMenuLabel"><?php bloginfo( 'name' ); ?></h5>
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body p-4">
		<?php if ( is_user_logged_in() ) :
			$current_user = wp_get_current_user();
		?>
			<div class="user-preview d-flex align-items-center gap-3 mb-4 p-3 bg-light rounded-4">
				<?php echo get_avatar( $current_user->ID, 48, '', '', array( 'class' => 'rounded-circle shadow-sm border border-2 border-white' ) ); ?>
				<div>
					<h6 class="mb-0 fw-bold"><?php echo esc_html( $current_user->display_name ); ?></h6>
					<span class="small text-muted"><?php echo esc_html( $current_user->user_email ); ?></span>
				</div>
			</div>
		<?php endif; ?>

		<div class="mobile-nav mb-4">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav flex-column gap-3 fw-bold h5',
			) );
			?>
		</div>

		<hr class="my-4">

		<div class="d-grid gap-2 mb-4">
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( org_ecosystem_get_page_url( 'templates/dashboard.php' ) ); ?>" class="btn btn-primary rounded-pill"><i class="bi bi-grid-fill me-2"></i> <?php esc_html_e( 'Dashboard', 'org-ecosystem' ); ?></a>
				<a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn-outline-danger rounded-pill"><i class="bi bi-box-arrow-right me-2"></i> <?php esc_html_e( 'Logout', 'org-ecosystem' ); ?></a>
			<?php else : ?>
				<a href="<?php echo esc_url( wp_login_url() ); ?>" class="btn btn-outline-primary rounded-pill mb-2"><i class="bi bi-person-fill me-2"></i> <?php esc_html_e( 'Sign In', 'org-ecosystem' ); ?></a>
				<a href="<?php echo esc_url( org_ecosystem_get_page_url( 'page-join.php' ) ); ?>" class="btn btn-primary rounded-pill py-3 fw-bold shadow-sm"><?php _e( 'Join the Ecosystem', 'org-ecosystem' ); ?></a>
			<?php endif; ?>
		</div>

		<div class="social-links d-flex gap-3 justify-content-center mt-auto pt-4">
			<?php
			$socials = array( 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube' );
			foreach ( $socials as $soc ) :
				$url = get_theme_mod( 'social_' . $soc );
				if ( $url ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" class="btn btn-light btn-sm rounded-circle shadow-sm" style="width: 35px; height: 35px; padding: 5px;"><i class="bi bi-<?php echo $soc; ?>"></i></a>
				<?php endif;
			endforeach; ?>
		</div>
	</div>
</div>
