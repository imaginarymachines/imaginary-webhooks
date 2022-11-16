<?php

namespace ImaginaryMachines\Webhooks;

use ImaginaryMachines\Webhooks\Metaboxes\EventName;
use ImaginaryMachines\Webhooks\Metaboxes\Url;

class LogPostType {
	const CPT_NAME = 'imwm_webhook_log';

    public static function addColumns(){
        $postType = self::CPT_NAME;
        add_filter("manage_{$postType}_posts_columns",
            function ( $columns ) {
                //$columns[EventName::KEY] = 'Event';

                return $columns;
            }
        );

        add_action( 'manage_posts_custom_column',function  ( $column_id, $post_id ) {
            switch( $column_id ) {
				case 'something':
					//echo something
                break;
        }
    }, 10, 2 );

    }

    public static function registerCpt()
	{
		$args = [
			'labels'             => [
				'name'                  => _x('Webhook Log', 'Post type general name', 'imaginary-webhooks'),
				'singular_name'         => _x('Webhook Log', 'Post type singular name', 'imaginary-webhooks'),
				'menu_name'             => _x('Webhook Log', 'Admin Menu text', 'imaginary-webhooks'),
				'name_admin_bar'        => _x('Webhook Log', 'Add New on Toolbar', 'imaginary-webhooks'),
				'add_new'               => __('Add New Webhook Log', 'imaginary-webhooks'),
				'add_new_item'          => __('Add New Webhook Log', 'imaginary-webhooks'),
				'new_item'              => __('New Webhook Log', 'imaginary-webhooks'),
				'edit_item'             => __('Edit New Webhook Log', 'imaginary-webhooks'),
				'view_item'             => __('View Webhook Log', 'imaginary-webhooks'),
				'all_items'             => __('All Webhook Logs', 'imaginary-webhooks'),
				'search_items'          => __('Search Webhook Logs', 'imaginary-webhooks'),
				'not_found'             => __('No Webhook Logs Found', 'imaginary-webhooks'),
				'not_found_in_trash'    => __('No Webhook Logs Found', 'imaginary-webhooks'),
				'featured_image'        => _x('', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'imaginary-webhooks'),
				'set_featured_image'    => _x('', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks'),
				'remove_featured_image' => _x('', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks'),
				'use_featured_image'    => _x('Use Webhook Log Featured Image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks'),
				'archives'              => _x('Webhook Log Archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'imaginary-webhooks'),
				'insert_into_item'      => _x('Insert Into Webhook Logs ', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'imaginary-webhooks'),
				'uploaded_to_this_item' => _x('Upload Tp Webhook Log ', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'imaginary-webhooks'),
				'filter_items_list'     => _x('Fitler  Webhook Logs ', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'imaginary-webhooks'),
				'items_list_navigation' => _x('Webhook Logs List Navigation ', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'imaginary-webhooks'),
				'items_list'            => _x('Webhook Logs List ', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'imaginary-webhooks'),
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
			'supports'           => ['title','editor'],
			'register_meta_box_cb' => [LogPostType::class, 'registerMetaBoxes'],

		];

		register_post_type(static::CPT_NAME, $args);
	}


    public static function registerMetaBoxes()
	{
		//None yet.
	}


}
