<?php

namespace ImaginaryMachines\Webhooks\Metaboxes;

use ImaginaryMachines\Webhooks\Plugin;

class Secret extends Metabox
{

	const KEY = 'imwm_webhook_secret';
	public static function factory()
	{

		return new self(
			self::KEY,
			'Webhook Secret',
			[Plugin::CPT_NAME]
		);
	}

	public function html($post)
	{
		$value = $this->getValue($post);
		?>
		<label for="<?php echo esc_attr($this->fieldName) ?>">
			<?php echo esc_html($this->title) ?>
		</label>
		<input
			id="<?php echo esc_attr($this->fieldName) ?>"
			name="<?php echo esc_attr($this->fieldName) ?>"
			type="text"
			value="<?php echo esc_attr($value) ?>"
		/>
		<?php
	}
}
