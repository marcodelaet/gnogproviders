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
    $columns        = "(id) as uuid_full, name, description, is_active";
    $tableOrView    = "salemodels";
    $orderBy        = "order by name";
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

    if(array_key_exists('digyn',$_REQUEST)){
        if($_REQUEST['digyn']!==''){
            if($filters != '')
                $filters .= " AND ";
            $isDigital = $_REQUEST['digyn'];
            $filters        .= " is_digital = '$isDigital'";
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