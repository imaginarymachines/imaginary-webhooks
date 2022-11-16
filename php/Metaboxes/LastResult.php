<?php

namespace ImaginaryMachines\Webhooks\Metaboxes;

use ImaginaryMachines\Webhooks\Plugin;

class LastResult extends Metabox
{

	const KEY = 'imwm_last_result';
	public static function factory()
	{

		return new self(
			self::KEY,
			'Last Result',
			[Plugin::CPT_NAME]
		);
	}

	public function html($post)
	{
		$value = $this->getValue($post);
		if( $value ) {
			?>
			<p>
				<?php echo json_encode($value) ?>
			</p>
			<?php
		}else{
			?>
			<p>
				No result saved
			</p>
			<?php
		}

	}
}
