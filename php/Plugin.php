<?php

namespace ImaginaryMachines\Webhooks;

use ImaginaryMachines\Webhooks\Metaboxes\EventName;
use ImaginaryMachines\Webhooks\Metaboxes\Secret;
use ImaginaryMachines\Webhooks\Metaboxes\Url;

class Plugin
{
    const CPT_NAME = 'imwm_webhook';
    const PREFIX = 'imwm_';
    protected array $webhooks = [];
    public function __construct()
    {
        $this->webhooks = [
            Url::factory(),
            Secret::factory(),
            EventName::factory(),
        ];
        foreach ($this->webhooks as $webook) {
            add_action('save_post', [$webook, 'save']);

        }
    }
    public function sayHi(): string
    {
        return  'Hi Roy';
    }

    public static function addPrefix(string $string):string{
        return sprintf('%s%s', Plugin::PREFIX, $string);
    }

    public function registerCpt(){
        $args = [
            'labels'             => [
                'name'                  => _x( 'imwm_webhook', 'Post type general name', 'imaginary-webhooks' ),
                'singular_name'         => _x( 'imwm_webhook', 'Post type singular name', 'imaginary-webhooks' ),
                'menu_name'             => _x( 'imwm_webhook', 'Admin Menu text', 'imaginary-webhooks' ),
                'name_admin_bar'        => _x( 'imwm_webhook', 'Add New on Toolbar', 'imaginary-webhooks' ),
                'add_new'               => __( 'Add New imwm_webhook', 'imaginary-webhooks' ),
                'add_new_item'          => __( 'Add New imwm_webhook', 'imaginary-webhooks' ),
                'new_item'              => __( 'New imwm_webhook', 'imaginary-webhooks' ),
                'edit_item'             => __( 'Edit New imwm_webhook', 'imaginary-webhooks' ),
                'view_item'             => __( 'View imwm_webhook', 'imaginary-webhooks' ),
                'all_items'             => __( 'All imwm_webhooks', 'imaginary-webhooks' ),
                'search_items'          => __( 'Search imwm_webhooks', 'imaginary-webhooks' ),
                'not_found'             => __( 'No imwm_webhooks Found', 'imaginary-webhooks' ),
                'not_found_in_trash'    => __( 'No imwm_webhooks Found', 'imaginary-webhooks' ),
                'featured_image'        => _x( '', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'imaginary-webhooks' ),
                'set_featured_image'    => _x( '', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks' ),
                'remove_featured_image' => _x( '', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks' ),
                'use_featured_image'    => _x( 'Use imwm_webhook Featured Image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks' ),
                'archives'              => _x( 'imwm_webhook Archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'imaginary-webhooks' ),
                'insert_into_item'      => _x( 'Insert Into imwm_webhooks ', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'imaginary-webhooks' ),
                'uploaded_to_this_item' => _x( 'Upload Tp imwm_webhook ', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'imaginary-webhooks' ),
                'filter_items_list'     => _x( 'Fitler  imwm_webhooks ', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'imaginary-webhooks' ),
                'items_list_navigation' => _x( 'imwm_webhooks List Navigation ', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'imaginary-webhooks' ),
                'items_list'            => _x( 'imwm_webhooks List ', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'imaginary-webhooks' ),
            ],
            'show_in_rest' => false,
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
            'supports'           => ['title',],
            'register_meta_box_cb' => [$this, 'registerMetaBoxes'],

        ];

        register_post_type( self::CPT_NAME, $args );
    }

    public function registerMetaBoxes(){
        foreach ($this->webhooks as $webook) {
            $webook->register();

        }
    }
}
