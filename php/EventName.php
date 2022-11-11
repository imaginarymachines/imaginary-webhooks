<?php

namespace ImaginaryMachines\Webhooks;

class EventName extends Metabox {

	public static function factory(){

		return new self(
			Plugin::addPrefix('event_name'),
			'Webook Event',
			[Plugin::CPT_NAME]
		);
	}

	public function getRegisteredEvents(){
		$events = apply_filters(Plugin::addPrefix('registered_events'), [
			['label' => 'One', 'id' => 'one', 'callback'=> function(){}]
		]);
		foreach ($events as $eventI => $event) {
			foreach (['label', 'id', 'callback'] as $field) {
				if( ! isset($event[$field])){
					unset($events[$eventI]);
					continue;
				}
			}
		}
		return $events;
	}
    public function html($post)
    {
        $value = $this->getValue($post);
		$events = $this->getRegisteredEvents();
		?>
		<label for="<?php echo esc_attr($this->fieldName) ?>">
			Webhook Event
		</label>
		<select
			required
			id="<?php echo esc_attr($this->fieldName) ?>"
			name="<?php echo esc_attr($this->fieldName) ?>"

		>

		<?php
		foreach ($events as $event) {
			?>
			<option value="<?php echo esc_attr($event['id']) ?>"
				<?php selected( $value, $event['id'] ); ?>>
				<?php echo esc_html($event['label']) ?>
			</option>
		<?php
		}

    }
 }
