<?php
/**
 * The template for displaying all single member profiles
 *
 * @package OrgEcosystem
 */

get_header();

while ( have_posts() ) :
	the_post();

	$bio = get_post_meta( get_the_ID(), '_member_bio', true );
	$cover_photo = get_post_meta( get_the_ID(), '_member_cover_photo', true );
	$phone = get_post_meta( get_the_ID(), '_member_phone', true );
	$email = get_post_meta( get_the_ID(), '_member_email', true );
	$website = get_post_meta( get_the_ID(), '_member_website', true );
	$business_name = get_post_meta( get_the_ID(), '_member_business_name', true );
	$facebook = get_post_meta( get_the_ID(), '_member_facebook', true );
	$linkedin = get_post_meta( get_the_ID(), '_member_linkedin', true );
	$twitter = get_post_meta( get_the_ID(), '_member_twitter', true );
	$is_featured = get_post_meta( get_the_ID(), '_member_is_featured', true );
	$is_verified = get_post_meta( get_the_ID(), '_member_is_verified', true );
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'member-profile-single pb-5' ); ?>>
		<?php if ( $cover_photo ) : ?>
			<div class="member-cover-photo" style="height: 300px; background: url('<?php echo esc_url( $cover_photo ); ?>') no-repeat center center; background-size: cover;"></div>
		<?php endif; ?>
		<div class="container <?php echo $cover_photo ? 'mt-n5' : 'py-5'; ?>">
			<?php org_ecosystem_breadcrumbs(); ?>
			<div class="row">
				<div class="col-md-4">
					<div class="member-card shadow-sm border rounded p-4 text-center bg-white mb-4">
						<div class="member-photo mb-3">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium', array( 'class' => 'rounded-circle shadow-sm', 'style' => 'width: 150px; height: 150px; object-fit: cover;' ) ); ?>
							<?php else : ?>
								<img src="<?php echo ORG_ECOSYSTEM_URI . '/assets/images/default-avatar.png'; ?>" class="rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
							<?php endif; ?>
						</div>
						<h1 class="h3 member-name mb-1"><?php the_title(); ?></h1>
						<?php if ( $business_name ) : ?>
							<p class="text-muted mb-3"><?php echo esc_html( $business_name ); ?></p>
						<?php endif; ?>

						<div class="badges mb-3">
							<?php if ( $is_verified ) : ?>
								<span class="badge bg-success me-1"><i class="bi bi-check-circle-fill"></i> Verified</span>
							<?php endif; ?>
							<?php if ( $is_featured ) : ?>
								<span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> Featured</span>
							<?php endif; ?>
						</div>

						<div class="member-contact list-group list-group-flush text-start mb-4">
							<?php
							$can_view = true;
							if ( get_theme_mod( 'protect_leads', false ) ) {
								$curr_user_id = get_current_user_id();
								$level = get_user_meta( $curr_user_id, '_membership_level', true );
								if ( ! is_user_logged_in() || ! in_array( $level, array( 'premium', 'corporate', 'lifetime' ) ) ) {
									$can_view = false;
								}
							}

							if ( $can_view ) : ?>
								<?php if ( $phone ) : ?>
									<div class="list-group-item px-0"><i class="bi bi-telephone me-2 text-primary"></i> <?php echo esc_html( $phone ); ?></div>
								<?php endif; ?>
								<?php if ( $email ) : ?>
									<div class="list-group-item px-0"><i class="bi bi-envelope me-2 text-primary"></i> <?php echo esc_html( $email ); ?></div>
								<?php endif; ?>
								<?php if ( $website ) : ?>
									<div class="list-group-item px-0"><i class="bi bi-globe me-2 text-primary"></i> <a href="<?php echo esc_url( $website ); ?>" target="_blank">Website</a></div>
								<?php endif; ?>
							<?php else : ?>
								<div class="list-group-item px-0 py-3 text-center bg-light border rounded">
									<i class="bi bi-lock-fill text-muted d-block mb-2 h4"></i>
									<p class="small text-muted mb-2"><?php _e( 'Contact details are restricted to Premium members.', 'org-ecosystem' ); ?></p>
									<a href="<?php echo home_url( '/membership-plans' ); ?>" class="btn btn-primary btn-sm fw-bold"><?php _e( 'Upgrade to View', 'org-ecosystem' ); ?></a>
								</div>
							<?php endif; ?>
						</div>

						<div class="member-social d-flex justify-content-center gap-3 mb-4">
							<?php if ( $can_view ) : ?>
								<?php if ( $facebook ) : ?><a href="<?php echo esc_url( $facebook ); ?>" class="text-primary h4"><i class="bi bi-facebook"></i></a><?php endif; ?>
								<?php if ( $linkedin ) : ?><a href="<?php echo esc_url( $linkedin ); ?>" class="text-primary h4"><i class="bi bi-linkedin"></i></a><?php endif; ?>
								<?php if ( $twitter ) : ?><a href="<?php echo esc_url( $twitter ); ?>" class="text-primary h4"><i class="bi bi-twitter"></i></a><?php endif; ?>
							<?php endif; ?>
						</div>

                        <?php if ( is_user_logged_in() ) : ?>
                            <div class="d-grid px-3">
                                <button type="button" class="btn btn-primary rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#directMessageModal">
                                    <i class="bi bi-chat-dots me-2"></i> <?php _e( 'Message Member', 'org-ecosystem' ); ?>
                                </button>
                            </div>
                        <?php endif; ?>
					</div>
				</div>

				<div class="col-md-8">
					<div class="member-content-area bg-white p-4 shadow-sm border rounded">
						<h2 class="h4 mb-4"><?php _e( 'About', 'org-ecosystem' ); ?></h2>
						<div class="member-bio mb-5">
							<?php if ( $bio ) : ?>
								<?php echo wpautop( esc_html( $bio ) ); ?>
							<?php else : ?>
								<?php the_content(); ?>
							<?php endif; ?>
						</div>

						<hr>

						<div class="member-details row mt-4">
							<div class="col-md-6 mb-4">
								<h5 class="fw-bold"><?php _e( 'Industries', 'org-ecosystem' ); ?></h5>
								<?php the_terms( get_the_ID(), 'industry', '<div class="d-flex flex-wrap gap-2">', '', '</div>' ); ?>
							</div>
							<div class="col-md-6 mb-4">
								<h5 class="fw-bold"><?php _e( 'Skills & Expertise', 'org-ecosystem' ); ?></h5>
								<?php the_terms( get_the_ID(), 'skill', '<div class="d-flex flex-wrap gap-2">', '', '</div>' ); ?>
							</div>
						</div>

						<?php
						$certs = get_post_meta( get_the_ID(), '_member_certifications', true );
						if ( $certs ) : ?>
							<hr>
							<div class="member-certifications mt-4">
								<h5 class="fw-bold"><?php _e( 'Certifications', 'org-ecosystem' ); ?></h5>
								<p><?php echo nl2br( esc_html( $certs ) ); ?></p>
							</div>
						<?php endif; ?>

						<?php
						$gallery = get_post_meta( get_the_ID(), '_member_gallery', true );
						if ( $gallery ) :
							$images = explode( ',', $gallery );
							?>
							<hr>
							<div class="member-gallery mt-4">
								<h5 class="fw-bold mb-3"><?php _e( 'Gallery', 'org-ecosystem' ); ?></h5>
								<div class="row g-2">
									<?php foreach ( $images as $img_url ) : ?>
										<div class="col-4">
											<img src="<?php echo esc_url( trim( $img_url ) ); ?>" class="img-fluid rounded shadow-sm">
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php
						$files = get_post_meta( get_the_ID(), '_member_files', true );
						if ( $files ) :
							$file_list = explode( ',', $files );
							?>
							<hr>
							<div class="member-files mt-4">
								<h5 class="fw-bold mb-3"><?php _e( 'Downloadable Resources', 'org-ecosystem' ); ?></h5>
								<div class="list-group shadow-sm">
									<?php foreach ( $file_list as $file_url ) :
										$file_name = basename( trim( $file_url ) );
										?>
										<a href="<?php echo esc_url( trim( $file_url ) ); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" target="_blank">
											<span><i class="bi bi-file-earmark-arrow-down me-2 text-primary"></i> <?php echo esc_html( $file_name ); ?></span>
											<span class="badge bg-light text-primary border"><?php _e( 'Download', 'org-ecosystem' ); ?></span>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php
						$map = get_post_meta( get_the_ID(), '_member_map_location', true );
						if ( $map ) : ?>
							<hr>
							<div class="member-map mt-4">
								<h5 class="fw-bold mb-3"><?php _e( 'Location', 'org-ecosystem' ); ?></h5>
								<div class="ratio ratio-16x9">
									<iframe src="<?php echo esc_url( $map ); ?>" allowfullscreen="" loading="lazy"></iframe>
								</div>
							</div>
						<?php endif; ?>

						<hr>
						<div class="member-products mt-4">
							<h5 class="fw-bold mb-4"><?php _e( 'Products & Services', 'org-ecosystem' ); ?></h5>
							<?php
							$products = new WP_Query( array(
								'post_type' => 'product',
								'author'    => get_the_author_meta('ID'),
								'posts_per_page' => 6
							) );

							if ( $products->have_posts() ) : ?>
								<div class="row g-3">
									<?php while ( $products->have_posts() ) : $products->the_post(); ?>
										<div class="col-md-6">
											<div class="card h-100 shadow-sm border">
												<div class="card-body p-3">
													<h6 class="fw-bold mb-1"><?php the_title(); ?></h6>
													<p class="text-muted small mb-2"><?php echo wp_trim_words( get_the_excerpt(), 10 ); ?></p>
													<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary"><?php _e( 'View Details', 'org-ecosystem' ); ?></a>
												</div>
											</div>
										</div>
									<?php endwhile; wp_reset_postdata(); ?>
								</div>
							<?php else : ?>
								<p class="text-muted small"><?php _e( 'No products listed yet.', 'org-ecosystem' ); ?></p>
							<?php endif; ?>
						</div>

						<hr>
                        <div class="member-announcements mt-4">
							<h5 class="fw-bold mb-4"><?php _e( 'Latest Updates', 'org-ecosystem' ); ?></h5>
							<?php
							$announcements = new WP_Query( array(
								'post_type' => 'announcement',
								'author'    => get_the_author_meta('ID'),
								'posts_per_page' => 3
							) );

							if ( $announcements->have_posts() ) : ?>
								<div class="list-group list-group-flush shadow-sm rounded-4 overflow-hidden border">
									<?php while ( $announcements->have_posts() ) : $announcements->the_post(); ?>
										<a href="<?php the_permalink(); ?>" class="list-group-item list-group-item-action p-3">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1 fw-bold"><?php the_title(); ?></h6>
                                                <small class="text-muted"><?php echo get_the_date(); ?></small>
                                            </div>
                                            <p class="mb-1 small text-muted"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                                        </a>
									<?php endwhile; wp_reset_postdata(); ?>
								</div>
							<?php else : ?>
								<p class="text-muted small"><?php _e( 'No recent announcements.', 'org-ecosystem' ); ?></p>
							<?php endif; ?>
						</div>

						<hr>
                        <div class="member-programs mt-4">
							<h5 class="fw-bold mb-4"><?php _e( 'Active Programs & Projects', 'org-ecosystem' ); ?></h5>
							<?php
							$programs = new WP_Query( array(
								'post_type' => 'program',
								'author'    => get_the_author_meta('ID'),
								'posts_per_page' => 3
							) );

							if ( $programs->have_posts() ) : ?>
								<div class="row g-3">
									<?php while ( $programs->have_posts() ) : $programs->the_post(); ?>
										<div class="col-md-6">
											<div class="card h-100 border-0 shadow-sm bg-light">
												<div class="card-body">
													<h6 class="fw-bold mb-1"><?php the_title(); ?></h6>
													<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-link p-0 text-decoration-none small"><?php _e( 'Learn More', 'org-ecosystem' ); ?></a>
												</div>
											</div>
										</div>
									<?php endwhile; wp_reset_postdata(); ?>
								</div>
							<?php else : ?>
								<p class="text-muted small"><?php _e( 'No active programs listed.', 'org-ecosystem' ); ?></p>
							<?php endif; ?>
						</div>

						<hr>
						<div class="member-contact-form mt-4">
							<h5 class="fw-bold mb-3"><?php _e( 'Send a Message', 'org-ecosystem' ); ?></h5>
							<?php org_ecosystem_inquiry_form( get_the_ID() ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>

    <!-- Message Modal -->
    <div class="modal fade" id="directMessageModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 rounded-4 shadow-lg" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
          <input type="hidden" name="action" value="org_send_message">
          <input type="hidden" name="receiver_id" value="<?php echo get_the_author_meta('ID'); ?>">
          <?php wp_nonce_field( 'org_send_message', 'org_message_nonce' ); ?>

          <div class="modal-header border-0 p-4">
            <h5 class="modal-title fw-bold"><?php _e( 'New Message', 'org-ecosystem' ); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4 pt-0">
            <div class="mb-3">
                <label class="form-label small fw-bold text-uppercase"><?php _e( 'Subject', 'org-ecosystem' ); ?></label>
                <input type="text" name="msg_subject" class="form-control bg-light border-0 py-2" placeholder="Brief topic..." required>
            </div>
            <div class="mb-0">
                <label class="form-label small fw-bold text-uppercase"><?php _e( 'Your Message', 'org-ecosystem' ); ?></label>
                <textarea name="msg_content" class="form-control bg-light border-0 py-2" rows="6" placeholder="Write your message here..." required></textarea>
            </div>
          </div>
          <div class="modal-footer border-0 p-4 pt-0">
            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold"><?php _e( 'Send Direct Message', 'org-ecosystem' ); ?></button>
          </div>
        </form>
      </div>
    </div>

<?php
endwhile;

get_footer();
