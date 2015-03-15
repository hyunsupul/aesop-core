<?php

/**
 * Creates a notification when plugin is activated
 *
 * @since    0.9.9
 */

class AesopNotifyonActivation {

	public function __construct() {

		add_action( 'admin_notices', array( $this, 'notify' ) );

	}

	public function notify() {

		if ( AI_CORE_VERSION > get_option( 'ai_core_version' ) ) {

			$out = '<div class="updated aesop-notice"><p>';

			$out .= __( 'Thanks for checking out Aesop! Get started by going to any post and clicking the "Add Component" button. Refer to the Help tab while editing a post for more information.', 'aesop-core' );

			$out .= '</p></div>';

			update_option( 'ai_core_version', AI_CORE_VERSION );

			echo apply_filters( 'ai_activation_notification', $out );

		} else {

			add_option( 'ai_core_version', AI_CORE_VERSION );
		}

	}

}
new AesopNotifyonActivation;
