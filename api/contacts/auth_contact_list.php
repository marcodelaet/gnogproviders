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
    $group          = 'user';

    // setting query
    $columns        = "contact_id,contact_name,contact_surname,contact_email,contact_position,contact_client_id,phone_international_code,phone_prefix,phone_number";
    $tableOrView    = "view_advertisercontacts";
    $orderBy        = "";
    $groupBy        = "";

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
            $groupBy        = " ORDER BY $grouped";
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
    
    if(array_key_exists('aid',$_REQUEST)){
        if($_REQUEST['aid']!==''){
            if($filters != '')
                $filters .= " AND ";
            $advertiser_id         = $_REQUEST['aid'];
            $filters        .= " contact_client_id = '$advertiser_id'";
        }
    }

    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $orderBy $groupBy";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sql);
    $rowNumbers = $DB->numRows($sql);

    // Response JSON 
    header('Content-type: application/json');
    if($rs){
        if($rowNumbers > 0)
            $return = $rs;
        else{
            $return = array('response'=>'ZERO_RETURN');
        }
        echo json_encode($return);
    }
    else{
        $return = array('response'=>'error');
        echo json_encode($return);
    }
}

//close connection
$DB->close();
?>