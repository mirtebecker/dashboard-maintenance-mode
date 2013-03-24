=== Plugin Name ===
Contributors: mirte
Tags: dashboard, widget, maintenance mode, maintenance
Tested up to: 3.4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a nifty widget to your dashboard from which you can put your website in maintenance mode.

== Description ==

If, for example, your clients want to be able to "turn off" their website for a while, so they can work on new
content or features of their website, but you don't want them rummaging through the Wordpress Settings pages to do so, this plugin might be something for you.

This plugin creates a very simple little widget for your WP Dashboard, from which the website can turned to / out of maintenance mode.

Activating maintenance mode will display a maintenance mode page with explanatory text for your visitors. Logged in users will be able to view the website as they normally would.

The plugin will automatically create a `maintenance.php` file and add it to your `/wp-content/` directory. Customize this page to change the appearance and text of the maintenance mode page.

<b>Known bugs</b>
* Right now, this plugin will not work on certain servers (like Antagonist.nl) because of a permissions issue.

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Activate/deactivate maintenance mode through your WP Dashboard
4. Customize `maintenance.php` in your `/wp-content/` directory. 
