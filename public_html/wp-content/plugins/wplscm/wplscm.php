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
 * 
 */

 /**
 * Get post language details
 */
function khy991_wpml_get_post_language($post_id)
{
  $post_language_details = apply_filters('wpml_post_language_details', NULL, $post_id);
  return $post_language_details;
}

/**
 * Get the moderation email by language
 * 
 * This function checks for an ACF field which 
 * contains the moderation email address for the
 * specific language.
 * 
 * It achieves this by switching language, checking
 * the value, then switching back to the default 
 * language. 
 * 
 * As an input, this function requires the WPML language code. 
 * 
 * This fuction outputs an email address. 
 * 
 */
function khy991_get_local_moderation_email($lang_code)
{
      do_action( 'wpml_switch_language', $lang_code );
      $email = get_field( 'comment_moderation_email_address', 'option' );
      do_action( 'wpml_switch_language', NULL );
      
      return $email;
}

/**
 * Filter the comment moderation email
 */

function khy991_comment_moderation_recipients($emails, $comment_id)
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
    $lang_details = khy991_wpml_get_post_language($post_id);
    if( ! is_wp_error( $post_id ) ) {
      $language_code = $lang_details['language_code'];  
      // error_log('Lang code: ' . $language_code);
      $emails = array ( khy991_get_local_moderation_email($language_code) );      
      return $emails;
    }

  }

}
add_filter('comment_moderation_recipients', 'khy991_comment_moderation_recipients', 11, 2);