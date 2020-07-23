<?php
require_once 'accountManagementMenu.php';

//Identifies the user managing their account
$managingUser = getUserIdentifier($_SESSION['password']);

$errors = array(); //An array to store errors.

$id = sanitizeString($_SESSION['ID']);

//Using a $_GET array to retrieve information passed in the link
$action = sanitizeString($_GET['action']);

if($action == "Manage"){
    echo "<div class='center'><b>Account Management app section</b>
            <br><br><br><br></div></div>";
    require_once(dirname(__DIR__)."/footer.php");
}

if(isset($_POST['Update'])){
        
    if(isset($_POST['name'])){
        $errors[] = validateUsername(sanitizeString($_POST['name']));
    }    
    if(isset($_POST['password'])){
        switch ($managingUser){
            case "Security":
                $errors[] = validateSecurityPassword(sanitizeString($_POST['password']));
                break;
            case "Client":
                $errors[] = validateClientPassword(sanitizeString($_POST['password']));
                break;
            case "Administrator":
                $errors[] = validateAdminPassword(sanitizeString($_POST['password']));
                break;
        }
    }
    
    if($errors[0] != null || $errors[1] != null){
        echo "<span class='error' class='center'>".
            "<ul>";
            foreach ($errors as $key => $value){
                if($value != null){
                    echo "<li>". $value . "</li>";
                }
            }
            echo"</ul></span>
        </div><br><br>";
    }else{
        $result = queryMysql("UPDATE tblUsers SET Name ='".sanitizeString($_POST['name']).
            "', Password='". sha1(sanitizeString($_POST['password'])) ."' WHERE ID ='$id'");
        if($result){
            echo"<div>Account is updated.</div>";
        }else{
            echo"<div class='error'>Something went wrong while trying to update.</div>";
        }
    }
}

if(isset($_POST['Deactivate'])){
    $sqlDeactivateQuery = "INSERT INTO tblDeactivatedUser(DeactivatedID)
                VALUES('".$id."')";
    $result = queryMysql($sqlDeactivateQuery);
    if(!$result){
        echo '<div class="center">An error occured while deactivating your account.</div>';
    }else if($result){
        echo '<div class="center">Account has been deactivated, 
            <a href="/ABCSecurity/logout.php">refresh</a>.</div>';
    }
}

$result = queryMysql("SELECT Name, Password FROM tblUsers WHERE ID = $id");
if($result && $action != "Manage"){
    $arrValues = $result->fetch_array(MYSQLI_ASSOC);
    $name = $arrValues['Name']; 
    $password = $_SESSION['password'];

    echo <<<_ACC
    <form method="post" action="manageAccount.php?action=$action" 
                onsubmit = "return(validate(this))">
        <div data-role='container' class='center'>
        <fieldset>
            <legend>$action Account</legend>
            <div id="error"></div>
            <div id='input' data-role='fieldcontain'>
                <label for='Name'>Name(s)</label> 
                    <input type='text' maxlength='16' name='name' value="$name" required='required'>                
            </div>
            <div id='input' data-role='fieldcontain'>
                <label for='Password'>Password</label> 
                    <input type='text' maxlength='16' name='password' value="$password" required='required'/>
            </div>
                <input align='center' type='submit' name='$action' value='$action Account' />
        </fieldset>
        </div>
    </form>
</div>
_ACC;
}

require_once(dirname(__DIR__)."/footer.php");