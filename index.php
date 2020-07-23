<?php
require_once 'mainMenu.php'; //A request to use the mainMenu file on this page

echo "<div class='center'><b>Welcome to ABC Security web application</b>";
if($loggedin)
{
    echo " <b>$user, you are logged in.</b>"; //Shows when a user is logged in
}
else {
    echo "<b>, please log in.<b><br><br>"; //Shows when a user is not logged in
}
echo"</div>";
require_once 'footer.php';