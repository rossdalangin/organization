<?php
require_once('wp-load.php');
$users = count_users();
echo "Total Users: " . $users['total_users'] . "\n";
$posts = wp_count_posts('page');
echo "Total Pages: " . $posts->publish . " publish, " . $posts->trash . " trash\n";
