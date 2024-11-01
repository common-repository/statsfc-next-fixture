=== StatsFC Next Fixture ===
Contributors: willjw
Donate link:
Tags: widget, football, soccer, fixtures, premier league, fa cup, league cup
Requires at least: 3.3
Tested up to: 6.2.2
Stable tag: 3.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This widget will show the next fixture for a Premier League team on your website.

== Description ==

Add the next fixture for any Premier League team to your WordPress website. To request a key sign up for your free trial at [statsfc.com](https://statsfc.com).

Fixture times are automatically adjusted to your website's local time.

For a demo, check out [wp.statsfc.com/next-fixture](https://wp.statsfc.com/next-fixture/).

= Translations =
* Bahasa Indonesia
* Dansk
* Deutsch
* Eesti
* Español
* Français
* Hrvatski Jezik
* Italiano
* Magyar
* Norsk bokmål
* Slovenčina
* Slovenski Jezik
* Suomi
* Svenska
* Türkçe

If you're interested in translating for us, please get in touch at [hello@statsfc.com](mailto:hello@statsfc.com) or on Twitter [@StatsFC](https://twitter.com/StatsFC).

== Installation ==

1. Upload the `statsfc-next-fixture` folder and all files to the `/wp-content/plugins/` directory
2. Activate the widget through the 'Plugins' menu in WordPress
3. Drag the widget to the relevant sidebar on the 'Widgets' page in WordPress
4. Set the StatsFC key and any other options. If you don't have a key, sign up for free at [statsfc.com](https://statsfc.com)

You can also use the `[statsfc-next-fixture]` shortcode, with the following options:

* `key` (required): Your StatsFC key
* `team` (required): Team name, e.g., `Liverpool`
* `competition` (optional): Competition key, e.g., `EPL`
* `date` (optional): For a back-dated match, e.g., `2013-12-31`
* `timezone` (optional): The timezone to convert match times to, e.g., `Europe/London` ([complete list](https://php.net/manual/en/timezones.php))
* `default_css` (optional): Use the default widget styles, `true` or `false`
* `omit_errors` (optional): Omit error messages, `true` or `false`

== Frequently asked questions ==



== Screenshots ==



== Changelog ==

= 3.0.0 =
* Refactor: Update plugin for new API

= 2.16.3 =
* Hotfix: Possible issue loading language/CSS files

= 2.16.2 =
* Hotfix: Check options exist before using them

= 2.16.1 =
* Hotfix: Check the before/after widget/title bits exist before using them

= 2.16.0 =
* Feature: Translate dates if using non-English.

= 2.15.2 =
* Hotfix: Load relevant language file based on the default language for the site

= 2.15.1 =
* Hotfix: Fixed missing team badges

= 2.15.0 =
* Feature: Added multi-language support. If you're interested in translating for us, please get in touch at [hello@statsfc.com](mailto:hello@statsfc.com)

= 2.14.2 =
* Hotfix: Added a responsive horizontal scroll if the widget is too wide for mobile

= 2.14.1 =
* Hotfix: Fixed possible `Undefined index: omit_errors` error

= 2.14.0 =
* Feature: Put CSS/JS files back into the local repo
* Feature: Enqueue style/script directly instead of registering first

= 2.13.0 =
* Feature: Added `omit_errors` parameter
* Feature: Load CSS/JS remotely

= 2.12.2 =
* Hotfix: Fixed "Invalid domain" bug caused by referal domain

= 2.12.1 =
* Hotfix: Fixed bug with multiple widgets on one page

= 2.12.0 =
* Feature: Converted to JS widget

= 2.11.0 =
* Feature: Allow more discrete ads for ad-supported accounts

= 2.10.0 =
* Feature: Added a `competition` parameter

= 2.9.0 =
* Feature: Enabled ad-support

= 2.8.0 =
* Feature: Use built-in WordPress HTTP API functions

= 2.7.0 =
* Feature: Added badge class for each team

= 2.6.0 =
* Feature: Default `default_css` parameter to `true`

= 2.5.0 =
* Feature: Updated team badges.

= 2.4.0 =
* Feature: Added `[statsfc-next-fixture]` shortcode.

= 2.3.0 =
* Feature: Added a `date` parameter.

= 2.2.0 =
* Feature: Updated to use the new API.

= 2.1.0 =
* Feature: Improved timezone list.

= 2.0.0 =
* Feature: Allow an actual timezone to be selected, and use the new API.

= 1.5.0 =
* Feature: Tweaked error message.

= 1.4.0 =
* Feature: Show live score if there's a match ongoing.

= 1.3.1 =
* Hotfix: Fixed possible Timezone bug.

= 1.3.0 =
* Feature: Added fopen fallback if cURL request fails.

= 1.2.2 =
* Hotfix: Fixed possible cURL bug.

= 1.2.1 =
* Hotfix: Minor team shirt CSS bug fixes.

= 1.2.0 =
* Feature: Use short team names.

= 1.1.0 =
* Feature: Use cURL to fetch API data if possible.

= 1.0.1 =
* Hotfix: Fixed timezone adjustment bug in old versions of PHP. If using an old version, you'll need to choose your own UTC offset in the options.

== Upgrade notice ==

