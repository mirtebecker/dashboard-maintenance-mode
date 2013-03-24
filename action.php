<?php

// What to do with input from dashboard widget
if( isset($_POST['function']) ) {
	switch( $_POST['function'] ) {
		case 'Activate':
		dmm_activate();
		break;
		case 'Deactivate':
		dmm_deactivate();
		break;
	}
}

$path = ABSPATH;
		
// Activate 
// Check if .maintenance excists, if not change .notmaintenance to .maintenance
function dmm_activate() {
	global $path;
	$notmaintenance = $path.'../../../.notmaintenance';
	
	if (file_exists($notmaintenance)) {
		rename($path.'../../../.notmaintenance', $path.'../../../.maintenance');
	}
}

// Deactivate
// Check if .maintenance excists, if so change .maintenance to .notmaintenance
function dmm_deactivate() {
	global $path;
	$maintenance = $path.'../../../.maintenance';
	
	if (file_exists($maintenance)) {
		rename($path.'../../../.maintenance',  $path.'../../../.notmaintenance');
	}
}

header('Location: ../../../wp-admin');

?>