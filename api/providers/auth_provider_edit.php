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
    
    $sett   = "updated_at=now()";
    // values to update
    if(array_key_exists('name',$_REQUEST)){
        if($_REQUEST['name']!==''){
            $sett .= ",name='".$_REQUEST['name']."'";
        }
    }
    if(array_key_exists('address',$_REQUEST)){
        if($_REQUEST['address']!==''){
            $sett .= ",address='".$_REQUEST['address']."'";
        }
    }
    if(array_key_exists('webpage_url',$_REQUEST)){
        if($_REQUEST['webpage_url']!==''){
            $sett .= ",webpage_url='".$_REQUEST['webpage_url']."'";
        }
    }
    if(array_key_exists('product_id',$_REQUEST)){
        if($_REQUEST['product_id']!==''){
            $sett .= ",product_id=('".$_REQUEST['product_id']."')";
        }
    }
    if(array_key_exists('salemodel_id',$_REQUEST)){
        if($_REQUEST['salemodel_id']!==''){
            $sett .= ",salemodel_id=('".$_REQUEST['salemodel_id']."')";
        }
    }
    if(array_key_exists('product_price',$_REQUEST)){
        $product_price = (float)str_replace(",",".",str_replace(".","",$_REQUEST['product_price'])) * 100;
        if($_REQUEST['product_price']!==''){
            $sett .= ",product_price=".$product_price;
        }
    }
    if(array_key_exists('currency',$_REQUEST)){
        if($_REQUEST['currency']!==''){
            $sett .= ",currency='".$_REQUEST['currency']."'";
        }
    }
    // Query creation
    $sql = "UPDATE providers SET $sett WHERE id=('".$_REQUEST['tid']."')";
    // INSERT data
    $rs = $DB->executeInstruction($sql);

    //echo $sql;

    // Response JSON 
    if($rs){
        header('Content-type: application/json');
        echo json_encode(['status' => 'OK']);
    }
}

//close connection
$DB->close();
?>