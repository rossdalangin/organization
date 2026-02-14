<?php
/**
 * Template Name: Directory Page
 *
 * @package OrgEcosystem
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    // Include the directory logic
    include ORG_ECOSYSTEM_DIR . '/archive-member.php';
    ?>
</main>

<?php
get_footer();
