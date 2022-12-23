<?php
function xmlReader($file){
    $link = $file["tmp_name"];

    $fileName       = basename($file["name"]);
    $fileType       = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
    $errors         = 0;
    $response       = '';
    if($fileType != '.xml'){
        $errors++;
        $response = 'file_is_not_xml';
    } else {
        $response = simplexml_load_file($link) -> channel;
    }

    return $response; 
}


if(array_key_exists('file_field_name',$_POST)){
    $return = xmlReader($_FILES[$_POST['file_field_name']]);
    header('Content-type: application/json');
    echo $return;
}
?>