<?php

function verifyAlphaNum($testString) {
    // Check for letters, numbers and dash, period, space and single quote only. 
    return (preg_match("/^([[:alnum:]]|-|\.| |')+$/", $testString));
}

function verifyEmail($testString) {
    // Check for a valid email address 
    return filter_var($testString, FILTER_VALIDATE_EMAIL);
}

function verifyText($testString) {
    // Check for letters, numbers and dash, period, ?, !, space and single and double quotes only. 
    return (preg_match("/^([[:alnum:]]|-|\.| |\n|\r|\?|\!|\"|\')+$/", $testString));
}

function verifyPhone($testString) {
    // Check for only numbers, dashes and spaces in the phone number 
    return (preg_match('/^([[:digit:]]| |-)+$/', $testString));
}

function validNumber($testString) {
    return is_numeric($testString);
}

function validInteger($testString) {
    return filter_var($testString , FILTER_VALIDATE_INT);
}

function verifyName($testString){
    return (preg_match("^[A-Za-z]+$^", $testString));
}
?>