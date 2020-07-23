<?php
require_once 'taskManagementMenu.php';

$isTaskAvailable = FALSE;

if(isset($_POST['DeleteTask'])){
    $isTaskAvailable = array_key_exists('taskDescription', $_POST);
    
    if(!$isTaskAvailable){
       echo "<div>
                There is no task to Delete
            </div>
        </form>"; 
    }
    else if($isTaskAvailable){
        $result = queryMysql("DELETE FROM tblTasks WHERE ID ='".
                            sanitizeString($_POST['taskDescription'])."'");
        if($result){
            echo"<div>Task ".sanitizeString($_POST['taskDescription'])." is deleted.</div>";
        }else{
            echo"<div>Something went wrong while trying to delete.</div>";
        }
    }
}

$id = $_SESSION['ID'];

echo "<form method='post' action='DeleteTask.php'>
    <div data-role='container' class='center'>
        <fieldset>
            <legend>Delete Task</legend>
            <div id='input' data-role='fieldcontain'>
                <label for='Description'>Description:</label> <select name='taskDescription'>";
                $taskDescription = array();
                $taskRowIds = array();
                $taskIds = getIDs("SELECT ID FROM tblTasks WHERE IssuedBy = $id");
                $len = count($taskIds);
                for($i = 0; $i < $len; $i++){
                    $index = array_pop($taskIds);
                    $taskDescription[$i] = getRowData(queryMysql("SELECT Description FROM
                                                            tblTasks WHERE ID = $index "));
                    $taskRowIds[$i] = $index;     
                }
                for($i = 0; $i < count($taskDescription); $i++){
                    echo '<option value="'.$taskRowIds[$i].'">'. $taskDescription[$i].'</option>';
                }
                echo "</select>
            </div>
                <input class='tasks' type='submit' name='DeleteTask' value='Delete Task'/>
        </fieldset>
    </div>
</form>";
            
require_once(dirname(__DIR__)."/footer.php");