<?php


/**
* Plugin Name: Imaginary Webhooks
* Plugin URI:
* Description:
* Version: 0.0.1
* Requires at least: 6.0
* Requires PHP:      7.1.0
* Author:
* Author URI:
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:       imaginary-webhooks
* Domain Path:       /languages
*/

use ImaginaryMachines\Webhooks\Plugin;
use ImaginaryMachines\Webhooks\Url;

/**
* Include the autoloader
*/
add_action( 'plugins_loaded', function () {
    if ( file_exists(__DIR__ . '/vendor/autoload.php' ) ) {
        include __DIR__ . '/vendor/autoload.php';
        $plugin = new Plugin();
        add_action('init', [$plugin, 'registerCpt']);
        do_action('imwm_webhook',$plugin);
    }else{
        add_action( 'admin_notices', function () {
            echo '<div class="notice notice-error is-dismissible">
            <p>Imaginary Webhooks requires the <a href="https://getcomposer.org/">Composer</a> package manager to be installed.</p>
            </div>';
        } );
    }

}, 1 );

include_once dirname( __FILE__ ). '/inc/functions.php';
include_once dirname( __FILE__ ). '/inc/hooks.php';




include_once dirname( __FILE__ ) . '/admin/webooks-settings/init.php';
