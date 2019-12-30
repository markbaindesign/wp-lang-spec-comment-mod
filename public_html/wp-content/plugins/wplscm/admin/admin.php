<?php

/**
 * Admin screens
 */

add_action('admin_init', 'baindesign_wplscm_settings_init');

function baindesign_wplscm_settings_init()
{
	register_setting(
		'discussion', 													// Existing options group
		'baindesign_wplscm_email_settings'						// Entry in options table
	);

	add_settings_section(
		'baindesign-wplscm-email-section',						// Section ID
		__('Moderation Email Addresses', '_bd_wplscm'),		// Section header
		'baindesign_wplscm_settings_section_callback',		// Callback
		'discussion' 													// Add section to Settings > Discussion
	);

	/**
	 * Add a setting field for each language
	 */

	$langs = icl_get_languages();
	var_dump($langs);
	foreach( $langs as $lang ){
		$code = $lang["code"];
		$name = $lang["translated_name"];
		error_log($code, 0);
		add_settings_field(
			'baindesign_wplscm_email_'.$code,						// ID
			sprintf(__('%1$s Email Address', '_bd_wplscm'), $name), 			// Label
			'baindesign_wplscm_email_field_render', // Function to display inputs
			'discussion',													// Page to display on
			'baindesign-wplscm-email-section',						// Section ID where to show field
			array( $code, $name )																// Passes to callback function
		);
	}

}

/**
 * Render the input fields for each language
 */

function baindesign_wplscm_email_field_render(array $args)
{
	error_log("Code: " . $args[1], 0);

	$options = get_option( 'baindesign_wplscm_email_settings' );
	$input_name = 'baindesign_wplscm_email_settings[baindesign_wplscm_email_'.$args[0].']';
	$input_value_option = 'baindesign_wplscm_email_'.$args[0];
	$input_value = $options[$input_value_option];
	$input_placeholder = $args[1] .'@example.com';
	$input_id = 'email-' . $args[0];

	// Render
	echo '<input type="email" id="'.$input_id.'" name="'.$input_name.'" value="'.$input_value.'" placeholder="' . $input_placeholder .'">';
}

/**
 * Render the settings section content
 */
function baindesign_wplscm_settings_section_callback()
{
	echo __('Add an email address (e.g. mark@bain.design) for comment moderation in each available language.', '_bd_wplscm');
}
