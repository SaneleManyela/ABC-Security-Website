<?php
require_once 'ComplaintsManagementMenu.php';

$action = sanitizeString($_GET['action']);

if($action == "Manage"){
    echo "<div class='center'><b>Complaints Management app section</b>
            <br><br><br><br>";
    require_once(dirname(__DIR__)."/footer.php");   
}

if(isset($_POST['Register']))
{
    $complaintInsert = "INSERT INTO tblComplaints(ID, Description, DateAndTime,
        AreaOfIncident, NumberOfPeopleInvolved, ReportedBy)
                VALUES('".NULL."','".sanitizeString($_POST['Description'])."','".
                    getCurrentDate("DateTime")."','".sanitizeString($_POST['AreaOfIncidence']).
                    "','". sanitizeString($_POST['PeopleInvolved'])."','".$_SESSION['ID']."')";
    $result = queryMysql($complaintInsert);
    if(!$result){
        echo '<div class="center" class="error">An error occured while inserting your data.</div>';
    }else if($result){
        echo '<div class="center">Complaint Logged.</div>';
    }
}

if(isset($_POST['Update']))
{
    $complaintUpdate = "UPDATE tblComplaints SET Description = '".
            sanitizeString($_POST['Description'])."', AreaOfIncident = '".
            sanitizeString($_POST['AreaOfIncidence'])."', NumberOfPeopleInvolved ='".
            sanitizeString($_POST['PeopleInvolved'])."' WHERE ID ='". getLastLoggedComplaintID()."'";
        
    $result = queryMysql($complaintUpdate);
    if(!$result){
        echo '<div class="center" class="error">An error occured while updating your data.</div>';
    }else if($result){
        echo '<div class="center">Complaint Updated.</div>';
    }
}

$description = $areaOfIncidence = null;

if($action=="Update"){
    $result = queryMysql("SELECT Description, AreaOfIncident FROM tblComplaints WHERE ID ='".
            getLastLoggedComplaintID()."'");
    if($result){
        $arrValues = $result->fetch_array(MYSQLI_ASSOC);
        $description = $arrValues['Description']; 
        $areaOfIncidence = $arrValues['AreaOfIncident'];
    }
}
if($action == "Register" || $action == "Update")
{
    echo "<form method='post' action='RegisterComplaint.php?action=$action'>
        <div data-role='container' class='center'>
        <fieldset>
            <legend>$action Complaint</legend>
            <div id='input' data-role='fieldcontain'>
                <label for='Description'>Description:</label>
                    <textarea name='Description' required='required'/>$description</textarea>                
            </div>
            <div id='input' data-role='fieldcontain'>
                <label for='Address'>Address:</label> 
                    <textarea name='AreaOfIncidence' required='required'/>$areaOfIncidence</textarea>
            </div>
            <div id='input' data-role='fieldcontain'>";
                echo"<label for='People Involved'>People Involved:</label>
                <select name='PeopleInvolved'>";
                for($i = 1; $i <= 20; $i++){
                   echo '<option value="'.$i.'">'. $i.'</option>'; 
                }
                echo "</select>
            </div>
            <input class='tasks' type='submit' name='$action' value='$action Complaint'/>
        </fieldset>
        </div>
    </form>";
}

function getLastLoggedComplaintID()
{
    $fetchID = queryMysql("SELECT ID FROM tblComplaints WHERE ReportedBy ='"
                          .$_SESSION['ID']."'");
    $ID = array();
    if($fetchID -> num_rows)
    {
        $rows = $fetchID -> num_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $rowID = $fetchID -> fetch_Array(MYSQLI_NUM);
            array_push($ID, array_pop($rowID));
        }
        return array_pop($ID);
    }
}
require_once(dirname(__DIR__)."/footer.php");