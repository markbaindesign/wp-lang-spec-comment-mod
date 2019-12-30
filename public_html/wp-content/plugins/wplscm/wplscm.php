<?php
/**
 * Plugin Name: Language-specific Comment Moderation
 * Plugin URI: https://bain.design/wplscm
 * Description: A simple plugin enabling comment moderation emails to be sent to a different email address depending on the language of the commented post. Requires the WPML plugin.
 * Author: Bain Design
 * Version: 1.0.0
 * Author URI: http://bain.design
 * License: GNU General Public License v2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: _bd_wplscm
 * Plugin Slug: wp-ls-cm
 */

function baindesign_wplscm_plugin_init() {

	include( plugin_dir_path( __FILE__ ) . 'admin/admin.php');
	
	if( class_exists( 'SitePress' ) ) {

		/**
		 * Get post language details
		 */
		function baindesign_wplscm_get_post_language($post_id)
		{
			$post_language_details = apply_filters('wpml_post_language_details', NULL, $post_id);
			return $post_language_details;
		}

		/**
		 * Get the moderation email by language
		 * 
		 * As an input, this function requires the WPML language code. 
		 * 
		 * This function outputs an email address. 
		 * 
		 */
		function baindesign_wplscm_get_local_moderation_email($lang_code)
		{			
			$emails = get_option('baindesign_wplscm_email_settings');
			$email = $emails['baindesign_wplscm_email_' . $lang_code];			
			return $email;
		}

		/**
		 * Filter the comment moderation email
		 */

		function baindesign_wplscm_comment_moderation_recipients($emails, $comment_id)
		{
			$comment = get_comment($comment_id);
			// error_log('Comment ID: ' . $comment->comment_ID);
			// error_log('Post ID: ' . $comment->comment_post_ID);
			$post = get_post( $comment->comment_post_ID );
			if( is_wp_error( $post ) ) {
				return false; // Bail early
			}
			$post_id = $post->ID;
			if( ! is_wp_error( $post_id ) ) {
				// error_log('Post ID: ' . $post_id);
				$lang_details = baindesign_wplscm_get_post_language($post_id);
				if( ! is_wp_error( $post_id ) ) {
					$language_code = $lang_details['language_code'];  
					// error_log('Lang code: ' . $language_code);
					$emails = array ( baindesign_wplscm_get_local_moderation_email($language_code) );      
					return $emails;
				}
			}

		}
		add_filter('comment_moderation_recipients', 'baindesign_wplscm_comment_moderation_recipients', 11, 2);

	} else {

		/**
		 * Show an admin message to tell the user to install
		 * WPML plugin. 
		 */
		function baindesign_wplscm_admin_warning() {
			ob_start(); ?>
			<div class="error">
				<?php _e('<p><strong>Error</strong>: You must activate the WPML plugin for the Language-specific Comment Moderation to work!</p>', '_bd_wplscm' ); ?>
			</div>
			<?php
			echo ob_get_clean();
		}
		add_action('admin_notices', 'baindesign_wplscm_admin_warning');
	}
}
add_action( 'plugins_loaded', 'baindesign_wplscm_plugin_init' );