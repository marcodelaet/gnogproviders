<?php
$dir = '';
if(array_key_exists('dir',$_REQUEST)){
    $dir = $_REQUEST['dir'];
}

// only load dababase option if it is not SET
if(!isset($DB)){
    //REQUIRE GLOBAL conf
    require_once($dir.'./database/.config');

    // REQUIRE conexion class
    require_once($dir.'./database/connect.database.php');
}

function translateText($xcode){
    $userLanguage = $_COOKIE['ulang'];

    global $DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME;

    if(!isset($DB)){
        $DBTranslate = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

        // call conexion instance
        $con = $DBTranslate->connect();
    }

    // Query
    $sql = "SELECT id as uuid, text_eng, text_".$userLanguage." FROM translates WHERE is_active='Y' AND code_str = '$xcode'";

    $rs = $DBTranslate->getData($sql);
    if($rs){
        $returningText = $rs[0]['text_'.$userLanguage];
        if( is_null($returningText) || ($returningText == ''))
            $returningText = $rs[0]['text_eng'];
        return $returningText;
    } else {
        return 'Error';
    }

    //close connection
    $DBTranslate->close();

}

function translateTextInLanguage($xcode,$language){
    $userLanguage = $language;

    global $DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME;

    $DBTranslate = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DBTranslate->connect();

    // Query
    $sql = "SELECT id as uuid, text_eng, text_".$userLanguage." FROM translates WHERE is_active='Y' AND code_str = '$xcode'";

    $rs = $DBTranslate->getData($sql);
    if($rs){
        $returningText = $rs[0]['text_'.$userLanguage];
        if( is_null($returningText) || ($returningText == ''))
            $returningText = $rs[0]['text_eng'];
        $response = json_encode(["response"=>"OK","translation" => $returningText]);
    } else {
        $response = json_encode(["response"=>"Error","translation" => 'Error']);
    }
    //close connection
    $DBTranslate->close();
    return $response;
}

function setHistory($user_id,$module_name,$module_id,$description_en,$description_es,$description_ptbr,$user_token,$form_token,$resultType){
    global $DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME;

    $DBHistory = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DBHistory->connect();

    // Query
    $sql = "INSERT INTO loghistory (id, user_id, module_name, module_id, description_en, description_es, description_ptbr, user_token, form_token, created_at, updated_at) VALUES (UUID(),'$user_id', '$module_name', '$module_id', '$description_en','$description_es','$description_ptbr', '$user_token', '$form_token', now(), now())"; 

    $rs = $DBHistory->executeInstruction($sql);
    if($rs){
        if($resultType == 'json')
            $response = json_encode(["response"=>"OK"]);
        if($resultType == 'text')
            $response = "OK";
    } else {
        if($resultType == 'json')
            $response = json_encode(["response"=>"Error"]);
        if($resultType == 'text')
            $response = "Error: ".$sql;
    }
    //close connection
    $DBHistory->close();
    return $response;
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

function sendmailto($to,$subject,$message,$headers){
    $to = "user1@example.com, user2@example.com";
    $subject = "This is a test HTML email";
    
    $message = "
    <html>
    <head>
    <title>This is a test HTML email</title>
    </head>
    <body>
    <p>Test email. Please ignore.</p>
    </body>
    </html>
    ";
    
    // It is mandatory to set the content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // More headers. From is required, rest other headers are optional
    $headers .= 'From: <info@example.com>' . "\r\n";
    $headers .= 'Cc: sales@example.com' . "\r\n";
    
    mail($to,$subject,$message,$headers);
}

?>