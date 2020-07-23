<?php
require_once 'mainMenu.php';

echo "<form method='post' action='login.php'>";
//first check if the user is already logged in.
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo "<span class='error'>You are already logged in, 
        you can <a href='logout.php'>logout</a> if you want.</span>";
}
else if(isset($_POST['login'])){
    switch (getUserIdentifier(sanitizeString($_POST['password']))){
        case "Administrator": case "Client": case "Security":
            $isDeactivated = checkIfAccount("SELECT DeactivatedID FROM tblDeactivatedUser WHERE "
                    . "DeactivatedID ='".getUserID("SELECT ID FROM tblUsers WHERE Name ='"
                            .sanitizeString($_POST['username'])."' AND Password ='"
                            .sha1(sanitizeString($_POST['password']))."'")."'");
            if($isDeactivated){
                echo "<span class='error'>This account has been deactivated.</span>";
            }else{
                $result = queryMysql("SELECT ID, Name FROM tblUsers
                    WHERE Name='".sanitizeString($_POST['username'])."' "
                        . "AND password='".sha1(sanitizeString($_POST['password']))."'");
                if($result -> num_rows == 0)
                {
                    echo "<span class='error'>Invalid login attempt. Please try again.</span>";
                }
                else
                {
                    $_SESSION['loggedin'] = TRUE;
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $_SESSION['ID'] = $row['ID'];
                    $_SESSION['username'] = sanitizeString($_POST['username']);
                    $_SESSION['password'] = sanitizeString($_POST['password']);
                    echo('<span id="loginInfo">Welcome, ' . $_SESSION['username'] .
                            '. <a href="index.php">Proceed to the ABC Security Website</a>.</span>');
                }                               
            }
            break;
        case "DefaultAdministrator":
            if(strtoupper(sanitizeString($_POST['username'])) == "JAMES"
                    && sanitizeString($_POST['password']) == "56001544"){
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['ID'] = 0;
                $_SESSION['username'] = sanitizeString($_POST['username']);
                $_SESSION['password'] = sanitizeString($_POST['password']);
                echo('<span id="loginInfo">Welcome, ' . $_SESSION['username'] .
                    '. <a href="index.php">Proceed to the ABC Security Website</a>.</span>');
            }
            break;
    }
}

//Login form
    echo <<<_LOGIN
        <div data-role='container' class='center'>
        <fieldset>
            <legend>Login</legend>
            <div id="error"></div>
            <div id='input' data-role='fieldcontain'>
                <label for='Username'>Username</label> 
                    <input type='text' maxlength='16' name='username' required='required'>                
            </div>
            <div id='input' data-role='fieldcontain'>
                <label for='Password'>Password</label> 
                    <input type='password' maxlength='16' name='password' required='required'/>
            </div>
                <input align='center' type='submit' name='login' value='Login' />
        </fieldset>
        </div>
    </form>
_LOGIN;

require_once 'footer.php';