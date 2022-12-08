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
    $columns        = "uuid, UUID as uuid_full,proposalproduct_id,product_id,offer_name as name,product_name,salemodel_id,salemodel_name,provider_id,provider_name,user_id,username,client_id,client_name,agency_id,agency_name,status_id,status_name,status_percent,offer_name,description,start_date,stop_date,sum(price) as price_sum, price,currency,quantity,is_active";
    $tableOrView    = "view_proposals";
    $orderBy        = "order by offer_name";
    $groupBy        = "";

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
    if(array_key_exists('order',$_REQUEST)){
        if($_REQUEST['order']!==''){
            $orderBy        = " ORDER BY " . $_REQUEST['order'];
        }
    }
    if(array_key_exists('groupby',$_REQUEST)){
        if($_REQUEST['groupby']!==''){
            $groupBy        = " GROUP BY " . $_REQUEST['groupby'];
        }
    }
    if(array_key_exists('where',$_GET)){
        if($_GET['where']!==''){
            if($filters != '')
                $filters .= " AND ";
            $jocker         = explode("---",$_GET['where']);
            $filters        .= " $jocker[0]='$jocker[1]'";
        }
    }
    
    if($filters !== ''){
        $filters = "WHERE ".$filters;
    }

    // Query creation
    $sql = "SELECT $columns FROM $tableOrView $filters $groupBy $orderBy";
    // LIST data
    //echo $sql;
    $rs = $DB->getData($sql);

    // Response JSON 
    if($rs){
        $response = json_encode(["response"=>"OK","data"=>$rs]);
    } else {
        $response = json_encode(["response"=>"ERROR"]);

    }
    header('Content-type: application/json');
    echo $response;
}

//close connection
$DB->close();
?>