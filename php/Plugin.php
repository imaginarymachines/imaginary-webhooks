<?php

namespace ImaginaryMachines\Webhooks;

use ImaginaryMachines\Webhooks\Events\SavePost;
use ImaginaryMachines\Webhooks\Events\TransitionStatus;
use ImaginaryMachines\Webhooks\Metaboxes\EventName;
use ImaginaryMachines\Webhooks\Metaboxes\Secret;
use ImaginaryMachines\Webhooks\Metaboxes\Url;

class Plugin
{
	const CPT_NAME = 'imwm_webhook';
	const PREFIX = 'imwm_';
	protected array $webhookMetaBoxes = [];
	public function __construct()
	{
		$this->webhookMetaBoxes = [
			Url::factory(),
			Secret::factory(),
			EventName::factory(),
		];
		foreach ($this->webhookMetaBoxes as $webook) {
			add_action('save_post', [$webook, 'save']);
		}
		//Add actions for saved events
		add_action('init', [Hooks::class, 'onInit']);
		//When saving webhooks, re-prime cache
		add_action('save_post', [Hooks::class, 'onSavePost'], 10, 3);
	}


	public function getMetaKeys()
	{
		$keys = [];
		foreach ($this->webhookMetaBoxes as $webook) {
			$keys[] = $webook->getMetaKey();
		}
		return $keys;
	}
	/**
	 * Get all the events we can use
	 *
	 * @return WebhookEvent[]
	 */
	public function getRegisteredEvents()
	{

		foreach (apply_filters('imwm_registered_events', [
			SavePost::factory(),
			TransitionStatus::factory()
		]) as $event) {
			$events[$event->getId()] = $event;
		}
		return $events;
	}

	/**
	 * @return WebhookEvent
	 */
	public function getRegisteredEvent($id)
	{
		$events = $this->getRegisteredEvents();
		if (array_key_exists($id, $events)) {
			return $events[$id];
		}
		return false;
	}

	public function getSaved()
	{
		$cacheKey = __CLASS__ . __METHOD__.'1webhooks';
		$cacheGroup = 'imw_saved';
		$saved = wp_cache_get($cacheKey, $cacheGroup);
		if (! empty($saved)) {
			return json_decode($saved);
		}
		$posts =  get_posts([
			'post_type' => self::CPT_NAME,
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'fields' => 'ids'
		]);
		$saved = [];
		foreach ($posts as $postId) {
			$saved[] = [
				'ID' => $postId,
				URL::KEY => get_post_meta($postId, URL::KEY, true),
				SECRET::KEY => get_post_meta($postId, Secret::KEY, true),
				EventName::KEY => get_post_meta($postId, EventName::KEY, true),
			];
		}
		wp_cache_set($cacheKey, $cacheGroup, json_encode($saved));
		return $saved;
	}

	public static function addPrefix(string $string):string
	{
		return sprintf('%s%s', Plugin::PREFIX, $string);
	}

	public function registerCpt()
	{
		$args = [
			'labels'             => [
				'name'                  => _x('imwm_webhook', 'Post type general name', 'imaginary-webhooks'),
				'singular_name'         => _x('imwm_webhook', 'Post type singular name', 'imaginary-webhooks'),
				'menu_name'             => _x('imwm_webhook', 'Admin Menu text', 'imaginary-webhooks'),
				'name_admin_bar'        => _x('imwm_webhook', 'Add New on Toolbar', 'imaginary-webhooks'),
				'add_new'               => __('Add New imwm_webhook', 'imaginary-webhooks'),
				'add_new_item'          => __('Add New imwm_webhook', 'imaginary-webhooks'),
				'new_item'              => __('New imwm_webhook', 'imaginary-webhooks'),
				'edit_item'             => __('Edit New imwm_webhook', 'imaginary-webhooks'),
				'view_item'             => __('View imwm_webhook', 'imaginary-webhooks'),
				'all_items'             => __('All imwm_webhooks', 'imaginary-webhooks'),
				'search_items'          => __('Search imwm_webhooks', 'imaginary-webhooks'),
				'not_found'             => __('No imwm_webhooks Found', 'imaginary-webhooks'),
				'not_found_in_trash'    => __('No imwm_webhooks Found', 'imaginary-webhooks'),
				'featured_image'        => _x('', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'imaginary-webhooks'),
				'set_featured_image'    => _x('', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks'),
				'remove_featured_image' => _x('', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks'),
				'use_featured_image'    => _x('Use imwm_webhook Featured Image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'imaginary-webhooks'),
				'archives'              => _x('imwm_webhook Archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'imaginary-webhooks'),
				'insert_into_item'      => _x('Insert Into imwm_webhooks ', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'imaginary-webhooks'),
				'uploaded_to_this_item' => _x('Upload Tp imwm_webhook ', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'imaginary-webhooks'),
				'filter_items_list'     => _x('Fitler  imwm_webhooks ', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'imaginary-webhooks'),
				'items_list_navigation' => _x('imwm_webhooks List Navigation ', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'imaginary-webhooks'),
				'items_list'            => _x('imwm_webhooks List ', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'imaginary-webhooks'),
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

		register_post_type(self::CPT_NAME, $args);
	}

	public function registerMetaBoxes()
	{
		foreach ($this->webhookMetaBoxes as $webook) {
			$webook->register();
		}
	}
}
