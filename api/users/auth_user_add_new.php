<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// check authentication / local Storage
if(array_key_exists('auth_api',$_POST)){
    // check auth_api === local storage
    //if($localStorage == $_POST['auth_api']){}

    // values to insert
    $columns = 'id,username,email,user_language,mobile_international_code,mobile_number,user_type,level_account,authentication_string,account_locked,created_at,updated_at';
    
    $email                  = $_POST['email'];
    $username               = $_POST['username'];
    if(trim($username) == ''){
        $username = $email;
    } 
    $phone_ddi             = "'000'";
    if(array_key_exists('phone_international_code',$_POST)){
        if($_POST['phone_international_code']!=='')
            $phone_ddi         = "'".$_POST['phone_international_code']."'";
    }
    $phone                 = "'000'";
    if(array_key_exists('phone_number',$_POST)){
        if($_POST['phone_number']!=='')
            $phone         = "'".$_POST['phone_number']."'";
    }
    $authentication_string  = md5($_POST['password']);

    // Query creation
    $sql = "INSERT INTO users ($columns) VALUES ((UUID()),'$username','$email','esp',$phone_ddi,$phone,'provider','15','$authentication_string','N',now(),now())";
    // INSERT data
    $rs = $DB->executeInstruction($sql);

  

    // Response JSON 
    if($rs){        
        $response = json_encode(['status' => 'OK']);
    } else {
        $response = json_encode(['status' => 'ERROR','sql'=>$sql]);
    }
    header('Content-type: application/json');
    echo $response;
}

//close connection
$DB->close();
?>