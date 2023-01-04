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

    // values to insert
    $agency                 = 'Y';
    if(array_key_exists('agency',$_REQUEST)){
        if($_REQUEST['agency']!=='')
            $agency         = $_REQUEST['agency'];
    }
    $corporate_name         = $_REQUEST['corporate_name'];
    $address                = $_REQUEST['address'];

    $module     = "advertisers";
    $columns    = "id,is_agency,corporate_name,address,is_active,created_at,updated_at";
    $values     = "(UUID()),'$agency','$corporate_name','$address','Y',now(),now()";

    // Query creation
    $sql = "INSERT INTO $module ($columns) VALUES ($values)";
    // INSERT data
    $rs = $DB->executeInstruction($sql);

  

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode(['status' => 'OK']);
    }
}

//close connection
$DB->close();
?>