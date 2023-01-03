<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// rates URL - base USD
$urlRates = 'https://openexchangerates.org/api/latest.json?app_id=57406473634f419fbeb156c17ae42c8a&base=USD';

$sql = ""; // initializing SQL variable

$columnsSelect  = "id,rate,DATE_FORMAT(updated_at, '%Y%m%d%H%i%s')  AS updated_at, DATE_FORMAT(DATE_ADD(updated_at, INTERVAL 10 HOUR), '%Y%m%d%H%i%s') AS updated_next, DATE_FORMAT(updated_at, '%d-%m-%Y %H:%i:%s') AS updated_at_string, DATE_FORMAT(DATE_ADD(updated_at, INTERVAL 10 HOUR), '%d-%m-%Y %H:%i:%s') AS updated_next_string";
$columnsInsert  = "id,rate,is_active,created_at,updated_at";
$tableOrView    = "currencies";

// check authentication / local Storage
if(array_key_exists('auth_api',$_REQUEST)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    // query count rates
    $sql_select = "SELECT $columnsSelect FROM $tableOrView WHERE is_active='Y'";
    // if count > 0:
    if($DB->numRows($sql_select) > 0){
        // setting date(now()) - format(yyyymmdd)
        $dateNow = date('YmdHis');
        $dateNow_String = date('d-m-Y H:i:s');

        // update_at date (yyyymmdd)
        $resultSelect = $DB->getData($sql_select);
        
        // checking if update_at < now() - if yes, we must update rates
        if($resultSelect[0]['updated_next'] <= $dateNow)
        {
            //echo "Atualizar <BR/> atualiza em: " . $resultSelect[0]['updated_next'] . '<BR /> agora: ' . $dateNow;
            // reading file / url location (json result)
            $resultJSON = file_get_contents($urlRates);
            $resultJSON=str_replace('},]',"}]",$resultJSON);
            $data = json_decode($resultJSON,true);

            // sql UPDATE string variable
            foreach($data['rates'] as $key => $value){
                // values to update
                $sql = "UPDATE $tableOrView SET rate = $value, updated_at=now() WHERE id = '$key'";
               // echo $sql;
                $rs = $DB->executeInstruction($sql);
            }
            if($rs){
                header('Content-type: application/json');
                echo json_encode(['status' => 'OK']);
                $sql = "";
            }
        } else {
            header('Content-type: application/json');
            echo json_encode(['status' => 'ALREADY_UPDATED','updated_at'=>$resultSelect[0]['updated_at_string'],'next_update' => $resultSelect[0]['updated_next_string']]);
        }
    } else { // new datas
        // reading file / url location (json result)
        $resultJSON = file_get_contents($urlRates);
        $resultJSON=str_replace('},]',"}]",$resultJSON);
        $data = json_decode($resultJSON,true);

        // sql INSERT string variable
        $sql = "INSERT INTO $tableOrView ($columnsInsert) values ";
        $current = 0;
        foreach($data['rates'] as $key => $value){
            // creating values to insert
            if($current > 0)
                $sql .= ",";
            $sql .= "('$key',$value,'Y',now(),now())";
            $current++;
        }
        //echo $sql;
         
    }
    // running the SQL instance
    if($sql != ''){
        $rs = $DB->executeInstruction($sql);
        // Response JSON 
        if($rs){
            $updateDate = $resultSelect[0]['updated_at_string'];
            if(!isset($updateDate) || ($updateDate===null))
                $updateDate = $dateNow_String;
            header('Content-type: application/json');
            echo json_encode(['status' => 'OK','updated_at'=>$updateDate]);
        }
    }
} else {
    header('Content-type: application/json');
    echo json_encode(['status' => 'NOTAUTHENTICATED']);
}

//close connection
$DB->close();
?>