<?php

namespace ImaginaryMachines\Webhooks;


/**
 * A "webhook event" is a WordPress hook that we can use to trigger a webhook
 * This is a bad name.
 */
abstract class WebhookEvent implements WebhookEventContract
{

	protected $id;
	protected $label;
	protected $action;
	protected $priority;
	protected $acceptedArgs;
	public function __construct(
		string $id,
		string $label,
		string $action,
		int $acceptedArgs = 1,
		int $priority = 10
	) {
		$this->id = $id;
		$this->label = $label;
		$this->action = $action;
		$this->priority = $priority;
		$this->acceptedArgs = $acceptedArgs;
	}


	/**
	 * Create an instance of this class
	 * @return static
	 */
	abstract public static function factory();

	/**
	 * Should webhook run
	 *
	 * @return bool
	 */
	public function shouldRun(array $args): bool
	{
		return true;
	}

	/** @inheritDoc */
	public function addHook(WebhookContract $webhook):void
	{
		add_filter(
			$this->action,
			function (...$args) use ($webhook) {
				imwm_webhook()->reportWebhook(
					$webhook,
					false,
					[],
					['BEFORE' => $args]
				);
				if (! $this->shouldRun($args)) {
					do_action('imwm_webhook_not_sent',$webhook,$args);
					return;
				}
				$payload = $this->getPayload($args);
				$r = wp_remote_post($webhook->getUrl(), [
					'method' => 'POST',
					'body' => $payload,
				]);
				imwm_webhook()->reportWebhook(
					$webhook,
					true,
					$payload
				);
				do_action('imwm_webhook_sent', $r, $webhook, $args);
				if( isset($args[0])){
					return $args[0];
				}
			},
			$this->priority,
			$this->acceptedArgs
		);
	}


	/** @inheritDoc */
	public function getId(): string
	{
		return $this->id;
	}

	/** @inheritDoc */
	public function getLabel(): string
	{
		return $this->label;
	}

	protected function isPostWebhook(\WP_Post $post ):bool{
		if (is_object($post)) {
			return $post->post_type !== Plugin::CPT_NAME;
		}
		return false;
	}
}
