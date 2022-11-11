<?php

namespace ImaginaryMachines\Webhooks\Metaboxes;


abstract class Metabox {
    public $metaKey;
    public $title;
    public $postTypes;
    public $fieldName;
    public function __construct($metaKey,$title,$postTypes = ['post'],$fieldName = null )
    {
        $this->metaKey = $metaKey;
        $this->postTypes = $postTypes;
        $this->fieldName =  $fieldName ? $fieldName : $metaKey;
        $this->title = $title;
    }


	/**
	 * Display the meta box HTML to the user.
	 *
	 * @param \WP_Post $post   Post object.
	 */
	abstract public function html( $post );

	/**
	 * Create a new instance of this class
	 *
	 * @return static
	 */
	abstract public static function factory();

	/**
	 * Set up and add the meta box.
	 */
	public function register() {
		$screens = $this->postTypes;
        $boxId = sprintf('%s-%s-box', $this->metaKey, $this->fieldName);
		foreach ( $screens as $screen ) {
			add_meta_box(
				$boxId,          // Unique ID
				$this->title, // Box title
				[ $this, 'html' ],   // Content callback, must be of type callable
				$screen                  // Post type
			);
		}
	}


	/**
	 * Save the meta box selections.
	 *
	 * @param int $post_id  The post ID.
	 */
	public function save( int $post_id ) {
		if ( array_key_exists( $this->metaKey, $_POST ) ) {
			update_post_meta(
				$post_id,
				$this->metaKey,
				$_POST[$this->metaKey]
			);
		}
	}

    public function getValue(\WP_Post $post){
        return get_post_meta( $post->ID, $this->metaKey, true );
    }



}
