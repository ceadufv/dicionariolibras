=== DD Last Viewed ===
Contributors: Mosterd3d
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=5V2C94HQAN63C&lc=US&item_name=Dijkstra%20Design&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
Tags: History, Last, Viewed, posts, custom, posttypes, thumbnail, cookie, widget, recent, visit, visited, recently, terms, taxonomies, taxonomy, term, category, template, customize
Requires at least: 3.3
Tested up to: 4.9.2
Stable tag: 3.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shows the visitors recently viewed/visited Posts, Pages, Custom Types and even Terms in a widget.

== Description ==

This plugin contains the lastViewed-widget. This widget shows the users recently viewed/visited Posts, Pages, Custom Types and even Terms in a widget.

The widget is fully customizable:

* Filter on Types and Terms
* Set the maximum
* Set thumbnail on/off
* Show Content(rich or plain) or Excerpt
* Set the excerpt length
* Add links to elements
* Set cookie lifetime


Customize the widget template by copy the file "dd-templates/lastviewed-widget.php" from the plugin directory into your theme directory. You can now start customizing the widgets template.


If one of the posts with the filtered types or terms gets visited in the front, a cookie sets/updates with an array of visited ids. Each widget has his own cookie, so you can set as many widgets as you want.

== Installation ==

1. Upload the `dd-lastViewed` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Customize the widget

OPTIONAL ADVANCED (customize widget template):

4. Copy dd_templates/widget.php
5. Paste clipboard in theme folder
6. Start customizing the template

You can use [dd_lastviewed widget_id="12"] as shortcode to publish the widget inside a page or a post. Do not forget to use the correct id!

== Frequently asked questions ==

Do you have ideas, questions or issues with LastViewed? Please leave a message in the support forum.

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png
3. screenshot-3.png

== Changelog ==

= 3.2.4 =

* Fix bug thumbnail active

= 3.2.3 =

* Fix bug when not all settings are set

= 3.2.2 =

* Update js
* fix saving bug

= 3.2.1 =

* Refined Code
* Refined the template

= 3.2.0 =

* Added the option to set te cookie expire time

= 3.1.4 =

* Fixed bug 'Undefined index:'
* Enabled custom template in theme folder ('**THEME**/dd-templates/lastviewed-widget.php')
* Increase widget cookie lifetime to 365 days

= 3.0.3 =

* Align NPM and added grunt tasks

= 3.0.2 =
* Show widget only when cookie exist
* Make more unique vars for args
* Just functions not public

= 3.0.1 =
* Revert array notation from [] to array() to be compatible with old php versions
* If total is not set use -1 for posts_per_page

= 3.0 =
* Put everything in a class
* Made new multi-filter for types and terms
* Refactor code
* Added "Donate & review"

= 2.7 =
* Add link-button to title, thumb and content


= 2.6 =
* Implement exclude IDs

= 2.5.2 =
* Set cookie by PHP instead of JS
* Hide H2 element while title is not set
* Tuned phrases
* Removed files

= 2.5.1 =
* Fix error with '_multiwidget'
* Avoid shortcode '[lastviewed] in order to prevent a loop in a widget with a lastviewed-shortcode ;)

= 2.5 =
* Refined code
* Get posts by one query
* Set cookie per widget
* Fill cookies with id's of types set in the widget
* Cookie length set by length in widget
* Fix shortcode in rich content
* Added warning in front when options are not set
* Fix show last id on index

= 2.3.1 =
* Added rich/plain radio input

= 2.3 =
* Added choice content/excerpt
* Added full text or truncated
* Set max cookie to 40

= 2.2 =
* Add select thumb-size

= 2.1.2 =
* Fix Strict standards widget

= 2.1.1 =
* Fix filenames

= 2.1 =
* Fix typo

= 2.0 =
* Added switches voor settings
* Cleaned up code

= 1.4 =
* Removed tags and shortcodes from content
* Add clearfix only on listitems with thumb.

= 1.3 =
* Added SASS
* Added Widget admin Icon
* Bugfix: hide widget when no type is selected
* Branding: catch the eye ;)

= 1.2.2 =
* Added pages
* Added before and after title

= 1.2.1 =
* Cleanup code

= 1.2 =
* Bugfix: removed the debug echo
* Do not show current visit post in widget

= 1.1 =
* Bugfix: number to show

= 1.0 =
* Cleanup the code
* Load assets properly

= 0.9.0 =
* Added shortcode to the widgetform for easy use, copy paste.

= 0.9.0 =
* Use the widget inside page or post with shortcode eg. [dd_lastviewed widget_id="12"]
* Clean up some code

= 0.8.1 =
* At least posts need to be selected, otherwise this plugin is worthless! ;)
* At more screenshots

= 0.8.0 =
* Bugfixes
* solved the warnings when a variable is not set FULLY.
* Make custom link name
* Set default title to "Last Viewed"


= 0.7.3 =
* Bugfixes
* solved the warnings when a variable is not set.

= 0.7.2 =
* Bugfixes

= 0.7.1 =
* Bugfixes



== Upgrade notice ==

= 3.2.1 =
- Use the new variables in the custom template

= 3.0 =
- Reconfigure widget setting

= 2.7 =
- Reconfigure widget setting
- Style title if link not set


The current version of LastViewed requires WordPress 3.3 or higher. If you use older version of WordPress, you need to upgrade WordPress first.

== Arbitrary section 1 ==
