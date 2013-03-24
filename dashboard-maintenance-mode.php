<?php   
 
/* 
Plugin Name: Dashboard Maintenance Mode
Plugin URI: http://
Description: Adds a widget to the Wordpress dashboard from which you can turn your website in maintenance mode.
Version: 0.2
Author: Mirte Becker
Author URI: http://www.mirtebecker.com

Thank you: 
- Rami Ismail
- Matthew Wilse
- Matt from Sivel.net (sivel.net/2009/06/wordpress-maintenance-mode-without-a-plugin)

Wishlist:
- Settings page for styling of maintenance page
- Language support

*/

$maintenance = ABSPATH.'.maintenance';
$notmaintenance = ABSPATH.'.notmaintenance';

register_activation_hook(__FILE__, 'dmm_activation');
register_deactivation_hook(__FILE__, 'dmm_deactivation'); 	

function dmm_activation() {
    register_uninstall_hook(__FILE__, 'dmm_uninstall');

	global $maintenance;
	global $notmaintenance;
	
	// First time use?
	if (!file_exists($maintenance) && !file_exists($notmaintenance)) {
		// Create all files
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

// Add javascript only on admin pages (possibly only dashboard page?)
if ( is_admin() ) {
	wp_enqueue_script('javascript', get_bloginfo('url').'/wp-content/plugins/dashboard-maintenance-mode/script.js');
}

// Add login message if maintenance mode is active.
add_filter('login_message', 'dmm_login_message');
function dmm_login_message() {
	global $maintenance;
	if (file_exists($maintenance)) {
		$message = '<div id="login_error"><p>Remember: Maintenance Mode is <b>active</b>!</p></div>';
		return $message;
	}
}

// Remove Maintenance Nag
function dmm_hide_nag() {
	remove_action( 'admin_notices', 'maintenance_nag' );
}
add_action( 'admin_notices', 'dmm_hide_nag', 1 );

// Add the dashboard widget
add_action('wp_dashboard_setup', 'dmm_add_widget');
function dmm_add_widget() {
	wp_add_dashboard_widget('dmm_widget', 'Dashboard Maintenance Mode', 'dmm_widget');
}

// Content of dashboard widget
function dmm_widget() { 
	global $maintenance;
	
	echo '<p>Activating maintenance mode will temporarily hide your home page for your visitors, so you can work on new features or content. Visitors of your website will be directed to a page asking them to please come back soon. Logged in users (including you!) will be able to view the website just like before. Don&rsquo;t forget to disable maintenance mode when you&rsquo;re done!</p>';

	// Check if .maintenance excists 	
	if (file_exists($maintenance)) {
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
    		border-width:1px;border-style:solid;-webkit-border-radius:3px;border-radius:3px;border-color:#555;color:#555;background-color:#E8E8E8;">Maintenance Mode is not active.</label> 
    		<input name="function" type="submit" value="Activate" onClick="toggle(this)"/>
			<div name="hide" style="display:none">
				<img id="image" src="'.get_bloginfo("url").'/wp-content/plugins/dashboard-maintenance-mode/wpspin_light.gif" style="vertical-align:middle;">
			</div>
    	</form>';
	} 
} 

function dmm_deactivation(){
	// Deactivate maintenance mode when plugin is deactivated
	global $maintenance;
	global $notmaintenance;
	
	if (file_exists($maintenance)) {
    	rename($maintenance, $notmaintenance);
	}
}

function dmm_uninstall(){
	// Trash all files when plugin is uninstalled
	global $maintenance;
	global $notmaintenance;
	$maintenancephp = ABSPATH.'wp-content/maintenance.php';

	if (file_exists($maintenance)) {
    	unlink($maintenance);
	}
	if (file_exists($notmaintenance)) {
    	unlink($notmaintenance);
	}    
	if(file_exists($maintenancephp)){
		unlink($maintenancephp);
	}
}

?>