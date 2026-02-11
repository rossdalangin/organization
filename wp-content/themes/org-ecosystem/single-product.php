<?php
/**
 * The template for displaying single products
 *
 * @package OrgEcosystem
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'product-single py-5' ); ?>>
		<div class="container">
			<div class="row">
				<div class="col-md-6 mb-4">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded shadow' ) ); ?>
					<?php else : ?>
						<div class="bg-light rounded shadow d-flex align-items-center justify-content-center" style="height: 400px;">
							<i class="bi bi-box text-secondary display-1"></i>
						</div>
					<?php endif; ?>
				</div>
				<div class="col-md-6">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo get_post_type_archive_link( 'product' ); ?>"><?php _e( 'Products', 'org-ecosystem' ); ?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
						</ol>
					</nav>
					<h1 class="display-5 fw-bold mb-3"><?php the_title(); ?></h1>
					<?php the_terms( get_the_ID(), 'product_cat', '<div class="mb-4">', ' ', '</div>' ); ?>

					<div class="product-price h3 text-primary fw-bold mb-4">
						<?php echo esc_html( get_post_meta( get_the_ID(), '_product_price', true ) ); ?>
					</div>

					<div class="product-description mb-5">
						<?php the_content(); ?>
					</div>

					<?php
					$business_id = get_post_meta( get_the_ID(), '_product_business_id', true );
					if ( $business_id ) : ?>
						<div class="card bg-light border-0 p-3 mb-4">
							<div class="d-flex align-items-center">
								<div class="me-3">
									<?php if ( has_post_thumbnail( $business_id ) ) echo get_the_post_thumbnail( $business_id, array( 50, 50 ), array( 'class' => 'rounded-circle' ) ); ?>
								</div>
								<div>
									<h6 class="mb-0"><?php _e( 'Sold by', 'org-ecosystem' ); ?> <strong><?php echo get_the_title( $business_id ); ?></strong></h6>
									<a href="<?php echo get_permalink( $business_id ); ?>" class="small text-decoration-none"><?php _e( 'Visit Store', 'org-ecosystem' ); ?></a>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<div class="d-grid mb-5">
						<a href="#inquiry-form-wrapper" class="btn btn-primary btn-lg"><?php _e( 'Inquire About Product', 'org-ecosystem' ); ?></a>
					</div>

					<div class="inquiry-section bg-white p-4 border rounded shadow-sm">
						<h5 class="fw-bold mb-3"><?php _e( 'Send Inquiry', 'org-ecosystem' ); ?></h5>
						<?php org_ecosystem_inquiry_form( get_the_ID() ); ?>
					</div>
				</div>
			</div>
		</div>
	</article>

<?php
endwhile;

get_footer();
