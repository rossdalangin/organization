<?php
/**
 * Template Name: Member Directory
 *
 * @package OrgEcosystem
 */

get_header();

// We can just call the archive logic or a shortcode
?>

<main id="primary" class="site-main">
    <?php echo do_shortcode('[org_directory]'); ?>
</main>

<?php
get_footer();
