<?php
require_once 'reportsMenu.php';

switch (sanitizeString($_GET['report']))
{
    case "reports":
        echo "<div class='center'><b>Reports app section</b><br><br><br><br>";
        break;
    case "staffReport":
        mViewComplaints("SELECT ID, Name, DateOfBirth, Gender, Level 
                    FROM tblUsers WHERE level = 'security' OR level = 'Administrator'");
        break;
    case "complaintsReport":
        mViewComplaints(mViewComplaintsReportQuery());
        break;
}

function mViewComplaintsReportQuery()
{
    return "SELECT ".getRowData(queryMysql("SELECT COUNT(*) FROM tblComplaints ".
             "WHERE datediff(DateAndTime, Now()) <= '7'"))." AS Complaints_This_Week, ".
                getRowData(queryMysql("SELECT COUNT(*) FROM tblComplaints ".
                    "WHERE AreaOfIncident LIKE '%Sandton%'"))." AS Sandton, ".
                getRowData(queryMysql("SELECT COUNT(*) FROM tblComplaints ".
                     "WHERE AreaOfIncident LIKE '%Hillcrest%'"))." As Hillcrest, ".
                getRowData(queryMysql("SELECT COUNT(*) FROM tblComplaints ".
                     "WHERE AreaOfIncident LIKE '%Vancqouver%'"))." AS Vancqouver";
}
require_once(dirname(__DIR__)."/footer.php");