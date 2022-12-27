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
        $response = json_encode(["response"=>"Error","translation" => 'Error']);
    }
    return $response;

    //close connection
    $DB->close();
}

function setHistory($user_id,$module_name,$description,$user_token,$form_token){
    global $DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME;

    $DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DB->connect();

    // Query
    $sql = "INSERT INTO loghistory (id, user_id, module_name, DESCRIPTION, user_token, form_token, created_at, updated_at) VALUES (UUID(), '$user_id', '$module_name', '$description', '$user_token', '$form_token', now(), now()"; 

    $rs = $DB->getData($sql);
    if($rs){
        $response = json_encode(["response"=>"OK"]);
    } else {
        $response = json_encode(["response"=>"Error"]);
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