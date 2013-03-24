<?php   
 
/* 
Plugin Name: Dashboard Maintenance Mode
Plugin URI: http://
Description: Adds a maintenance mode widget to the dashboard. Perpect for CMS use of Wordpress.
Version: 0.1
Author: Mirte Becker
Author URI: http://www.mirtebecker.com

Credit: 
- Matthew Wilse 
- Matt from Sivel.net (sivel.net/2009/06/wordpress-maintenance-mode-without-a-plugin)

Wishlist:
- Settings page for styling of maintenance page
- Language support
- Remove "An automated WordPress update has failed to complete - please attempt the update again now."

*/

$mypath = ABSPATH;

// Add javascript only on admin pages (possibly only dashboard page?)
if ( is_admin() ) {
	wp_enqueue_script('javascript', get_bloginfo('url').'/wp-content/plugins/dashboard-maintenance-mode/script.js');
}

// Add login message if maintenance mode is active.
add_filter('login_message', 'custom_login_message');
function custom_login_message() {
	$filename = ABSPATH.'.maintenance';

	if (file_exists($filename)) {
		$message = '<div id="login_error"><p>Remember: maintenance mode is <b>active</b>!</p></div>';
		return $message;
	}
}
// Remove Maintenance Nag
function hide_maintenance_nag() {
	remove_action( 'admin_notices', 'maintenance_nag' );
}
add_action( 'admin_notices', 'hide_maintenance_nag', 1 );

// Add the dashboard widget
add_action('wp_dashboard_setup', 'add_maintenance_widget');
function add_maintenance_widget() {
	wp_add_dashboard_widget('maintenance_dashboard_widget', 'Dashboard Maintenance Mode', 'maintenance_dashboard_widget');
}

// Content of dashboard widget
function maintenance_dashboard_widget() { 

	echo '<p>Activating maintenance mode will temporarily hide your home page for your visitors, so you can work on new features or content. Visitors of your website will be directed to a page asking them to please come back soon. Logged in users (including you!) will be able to view the website just like before. Don&rsquo;t forget to disable maintenance mode when you&rsquo;re done!</p>';

	// Check if .maintenance excists 
	$filename = ABSPATH.'.maintenance';
	
	if (file_exists($filename)) {
		// Maintenance mode is active
    	echo '
    	<form action="'.get_bloginfo("url").'/wp-content/plugins/dashboard-maintenance-mode/action.php" method="post">
    		<label class="error" style="font-size:11px;padding:4px 4px;margin:0;vertical-align:baseline;cursor:default;
    		border-width:1px;border-style:solid;-webkit-border-radius:3px;border-radius:3px;border-color:#C00;color:#555;background-color:#FFEBE8;">Maintenance Mode is active.</label>
    		<input name="function" type="submit" value="Deactivate" onClick="toggle(this)"/>
			<div name="hide" style="display:none;">
				<img id="image" src="'.get_bloginfo("url").'/wp-content/plugins/dashboard-maintenance-mode/wpspin_light.gif" style="vertical-align:middle;">
			</div>
    	</form>';
	} else {
		// Maintenance mode is not active
    	echo '
    	<form action="'.get_bloginfo("url").'/wp-content/plugins/dashboard-maintenance-mode/action.php" method="post">
    	<form action="'.get_bloginfo("url").'/wp-content/plugins/dashboard-maintenance-mode/action.php" method="post">
    		<label class="error" style="padding-left: 2px;font-size:11px;padding:4px 4px;margin:0;vertical-align:baseline;cursor:default;
    		border-width:1px;border-style:solid;-webkit-border-radius:3px;border-radius:3px;border-color:#555;color:#555;background-color:#E8E8E8;">Maintenance Mode is deactivated.</label> 
    		<input name="function" type="submit" value="Activate" onClick="toggle(this)"/>
			<div name="hide" style="display:none">
				<img id="image" src="'.get_bloginfo("url").'/wp-content/plugins/dashboard-maintenance-mode/wpspin_light.gif" style="vertical-align:middle;">
			</div>
    	</form>';
	} 
	
	// Check if both .maintenance and .notmaintenance don't excist (first time use)
	
	$maintenance = ABSPATH.'.notmaintenance';
	$notmaintenance = ABSPATH.'.maintenance';

	if (!file_exists($maintenance) && !file_exists($notmaintenance)) {
		// If not, copy .maintenance from plugin directory to root directory and rename to .notmaintenance
		$file = ABSPATH.'wp-content/plugins/dashboard-maintenance-mode/.maintenance';
		$newfile = ABSPATH.'.notmaintenance';
		
		$maintenancephp = ABSPATH.'wp-content/plugins/dashboard-maintenance-mode/maintenance.php';
		$newmaintenancephp = ABSPATH.'wp-content/maintenance.php';

		if (!copy($file, $newfile)) {
			echo "Failed to copy $file...\n";
		}
		if (!copy($maintenancephp, $newmaintenancephp)) {
			echo "Failed to copy $file...\n";
		}
	}
} 

?>