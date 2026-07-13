<?php
/**
 * Tests for the core comment-moderation-recipient logic.
 *
 * @package Wplscm
 */

class Wplscm_Core_Test extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();
		delete_option( 'baindesign_wplscm_email_settings' );
	}

	/**
	 * With no lang code, no email should be returned.
	 */
	public function test_get_local_moderation_email_returns_null_without_lang_code() {
		$this->assertNull( baindesign_wplscm_get_local_moderation_email( '' ) );
		$this->assertNull( baindesign_wplscm_get_local_moderation_email( false ) );
	}

	/**
	 * With no settings saved at all, no email should be returned.
	 */
	public function test_get_local_moderation_email_returns_null_without_option() {
		$this->assertNull( baindesign_wplscm_get_local_moderation_email( 'es' ) );
	}

	/**
	 * A configured language-specific email should be returned for that language.
	 */
	public function test_get_local_moderation_email_returns_configured_email() {
		update_option(
			'baindesign_wplscm_email_settings',
			array( 'baindesign_wplscm_email_es' => 'moderator-es@example.com' )
		);

		$this->assertSame( 'moderator-es@example.com', baindesign_wplscm_get_local_moderation_email( 'es' ) );
	}

	/**
	 * The comment_moderation_recipients filter should return the language-specific
	 * email when one is configured for the post's language.
	 */
	public function test_comment_moderation_recipients_uses_language_specific_email() {
		update_option(
			'baindesign_wplscm_email_settings',
			array( 'baindesign_wplscm_email_es' => 'moderator-es@example.com' )
		);

		$post_id    = self::factory()->post->create();
		$comment_id = self::factory()->comment->create( array( 'comment_post_ID' => $post_id ) );

		add_filter(
			'wpml_post_language_details',
			function ( $details, $for_post_id ) use ( $post_id ) {
				if ( $for_post_id === $post_id ) {
					return array( 'language_code' => 'es' );
				}
				return $details;
			},
			10,
			2
		);

		$recipients = baindesign_wplscm_comment_moderation_recipients( array(), $comment_id );

		$this->assertSame( array( 'moderator-es@example.com' ), $recipients );
	}

	/**
	 * When no language-specific email is configured, the site's admin_email
	 * should be used instead.
	 */
	public function test_comment_moderation_recipients_falls_back_to_admin_email() {
		update_option( 'admin_email', 'admin@example.com' );

		$post_id    = self::factory()->post->create();
		$comment_id = self::factory()->comment->create( array( 'comment_post_ID' => $post_id ) );

		add_filter(
			'wpml_post_language_details',
			function ( $details, $for_post_id ) use ( $post_id ) {
				if ( $for_post_id === $post_id ) {
					return array( 'language_code' => 'fr' );
				}
				return $details;
			},
			10,
			2
		);

		$recipients = baindesign_wplscm_comment_moderation_recipients( array(), $comment_id );

		$this->assertSame( array( 'admin@example.com' ), $recipients );
	}

	/**
	 * The comment_moderation_recipients filter is registered against WordPress
	 * core, using the same fallback/override logic as above end-to-end.
	 */
	public function test_comment_moderation_recipients_filter_is_registered() {
		$this->assertNotFalse(
			has_filter( 'comment_moderation_recipients', 'baindesign_wplscm_comment_moderation_recipients' )
		);
	}
}
