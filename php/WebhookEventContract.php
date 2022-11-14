<?php

namespace ImaginaryMachines\Webhooks;

/**
 * A WebhookEvent is a possible action/ data getter we can use for a webhook
 */
interface WebhookEventContract
{

	/**
	 * Get the ID of the event
	 *
	 * @return string
	 */
	public function getId():string;

	/**
	 * Get the label for the event
	 *
	 * @return string
	 */
	public function getLabel():string;

	/**
	 * Add the WordPress hook a webhook
	 *
	 * @return string
	 */
	public function addHook(WebhookContract $webhook);

	/**
	 * Should webhook run?
	 *
	 * @param array $args
	 * @return bool
	 */
	public function shouldRun(array $args): bool;

	/**
	 * Get the payload for the webhook
	 *
	 * @param array $args
	 * @return array
	 */
	 public function getPayload(array $args):array;

}
