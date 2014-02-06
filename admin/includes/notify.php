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

		if( AI_CORE_VERSION != get_option( 'ai_core_version' ) ) {

			add_option( 'ai_core_version', AI_CORE_VERSION );

			$out = '<div class="updated"><p>';
			$out .= __( 'Thanks for checking out Aesop! Get started by going to any post, and clicking the "Add Component" button.', 'aesop-core' );
			$out .= '</p></div>';

			echo apply_filters('ai_activation_notification',$out);

		}

	}

}
new AesopNotifyonActivation;