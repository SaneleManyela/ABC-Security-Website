<?php
require_once 'registerAccountMenu.php';

$registerUser = sanitizeString($_GET['user']);
$prefix = "";

if(isset($_POST['submit']))
{
    $errors = array();
    if(isset($_POST['name'])){
        $errors[] = validateUsername(sanitizeString($_POST['name']));
    }
    if(isset($_POST['password'])){
        switch ($registerUser){
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
        echo "<div class='error' class='center'>".
                "<ul>";
                foreach ($errors as $key => $value){
                    if($value != null){
                        echo "<li>". $value . "</li>";
                    }
                }
        echo"</ul></div><br><br>";
    }
    else{
            if(checkIfAccount("SELECT * FROM tblUsers WHERE Name ='".sanitizeString($_POST['name'])."'"
                . " AND DateOfBirth='".sanitizeString($_POST['dateOfBirth'])."'"))
            {
                echo '<span>Account already registered.</span>';
            }else{
                $query = "INSERT INTO tblUsers(Name, DateOfBirth, Gender, Password, Level)
                        VALUES('".sanitizeString($_POST['name'])."','".sanitizeString($_POST['dateOfBirth'])."','"
                            .sanitizeString($_POST['gender'])."','". sha1(sanitizeString($_POST['password'])).
                            "','".$registerUser."')"; 
                $result = queryMysql($query);
                if(!$result){
                    echo '<div>Something went wrong while registering. Please try again later.</div>';
                require_once 'footer.php';
            }else if($result){
                echo '<div>Successfully registered.</div>';
            }
        }
    }
}
    
if($registerUser == "Register"){
        echo "<div class='center'><b>Accounts Registrations app section</b>
            <br><br><br><br>";
        require_once(dirname(__DIR__)."/footer.php");
}else{
    switch($registerUser){
        case "Administrator":
            $prefix = "admin";
            break;
        case "Security":
            $prefix = "sec";
            break;
        default :
            $prefix="";
            break;
    }
    echo <<<_REGISTER
    <form method="post" action="registerUsersForm.php?user=$registerUser" 
        onsubmit = "return(validate(this))">
            <div data-role='container' class='center'>
            <fieldset>
                <legend>$registerUser Registration</legend>
                <div id='input' data-role='fieldcontain'>
                    <label for='Name'>Name(s)</label> 
                    <input type='text' maxlength='16' name='name' required='required'>                
                </div>
                <div id='input' data-role='fieldcontain'>
                    <label for='DateOfBirth'>D.O.B</label>
                    <input type='date' maxlength='16' name='dateOfBirth' required='required'/>
                </div>
                <div id='input' data-role='fieldcontain'>
                    <label for='gender'>Gender</label> <select name='gender'/> 
                        <option value='Male'>Male</option>
                        <option value='Female'>Female</option>
                    </select>
                </div>
                <div id='input' data-role='fieldcontain'>
                    <label for='Password'>Password</label> 
                    <input type='text' maxlength='16' name='password' value="$prefix" required='required'/>
                </div>
                    <input align='center' type='submit' formaction='registerUsers.php?user=$registerUser' 
                        name='submit' value='Register $registerUser' />
            </fieldset>
            </div>
        </form>
_REGISTER;
}

require_once(dirname(__DIR__)."/footer.php");