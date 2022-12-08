<?php
//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

$DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

// call conexion instance
$con = $DB->connect();

$dir            = '../..';
//$dir            = "";
$target_dir     = $dir."/public/advertiser/csv/";
$target_file    = $target_dir . basename($_FILES["advertiser_file"]["name"]);
$uploadOk       = 1;
$message        = '';
$imageFileType  = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$commaSymbol    = ";"; // ",";

$module = 'advertisers';

$columns = '';

$fileSize       = $_FILES["advertiser_file"]["size"];

// Check if file already exists
/*
if (file_exists($target_file)) {
    $message    .= "\n- Sorry, file already exists.";
    $uploadOk = 0;
}
*/
// Check if file is a CSV 
if($imageFileType != 'csv'){
    $message    .= "\n- Sorry, Only CSV file is allowed";
    $uploadOk   = 0;
}

if ($uploadOk > 0) {
    if (move_uploaded_file($_FILES["advertiser_file"]["tmp_name"], $target_file)) {
        //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";

        $return = json_encode(["file" => "$target_file", "filetype" => "$imageFileType", "size" => "$fileSize"]);
        $fileRead   = file($target_file);
        foreach ($fileRead as $num_line => $line) {
            if($num_line == 0){
                $columns = str_replace('main_contact_lastname','main_contact_surname',htmlspecialchars($line));
                $columns = str_replace('main_contact_internationalcode','phone_international_code',$columns);
                $columns = str_replace('main_contact_areacode','phone_prefix',$columns);
                $columns = str_replace('main_contact_phonenumber','phone_number',$columns);
                $columns = str_replace('corporate_name','corporate_name',$columns);
                $columns = str_replace(';',',',$columns);
                $columns = "id,$columns,is_active,created_at,updated_at";
                $arrayColumns = explode($commaSymbol,$columns); 
            } else {
                $posStart[0]   = 0;
                $posFinal[0]   = strpos($line,'"');
                $index      = 1;
                while($posFinal[$index-1] > 0) { 
                    $addictive   = 0;
                    $posFinal[$index]   = $posStart[$index-1] + $posFinal[$index-1];
                    $numberOfCommas = count(explode($commaSymbol,substr($line,$posStart[$index-1],$posFinal[$index-1]))) - 1;
                    $numberOfQuotes = count(explode('"',substr($line,$posStart[$index-1],$posFinal[$index-1]))) - 1;
                    if($index >= 1){
                        $commas         = 2;
                        $quotes         = 1;
                        
                    }
                    if($index%2 != 0){
                        $line1  = str_replace($commaSymbol,"|||",substr($line,$posStart[$index-1],$posFinal[$index-1]));
                        $line   = str_replace(substr($line,$posStart[$index-1],$posFinal[$index-1]),$line1,$line);
                        $addictive       = ($commas * $numberOfCommas) + ($quotes * $numberOfQuotes)+1;
                    } else { $addictive++; }
                    $posStart[$index]   = $posFinal[$index] + $addictive;
                    $posFinal[$index]   = strpos(substr($line,$posStart[$index],strlen($line)),'"');
                    $index++;
                }
                $posFinal[$index]   = strlen($line);
                $line1  = str_replace($commaSymbol,"|||",substr($line,$posStart[$index-1],$posFinal[$index]));
                $line   = str_replace(substr($line,$posStart[$index-1],$posFinal[$index]),$line1,$line);
                $line = str_replace('"','',$line);
                $arrayLine  = explode("|||",$line);
                for($al=0;$al < count($arrayLine);$al++){
                    $arrayLine[$al]     = "'".$arrayLine[$al]."'";
                    if($arrayLine[$al]  == "''"){
                        $arrayLine[$al] = "null";
                    }
                }
                $line   = implode($commaSymbol,$arrayLine);
                //$line   = "'".$line."'";
                $line = str_replace(';',',',$line);
                $line   = "UUID(),$line,'Y',now(),now()";
                
                // creating INSERT sql
                $sql_insert_line = "INSERT INTO $module ($columns) VALUES ($line)";
                //echo $sql_insert_line." ---- ";
                // saving lines on database
                $rs = $DB->executeInstruction($sql_insert_line);

               // echo "<BR/><BR/>" . $sql_insert_line;
                $return = json_encode(["status" => "OK"]);
            }
        }
    } else {
        $message = '\n- Sorry, there was an error uploading your file';
        $return = json_encode(["status" => "error", "message" => "$message"]);
    }
} else {
    $return = json_encode(["status" => "error", "message" => "$message"]);
}


header('Content-type: application/json');
echo $return;

//close connection
$DB->close();
?>