<?php
$host_name = 'localhost'; //database host name
$database_name = 'ABCSecurity'; //Name of the database used
$username = 'root'; //name of the database user
$password = 'password'; //password of the database

/*A database connection to connect the user so that
 * they can access database stored records.
 */
$connection = new mysqli($host_name, $username, $password, $database_name);

//This statement checks if there was no error while connecting to the database
if($connection ->connect_error) 
{
    mysql_fatal_error(); //A function that outputs user friendly error message
}

/*A function that executes all SQL queries - depending on
 * the correctness of the passed argument - and then
 * returns a result
 */
function queryMysql($query)
{
    global $connection;
    $result = $connection->query($query);
    if (!$result) {
        echo mysqli_error($connection);
    }
    return $result;
}

//A multipurpose function to check user account:
//if its deactivated or if it exists
function checkIfAccount($query)
{
    $checkID = queryMysql($query);
    if($checkID -> num_rows == 0)
    {
        return FALSE;
    }else{
        return TRUE;
    }
}

//A function that returns from the database a user ID
function getUserID($query)
{
    $fetchID = queryMysql($query);
    if($fetchID -> num_rows){
        $id = $fetchID -> fetch_Array(MYSQLI_ASSOC);
        return $id['ID'];
    }
}

//A function that returns an array of IDs from the database
function getIDs($query)
{
    $fetchID = queryMysql($query);
    $ID = array();
    if($fetchID -> num_rows)
    {
        $rows = $fetchID -> num_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $rowID = $fetchID -> fetch_Array(MYSQLI_NUM);
            array_push($ID, array_pop($rowID));
        }
        return array_reverse($ID);
    }
}

//A functon that returns data of a record
function getRowData($result)
{
    global $connection;
    if($result -> num_rows == 0){
        echo mysqli_error($connection);
    }else{
        $arr = mysqli_fetch_array($result, MYSQLI_NUM);
        foreach ($arr as $key => $value){
            return $value;
        }
    }
}

//A function that returns date in the
//desired format.
function getCurrentDate($format)
{
    switch ($format){
        case "DateTime":
            return getRowData(queryMysql("SELECT NOW()"));
        default :
            return getRowData(queryMysql("SELECT DATE(NOW())"));
    }    
}

//A functions that displays a table populated with data from database
function mViewComplaints($query)
{
    $result = queryMysql($query);
    if(!$result){
        echo'<div class="error">Something went wrong</div>';
    } else {
        mTableHeadings($result);
        mTableRows($result);
        mysqli_free_result($result);
        echo '</table>';
    }
}

function mTableHeadings($result)
{
    $i = 0;
    echo '<div><table><tr class="head">';
    while($i < mysqli_num_fields($result)){
        $meta = mysqli_fetch_field_direct($result, $i);
        echo '<th>'.$meta -> name.'</th>';
        $i++;
    }
    echo '</tr>';
}

function mTableRows($result)
{
    $index = 0;
    while($row = mysqli_fetch_row($result)){
        echo '<tr>';
        $count = count($row);
        for($i = 0; $i < $count; $i++){
            $currentRow = current($row);
            echo '<td>'.$currentRow.'</td>';
            next($row);
        }
        echo '</tr>';
        $index++;
    }
}

//A function that destroy user session with a cookie that expires after one day
function destroySession()
{
    $_SESSION = array();
    if(session_id() != "" || isset($_COOKIE[session_name()]))
    {
        setcookie(session_name(), '', time()-86400, '/');
    }
    session_destroy();
}

//A funtion that sanitises user input in order to prevent malicious code
function sanitizeString($var)
{
    global $connection;
    $var = htmlentities(strip_tags($var));
    if(get_magic_quotes_gpc())
    {
        $var = stripcslashes($var);
    }
    return $connection->real_escape_string($var);
}

//A function that identifies a user based on user password 
function getUserIdentifier($field)
{
    if(preg_match("/^admin/", $field)){
        return "Administrator";
    }
    else if(preg_match("/56001544/", $field)){
        return "DefaultAdministrator";
    }
    else if(preg_match("/^sec/", $field)){
        return "Security";
    }
    else{
        return "Client";
    }
}

//A function that validates username
function validateUsername($field)
{
    if(strlen($field) > 65){
        return "Usernames must be a maximum of 65 characters.";
    }
}

//A function that validates and ensures correct admin password
//is used
function validateAdminPassword($pass)
{
    if(strlen($pass) > 15){
        return "Password must not be greater than 15 characters.";
    }else if(!preg_match("/^admin/", $pass)){
        return "Admin passwords must be prefixed with 'admin'";
    }
}

//A function that validates and ensures correct security password
//is used
function validateSecurityPassword($pass)
{
    if(strlen($pass) > 15){
        return "Password must not be greater than 15 characters.";
    }else if(!preg_match("/^sec/", $pass)){
        return "A security the password must be prefixed with 'sec'\n";
    }
}

//A function that validates and ensures correct client password
//is used
function validateClientPassword($pass)
{
    if(strlen($pass) > 15){ 
        return "Password must not be greater than 15 characters.";
    }
}

//A function that outputs user friendly error message
function mysql_fatal_error()
{
    echo <<<_END
    <div> We are sorry, but it was not possible to complete
    the requested task. The error message we got was:
        <p class='error'>Fatal Error</p/>
    Please click the back navigating button on your browser
    and try again. If you are still having problems,
    please <a href="mailto:admission@server.com">email
            our adminstrator</a>. Thank you.</br>
        </div>
_END;
}