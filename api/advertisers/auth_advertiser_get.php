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

    // setting query
    $addColumn  = "";
    if(array_key_exists("addcolumn",$_REQUEST)){
        if($_REQUEST['addcolumn']!==''){
            $addColumn      = $_REQUEST["addcolumn"].",";
        }
    }

    $columns = "  left(uuid,13)as uuid, uuid as uuid_full, $addColumn corporate_name, address, concat(contact_name,' ',contact_surname,' (', contact_email,')') as contact, contact_name, contact_surname, contact_email, contact_position, phone_international_code, phone_prefix, phone_number, is_agency, is_active, concat('+',phone_international_code,phone_number) as phone";
    $tableOrView    = "view_advertisers";
    

    // filters
    $uuid                   = '';

    $filters                = '';
    if(array_key_exists('aid',$_REQUEST)){
        if($_REQUEST['aid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_REQUEST['aid'];
            $filters        .= " uuid = '$uuid'";
        }
    }
   
    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }


    // Query creation
    $sql = "SELECT $columns FROM view_advertisers $filters";
    // LIST data
   // echo $sql;
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