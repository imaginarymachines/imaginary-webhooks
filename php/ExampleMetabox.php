<?php

namespace ImaginaryMachines\Webhooks;

 class ExampleMetabox extends Metabox {

    public function html($post)
    {
        $value = $this->getValue($post);
		?>
		<label for="<?php echo esc_attr($this->fieldName) ?>">Description for this field</label>
		<select name=<?php echo esc_attr($this->fieldName) ?> id=<?php echo esc_attr($this->fieldName) ?> class="postbox">
			<option value="">Select something...</option>
			<option value="something" <?php selected( $value, 'something' ); ?>>Something</option>
			<option value="else" <?php selected( $value, 'else' ); ?>>Else</option>
		</select>
		<?php
    }
 }
