<?php
$dir = '';
if(array_key_exists('dir',$_REQUEST)){
    $dir = $_REQUEST['dir'];
}

//REQUIRE GLOBAL conf
require_once($dir.'./database/.config');

// REQUIRE conexion class
require_once($dir.'./database/connect.database.php');

function translateText($xcode){
    $userLanguage = $_COOKIE['ulang'];

    global $DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME;

    $DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DB->connect();

    // Query
    $sql = "SELECT id as uuid, text_eng, text_".$userLanguage." FROM translates WHERE is_active='Y' AND code_str = '$xcode'";

    $rs = $DB->getData($sql);
    if($rs){
        $returningText = $rs[0]['text_'.$userLanguage];
        if( is_null($returningText) || ($returningText == ''))
            $returningText = $rs[0]['text_eng'];
        return $returningText;
    } else {
        return 'Error';
    }

    //close connection
    $DB->close();

}

function translateTextInLanguage($xcode,$language){
    $userLanguage = $language;

    global $DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME;

    $DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DB->connect();

    // Query
    $sql = "SELECT id as uuid, text_eng, text_".$userLanguage." FROM translates WHERE is_active='Y' AND code_str = '$xcode'";

    $rs = $DB->getData($sql);
    if($rs){
        $returningText = $rs[0]['text_'.$userLanguage];
        if( is_null($returningText) || ($returningText == ''))
            $returningText = $rs[0]['text_eng'];
        $response = json_encode(["response"=>"OK","translation" => $returningText]);
    } else {
        $response = json_encode(["response"=>"Error","translation" => 'Error']);;
    }
    return $response;

    //close connection
    $DB->close();
}


if(array_key_exists('fcn',$_REQUEST)){
    $function = $_REQUEST['fcn'];
    switch($function){
        case 'translateInLanguage':
            $xcode      = '';
            $language   = '';
            
            if(array_key_exists('code',$_REQUEST))
                $xcode = $_REQUEST['code'];
            if(array_key_exists('lng',$_REQUEST))
                $language = $_REQUEST['lng'];
            $response = translateTextInLanguage($xcode,$language);
            break;
    }
    header('Content-type: application/json'); 
    echo $response;
}

?>