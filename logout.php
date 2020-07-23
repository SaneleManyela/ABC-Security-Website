<?php
require_once 'header.php';

if(isset($_SESSION['username'])){
   $userstr = "Goodbye ".$_SESSION['username'];
}else{
    $userstr = "Welcome Guest";
}

echo <<<_MAIN
<body>
    <div>
        <div id='logo'><img id='secLogo' src='logo.jpeg'>       
            ABC Security Company</div>
        <div class='username'>$userstr</div>
    </div>
_MAIN;

echo <<<_GUEST
   <div id='wrapper'>
        <div id='menu'>
            <ul>
                <li><a class="item" href="index.php">Home</a></li>
                <li><a class="item" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
    <div data-role='content'>
    <p class='info'>Login to use the app</p>
_GUEST;
/*When the logout menu is selected, this statement
 * first checks if a user has a session going on, if
 * so the user session is destroyed the logged out
 */
if(isset($_SESSION['loggedin']) == true)
{
    destroySession();
    echo "<div id='logoutInfo'><b>You have been logged out.</b></div><br><br>";
}
require_once 'footer.php';