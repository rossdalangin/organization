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
							<?php if ( $phone ) : ?>
								<div class="list-group-item px-0"><i class="bi bi-telephone me-2 text-primary"></i> <?php echo esc_html( $phone ); ?></div>
							<?php endif; ?>
							<?php if ( $email ) : ?>
								<div class="list-group-item px-0"><i class="bi bi-envelope me-2 text-primary"></i> <?php echo esc_html( $email ); ?></div>
							<?php endif; ?>
							<?php if ( $website ) : ?>
								<div class="list-group-item px-0"><i class="bi bi-globe me-2 text-primary"></i> <a href="<?php echo esc_url( $website ); ?>" target="_blank">Website</a></div>
							<?php endif; ?>
						</div>

						<div class="member-social d-flex justify-content-center gap-3">
							<?php if ( $facebook ) : ?><a href="<?php echo esc_url( $facebook ); ?>" class="text-primary h4"><i class="bi bi-facebook"></i></a><?php endif; ?>
							<?php if ( $linkedin ) : ?><a href="<?php echo esc_url( $linkedin ); ?>" class="text-primary h4"><i class="bi bi-linkedin"></i></a><?php endif; ?>
							<?php if ( $twitter ) : ?><a href="<?php echo esc_url( $twitter ); ?>" class="text-primary h4"><i class="bi bi-twitter"></i></a><?php endif; ?>
						</div>
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
						<div class="member-contact-form mt-4">
							<h5 class="fw-bold mb-3"><?php _e( 'Send a Message', 'org-ecosystem' ); ?></h5>
							<?php org_ecosystem_inquiry_form( get_the_ID() ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>

<?php
endwhile;

get_footer();
