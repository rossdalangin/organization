<?php
/**
 * Template part for displaying posts
 *
 * @package OrgEcosystem
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-5' ); ?>>
	<header class="entry-header mb-3">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="text-decoration-none text-dark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta text-muted small">
				<?php echo get_the_date(); ?> | <?php the_author(); ?>
			</div>
		<?php endif; ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail mb-3">
			<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		if ( is_singular() ) :
			the_content();
		else :
			the_excerpt();
			?>
			<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm mt-3"><?php _e( 'Read More', 'org-ecosystem' ); ?></a>
		<?php endif; ?>
	</div>
</article>
