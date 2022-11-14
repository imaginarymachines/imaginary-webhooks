<?php

namespace ImaginaryMachines\Webhooks\Events;
use ImaginaryMachines\Webhooks\Plugin;
use ImaginaryMachines\Webhooks\WebhookEvent;

class WpLogin extends WebhookEvent {

public static function factory():static
	{
		return new self(
            //ID of event
			'wp_login',
            //Name of event
			'When User Is Logged In',
            //Name of action
			'wp_login',
			3
		);
	}

	public function getPayload(array $args): array
	{
		$payload = [
			//Write code here please
		];
		return $payload;
	}

    protected function getPost(array $args)
	{
		if (isset($args[1]) && $args[1] instanceof \WP_Post) {
			return $args[1];
		}
		return false;
	}
	public function shouldRun(array $args): bool
	{
		$post = $this->getPost($args);
		if (is_object($post)) {
			return $post->post_type !== Plugin::CPT_NAME;
		}
		return false;
	}
}
