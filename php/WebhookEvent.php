<?php

namespace ImaginaryMachines\Webhooks;

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
	 * @return static
	 *
	 */
	abstract public static function factory();

	/**
	 * Get the payload for the webhook
	 *
	 * @param array $args
	 * @return array
	 */
	abstract public function getPayload(array $args);

	/**
	 * Should webhook run
	 *
	 * @return string
	 */
	public function shouldRun(array $args): bool
	{
		return true;
	}

	public function addHook(WebhookContract $webhook)
	{
		add_action(
			$this->action,
			function (...$args) use ($webhook) {
				if (! $this->shouldRun($args)) {
					return;
				}
				$payload = $this->getPayload($args);
				$r = wp_remote_post($webhook->getUrl(), [
					'method' => 'POST',
					'body' => $payload,
				]);
				do_action('imwm_webhook_sent', $r, $webhook, $this);
			},
			$this->priority,
			$this->acceptedArgs
		);
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getLabel(): string
	{
		return $this->label;
	}
}
