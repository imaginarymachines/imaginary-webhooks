<?php

namespace ImaginaryMachines\Webhooks\Events;

use ImaginaryMachines\Webhooks\Plugin;
use ImaginaryMachines\Webhooks\WebhookEvent;

class SavePost extends WebhookEvent
{

	public static function factory():static
	{
		return new self(
			'save_post',
			'Post Saved',
			'save_post',
			3
		);
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

	public function getPayload(array $args) :array
	{
		$post = $args[1];
		$payload = [
			'post' => $post->to_array(),
			'meta' => get_post_meta($post->ID),
			'is_update' => $args[2]
		];
		return $payload;
	}
}
