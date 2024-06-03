<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// check authentication / local Storage
if(array_key_exists('auth_api',$_REQUEST)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    $sett   = "updated_at=now()";
    // values to update
    if(array_key_exists('email',$_REQUEST)){
        if($_REQUEST['email']!==''){
            $sett .= ",email='".$_REQUEST['email']."'";
        }
    }
    if(array_key_exists('password',$_REQUEST)){
        if($_REQUEST['password']!==''){
            $sett .= ",authentication_string='".md5($_REQUEST['password'])."',password_last_changed=now()";
        }
    }
    if(array_key_exists('mobile_ddi',$_REQUEST)){
        if($_REQUEST['mobile_ddi']!==''){
            $sett .= ",mobile_international_code='".$_REQUEST['mobile_ddi']."'";
        }
    }
    if(array_key_exists('mobile',$_REQUEST)){
        if($_REQUEST['mobile']!==''){
            $sett .= ",mobile_number='".$_REQUEST['mobile']."'";
        }
    }

    // Query creation
    $sql = "UPDATE users SET $sett WHERE id=('".$_REQUEST['tid']."')";
    // INSERT data
    $rs = $DB->executeInstruction($sql);

    //echo $sql;

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode(['status' => 'OK']);
    }
}

//close connection
$DB->close();
?>