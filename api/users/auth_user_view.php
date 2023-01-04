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
    $username               = ''; 
    $email                  = '';
    $mobile                 = '00000000000';

    $filters                = '';
    if(array_key_exists('search',$_REQUEST)){
        if($_REQUEST['search']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = $_REQUEST['search'];
            $filters        .= " search like '%$jocker%'";
        }
    }
    if(array_key_exists('mobile',$_REQUEST)){
        if($_REQUEST['mobile']!==''){
            if($filters != '')
                $filters .= " AND ";
            $mobile         = $_REQUEST['mobile'];
            $filters        .= " mobile like '%$mobile%'";
        }
    }
    if(array_key_exists('email',$_REQUEST)){
        if($_REQUEST['email']!==''){
            if($filters != '')
                $filters .= " AND ";
            $email         = $_REQUEST['email'];
            $filters        .= " email like '%$email%'";
        }
    }
    if(array_key_exists('username',$_REQUEST)){
        if($_REQUEST['username']!==''){
            if($filters != '')
                $filters .= " AND ";
            $username         = $_REQUEST['username'];
            $filters        .= " username like '%$username%'";
        }
    }
    if(array_key_exists('uid',$_REQUEST)){
        if($_REQUEST['uid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_REQUEST['uid'];
            $filters        .= " uuid = '$uuid'";
        }
    }
    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }


    // Query creation
    $sql = "SELECT left(uuid,13)as uuid, uuid as uuid_full, level_account, username, email, mobile_number,mobile_international_code, concat('+',mobile_international_code,mobile_number) as mobile, account_locked FROM view_users $filters order by username";
    // LIST data
    //echo $sql;
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