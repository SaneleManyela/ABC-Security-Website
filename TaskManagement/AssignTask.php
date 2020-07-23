<?php
require_once 'taskManagementMenu.php';

$result = queryMysql("BEGIN WORK");

$action = sanitizeString($_GET['action']);

switch ($action){
    case "Assign":
        if(isset($_POST['assignTask']))
        {
            if(!$result){
                echo '<div class="center">An error occured while assigning a task</div>';
            }
            else{
                if(isset($_POST['Description']) && isset($_POST['TaskFor']))
                {
                    $sqlDeactivateQuery = "INSERT INTO tblTasks(ID, Description, DateIssued, IssuedTo, IssuedBy)
                         VALUES('".NULL."','".sanitizeString($_POST['Description'])."','". getCurrentDate("").
                        "','". sanitizeString($_POST['TaskFor'])."','".$_SESSION['ID']."')";
                    $result = queryMysql($sqlDeactivateQuery);
                    if(!$result){
                        echo '<div class="center">An error occured while inserting your data.</div>';
                        $result = queryMysql("ROLLBACK");
                    }else if($result){
                        echo '<div class="center">The task has been assigned.</div>';
                        $result = queryMysql("COMMIT");
                    }
                }
            }
        }
        echo "<form method='post' action='AssignTask.php?action=$action'>
            <div data-role='container' class='center'>
            <fieldset>
                <legend>$action Task</legend>
                <div id='input' data-role='fieldcontain'>
                    <label for='Description'>Description:</label> 
                        <textarea name='Description' required='required'/></textarea>             
                </div>
                <div id='input' data-role='fieldcontain'>
                    <label for='Task For'>Task For:</label> <select name='TaskFor'>";
                    $value = array();
                    $rowId = array();
                    $valueIds = getIDs("SELECT ID FROM tblUsers WHERE Level = 'security'");
                    $len = count($valueIds);
                    for($i = 0; $i < $len; $i++){
                        $index = array_pop($valueIds);
                        $value[$i] = getRowData(queryMysql("SELECT Name FROM tblUsers WHERE ID = $index"));
                        $rowId[$i] = $index;     
                    }
                    for($i = 0; $i < count($value); $i++){
                        echo '<option value="'.$rowId[$i].'">'. $value[$i].'</option>';
                    }
                    echo "</select>
                </div>
                    <input class='tasks' type='submit' name='assignTask' value='Assign Task'/>
            </fieldset>
            </div>
        </form>";
    break;
case "Manage":
    echo "<div class='center'><b>Task Management app section</b>
            </div><br><br><br><br>";
    require_once(dirname(__DIR__)."/footer.php");
    break;
}

require_once(dirname(__DIR__)."/footer.php");