<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// check authentication / local Storage
if(array_key_exists('auth_api',$_GET)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    // setting query
    $columns = "id as uuid_full, concat(name,' (',percent,'%)') as name, name as simple_name, percent, description, is_active";
    $tableOrView    = "statuses";
    $orderBy        = "order by name";

    if(array_key_exists('order',$_GET)){
        if($_GET['order']!='')
            $orderBy = "order by ".$_GET['order'];
    }
    
    // filters
    $filters                = '';
    if(array_key_exists('search',$_GET)){
        if($_GET['search']!==''){
            $jocker         = $_GET['search'];
            $filters        .= "AND search like '%$jocker%'";
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