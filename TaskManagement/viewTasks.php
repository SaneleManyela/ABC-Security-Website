<?php
require_once 'taskManagementMenu.php';

switch(sanitizeString($_GET['user'])){
    case "Administrator":
        mViewComplaints("SELECT Description, DateIssued, IssuedTo, IssuedBy
                FROM tblTasks WHERE datediff(DATE(NOW()), DateIssued) <= 7");
        break;
    case "Security":
        mViewComplaints("SELECT Description, DateIssued FROM tblTasks WHERE IssuedTo='".$_SESSION['ID'].
                "' AND datediff(DATE(NOW()), DateIssued) <= 1");
        break;
}

require_once(dirname(__DIR__)."/footer.php");