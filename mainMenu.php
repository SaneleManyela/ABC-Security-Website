<?php
require_once 'header.php';

//The upper part of the page
echo <<<_MAIN
    <body>
        <div>
            <div id='logo'><img id='secLogo' src='logo.jpeg'>       
                ABC Security Company</div>
            <div class='username'>$userstr</div>
        </div>
_MAIN;

/*If a user is logged in, the site checks
 * if they logged in as an administrator, security,
 * or as a client. This is evaluated based on user password. 
 * Depending on the results of the evaluation,
 * a user is directed to the home page and for each a different
 * menu is displayed.
 */
if($loggedin)
{
    switch(getUserIdentifier($_SESSION['password']))
    {
        case "Administrator":
echo <<<_LOGGEDIN
   <div id='wrapper'>
        <div id='menu'>
         <ul>
            <li><a class="item" href="index.php?view=$user">Home</a></li>
            <li><a class="item" href="UserRegistrations/registerUsers.php?user=Register">Account Registrations</a></li>
            <li><a class="item" href="AccountManagement/manageAccount.php?action=Manage">Account Management</a></li>
            <li><a class="item" href="TaskManagement/AssignTask.php?action=Manage">Task Management</a></li>
            <li><a class="item" href="Reports/reports.php?report=reports">Reports</a></li>
            <li><a class="item" href="logout.php">Log out</a></li>
         </ul>
        </div>
    </div>
    <div data-role='content'>
_LOGGEDIN;
            break;
        case "DefaultAdministrator":
echo <<<_LOGGEDIN
        <div id='wrapper'>
            <div id='menu'>
             <ul>
                <li><a class="item" href="index.php?view=$user">Home</a></li>
                <li><a class="item" href="UserRegistrations/registerUsers.php?user=Register">Account Registrations</a></li>
                <li><a class="item" href="logout.php">Log out</a></li>
             </ul>
            </div>
        </div>
        <div data-role='content'>
_LOGGEDIN;
            break;
        case "Security":
echo <<<_LOGGEDIN
   <div id='wrapper'>
        <div id='menu'>
            <ul>
                <li><a class="item" href="index.php?view=$user">Home</a></li>
                <li><a class="item" href="TaskManagement/AssignTask.php?action=Manage">Task Management</a></li>
                <li><a class="item" href="AccountManagement/manageAccount.php?action=Manage">Account Management</a></li>
                <li><a class="item" href="ComplaintsManagement/RegisterComplaint.php?action=Manage">Complaints Management</a></li>
                <li><a class="item" href="logout.php">Log out</a></li>
            </ul>
        </div>
    </div>
    <div data-role='content'>
_LOGGEDIN;
            break;
            
        case "Client":
echo <<<_LOGGEDIN
   <div id='wrapper'>
        <div id='menu'>
            <ul>
                <li><a class="item" href="index.php?view=$user">Home</a></li>
                <li><a class="item" href="AccountManagement/manageAccount.php?action=Manage">Account Management</a></li>
                <li><a class="item" href="ComplaintsManagement/registerComplaint.php?action=Manage">Log a Complaint</a></li>
                <li><a class="item" href="logout.php">Log out</a></li>
            </ul>
        </div>
    </div>
    <div data-role='content'>
_LOGGEDIN;
            break;
    }
}
else
{
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
    <p class='info'>(You must be logged in to use this app)</p>
_GUEST;
}