<?php



//Enqueue assets for Webhooks Settings on admin page only
add_action('admin_enqueue_scripts', function ($hook) {
    if ('toplevel_page_webooks-settings' != $hook) {
        return;
    }
    //wp_enqueue_script('webooks-settings');
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
