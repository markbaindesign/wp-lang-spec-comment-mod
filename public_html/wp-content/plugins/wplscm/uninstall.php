<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
   die;
}

// Delete the options we have created
delete_option( 'baindesign_wplscm_email_settings' );