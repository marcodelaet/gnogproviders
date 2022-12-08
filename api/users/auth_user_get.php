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

    // View or Table
    $viewOrTable = 'view_full_profiles_data';

    // Columns
    $columns = 'left(user_id,13) as user_id, user_id as user_id_full, username, contact_email, user_email, user_international_code, user_mobile_number, contact_international_code, contact_phone_number, user_locked_status, contact_module_name, user_type, user_language, user_level_account, provider_name, advertiser_name, contact_position, contact_name, contact_surname, provider_id, advertiser_id';

    // filters
    $uuid                   = '';

    // Searching only contact users
    $filters                = '';
    if(array_key_exists('cpid',$_REQUEST)){
        if($_REQUEST['cpid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_REQUEST['cpid'];
            $filters        .= " contact_id = '$uuid' AND contact_module_name = 'provider'";
        }
    }

    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }


    // Query creation
    $sql = "SELECT $columns FROM $viewOrTable $filters";
    // LIST data
    
    $rs = $DB->getData($sql);

    // Response JSON 
    if($rs){
        $response = json_encode(["response" => "OK","data" => $rs]);
    } else {
        $response = json_encode(["response" => "ERROR"]);
    }
    header('Content-type: application/json');
    echo $response;
}

//close connection
$DB->close();
?>