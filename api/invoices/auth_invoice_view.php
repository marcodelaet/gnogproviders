<?php

error_reporting(E_ALL);
ini_set('display_errors', 1); 


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

    $offSet         = 0;
    $numberOfRegistries = 500;
    $columns        = "invoice_id, provider_id, provider_name, invoice_number, invoice_amount_int, invoice_amount, invoice_amount_paid_int, invoice_amount_paid, invoice_amount_currency, DATE_FORMAT(invoice_last_payment_date, '%Y/%m/%d') as invoice_last_payment_date, invoice_month, invoice_year, order_number, invoice_status, DATE_FORMAT(invoice_updated_at, '%Y/%m/%d') as invoice_updated_at, file_location, file_name, file_type, user_email, offer_name, product_name, salemodel_name";
    $tableOrView    = "view_invoices_files";
    $orderBy        = "order by invoice_id";
    
    $groupBy        = "";

    // page
    if(array_key_exists('p',$_REQUEST)){
        if($_REQUEST['p']!==''){
            $offSet        = intval($_REQUEST['p']) * $numberOfRegistries;
        }
    }
    $limit          = "limit $offSet, $numberOfRegistries";

    // order by
    if(array_key_exists('orderby',$_REQUEST)){
        if($_REQUEST['orderby']!==''){
            $ordered        = $_REQUEST['orderby'];
            $orderBy        = " ORDER BY $ordered";
        }
    }

    // group by
    if(array_key_exists('groupby',$_REQUEST)){
        if($_REQUEST['groupby']!==''){
            $grouped        = $_REQUEST['groupby'];
            $groupBy        = " GROUP BY $grouped";
        }
    }

    // filters
    $filters                = '';
    if(array_key_exists('search',$_REQUEST)){
        if($_REQUEST['search']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = $_REQUEST['search'];
            $filters        .= " search like '%$jocker%'";
        }
    }
    
    if(array_key_exists('uid',$_REQUEST)){
        if($_REQUEST['uid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = $_REQUEST['uid'];
            $filters        .= " user_id = '$jocker'";
        }
    }

    if(array_key_exists('where',$_GET)){
        if($_GET['where']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = explode("-",$_GET['where']);
            $filters        .= " $jocker[0]='$jocker[1]'";
        }
    }
    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $groupBy $orderBy";
    $sqlPaged = "SELECT $columns FROM $tableOrView $filters $groupBy $orderBy $limit";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sqlPaged);
    $rsNumRows = $DB->numRows($sql);

    // Response JSON
    header('Content-type: application/json'); 
    if($rs){
        echo json_encode(["result" => "OK","data" => $rs, "rows" => "$rsNumRows"]);
    }
    else {
        echo json_encode(["result" => "ERROR"]);
    }
}

//close connection
$DB->close();
?>