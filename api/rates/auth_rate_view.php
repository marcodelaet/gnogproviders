<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

$sql                = ""; // initializing SQL variable
$order              = "";
$whereQuerystring   = "";
if(array_key_exists('where',$_REQUEST)){
    if($_REQUEST['where'] != "")
        $whereQuerystring   = " AND " . $_REQUEST['where'];
}

if(array_key_exists('order',$_REQUEST)){
    if($_REQUEST['order'] != "")
        $order  = " ORDER BY " . $_REQUEST['order'];
}

if($_REQUEST['order'] == 'orderby'){
    $order  .= " DESC, id ASC";
}

$tableOrView    = "currencies";
$columnsSelect  = "id,rate,orderby";

// check authentication / local Storage
if(array_key_exists('auth_api',$_REQUEST)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    $sql    = "SELECT $columnsSelect FROM $tableOrView WHERE is_active='Y' $whereQuerystring $order";
    // echo $sql;
    // update_at date (yyyymmdd)
    $rs = $DB->getData($sql);
    
    //echo "Atualizar <BR/> atualiza em: " . $resultSelect[0]['updated_next'] . '<BR /> agora: ' . $dateNow;
    if($rs){
        header('Content-type: application/json');
        echo json_encode($rs);
    }
} else {
    header('Content-type: application/json');
    echo json_encode(['status' => 'NOTAUTHENTICATED']);
}

//close connection
$DB->close();
?>