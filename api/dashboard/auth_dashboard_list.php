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

    // User Group
    $group          = $_COOKIE['lacc'];


    $currency_selected = 'MXN';
    if(array_key_exists('currency',$_REQUEST)){
        $currency_selected = $_REQUEST['currency'];
    }


    // setting query
    $columns        = "UUID,product_id,product_name,salemodel_id,salemodel_name,provider_id,provider_name,user_id,username,client_id,client_name,agency_id,agency_name,status_id,status_name,status_percent,offer_name,description,start_date,stop_date,month_diff_data,sum(amount_$currency_selected) as amount,sum(amount_".$currency_selected."_int) as amount_int, sum(amount_per_month_$currency_selected) as amount_per_month, sum(amount_per_month_".$currency_selected."_int) as amount_per_month_int, '$currency_selected' as currency,quantity,is_active";
    $tableOrView    = "view_proposals";
    $orderBy        = " group by UUID";


    //echo $group;
    // filters
    $filters                = " is_active = 'Y'";
    if($group < '99999'){
        if($filters != '')
            $filters .= " AND ";
        $filters .= "user_id = '".$_COOKIE['uuid']."' ";
    }else{
        if(array_key_exists('uid',$_REQUEST)){
            if($_REQUEST['uid']!==''){
                if($filters != '')
                    $filters .= " AND ";
                $uid         = $_REQUEST['uid'];
                $filters        .= " user_id = '$uid'";
            }
        }
    }

    if(array_key_exists('status',$_REQUEST)){
        if($_REQUEST['status']!==''){
            if($filters != '')
                $filters .= " AND ";
            $statuses       = $_REQUEST['status'];
            $arrayStatus    = explode(",",$statuses);
            $filters        .= "(";
            for($i_status=0; $i_status < count($arrayStatus); $i_status++){
                if($i_status > 0)
                    $filters    .= " OR ";
                $filters        .= " status_id = ".$arrayStatus[$i_status];
            }
            $filters        .= ")";
        }
    }

    if(array_key_exists('date',$_REQUEST)){
        if($_REQUEST['date']!==''){
            if($filters != '')
                $filters .= " AND ";
            $fullDate         = $_REQUEST['date'];
            $filters        .= " ( (concat(year(stop_date),right(concat('00',month(stop_date)),2)) >= '$fullDate') AND (concat(year(start_date),right(concat('00',month(start_date)),2)) <= '$fullDate') )";
        }
    }
    
    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $orderBy";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sql);
    $numberOfRows = $DB->numRows($sql); 

    // Response JSON 
    if($rs){
        if($numberOfRows > 0)
            echo json_encode($rs);
        else
            echo "[{'response':'0 results'}]";
    }
    else{
        echo '[{"response":"Error"}]';
    }
}

//close connection
$DB->close();
?>