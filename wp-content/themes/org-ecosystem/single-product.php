<?php
/**
 * The template for displaying single products
 *
 * @package OrgEcosystem
 */

get_header();

while ( have_posts() ) :
	the_post();
    $price = get_post_meta( get_the_ID(), '_product_price', true );
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'product-single pb-5' ); ?>>
		<div class="container py-5">
			<?php org_ecosystem_breadcrumbs(); ?>
			<div class="row g-5 mt-2">
				<div class="col-md-6 animate-fade-in-up position-relative">
                    <?php
                    $is_featured = get_post_meta( get_the_ID(), '_product_is_featured', true );
                    $is_solution = get_post_meta( get_the_ID(), '_product_is_solution', true );
                    if ( $is_featured ) : ?>
                        <div class="featured-ribbon bg-warning text-dark fw-bold px-4 py-1 position-absolute top-0 start-0 translate-middle-y ms-3 shadow-sm rounded-pill" style="z-index: 10;">
                            <i class="bi bi-star-fill me-1"></i> <?php _e( 'Featured Offering', 'org-ecosystem' ); ?>
                        </div>
                    <?php endif; ?>

					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded-4 shadow-lg border p-2 bg-white' ) ); ?>
					<?php else : ?>
						<div class="bg-white border rounded-4 shadow-sm d-flex align-items-center justify-content-center" style="height: 500px;">
							<i class="bi bi-box text-light display-1"></i>
						</div>
					<?php endif; ?>
				</div>
				<div class="col-md-6 animate-fade-in-up" style="animation-delay: 0.2s;">
					<div class="product-badge mb-3">
                        <?php the_terms( get_the_ID(), 'product_cat', '<span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">', ' ', '</span>' ); ?>
                    </div>
                    <h1 class="display-4 fw-bold mb-3">
                        <?php the_title(); ?>
                        <?php if ( $is_solution ) : ?>
                            <span class="ms-2" title="<?php _e( 'Verified Enterprise Solution', 'org-ecosystem' ); ?>"><i class="bi bi-patch-check-fill text-primary fs-2"></i></span>
                        <?php endif; ?>
                    </h1>

					<div class="product-price h2 text-primary fw-bold mb-4">
						₱ <?php echo number_format( floatval($price), 2 ); ?>
					</div>

                    <div class="d-flex gap-4 mb-4 small text-uppercase fw-bold letter-spacing-1">
                        <?php
                        $stock = get_post_meta( get_the_ID(), '_product_stock', true ) ?: 'instock';
                        $sku = get_post_meta( get_the_ID(), '_product_sku', true );
                        ?>
                        <span class="<?php echo $stock === 'instock' ? 'text-success' : 'text-danger'; ?>">
                            <i class="bi <?php echo $stock === 'instock' ? 'bi-check-circle' : 'bi-x-circle'; ?> me-1"></i>
                            <?php echo $stock === 'instock' ? __( 'In Stock', 'org-ecosystem' ) : __( 'Out of Stock', 'org-ecosystem' ); ?>
                        </span>
                        <?php if ( $sku ) : ?>
                            <span class="text-muted">SKU: <?php echo esc_html( $sku ); ?></span>
                        <?php endif; ?>
                    </div>

					<div class="product-description mb-4 fs-5 text-muted">
						<?php the_content(); ?>
					</div>

                    <?php
                    $features = get_post_meta( get_the_ID(), '_product_features', true );
                    if ( $features ) :
                        $feature_list = explode( "\n", $features );
                    ?>
                        <div class="product-features mb-5">
                            <h5 class="fw-bold mb-3"><?php _e( 'Key Features', 'org-ecosystem' ); ?></h5>
                            <ul class="list-unstyled">
                                <?php foreach ( $feature_list as $feature ) : if(trim($feature)) : ?>
                                    <li class="mb-2 d-flex align-items-center"><i class="bi bi-check2-circle text-primary me-2"></i> <?php echo esc_html( $feature ); ?></li>
                                <?php endif; endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

					<?php
					$business_id = get_post_meta( get_the_ID(), '_product_business_id', true );
					if ( $business_id ) : ?>
						<div class="card border-0 bg-light p-4 mb-5 rounded-4 d-flex flex-row align-items-center">
							<div class="me-4">
								<?php if ( has_post_thumbnail( $business_id ) ) : ?>
                                    <?php echo get_the_post_thumbnail( $business_id, array( 60, 60 ), array( 'class' => 'rounded-circle border border-2 border-white shadow-sm' ) ); ?>
                                <?php else : ?>
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px;"><i class="bi bi-shop"></i></div>
                                <?php endif; ?>
							</div>
							<div>
								<h6 class="mb-1 fw-bold"><?php _e( 'Verified Seller', 'org-ecosystem' ); ?></h6>
								<h5 class="mb-2"><?php echo get_the_title( $business_id ); ?></h5>
								<a href="<?php echo get_permalink( $business_id ); ?>" class="btn btn-sm btn-link p-0 text-decoration-none fw-bold"><?php _e( 'Visit Storefront', 'org-ecosystem' ); ?> <i class="bi bi-arrow-right"></i></a>
							</div>
						</div>
					<?php endif; ?>

					<div class="d-grid gap-3 mb-5">
                        <a href="<?php echo esc_url( add_query_arg( array('dash_page' => 'checkout', 'checkout_type' => 'product', 'checkout_item_id' => get_the_ID()), org_ecosystem_get_page_url('page-dashboard.php') ) ); ?>" class="btn btn-primary btn-lg py-3 fw-bold rounded-pill shadow">
                            <i class="bi bi-cart-check me-2"></i> <?php _e( 'Purchase Now', 'org-ecosystem' ); ?>
                        </a>
                        <?php if ( is_user_logged_in() ) : ?>
                            <button type="button" class="btn btn-outline-primary btn-lg py-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#directMessageModal">
                                <i class="bi bi-chat-dots me-2"></i> <?php _e( 'Message Seller', 'org-ecosystem' ); ?>
                            </button>
                        <?php endif; ?>
                        <a href="#inquiry" class="btn btn-outline-secondary btn-lg py-3 rounded-pill"><?php _e( 'Custom Quote / Inquiry', 'org-ecosystem' ); ?></a>
					</div>

					<div id="inquiry" class="inquiry-section bg-white p-5 border rounded-4 shadow-sm">
						<h4 class="fw-bold mb-4"><?php _e( 'Inquire about this Solution', 'org-ecosystem' ); ?></h4>
						<?php org_ecosystem_inquiry_form( get_the_ID() ); ?>
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
          <input type="hidden" name="receiver_id" value="<?php echo get_post_field('post_author', $business_id); ?>">
          <input type="hidden" name="msg_subject" value="Product Inquiry: <?php the_title(); ?>">
          <?php wp_nonce_field( 'org_send_message', 'org_message_nonce' ); ?>

          <div class="modal-header border-0 p-4">
            <h5 class="modal-title fw-bold"><?php _e( 'Direct Message', 'org-ecosystem' ); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4 pt-0">
            <p class="small text-muted mb-3">Send a direct message to <strong><?php echo get_the_title($business_id); ?></strong> regarding this solution.</p>
            <textarea name="msg_content" class="form-control bg-light border-0" rows="5" placeholder="How can we help you?" required></textarea>
          </div>
          <div class="modal-footer border-0 p-4 pt-0">
            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold"><?php _e( 'Send Message', 'org-ecosystem' ); ?></button>
          </div>
        </form>
      </div>
    </div>


<?php
endwhile;

get_footer();
