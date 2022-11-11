<?php

namespace ImaginaryMachines\Webhooks\Metaboxes;

use ImaginaryMachines\Webhooks\Plugin;

class Url extends Metabox {

	public static function factory(){

		return new self(
			Plugin::addPrefix('webhook_url'),
			'Webhook URL',
			[Plugin::CPT_NAME]
		);
	}

    public function html($post)
    {
        $value = $this->getValue($post);
		?>
		<label for="<?php echo esc_attr($this->fieldName) ?>">
			Webhook URL *
		</label>
		<input
			required
			id="<?php echo esc_attr($this->fieldName) ?>"
			name="<?php echo esc_attr($this->fieldName) ?>"
			type="url"
			value="<?php echo esc_attr($value) ?>"
		/>
		<?php
    }
 }
