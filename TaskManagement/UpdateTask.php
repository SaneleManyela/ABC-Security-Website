<?php
require_once 'taskManagementMenu.php';

$id = $_SESSION['ID'];
$isTaskAvailable = FALSE;

if(isset($_POST['SaveUpdate'])){   
    $result = queryMysql("UPDATE tblTasks SET Description ='".
            sanitizeString($_POST['Description'])."', IssuedTo='".
            sanitizeString($_POST['ReIssueTask']) ."' WHERE ID ='".
            sanitizeString($_GET['taskId'])."'");
    if($result){
        echo"<div>Task '".sanitizeString($_POST['Description'])."' is updated.</div>";
    }else{
        echo"<div>Something went wrong while trying to update.</div>";
    }
}

if(!isset($_POST['UpdateTask'])){
    echo "<form method='post' action='UpdateTask.php'>
        <div data-role='container' class='center'>
            <fieldset>
                <legend>Update Task</legend>
                <div id='input' data-role='fieldcontain'>
                    <label for='Description'>Description:</label> 
                    <select name='taskDescription'>";
                    $taskDescription = array();
                    $taskRowIds = array();
                    $taskIds = getIDs("SELECT ID FROM tblTasks WHERE IssuedBy = $id");
                    $len = count($taskIds);
                    for($i = 0; $i < $len; $i++){
                        $index = array_pop($taskIds);
                        $taskDescription[$i] = getRowData(queryMysql("SELECT Description
                                                     FROM tblTasks WHERE ID = $index "));
                        $taskRowIds[$i] = $index;     
                    }
                    for($i = 0; $i < count($taskDescription); $i++){
                        echo '<option value="'.$taskRowIds[$i].'">'. $taskDescription[$i].'</option>';
                    }
                    echo "</select>
                </div>
                    <input class='tasks' type='submit' name='UpdateTask' value='Update Task'/>
            </fieldset>
        </div>
    </form>";
}

if(isset($_POST['UpdateTask'])){ 
    
    $isTaskAvailable = array_key_exists('taskDescription', $_POST);
    
    if(!$isTaskAvailable){
       echo "<form method='post' action='UpdateTask.php'>
                <div>
                    There is no task to Update
                </div>
            </form>"; 
    }else if($isTaskAvailable){
        $taskID = sanitizeString($_POST['taskDescription']);
        $description = getRowData(queryMysql("SELECT Description 
                                FROM tblTasks WHERE ID = $taskID"));
        echo "<form method='post' action='UpdateTask.php?taskId=$taskID'>
        <div data-role='container' class='center'>
        <fieldset>
            <legend>Update Task</legend>
            <div id='input' data-role='fieldcontain'>
                <label for='Description'>Description:</label> 
                <textarea name='Description' required='required'/>$description</textarea>             
            </div>
            <div id='input' data-role='fieldcontain'>
                <label for='Task For'>Task For:</label> <select name='TaskFor'>";
                    $issuedTo = queryMysql("SELECT IssuedTo FROM tblTasks WHERE ID = $taskID");
                    $rowId = getRowData($issuedTo);
                    $value = getRowData(queryMysql("SELECT Name from tblUsers WHERE ID = '$rowId'"));
                    echo "<option value='.$rowId.'>". $value."</option>
                </select>
            </div>
            <div id='input' data-role='fieldcontain'>
                <label for='Reissue To'>Re-issue To:</label>     <select name='ReIssueTask'>";
                $securityIds = getIDs("SELECT ID FROM tblUsers WHERE Level = 'security'");
                $length = count($securityIds);
                for($i = 0; $i < $length; $i++){
                    $index = array_pop($securityIds);
                    $taskDescription[$i] = getRowData(queryMysql("SELECT Name 
                                            FROM tblUsers WHERE ID = $index "));
                    $taskRowIds[$i] = $index;     
                }
                for($i = 0; $i < count($taskDescription); $i++){
                    echo '<option value="'.$taskRowIds[$i].'">'. $taskDescription[$i].'</option>';
                }       
                echo "</select>
            </div>
                <br><br><input class='tasks' type='submit' name='SaveUpdate' value='Save Update'/>
        </fieldset>
    </div>
</form>";
    }
}

require_once(dirname(__DIR__)."/footer.php");