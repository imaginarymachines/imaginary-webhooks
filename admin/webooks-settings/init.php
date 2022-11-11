<?php

//Register assets for Webhooks Settings
add_action('init', function () {
    $handle = 'webooks-settings';
    $assets = include dirname(__FILE__, 3). "/build/admin-page-$handle.asset.php";
    $dependencies = $assets['dependencies'];
    $dependencies[] = 'jquery';
    wp_register_script(
        $handle,
        plugins_url("/build/admin-page-$handle.js", dirname(__FILE__, 2)),
        $dependencies,
        $assets['version']
    );
});

//Enqueue assets for Webhooks Settings on admin page only
add_action('admin_enqueue_scripts', function ($hook) {
    if ('toplevel_page_webooks-settings' != $hook) {
        return;
    }
    wp_enqueue_script('webooks-settings');
});

//Register Webhooks Settings menu page
add_action('admin_menu', function () {
    add_menu_page(
        __('Webhooks Settings', 'imaginary-webhooks'),
        __('Webhooks Settings', 'imaginary-webhooks'),
        'manage_options',
        'webooks-settings',
        function () {
            include_once dirname(__FILE__) . '/template.php';
        }
    );
});
