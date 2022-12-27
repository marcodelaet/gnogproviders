<?php
function xmlReader($file){
    $link = $file["tmp_name"];



    $fileName       = basename($file["name"]);
    $fileType       = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
    $errors         = 0;
    $response       = '';

    $dir            = '../..';
    //$dir          = "";
    $path_dir       = $dir."/public/invoices/";
    $target_dir     = $path_dir;

    $file_name      = 'xml-aaa.'.$fileType;
    $file_up        = $target_dir.$file_name;

    if($fileType != 'xml'){
        $errors++;
        $response = "file_is_not_xml (fileType: $fileType)";
    } else {
        if(move_uploaded_file($file["tmp_name"], $file_up)) {
            $xml = simplexml_load_file($file_up);
            $firstNode = 'cfdi:Comprobante';
//            $total = var_dump($xml->$firstNode->attributes()->Total);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
            $response = $json;

        } else {
            $errors++;
            $response = "file_not_sent";
        }
    }
    return $response; 
}

if(array_key_exists('file_field_name',$_POST)){
    $return = xmlReader($_FILES[$_POST['file_field_name']]);
    //$return = basename($_FILES[$_POST['file_field_name']]["name"]) . ' ' . $_POST['file_field_name'];
    header('Content-type: application/json');
    echo(str_replace('@attributes','attributes',$return));
}
?>