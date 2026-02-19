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

$edit_id = isset( $_GET['edit_product'] ) ? intval( $_GET['edit_product'] ) : 0;
$product_to_edit = $edit_id ? get_post( $edit_id ) : null;

if ( $product_to_edit && (int) $product_to_edit->post_author !== (int) $user_id ) {
	$product_to_edit = null;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
	<h2 class="h4 mb-0"><?php _e( 'My Products & Services', 'org-ecosystem' ); ?></h2>
	<?php if ( ! $product_to_edit ) : ?>
		<a href="?dash_page=my-products&add_new=1" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> <?php _e( 'Add New', 'org-ecosystem' ); ?></a>
	<?php else : ?>
		<a href="?dash_page=my-products" class="btn btn-secondary btn-sm"><?php _e( 'Back to List', 'org-ecosystem' ); ?></a>
	<?php endif; ?>
</div>

<?php if ( isset( $_GET['add_new'] ) || $product_to_edit ) : ?>
	<div class="card bg-white border p-4 shadow-sm mb-5">
		<h3 class="h5 mb-4"><?php echo $product_to_edit ? __( 'Edit Product', 'org-ecosystem' ) : __( 'Add New Product', 'org-ecosystem' ); ?></h3>
		<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="org_save_product">
			<?php if ( $product_to_edit ) : ?>
				<input type="hidden" name="product_id" value="<?php echo $product_to_edit->ID; ?>">
			<?php endif; ?>
			<?php wp_nonce_field( 'org_save_product_action', 'org_product_nonce' ); ?>

			<div class="row g-3">
				<div class="col-md-8">
					<div class="mb-3">
						<label class="form-label fw-bold"><?php _e( 'Product Name', 'org-ecosystem' ); ?></label>
						<input type="text" name="product_name" class="form-control" value="<?php echo $product_to_edit ? esc_attr( $product_to_edit->post_title ) : ''; ?>" required>
					</div>
					<div class="mb-3">
						<label class="form-label fw-bold"><?php _e( 'Description', 'org-ecosystem' ); ?></label>
						<textarea name="product_description" class="form-control" rows="5" required><?php echo $product_to_edit ? esc_textarea( $product_to_edit->post_content ) : ''; ?></textarea>
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-bold"><?php _e( 'Product Image', 'org-ecosystem' ); ?></label>
						<?php if ( $product_to_edit && has_post_thumbnail($product_to_edit->ID) ) : ?>
							<div class="mb-2">
								<?php echo get_the_post_thumbnail($product_to_edit->ID, 'thumbnail', array('class' => 'img-thumbnail', 'style' => 'max-height: 100px;')); ?>
							</div>
						<?php endif; ?>
						<input type="file" name="product_image" class="form-control" accept="image/*">
						<small class="text-muted"><?php _e( 'Recommended size: 800x800px', 'org-ecosystem' ); ?></small>
					</div>
					<div class="mb-3">
						<label class="form-label fw-bold"><?php _e( 'Category', 'org-ecosystem' ); ?></label>
						<?php
						wp_dropdown_categories( array(
							'show_option_none' => __( 'Select Category', 'org-ecosystem' ),
							'taxonomy'         => 'product_cat',
							'name'             => 'product_cat',
							'class'            => 'form-select',
							'selected'         => $product_to_edit ? ( wp_get_post_terms( $product_to_edit->ID, 'product_cat', array( 'fields' => 'ids' ) )[0] ?? 0 ) : 0,
						) );
						?>
					</div>
				</div>
			</div>

			<hr class="my-4">

			<div class="row g-3 mb-4">
				<div class="col-md-3">
					<label class="form-label fw-bold"><?php _e( 'Price (₱)', 'org-ecosystem' ); ?></label>
					<input type="number" name="product_price" class="form-control" value="<?php echo $product_to_edit ? esc_attr( get_post_meta( $product_to_edit->ID, '_product_price', true ) ) : ''; ?>" step="0.01">
				</div>
				<div class="col-md-3">
					<label class="form-label fw-bold"><?php _e( 'Stock Status', 'org-ecosystem' ); ?></label>
					<select name="product_stock" class="form-select">
						<option value="instock" <?php echo ($product_to_edit && get_post_meta($product_to_edit->ID, '_product_stock', true) === 'instock') ? 'selected' : ''; ?>><?php _e( 'In Stock', 'org-ecosystem' ); ?></option>
						<option value="outofstock" <?php echo ($product_to_edit && get_post_meta($product_to_edit->ID, '_product_stock', true) === 'outofstock') ? 'selected' : ''; ?>><?php _e( 'Out of Stock', 'org-ecosystem' ); ?></option>
					</select>
				</div>
				<div class="col-md-3">
					<label class="form-label fw-bold"><?php _e( 'SKU / Model', 'org-ecosystem' ); ?></label>
					<input type="text" name="product_sku" class="form-control" value="<?php echo $product_to_edit ? esc_attr( get_post_meta( $product_to_edit->ID, '_product_sku', true ) ) : ''; ?>">
				</div>
				<div class="col-md-3">
					<label class="form-label fw-bold"><?php _e( 'External Link (Optional)', 'org-ecosystem' ); ?></label>
					<input type="url" name="product_external_url" class="form-control" value="<?php echo $product_to_edit ? esc_attr( get_post_meta( $product_to_edit->ID, '_product_external_url', true ) ) : ''; ?>" placeholder="https://...">
				</div>
			</div>

            <div class="mb-4">
                <label class="form-label fw-bold"><?php _e( 'Key Features / Specifications (One per line)', 'org-ecosystem' ); ?></label>
                <textarea name="product_features" class="form-control" rows="3" placeholder="<?php _e( "Example:\nHigh Quality Material\n2 Year Warranty\nFree Shipping", 'org-ecosystem' ); ?>"><?php echo $product_to_edit ? esc_textarea( get_post_meta( $product_to_edit->ID, '_product_features', true ) ) : ''; ?></textarea>
            </div>

			<div class="d-flex gap-2">
				<button type="submit" class="btn btn-primary px-4 py-2 fw-bold"><?php echo $product_to_edit ? __( 'Update Product', 'org-ecosystem' ) : __( 'Publish Product', 'org-ecosystem' ); ?></button>
				<?php if($product_to_edit) : ?>
					<a href="?dash_page=my-products" class="btn btn-light px-4 py-2 border"><?php _e( 'Cancel', 'org-ecosystem' ); ?></a>
				<?php endif; ?>
			</div>
		</form>
	</div>
<?php endif; ?>

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
									<a href="?dash_page=my-products&edit_product=<?php the_ID(); ?>" class="btn btn-sm btn-outline-primary"><?php _e( 'Edit', 'org-ecosystem' ); ?></a>
                                    <?php if ( ! get_post_meta( get_the_ID(), '_product_is_featured', true ) ) : ?>
                                        <a href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'org_promote_listing', 'checkout_item_id' => get_the_ID(), 'checkout_type' => 'promotion' ), admin_url( 'admin-post.php' ) ), 'org_promote_listing_action' ); ?>" class="btn btn-sm btn-outline-warning text-dark"><?php _e( 'Promote', 'org-ecosystem' ); ?></a>
                                    <?php endif; ?>
									<a href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'org_delete_product', 'product_id' => get_the_ID() ), admin_url( 'admin-post.php' ) ), 'org_delete_product_action' ); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><?php _e( 'Delete', 'org-ecosystem' ); ?></a>
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
			<a href="?dash_page=my-products&add_new=1" class="btn btn-primary"><?php _e( 'Add Your First Product', 'org-ecosystem' ); ?></a>
		</div>
	<?php endif; ?>
</div>
