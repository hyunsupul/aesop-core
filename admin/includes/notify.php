<?php

/**
 	* Creates a notification when plugin is activated
 	*
 	* @since    0.9.9
*/

class AesopNotifyonActivation {

	function __construct() {

		add_action( 'admin_notices', array( $this, 'notify' ) ) ;

	}

	function notify() {

		if( AI_CORE_VERSION > get_option('ai_core_version')) {

			$out = '<div class="updated"><p>';
			$out .= __( 'Thanks for checking out Aesop! Get started by going to any post, and clicking the "Add Component" button. Refer to the Help Tab while editing a single post for more.', 'aesop-core' );
			$out .= '</p></div>';

			update_option('ai_core_version', AI_CORE_VERSION );

			echo apply_filters('ai_activation_notification',$out);

		} else {

			add_option( 'ai_core_version', AI_CORE_VERSION );
		}

	}

}
new AesopNotifyonActivation;