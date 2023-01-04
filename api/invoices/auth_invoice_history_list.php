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
    $columns        = "user_id, module_name, module_id, DATE_FORMAT(created_at, '%Y/%m/%d %h:%i:%s') as history_date, description_en, description_es, description_ptbr";
    $tableOrView    = "loghistory";
    $orderBy        = "order by created_at desc";

    // filters
    $uuid                   = '';

    $filters                = "module_name = 'invoices'";
    if(array_key_exists('iid',$_REQUEST)){
        if($_REQUEST['iid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_REQUEST['iid'];
            $filters        .= " module_id = '$uuid'";
        }
    }
   
    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }



    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $orderBy";
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