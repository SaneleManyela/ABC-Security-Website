<?php
require_once(dirname(__DIR__)."/header.php");

//The upper part of the page
echo <<<_MAIN
    <body>
        <div>
            <div id='logo'><img id='secLogo' src='/ABCSecurity/logo.jpeg'>       
                ABC Security Company</div>
            <div class='username'>$userstr</div>
        </div>
        <div data-role='content'>
_MAIN;
switch (getUserIdentifier($_SESSION['password']))
{
    case "Administrator":
echo <<<_LOGGEDIN
   <div id='wrapper'>
        <div id='menu'>
         <ul>
            <li><a class="item" href="/ABCSecurity/index.php">Home</a></li>
            <li><a class="item" href="registerUsers.php?user=Administrator">Register Admins</a></li>
            <li><a class="item" href="registerUsers.php?user=Security">Register Securities</a></li>
            <li><a class="item" href="registerUsers.php?user=Client">Register Clients</a></li>
         </ul>
        </div>
    </div>
_LOGGEDIN;
        break;
    case "DefaultAdministrator":
        echo <<<_LOGGEDIN
   <div id='wrapper'>
        <div id='menu'>
         <ul>
            <li><a class="item" href="/ABCSecurity/index.php?view=$user">Home</a></li>
            <li><a class="item" href="registerUsers.php?user=Administrator">Register Admins</a></li>
         </ul>
        </div>
    </div>
_LOGGEDIN;
        break;
}