	<footer id="colophon" class="site-footer bg-dark text-white pt-5 pb-3">
		<div class="container">
			<div class="row">
				<div class="col-md-4 mb-4">
					<div class="footer-widget">
						<h5 class="widget-title mb-3"><?php bloginfo( 'name' ); ?></h5>
						<p><?php bloginfo( 'description' ); ?></p>
						<div class="social-links mt-3 d-flex gap-3">
							<?php
							$socials = array(
								'facebook'  => 'facebook',
								'twitter'   => 'twitter',
								'linkedin'  => 'linkedin',
								'instagram' => 'instagram',
								'youtube'   => 'youtube',
							);
							foreach ( $socials as $key => $icon ) :
								$url = get_theme_mod( 'org_social_' . $key );
								if ( $url ) : ?>
									<a href="<?php echo esc_url( $url ); ?>" class="text-white h5" target="_blank"><i class="bi bi-<?php echo $icon; ?>"></i></a>
								<?php endif;
							endforeach; ?>
						</div>
					</div>
				</div>
				<div class="col-md-2 mb-4">
					<h5 class="widget-title mb-3"><?php esc_html_e( 'Quick Links', 'org-ecosystem' ); ?></h5>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'list-unstyled footer-menu',
					) );
					?>
				</div>
				<div class="col-md-3 mb-4">
					<h5 class="widget-title mb-3"><?php esc_html_e( 'Contact Us', 'org-ecosystem' ); ?></h5>
					<ul class="list-unstyled">
						<li><i class="bi bi-geo-alt me-2"></i> <?php echo esc_html( get_theme_mod( 'org_address', '123 Org St, City, Country' ) ); ?></li>
						<li><i class="bi bi-telephone me-2"></i> <?php echo esc_html( get_theme_mod( 'org_phone', '+1 234 567 890' ) ); ?></li>
						<li><i class="bi bi-envelope me-2"></i> <?php echo esc_html( get_theme_mod( 'org_email', 'info@example.org' ) ); ?></li>
					</ul>
				</div>
				<div class="col-md-3 mb-4">
					<h5 class="widget-title mb-3"><?php esc_html_e( 'Newsletter', 'org-ecosystem' ); ?></h5>
					<p><?php esc_html_e( 'Stay updated with our latest news and events.', 'org-ecosystem' ); ?></p>
					<form class="newsletter-form mt-2" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<input type="hidden" name="action" value="org_newsletter">
						<div class="input-group">
							<input type="email" name="newsletter_email" class="form-control" placeholder="<?php esc_attr_e( 'Your email', 'org-ecosystem' ); ?>" required>
							<button class="btn btn-primary" type="submit"><?php esc_html_e( 'Join', 'org-ecosystem' ); ?></button>
						</div>
					</form>
				</div>
			</div>
			<hr class="bg-secondary">
			<div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
				<p class="mb-0">&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'org-ecosystem' ); ?></p>
				<nav class="footer-legal-nav mt-2 mt-md-0">
					<a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>" class="text-white me-3"><?php esc_html_e( 'Privacy Policy', 'org-ecosystem' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/terms' ) ); ?>" class="text-white"><?php esc_html_e( 'Terms & Conditions', 'org-ecosystem' ); ?></a>
				</nav>
			</div>
		</div>
	</footer>
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
