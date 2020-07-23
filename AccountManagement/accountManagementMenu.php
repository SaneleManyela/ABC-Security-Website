<?php
//A request for header file in the root directory
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
_MAIN;

//Account management menu
echo <<<_ACCOUNT
   <div id='wrapper'>
        <div id='menu'>
         <ul>
            <li><a class="item" href="/ABCSecurity/index.php">Home</a></lis>
            <li><a class="item" href="manageAccount.php?action=Update">Update Account</a></li>
            <li><a class="item" href="manageAccount.php?action=Deactivate">Deactivate Account</a></li>
         </ul>
        </div>
    </div>
 <div data-role='content'>
_ACCOUNT;
