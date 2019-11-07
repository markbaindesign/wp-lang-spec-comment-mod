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

	// Catalan
	add_settings_field(
		'baindesign_wplscm_email_ca',								// ID
		__('Catalan Email Address', '_bd_wplscm'),			// Label
		'baindesign_wplscm_email_field_render_ca',			// Function to display inputs
		'discussion',													// Page to display on
		'baindesign-wplscm-email-section'						// Section ID where to show field
	);

	// Spanish
	add_settings_field(
		'baindesign_wplscm_settings_email__es',
		__('Spanish Email Address', '_bd_wplscm'),
		'baindesign_wplscm_email_field_render_es',
		'discussion',
		'baindesign-wplscm-email-section'
	);

}

/**
 * Render the input fields for each language
 */

// Catalan
function baindesign_wplscm_email_field_render_ca()
{
	$options = get_option( 'baindesign_wplscm_email_settings' );
	?>
	<input type='email' name='baindesign_wplscm_email_settings[baindesign_wplscm_email_ca]' value='<?php echo $options['baindesign_wplscm_email_ca']; ?>' placeholder='catalan@example.com'>
<?php
}

// Spanish
function baindesign_wplscm_email_field_render_es()
{
	$options = get_option( 'baindesign_wplscm_email_settings' );
	?>
	<input type='email' name='baindesign_wplscm_email_settings[baindesign_wplscm_email_es]' value='<?php echo $options['baindesign_wplscm_email_es']; ?>' placeholder='spanish@example.com'>
<?php
}

/**
 * Render the settings section content
 */
function baindesign_wplscm_settings_section_callback()
{
	echo __('Add an email address (e.g. mark@bain.design) for comment moderation in each available language.', '_bd_wplscm');
}
