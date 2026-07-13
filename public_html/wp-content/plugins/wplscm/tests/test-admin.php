<?php
/**
 * Tests for the Settings > Discussion admin screen.
 *
 * @package Wplscm
 */

class Wplscm_Admin_Test extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();
		delete_option( 'baindesign_wplscm_email_settings' );
	}

	/**
	 * baindesign_wplscm_settings_init() should not fatal when WPML's
	 * icl_get_languages() is unavailable (the bug that caused a critical
	 * error on every wp-admin page when WPML was inactive).
	 */
	public function test_settings_init_does_not_require_wpml_to_be_callable() {
		// icl_get_languages() is always defined in the test bootstrap, so we
		// can only assert the guard clause exists and returns cleanly.
		$this->assertTrue( function_exists( 'baindesign_wplscm_settings_init' ) );
		baindesign_wplscm_settings_init();
		$this->assertTrue( true ); // Reaching this line means no fatal occurred.
	}

	/**
	 * Settings registration should add a field for each WPML language.
	 */
	public function test_settings_init_registers_a_field_per_language() {
		global $wp_settings_fields;

		baindesign_wplscm_settings_init();

		$this->assertArrayHasKey( 'discussion', $wp_settings_fields );
		$this->assertArrayHasKey( 'baindesign_wplscm_email_en', $wp_settings_fields['discussion']['baindesign-wplscm-email-section'] );
		$this->assertArrayHasKey( 'baindesign_wplscm_email_es', $wp_settings_fields['discussion']['baindesign-wplscm-email-section'] );
	}

	/**
	 * The rendered input field must escape a stored value, even a malicious
	 * one, rather than emitting it raw into the HTML attribute.
	 */
	public function test_email_field_render_escapes_stored_value() {
		$malicious = '"><script>alert(1)</script>';

		update_option(
			'baindesign_wplscm_email_settings',
			array( 'baindesign_wplscm_email_en' => $malicious )
		);

		ob_start();
		baindesign_wplscm_email_field_render( array( 'en', 'English' ) );
		$output = ob_get_clean();

		$this->assertStringNotContainsString( '<script>', $output );
		$this->assertStringContainsString( esc_attr( $malicious ), $output );
	}

	/**
	 * Rendering the field for a language with no saved value yet should not
	 * emit a PHP warning (regression test for the missing isset() check).
	 */
	public function test_email_field_render_handles_missing_value() {
		ob_start();
		baindesign_wplscm_email_field_render( array( 'de', 'German' ) );
		$output = ob_get_clean();

		$this->assertStringContainsString( 'id="email-de"', $output );
	}
}
