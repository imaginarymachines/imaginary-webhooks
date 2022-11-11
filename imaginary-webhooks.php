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

/**
* Include the autoloader
*/
add_action( 'plugins_loaded', function () {
    if ( file_exists(__DIR__ . '/vendor/autoload.php' ) ) {
        include __DIR__ . '/vendor/autoload.php';
    }
}, 1 );

include_once dirname( __FILE__ ). '/inc/functions.php';
include_once dirname( __FILE__ ). '/inc/hooks.php';

/**
* Register imwwebhhook Custom Post Type
*/
add_action( 'init', function(){
    $args = [
        'labels'             => [
            'name'                  => _x( 'imwwebhhook', 'Post type general name', 'imaginary-webhooks' ),
            'singular_name'         => _x( 'Imwwebhhook', 'Post type singular name', 'imaginary-webhooks' ),
            'menu_name'             => _x( 'Imwwebhhook', 'Admin Menu text', 'imaginary-webhooks' ),
            'name_admin_bar'        => _x( 'Imwwebhhook', 'Add New on Toolbar', 'imaginary-webhooks' ),
            'add_new'               => __( 'Add New Imwwebhhook', 'imaginary-webhooks' ),
            'add_new_item'          => __( 'Add New Imwwebhhook', 'imaginary-webhooks' ),
            'new_item'              => __( 'New Imwwebhhook', 'imaginary-webhooks' ),
            'edit_item'             => __( 'Edit New Imwwebhhook', 'imaginary-webhooks' ),
            'view_item'             => __( 'View Imwwebhhook', 'imaginary-webhooks' ),
            'all_items'             => __( 'All Imwwebhhooks', 'imaginary-webhooks' ),
            'search_items'          => __( 'Search Imwwebhhooks', 'imaginary-webhooks' ),
            'not_found'             => __( 'No Imwwebhhooks Found', 'imaginary-webhooks' ),
            'not_found_in_trash'    => __( 'No Imwwebhhooks Found', 'imaginary-webhooks' ),
            'featured_image'        => _x( '', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'imaginary-webhooks' ),
            'set_featured_image'    => _x( '', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks' ),
            'remove_featured_image' => _x( '', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks' ),
            'use_featured_image'    => _x( 'Use Imwwebhhook Featured Image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks' ),
            'archives'              => _x( 'Imwwebhhook Archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'imaginary-webhooks' ),
            'insert_into_item'      => _x( 'Insert Into Imwwebhhooks ', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'imaginary-webhooks' ),
            'uploaded_to_this_item' => _x( 'Upload Tp Imwwebhhook ', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'imaginary-webhooks' ),
            'filter_items_list'     => _x( 'Fitler  Imwwebhhooks ', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'imaginary-webhooks' ),
            'items_list_navigation' => _x( 'Imwwebhhooks List Navigation ', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'imaginary-webhooks' ),
            'items_list'            => _x( 'Imwwebhhooks List ', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'imaginary-webhooks' ),
        ],
        'show_in_rest' => true,
        'publicly_queryable' => false,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'supports'           => ['title', 'custom-fields'],
    ];

    register_post_type( 'imwwebhhook', $args );
});

include_once dirname( __FILE__ ) . '/admin/webooks-settings/init.php';
