# WP Language-specific Comment Moderation

## Version: 1.0.0

### By bain.design

A plugin to manage language-specific comment moderation settings (mostly just the recipient email addresses) for multilingual WordPress sites using the WPML plugin

** This plugin requires the WPML plugin to be installed **

# VVV setup
This plugin has been developed in VVV. To add this project to your VVV machine, add the following lines to your `config.yml` 

```
  wp-language-specific-comment-moderation:
    description: "A WordPress plugin"
    repo: https://github.com/markbaindesign/wp-lang-spec-comment-mod.git
    branch: develop
    hosts:
      - wplscm.test
      - cat.wplscm.test
      - esp.wplscm.test
    custom:
      site_title: WP Lang Specific Comment Moderation
      delete_default_plugins: true
      install_plugins:
        - debug-bar
        - transients-manager
        - query-monitor
        - email-log
      wp_config_constants:
        WP_DEBUG: true
        WP_DEBUG_LOG: true
        WP_DEBUG_DISPLAY: false
        WP_DISABLE_FATAL_ERROR_HANDLER: true
```