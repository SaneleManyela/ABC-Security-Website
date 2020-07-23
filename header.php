<?php
session_start(); //This begins a user session

/*This is where all the site's pages begin
 * and where the css and javascript files are
 * referenced
 */

echo <<<_HEADER
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>ABC Security</title>
        <link rel='stylesheet' href='/ABCSecurity/styles.css'>
        <script defer src="/ABCSecurity/validationScript.js"></script>
    </head>
_HEADER;

/*Requires the php file containing
 * functions that are used throughout 
 * the site's operations
 */
require_once 'functions.php'; 

if(isset($_SESSION['loggedin']))
{
    $user = $_SESSION['username'];
    $loggedin = TRUE; //A boolean variable that specifies if a user is logged in
    $userstr = "Logged in as: ".ucfirst(strtolower($user));//A logged user is welcomed with login name
}
 else {
     $loggedin = FALSE;
     $userstr = "Welcome Guest"; //An unlogged user is welcomed
}
