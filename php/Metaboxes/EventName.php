<?php

namespace ImaginaryMachines\Webhooks\Metaboxes;

use ImaginaryMachines\Webhooks\Plugin;

class EventName extends Metabox {

	const KEY = 'imwm_webhook_event_name';
	public static function factory(){

		return new self(
			self::KEY,
			'Webook Event',
			[Plugin::CPT_NAME]
		);
	}


    public function html($post)
    {

        $value = $this->getValue($post);
		$events = imwm_webhook()->getRegisteredEvents();
		if( empty($events)){
			?>
			<p>No events registered</p>
			<?php
			return;
		}
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
			<option value="<?php echo esc_attr($event->getId()) ?>"
				<?php selected( $value, $event->getId() ); ?>
			>
				<?php echo esc_html($event->getLabel()) ?>
			</option>

		<?php
		}
		echo '</select>';

    }
 }
