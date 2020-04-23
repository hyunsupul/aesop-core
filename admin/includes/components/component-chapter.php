<?php
/**
 * Filters custom meta box class to add cusotm meta
 *
 */
class AesopChapterComponentAdmin {

	public function __construct() {

		add_action( 'add_meta_boxes',      array( $this, 'new_chapter_box' ) );
		add_action( 'save_post',      array( $this, 'save_chapter_box' ) );
	}




	/**
	 * New metabox 
	 *
	 */
	public function new_chapter_box() {

		$screens = apply_filters( 'aesop_chapter_meta_location', array( 'post','page' ) );

		foreach ( $screens as $screen ) {
			add_meta_box( 'ase_chapter_component', __( 'Aesop Chapter', 'aesop-core' ), array( $this, 'render_chapter_box' ), $screen );

		}
	}

	/**
	 *  Render Meta Box content.
	 *
	 *
	 */
	public function render_chapter_box( $post ) {
        $value = get_post_meta($post->ID, 'ase_chapter_enable_timeline', true);
        ?>
        <label for="ase_chapter_enable_timeline"><?php echo __( 'Enable Timeline Bar for Chapter Components', 'aesop-core' );?></label>
        <select name="ase_chapter_enable_timeline" id="ase_chapter_enable_timeline">
            <option value="off" <?php selected($value, 'off'); ?>>Off</option>
            <option value="on" <?php selected($value, 'on'); ?>>On</option>
        </select>
        <?php


	}
	/**
	 *  Save the meta when the post is saved.
	 *
	 * @param integer $post_id The ID of the post being saved.
	 * @since 1.3
	 *
	 */
	public function save_chapter_box( $post_id ) {
		if (array_key_exists('ase_chapter_enable_timeline', $_POST)) {
            update_post_meta(
                $post_id,
                'ase_chapter_enable_timeline',
                $_POST['ase_chapter_enable_timeline']
            );
        }

	}

}
new AesopChapterComponentAdmin;