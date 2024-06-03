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
    $columns = "(id) as uuid_full, name, description, is_active";
    $tableOrView    = "salemodels";
    $orderBy        = "order by name";

    // filters
    $filters                = '';
    if(array_key_exists('search',$_REQUEST)){
        if($_REQUEST['search']!==''){
            $jocker         = $_REQUEST['search'];
            $filters        .= "AND search like '%$jocker%'";
        }
    }
    
    if(array_key_exists('where',$_REQUEST)){
        if($_REQUEST['where']!==''){
            $jocker         = $_REQUEST['where'];
            $filters        .= "AND $jocker";
        }
    }
    
    $filters = "WHERE is_active='Y' ".$filters;
    


    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $orderBy";
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