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
    $columns        = "invoice_id, provider_id, provider_name, invoice_number, invoice_amount_int, invoice_amount, invoice_amount_paid_int, invoice_amount_paid, invoice_amount_currency, DATE_FORMAT(invoice_last_payment_date, '%Y/%m/%d') as invoice_last_payment_date, invoice_month, invoice_year, order_number, invoice_status, DATE_FORMAT(invoice_updated_at, '%Y/%m/%d') as invoice_updated_at, file_location, file_name, file_type, user_email, offer_name, product_name, salemodel_name";
    $tableOrView    = "view_invoices_files";
    $orderBy        = "order by invoice_id";

    // filters
    $uuid                   = '';

    $filters                = '';
    if(array_key_exists('iid',$_REQUEST)){
        if($_REQUEST['iid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $uuid         = $_REQUEST['iid'];
            $filters        .= " invoice_id = '$uuid'";
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