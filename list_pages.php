<?php
require_once('wp-load.php');
$pages = get_posts(array('post_type'=>'page', 'posts_per_page'=>-1, 'post_status' => 'any'));
if (empty($pages)) {
    echo "NO PAGES FOUND\n";
}
foreach($pages as $p) {
    $tpl = get_post_meta($p->ID, '_wp_page_template', true);
    echo "Page: " . $p->post_title . " (ID: " . $p->ID . ") Slug: " . $p->post_name . " Template: " . $tpl . "\n";
}
