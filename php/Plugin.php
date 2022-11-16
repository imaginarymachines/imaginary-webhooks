<?php

namespace ImaginaryMachines\Webhooks;

use Exception;
use ImaginaryMachines\Webhooks\Events\SavePost;
use ImaginaryMachines\Webhooks\Events\TransitionStatus;
use ImaginaryMachines\Webhooks\Metaboxes\EventName;
use ImaginaryMachines\Webhooks\Metaboxes\LastResult;
use ImaginaryMachines\Webhooks\Metaboxes\Secret;
use ImaginaryMachines\Webhooks\Metaboxes\Url;

class Plugin
{
	const CPT_NAME = 'imwm_webhook';
	const PREFIX = 'imwm_';
	protected array $webhookMetaBoxes = [];
	public function __construct()
	{
		$loggingEnabled = $this->isLogEnabled();
		//Register meta boxes
		$this->webhookMetaBoxes = [
			Url::factory(),
			Secret::factory(),
			EventName::factory(),

		];
		if( $loggingEnabled ){
			$this->webhookMetaBoxes[] = LastResult::factory();
		}

		//Setup custom post type
		add_action( 'init', [WebhookPostType::class, 'registerCpt']);
		if( $loggingEnabled ){
			add_action( 'init', [LogPostType::class, 'registerCpt']);
		}
		//Setup events
		foreach ($this->webhookMetaBoxes as $webook) {
			add_action('save_post', [$webook, 'save']);
		}

		//When saving webhooks, re-prime cache
		add_action('save_post', [Hooks::class, 'onSavePost'], 10, 3);

		//Should we dispatch our own events?
		//Not working fully yet.
		$dispatchOn = apply_filters('imwm_dispatch_on', false );
		if( $dispatchOn ){
			//Add actions for saved events
			add_action('init', [Hooks::class, 'onInit']);
		}

	}

	/**
	 * @return bool
	 */
	public function isLogEnabled(): bool{
		return (bool) apply_filters('imwm_webhooks_log_enabled', false );
	}

	/**
	 * Report on log
	 */
	public function report(array $data, string $titlePattern = '' ){
		if( !$this->isLogEnabled()){
			return;
		}
		$titlePattern = $titlePattern ?: '%s';
		$content = sprintf('<!-- wp:code -->
		<pre class="wp-block-code"><code>%s</code></pre>
		<!-- /wp:code -->',json_encode($data));
		wp_insert_post(
			[
				'post_type' => LogPostType::CPT_NAME,
				'post_content' => $content,
				'post_title' => sprintf(
					$titlePattern,
					wp_date( get_option( 'date_format' ))

				),
			]
		);
	}

	public function reportWebhook(
		WebhookContract $webhook,
		bool $ran,
		array $payload = [],
		array $otherData = []
		){
			if( !$this->isLogEnabled()){
				return;
			}
			update_post_meta(
				$webhook->getId(),
				LastResult::KEY,
				array_merge($otherData,[
					'ran' => $ran,
					'time' => wp_date( get_option( 'date_format' ) ),
					'webhook' => [
						$webhook->getId(),
						$webhook->getUrl()
					],
					'payload' => $payload
				])
			);

	}


	public function getMetaKeys()
	{
		$keys = [];
		foreach ($this->webhookMetaBoxes as $webook) {
			$keys[] = $webook->getMetaKey();
		}
		return $keys;
	}

	public function getWebhookMetaBoxes():array {
		return $this->webhookMetaBoxes;
	}
	/**
	 * Get all the types of events we can use
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

	protected function isValid( $event ):bool {
		try{
			$impliments = in_array(
				"ImaginaryMachines\Webhooks\WebhookEventContract",
				class_implements($event,false)
			);
			return $impliments;
		}catch(\Exception $e){
			return false;
		}
	}

	/**
	 * Get a type of event we can use for a webhook
	 *
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

	/**
	 * Get all the saved webhooks
	 *
	 * @return array
	 *
	 */
	public function getSaved()
	{
		$cacheKey = __CLASS__ . __METHOD__.'webhooks';
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


}
