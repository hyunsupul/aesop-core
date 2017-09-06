<?php
/**
 * Creates a section of options in theme customizer
 *
 * @since    1.0.3
 */
class AesopStoryEngineOptions {

	// add new options to new section
	public static function register( $wp_customize ) {

		$wp_customize->add_section( 'aesop_story_engine', array(
				'title'   => __( 'Aesop Story Engine', 'aesop-core' ),
				'description' => __( 'Refer to the documentation located <a href="http://aesopstoryengine.com/help/map-component" target="_blank">here</a> for option descriptions.', 'aesop-core' )
			) );

		// Enable Google Analytics
		$wp_customize->add_setting( 'ase_mapbox_id', array(
				'default'   => '',
				'type'    => 'option',
				'sanitize_callback' => self::sanitize_text_field()
			) );
		$wp_customize->add_control( 'ase_mapbox_id', array(
				'label'   => __( 'Mapbox Map ID', 'aesop-core' ),
				'section'   => 'aesop_story_engine',
				'settings'   => 'ase_mapbox_id',
				'type'    => 'text'
			) );
			
		$wp_customize->add_setting( 'ase_mapbox_apikey', array(
				'default'   => 'AIzaSyDguxUeZr9LUPe9ImgYwXPTqPwQbsUFAJo',
				'type'    => 'option',
				'sanitize_callback' => self::sanitize_text_field()
			) );
		$wp_customize->add_control( 'ase_mapbox_apikey', array(
				'label'   => __( 'Google Map API Key.', 'aesop-core'),
                'description' => __('Recommended: Visit <a href="https://developers.google.com/maps/documentation/javascript/get-api-key">here</a> to get your own API key.', 'aesop-core' ),
				'section'   => 'aesop_story_engine',
				'settings'   => 'ase_mapbox_apikey',
				'type'    => 'text'
			) );
	}

	private static function sanitize_text_field( $input = ''  ) {
		return sanitize_text_field( $input );
	}

}
// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'AesopStoryEngineOptions' , 'register' ) );
