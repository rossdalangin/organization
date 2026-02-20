<?php
/**
 * Template Name: Checkout Page
 *
 * @package OrgEcosystem
 */

get_header();
?>

<div class="checkout-page py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 p-4 p-md-5 rounded-4 bg-white min-vh-50">
                    <?php
                    // Load the unified checkout template part
                    include ORG_ECOSYSTEM_DIR . '/template-parts/dashboard/checkout.php';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .min-vh-50 { min-height: 50vh; }
</style>

<?php
get_footer();
