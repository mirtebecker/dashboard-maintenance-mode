<?php

// What to do with input from dashboard widget
if( isset($_POST['function']) ) {
	switch( $_POST['function'] ) {
		case 'Activate':
		activate();
		break;
		case 'Deactivate':
		deactivate();
		break;
	}
}

$mypath = ABSPATH;
	
// Activate: 
// Check if .maintenance excists, if not (maintenance mode is off), change .notmaintenance to .maintenance (maintenance mode is on).
function activate() {
	global $mypath;
	echo $mypath;

	$notmaintenance = $mypath.'../../../.notmaintenance';
	if (file_exists($notmaintenance)) {
		rename($mypath.'../../../.notmaintenance', $mypath.'../../../.maintenance');
	}
}

// Deactivate: 
// Check if .maintenance excists, if so (maintenance mode is on), change .maintenance to .notmaintenance (maintenance mode is off).
function deactivate() {
	$maintenance = $mypath.'../../../.maintenance';
	if (file_exists($maintenance)) {
		rename($mypath.'../../../.maintenance',  $mypath.'../../../.notmaintenance');
	}
}

header('Location: ../../../wp-admin');

?>