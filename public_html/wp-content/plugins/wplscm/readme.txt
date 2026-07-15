=== Language-specific Comment Moderation ===
Contributors: markcbain
Donate link: https://bain.design/
Tags: wpml, multilingual, comment moderation, comments, translation
Requires at least: 4.6
Tested up to: 7.0.1
Stable tag: 1.2.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Route WordPress comment moderation notification emails to a different address for each language on your WPML multilingual site.

== Description ==

By default, WordPress sends every comment moderation notification to a single admin email address, no matter what language the commented-on post is in. On a multilingual site built with **WPML**, that means one inbox (and often one person) has to triage moderation requests for content they may not even be able to read.

**Language-specific Comment Moderation** fixes this by letting you set a separate moderation email address for each active language on your site. When a comment comes in on a post written in Spanish, the notification goes to your Spanish moderator; when it's in French, it goes to your French moderator; and so on. Any language without its own configured address simply falls back to your site's default Administration Email Address, so you only need to set up the languages that need a dedicated moderator.

**Key features**

* Per-language comment moderation email addresses, configured right on the familiar `Settings > Discussion` screen.
* Automatic fallback to the site's default admin email for any language you haven't configured.
* Works with any WPML-registered language, including custom/added languages.
* Lightweight: no new database tables, no extra settings pages, no bloat.
* Requires the WPML plugin (Multilingual CMS) to detect each post's language.

**Typical use cases**

* Editorial teams with different moderators per language/region.
* Agencies managing multilingual client sites where local staff moderate their own language's comments.
* Any WPML site where comment spam/moderation volume is high enough that splitting it by language saves time.

== Installation ==

1. Download the plugin .zip archive and unpack it.
1. Locate the plugin file and upload it to your website's Plugins folder (or install directly from the WordPress Plugin Directory).
1. Make sure the WPML plugin is installed and active — this plugin requires it.
1. Log into WordPress and activate the plugin.
1. Once activated, go to `Settings > Discussion` and add a moderation email address for each of your site's languages.

== Frequently Asked Questions ==

= Do I need WPML for this plugin to work? =

Yes. This plugin detects each post's language using WPML (the Multilingual CMS plugin), so WPML must be installed, active, and configured with at least one language.

= Do I need to add an email address for every language? =

No. Where no email address is specified for a language, comment moderation notifications for that language will default to your site's main Administration Email Address (set under `Settings > General`).

= Where do I configure the per-language email addresses? =

On the `Settings > Discussion` screen, under the "Multilingual Comment Moderation" section — no separate settings page needed.

= Does this affect anything other than comment moderation emails? =

No. It only changes who receives the "a comment is held for moderation" notification email. It doesn't change comment approval, spam handling, or any other WordPress comment behaviour.

= Does this work with Polylang or other multilingual plugins? =

Not currently — this plugin is built specifically against the WPML API.

== Screenshots ==

1. The plugin settings, showing a moderation email field for each registered language.

== Changelog ==

= 1.2.1 =
* Tested up to WordPress 7.0.1.

= 1.2.0 =
* Hardened output escaping on the settings screen.
* Fixed a fatal error that could occur if WPML was deactivated while the plugin was still active.
* Tested up to WordPress 6.7.

= 1.0.0 =
* Initial plugin version
