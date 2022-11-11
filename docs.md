# Imaginary Webhooks


## Usage


## Register New Event Type

```php

class SavePost extends WebhookEvent
{

	public static function factory()
	{
		return new self(
            //ID of event
			'myprefix_event_name',
            //Label for event
			'Something Happened',
            //Name of action
			'name_of_wordpress_action_to_hook_to',
            //Number of args for action (optional,default is 1)
			3
            //Priority to add action with (optional)
            42
		);
	}


	public function shouldRun(array $args): bool
	{
		if ($args[2] === 'something') {
			return true
		}
		return false;
	}

	public function getPayload($args)
	{
		$payload = [

		];
		return $payload;
	}
}
