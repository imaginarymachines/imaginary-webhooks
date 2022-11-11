<?php

namespace ImaginaryMachines\Webhooks\Events;

use ImaginaryMachines\Webhooks\Plugin;
use ImaginaryMachines\Webhooks\WebhookEvent;

class TransitionStatus extends WebhookEvent
{


	public static function factory()
	{
		return new self(
			'post_published',
			'Post Publish',
			'transition_post_status',
			3
		);
	}


	protected function getPost(array $args)
	{
		if (isset($args[2]) && $args[2] instanceof \WP_Post) {
			return $args[2];
		}
		return false;
	}
	public function shouldRun(array $args): bool
	{
		$post = $this->getPost($args);
		if (is_object($post)) {
			if ($post->type !== Plugin::CPT_NAME) {
				// Early bail: We are looking for published posts only
				if ($args[0] != 'publish' || $args[1] == 'publish') {
					return false;
				}
				return true;
			}
		}
		return false;
	}

	public function getPayload($args)
	{
		$post = $this->getPost($args);
		$payload = [
			'post' => $post->to_array(),
			'meta' => get_post_meta($post->ID),
			'is_update' => false
		];
		return $payload;
	}
}
