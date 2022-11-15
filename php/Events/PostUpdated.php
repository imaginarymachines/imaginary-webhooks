<?php

namespace ImaginaryMachines\Webhooks\Events;
use ImaginaryMachines\Webhooks\Plugin;
use ImaginaryMachines\Webhooks\WebhookEvent;

class PostUpdated extends WebhookEvent {

    /**
    * @return static
    * @see https://developer.wordpress.org/reference/post_updated/
    */
    public static function factory()
	{
		return new self(
            //ID of event
			'post_updated',
            //Name of event
			'Post Updated',
            //Name of action
			'post_updated',
			3
		);
	}

    public function getPayload(array $args): array
	{
        $post = $this->getPost($args);
		$payload = [
			//Write code here please
		];
		return $payload;
	}


    protected function getPost(array $args)
	{
		if (isset($args[0]) && is_numeric($args[0])) {
			return \get_post($args[0]);
		}
		return false;
	}
	public function shouldRun(array $args): bool
	{
		$post = $this->getPost($args);
		if( ! $post || ! $this->isPostWebhook($post) ) {
			return false;
		}
		return false;
	}
}
