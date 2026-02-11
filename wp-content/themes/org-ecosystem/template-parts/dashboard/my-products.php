<?php
/**
 * Dashboard My Products Part
 */
$user_id = get_current_user_id();
$products = new WP_Query( array(
	'post_type' => 'product',
	'author' => $user_id,
	'posts_per_page' => -1,
) );
?>
<div class="d-flex justify-content-between align-items-center mb-4">
	<h2 class="h4 mb-0"><?php _e( 'My Products & Services', 'org-ecosystem' ); ?></h2>
	<a href="#" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> <?php _e( 'Add New', 'org-ecosystem' ); ?></a>
</div>

<div class="row g-4">
	<?php if ( $products->have_posts() ) : ?>
		<?php while ( $products->have_posts() ) : $products->the_post(); ?>
			<div class="col-md-6">
				<div class="card h-100 border shadow-sm">
					<div class="row g-0">
						<div class="col-4">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid rounded-start h-100', 'style' => 'object-fit: cover;' ) ); ?>
							<?php else : ?>
								<div class="bg-light h-100 d-flex align-items-center justify-content-center">
									<i class="bi bi-box text-secondary"></i>
								</div>
							<?php endif; ?>
						</div>
						<div class="col-8">
							<div class="card-body p-3">
								<h6 class="card-title mb-1"><?php the_title(); ?></h6>
								<p class="card-text small text-muted mb-2"><?php echo wp_trim_words( get_the_excerpt(), 10 ); ?></p>
								<div class="d-flex gap-2">
									<a href="#" class="btn btn-sm btn-outline-primary"><?php _e( 'Edit', 'org-ecosystem' ); ?></a>
									<a href="#" class="btn btn-sm btn-outline-danger"><?php _e( 'Delete', 'org-ecosystem' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; wp_reset_postdata(); ?>
	<?php else : ?>
		<div class="col-12 text-center py-5">
			<div class="mb-3 text-muted display-4"><i class="bi bi-box"></i></div>
			<h5><?php _e( 'No products yet', 'org-ecosystem' ); ?></h5>
			<p class="text-muted"><?php _e( 'Start showcasing your products and services to other members.', 'org-ecosystem' ); ?></p>
			<a href="#" class="btn btn-primary"><?php _e( 'Add Your First Product', 'org-ecosystem' ); ?></a>
		</div>
	<?php endif; ?>
</div>
