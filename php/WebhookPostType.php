<?php

namespace ImaginaryMachines\Webhooks;

use ImaginaryMachines\Webhooks\Metaboxes\EventName;
use ImaginaryMachines\Webhooks\Metaboxes\Url;

class WebhookPostType {


    public static function addColumns(){
        $postType = Plugin::CPT_NAME;
        add_filter("manage_{$postType}_posts_columns",
            function ( $columns ) {
                $columns[EventName::KEY] = 'Event';
                $columns[Url::KEY] = 'URL';
                return $columns;
            }
        );

        add_action( 'manage_posts_custom_column',function  ( $column_id, $post_id ) {
            switch( $column_id ) {
                case EventName::KEY:
                    $value = get_post_meta($post_id,EventName::KEY,true);
                    if ($value) {
                        echo esc_html($value);
                    }
                    break;
                case Url::KEY:
                    $value = get_post_meta($post_id,Url::KEY,true);
                    if ($value) {
                        echo esc_url($value);
                    }
                    break;
                break;
        }
    }, 10, 2 );

    }

    public static function registerCpt()
	{
		$args = [
			'labels'             => [
				'name'                  => _x('Webhook', 'Post type general name', 'imaginary-webhooks'),
				'singular_name'         => _x('Webhook', 'Post type singular name', 'imaginary-webhooks'),
				'menu_name'             => _x('Webhook', 'Admin Menu text', 'imaginary-webhooks'),
				'name_admin_bar'        => _x('Webhook', 'Add New on Toolbar', 'imaginary-webhooks'),
				'add_new'               => __('Add New Webhook', 'imaginary-webhooks'),
				'add_new_item'          => __('Add New Webhook', 'imaginary-webhooks'),
				'new_item'              => __('New Webhook', 'imaginary-webhooks'),
				'edit_item'             => __('Edit New Webhook', 'imaginary-webhooks'),
				'view_item'             => __('View Webhook', 'imaginary-webhooks'),
				'all_items'             => __('All Webhooks', 'imaginary-webhooks'),
				'search_items'          => __('Search Webhooks', 'imaginary-webhooks'),
				'not_found'             => __('No Webhooks Found', 'imaginary-webhooks'),
				'not_found_in_trash'    => __('No Webhooks Found', 'imaginary-webhooks'),
				'featured_image'        => _x('', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'imaginary-webhooks'),
				'set_featured_image'    => _x('', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks'),
				'remove_featured_image' => _x('', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks'),
				'use_featured_image'    => _x('Use Webhook Featured Image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks'),
				'archives'              => _x('Webhook Archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'imaginary-webhooks'),
				'insert_into_item'      => _x('Insert Into Webhooks ', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'imaginary-webhooks'),
				'uploaded_to_this_item' => _x('Upload Tp Webhook ', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'imaginary-webhooks'),
				'filter_items_list'     => _x('Fitler  Webhooks ', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'imaginary-webhooks'),
				'items_list_navigation' => _x('Webhooks List Navigation ', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'imaginary-webhooks'),
				'items_list'            => _x('Webhooks List ', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'imaginary-webhooks'),
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
			'register_meta_box_cb' => [WebhookPostType::class, 'registerMetaBoxes'],

		];

		register_post_type(Plugin::CPT_NAME, $args);
	}


    public static function registerMetaBoxes()
	{
		foreach (imwm_webhook()->getWebhookMetaBoxes() as $webook) {
			$webook->register();
		}
	}


}
