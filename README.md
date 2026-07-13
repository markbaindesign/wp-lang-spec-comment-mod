# WP Language-specific Comment Moderation

## Version: 1.2.0

### By bain.design

A plugin to manage language-specific comment moderation settings (mostly just the recipient email addresses) for multilingual WordPress sites using the WPML plugin

** This plugin requires the WPML plugin to be installed **

# DDEV setup
This plugin is developed locally with [DDEV](https://ddev.com/). The project ships a `.ddev/config.yaml`, so setup is:

```
ddev start
```

The site is then available at:

- https://wplscm.ddev.site
- https://cat.wplscm.ddev.site
- https://esp.wplscm.ddev.site

WordPress core, WPML (`sitepress-multilingual-cms`, `wpml-string-translation`), and the dev-tool plugins (`debug-bar`, `email-log`, `query-monitor`, `transients-manager`) live under `public_html/wp-content` alongside the plugin itself and are not tracked in this repo's git history.

To import a database dump:

```
ddev import-db --file=/path/to/dump.sql
```

To export the current database:

```
ddev export-db --file=/path/to/dump.sql
```

# Manual testing

WP CLI is your friend (via `ddev wp ...` or `ddev ssh` then `wp ...`). Here are some commands to make testing a breeze.

```
ddev wp option get baindesign_wplscm_email_settings
```

# Automated testing

The plugin has a PHPUnit test suite plus WordPress Coding Standards linting, both runnable inside DDEV. Dependencies and the WordPress test library aren't tracked in git, so set them up once per environment:

```
cd public_html/wp-content/plugins/wplscm
ddev exec "cd public_html/wp-content/plugins/wplscm && composer install"
ddev exec "cd public_html/wp-content/plugins/wplscm && bash bin/install-wp-tests.sh wplscm_test root root db latest"
```

Then, from `public_html/wp-content/plugins/wplscm`:

```
ddev exec "cd public_html/wp-content/plugins/wplscm && WP_TESTS_DIR=/tmp/wordpress-tests-lib vendor/bin/phpunit"
ddev exec "cd public_html/wp-content/plugins/wplscm && vendor/bin/phpcs"
```

(`vendor/bin/phpcbf` will auto-fix most PHPCS formatting violations.)

# CI/CD

GitHub Actions (`.github/workflows/`) runs the same PHPUnit + PHPCS checks on every push/PR to `master` and `develop`. Pushing a `v*` tag (e.g. `v1.2.0`) triggers `deploy.yml`, which re-runs the test suite and, if it passes, publishes the plugin to the WordPress.org SVN repository and attaches a zip to the matching GitHub Release. This requires `SVN_USERNAME` and `SVN_PASSWORD` to be set as repository secrets.