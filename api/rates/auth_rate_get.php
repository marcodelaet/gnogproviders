<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

$sql = ""; // initializing SQL variable

$base   = $_REQUEST['base'];
$to     = $_REQUEST['to'];
$index  = $_REQUEST['index'];
$value  = '';
if(array_key_exists('value',$_REQUEST)){
    $value = $_REQUEST['value'];
}

$tableOrView    = "currencies";
$columnsSelect  = "id,rate,DATE_FORMAT(updated_at, '%Y%m%d%H%i%s')  AS updated_at, DATE_FORMAT(updated_at, '%d-%m-%Y %H:%i:%s')  AS updated_at_string, DATE_FORMAT(DATE_ADD(updated_at, INTERVAL 10 HOUR), '%Y%m%d%H%i%s') AS updated_next, DATE_FORMAT(DATE_ADD(updated_at, INTERVAL 10 HOUR), '%d-%m-%Y %H:%i:%s') AS updated_next_string";
$whereBase      = "AND id = '$base'";
$whereTo        = "AND id = '$to'";

// check authentication / local Storage
if(array_key_exists('auth_api',$_REQUEST)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    // query count rates
    $sqlBase    = "SELECT $columnsSelect FROM $tableOrView WHERE is_active='Y' $whereBase";
    $sqlTo      = "SELECT $columnsSelect FROM $tableOrView WHERE is_active='Y' $whereTo";

    // update_at date (yyyymmdd)
    $resultBase = $DB->getData($sqlBase);
    $resultTo   = $DB->getData($sqlTo);
    
    //echo "Atualizar <BR/> atualiza em: " . $resultSelect[0]['updated_next'] . '<BR /> agora: ' . $dateNow;
    if($resultBase && $resultTo){
        header('Content-type: application/json');
        if($value != ''){
            $newValueBase = (float)$value * (1 / (float)$resultBase[0]['rate']);
            $newValueFinal = $newValueBase * (float)$resultTo[0]['rate'];
            echo json_encode(['index'=>$index,'base' => $base,'rateBase' => $resultBase[0]['rate'],'to' => $to,'rateTo' => $resultTo[0]['rate'],'newValue' => "$newValueFinal",'updated_at' => $resultTo[0]['updated_at_string']]);
        }
        else
            echo json_encode(['index'=>$index,'base' => $base,'rateBase' => $resultBase[0]['rate'],'to' => $to,'rateTo' => $resultTo[0]['rate'],'updated_at' => $resultTo[0]['updated_at_string']]);
    }
} else {
    header('Content-type: application/json');
    echo json_encode(['status' => 'NOTAUTHENTICATED']);
}

//close connection
$DB->close();
?>