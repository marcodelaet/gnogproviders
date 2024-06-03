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

    // filters
    $uuid                   = '';

    $filters                = '';
    if(array_key_exists('cpid',$_REQUEST)){
        if($_REQUEST['cpid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_REQUEST['cpid'];
            $filters        .= " uuid = '$uuid'";
        }
    }
   
    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }


    // Query creation
    $sql = "SELECT left(uuid,13)as uuid, uuid as uuid_full, username, email, mobile_international_code, mobile_number, account_locked FROM view_users $filters";
    // LIST data
    
    $rs = $DB->getData($sql);

    

  

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode($rs);
    }
}

//close connection
$DB->close();
?>