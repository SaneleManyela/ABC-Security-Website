<?php
require_once(dirname(__DIR__)."/header.php");

//The upper part of the page
echo <<<_MAIN
    <body>
        <div data-role='page'>
            <div data-role='header'>
                <div id='logo'><img id='secLogo' src='/ABCSecurity/logo.jpeg'>       
                    ABC Security Company</div>
                <div class='username'>$userstr</div>
            </div>
        <div data-role='content'>
_MAIN;

$userAccessingComplaints = getUserIdentifier($_SESSION['password']);

switch($userAccessingComplaints){
    case "Client":
        echo <<<_LOGGEDIN
        <div id='wrapper'>
            <div id='menu'>
                <ul>
                    <li><a class="item" href="/ABCSecurity/index.php">Home</a></lis>
                    <li><a class="item" href="RegisterComplaint.php?action=Register">Register Complaint</a></li>
                    <li><a class="item" href="RegisterComplaint.php?action=Update">Update Complaint</a></li>
                </ul>
            </div>
        </div>
_LOGGEDIN;
        break;
    case "Security":
        echo <<<_LOGGEDIN
        <div id='wrapper'>
            <div id='menu'>
                <ul>
                    <li><a class="item" href="/ABCSecurity/index.php">Home</a></lis>
                    <li><a class="item" href="ViewComplaints.php">View Complaints</a></li>
                </ul>
            </div>
        </div>
_LOGGEDIN;
        break;
}