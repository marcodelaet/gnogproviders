<?php
//REQUIRE GLOBAL conf
require_once('./database/.config');

// REQUIRE conexion class
require_once('./database/connect.database.php');

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

?>