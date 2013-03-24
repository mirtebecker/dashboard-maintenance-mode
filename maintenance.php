<?php
$protocol = $_SERVER["SERVER_PROTOCOL"];
if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol )
        $protocol = 'HTTP/1.0';
header( "$protocol 503 Service Unavailable", true, 503 );
header( 'Content-Type: text/html; charset=utf-8' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Your Website | Briefly unavailable for scheduled maintenance</title>
    
    <style>
    body {
    	background-color: #F0F0F0;
    	font-family: "Trebuchet MS", sans-serif;
    	color: #4A4A4A;
    }
    
    section {
    	background-color: #fff;
    	width: 600px;
    	margin: 0 auto;
    	margin-top: 100px;
    	padding: 45px 25px;
    	border: 10px solid #b2b2b2;
    	text-align: center;
    }
    
    h1 {
    	font-size: 1em;
    }
    </style>
    
</head>
<body>

	<section>
    	<h1>Briefly unavailable for scheduled maintenance.</h1>
	</section>
	
</body>
</html>
<?php die(); ?>