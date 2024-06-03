<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

// check authentication / local Storage
//if(array_key_exists('auth_api',$_POST)){
    // check auth_api === local storage
    //if($localStorage == $_REQUEST['auth_api']){}

    // values to insert
    $typeContact                = $_POST['module'];
    $array_contact_name         = str_replace("[","",str_replace("]","",$_POST['contact_name']));
    $array_contact_surname      = str_replace("[","",str_replace("]","",$_POST['contact_surname']));
    $array_contact_email        = str_replace("[","",str_replace("]","",$_POST['contact_email']));
    $array_contact_position     = str_replace("[","",str_replace("]","",$_POST['contact_position']));
    $contact_client_id          = $_POST['ElementID'];
    $array_phone_international_code   = "000";
    if(array_key_exists('phone_ddi',$_POST)){
        if($_POST['phone_ddi']!=='')
            $array_phone_international_code   = $_POST['phone_ddi'];
    }
    $array_phone_prefix       = "000";
    $array_phone_number       = "000";
    if(array_key_exists('phone_number',$_POST)){
        if($_POST['phone_number']!=='')
            $array_phone_number   = str_replace("[","",str_replace("]","",$_POST['phone_number']));
    }

    $array_contact_name             = explode(",",$array_contact_name);
    $array_contact_surname          = explode(",",$array_contact_surname);
    $array_contact_email            = explode(",",$array_contact_email);
    $array_contact_position         = explode(",",$array_contact_position);
    $array_phone_number             = explode(",",$array_phone_number);
    

    $qtyLines   = count($array_contact_name);
    $oks        = 0;
    $module     = "contacts";
    $columns    = "id,module_name,contact_name,contact_surname,contact_email,contact_position,contact_client_id,phone_international_code,phone_prefix,phone_number,is_active,created_at,updated_at";
    // passing by every contact line
    for($i = 0;$i < $qtyLines;$i++) {
        $contact_name               = $array_contact_name[$i];
        $contact_surname            = $array_contact_surname[$i];
        $contact_email              = $array_contact_email[$i];
        $contact_position           = $array_contact_position[$i];
        $phone_international_code   = $array_phone_international_code;
        $phone_prefix               = $array_phone_prefix[$i];
        $phone_number               = $array_phone_number[$i];

        $values     = "(UUID()),'$typeContact','$contact_name','$contact_surname','$contact_email','$contact_position','$contact_client_id','$phone_international_code','$phone_prefix','$phone_number','Y',now(),now()";

        // Query creation
        $sql = "INSERT INTO $module ($columns) VALUES ($values)";
        // INSERT data
        $rs = $DB->executeInstruction($sql);
        if($rs){
            $oks++;
        }
    }

    // Response JSON 
    header('Content-type: application/json');
    if($qtyLines === $oks){
        echo json_encode(['status' => 'OK']);
    }
    else {
        echo json_encode(['status' => 'ERROR - '.$oks.'/'.$qtyLines]);
    }
//}

//close connection
$DB->close();
?>