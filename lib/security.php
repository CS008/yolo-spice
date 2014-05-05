<?php

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//performs a few security checks
function securityCheck($form = "") {
    
    // globals defined in top.php
    global $yourURL;

    $status = true; // start off thinking everything is good until a test fails
    $fromPage = htmlentities($_SERVER['HTTP_REFERER'], ENT_QUOTES, "UTF-8"); 

    if ($debug) print "<p>From: " . $fromPage . " should match yourUrl: " . $yourURL;

    if($fromPage != $yourURL){
        $status=false;
        
    } 
    
    return $status;
}
?>
