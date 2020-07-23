<?php
require_once 'ComplaintsManagementMenu.php';

//A call to a functions that displays a table populated with a day's complaints
mViewComplaints("SELECT Description, DateAndTime, AreaOfIncident, 
                NumberOfPeopleInvolved FROM tblComplaints
                WHERE datediff(NOW(), DateAndTime) <= 1");

require_once(dirname(__DIR__)."/footer.php");