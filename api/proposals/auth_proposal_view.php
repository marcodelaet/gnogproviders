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
    $columns        = "vp.uuid, vp.UUID as uuid_full,vp.proposalproduct_id,vp.product_id,vp.offer_name as name,vp.product_name,vp.salemodel_id,vp.salemodel_name,vp.provider_id,vp.provider_name,vp.user_id,vp.username,vp.client_id,vp.client_name,vp.agency_id,vp.agency_name,vp.status_id,vp.status_name,vp.status_percent,vp.offer_name,vp.description,vp.start_date,vp.stop_date,sum(vp.price) as price_sum, vp.price,vp.currency,vp.quantity,vp.is_active";
    $columnsjoin    = "";
    $tableOrView    = "view_proposals vp";
    $leftjoin       = "";
    if(array_key_exists('join',$_REQUEST)){
        $leftjoin       = urldecode($_REQUEST['join']);
    }
    if(array_key_exists('cjoin',$_REQUEST)){
        $acjoin         = explode(",",$_REQUEST['cjoin']);
        for($cj=0;$cj<count($acjoin);$cj++){
            $columnsjoin    = ', cjoin.'.$acjoin[$cj];
        }
    }    
    
    $columns        .= $columnsjoin;
    $tableOrView    .= ' LEFT JOIN '.$leftjoin;

    $orderBy        = "order by vp.offer_name";
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

    $jkr    = "";
    if(array_key_exists('where',$_GET)){
        if($_GET['where']!==''){
            if($filters != '')
                $filters .= " AND ";

            $jocker         = explode("---",urldecode($_GET['where']));
            if(count($jocker)==2){
                $filters    .= " vp.$jocker[0]='$jocker[1]'";
            } else {
                $filters    .= str_replace('---','=',urldecode($_GET['where']));
            }            
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