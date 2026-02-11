<?php
/**
 * The template for displaying comments
 *
 * @package OrgEcosystem
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<ul class="list-unstyled">
			<?php
			wp_list_comments( array(
				'style'      => 'ul',
				'short_ping' => true,
				'avatar_size' => 50,
				'callback'   => 'org_ecosystem_comment_callback'
			) );
			?>
		</ul>

		<?php the_comments_navigation(); ?>

	<?php endif; ?>

	<?php
	comment_form( array(
		'class_form' => 'row g-3',
		'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="btn btn-primary">%4$s</button>',
		'comment_field' => '<div class="col-12"><label class="form-label">Message</label><textarea id="comment" name="comment" class="form-control" rows="4" required></textarea></div>',
	) );
	?>

</div>
