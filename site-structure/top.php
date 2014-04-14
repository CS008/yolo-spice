<!DOCTYPE html>
<html lang="en">
<head>

<?php

    // parse the url into htmlentites to remove any suspicous vales that someone
    // may try to pass in. htmlentites helps avoid security issues
    // break the url up into an array, then pull out just the filename
    $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
    $path_parts = pathinfo($phpSelf);


    $pageName = $path_parts['filename'];
    print "<title>" . ucwords($pageName) . " - Assignment3.1 CS008</title>";

?>

<meta charset="utf-8">
<meta name="author" content="Michael Fritz">
<meta name="description" content="A site dedicated to MSC">

<!-- see: http://webdesign.tutsplus.com/tutorials/htmlcss-tutorials/quick-tip-dont-forget-the-viewport-meta-tag/ -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
<![endif]-->
	
<link rel="stylesheet" href="style.css" type="text/css" media="screen">

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

<?php
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^% 
// 
//  PATH SETUP
//
//  $domain = "https://www.uvm.edu" or http://www.uvm.edu;

if($_SERVER['HTTPS']) {
    $domain = "https://";
}else{
    $domain = "http://";
}

$server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");

$domain .= $server;

$phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

$path_parts = pathinfo($phpSelf);

$basePath = $domain . $path_parts['dirname'] . "/";

if ($debug){
    print "<p>Domain". $domain;
    print "<p>php Self". $phpSelf;
    print "<p>basePath". $basePath;
    print "<p>Path Parts<pre>";
    print_r($path_parts);
    print "</pre>";
}

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^% 
// 
//  inlcude all libraries
//  
//require_once('lib/security.php');

?>

</head>

<?php

print '<body id="' . $path_parts['filename'] . '">';

?>
