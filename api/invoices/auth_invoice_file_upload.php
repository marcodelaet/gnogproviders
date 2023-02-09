<?php
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
*/

//REQUIRE GLOBAL conf
require_once('../../database/.config');

// REQUIRE conexion class
require_once('../../database/connect.database.php');

// Loading SendMail class
require('../../assets/lib/SendMail.php');

// Creating a new instance to SendMail class
$SendGNogMail = new SendMail();

$from_name     = 'CRM - Provider Platform';
$from_email    = 'crm_no_contestar@gnogmedia.com';
$to_name       = 'Lorena Saitta, Christian Nolasco, Fernando Nogueira, Marco De Laet, Estephanie Torres, Amanda Gómes Morales, Juan Jose';
$to_email      = 'lorena@gnogmedia.com, finanzas@gnog.com.mx, fernando@gnog.com.mx, it@gnog.com.br, estephanie@gnog.com.mx, amanda@gnog.com.mx, juan@gnog.com.mx';
$signFilePath  = 'platform_CRM.png';


// initializing errors
$errors = 0;

if(!isset($DB)){
    $DB = new MySQLDB($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASSWORD,$DATABASE_NAME);

    // call conexion instance
    $con = $DB->connect();
}

// REQUIRE utils functions
require_once('../../assets/lib/translation.php');

if(array_key_exists('uid',$_POST)){
    $user_id    = $_POST['uid'];
    $user_dir   = $user_id . '/';
}

if(array_key_exists('year',$_POST)){
    $year = $_POST['year'];
}

if(array_key_exists('month',$_POST)){
    $month = $_POST['month'];
}

if(array_key_exists('pid',$_POST)){
    $provider_id = $_POST['pid'];
}

if(array_key_exists('product',$_POST)){
    $proposalproduct_id = $_POST['product'];
    $proposalproduct_dir= $proposalproduct_id . '/';
}

$user_token = 'AUTO';
if(array_key_exists('usrTk',$_POST)){
    $user_token = $_POST['usrTk'];
}

$form_token = 'AUTO';
if(array_key_exists('authApi',$_POST)){
    $form_token = $_POST['authApi'];
}

// invoice_number
$invoice_number = '';
if(array_key_exists('invoice_number',$_POST)){
    $invoice_number = $_POST['invoice_number'];
}

// invoice_amount_int
$invoice_amount_int = '';
if(array_key_exists('invoice_value',$_POST)){
    $zeros = '00';
    $invoice_amount_int = $_POST['invoice_value'];
    $invoice_amount_int = str_replace(",","",$invoice_amount_int);
    $aInvoice_amount_int = explode(".",$invoice_amount_int);

    if(count($aInvoice_amount_int) <= 1){
        $invoice_amount_int .= $zeros;
    } else {
        $invoice_amount_int = substr($invoice_amount_int,0,(strlen($invoice_amount_int) - strlen($aInvoice_amount_int[1])-1)) . substr($aInvoice_amount_int[1] . $zeros,0,2);
    }
}

// invoice_amount_currency
$invoice_amount_currency = '';
if(array_key_exists('currency',$_POST)){
    $invoice_amount_currency = $_POST['currency'];
}

// order_number
$order_number = '';
if(array_key_exists('po_number',$_POST)){
    $order_number = $_POST['po_number'];
}


$year_month = '000000' . $year . $month;
$year_month = substr($year_month,strlen($year_month)-6,6);
$year_month_dir = $year_month . '/';

$invoice_month  = substr($year_month,-2,2);
$invoice_year   = substr($year_month,0,4);

$dir            = '../..';
//$dir            = "";
$path_dir               = $dir."/public/invoices/";
$target_user_dir        = $path_dir.$user_dir;
$target_product_dir     = $target_user_dir.$proposalproduct_dir;
$target_dir             = $target_product_dir.$year_month_dir;

# create directories if not exists in
if(!is_dir($target_user_dir)){
    mkdir($target_user_dir);
}
if(!is_dir($target_product_dir)){
    mkdir($target_product_dir);
}
if(!is_dir($target_dir)){
    mkdir($target_dir);
}

$file_name_invoice      = basename($_FILES["invoice-file-invoice"]["name"]);
$file_name_po           = basename($_FILES["invoice-file-po"]["name"]);
$file_name_report       = basename($_FILES["invoice-file-report"]["name"]);
$file_name_presentation = basename($_FILES["invoice-file-presentation"]["name"]);
$file_name_xml          = basename($_FILES["invoice-file-xml"]["name"]);
$file_invoice           = $target_dir . $file_name_invoice;
$file_po                = $target_dir . $file_name_po;
$file_report            = $target_dir . $file_name_report;
$file_presentation      = $target_dir . $file_name_presentation;
$file_xml               = $target_dir . $file_name_xml;
$uploadOk               = 1;
$message                = '';
$imageFileTypeinvoice       = strtolower(pathinfo($file_invoice,PATHINFO_EXTENSION));
$imageFileTypepo            = strtolower(pathinfo($file_po,PATHINFO_EXTENSION));
$imageFileTypereport        = strtolower(pathinfo($file_report,PATHINFO_EXTENSION));
$imageFileTypepresentation  = strtolower(pathinfo($file_presentation,PATHINFO_EXTENSION));
$imageFileTypexml           = strtolower(pathinfo($file_xml,PATHINFO_EXTENSION));

$module = 'invoices';

$columns = '';

$fileSizeinvoice        = $_FILES["invoice-file-invoice"]["size"];
$fileSizepo             = $_FILES["invoice-file-po"]["size"];
$fileSizereport         = $_FILES["invoice-file-report"]["size"];
$fileSizepresentation   = $_FILES["invoice-file-presentation"]["size"];
$fileSizexml            = $_FILES["invoice-file-xml"]["size"];

$message = '';

$filesSent = '';

if ($uploadOk > 0) {
    $invoice_status = "waiting_approval"; // every time the user upload a new file, the status resets to waiting_approval
    
    // Checking if invoice is already on table (remember to change table name to view)
    $check_invoice_exist = "SELECT id, invoice_amount_int, invoice_amount_currency, invoice_number, order_number FROM invoices WHERE provider_id='$provider_id' AND invoice_month='$invoice_month' AND invoice_year='$invoice_year' AND proposalproduct_id='$proposalproduct_id' AND is_active='Y'";

    $invoiceNumRows    = $DB->numRows($check_invoice_exist);

    // if 0 results, then record a new invoice data
    $update = false;
    

    if($invoiceNumRows < 1){
        // RECORDING invoice data 
        $insert_invoice_data = "INSERT INTO invoices (id,provider_id,invoice_number,invoice_amount_int,invoice_amount_currency,invoice_month,invoice_year,order_number,proposalproduct_id,invoice_status,is_active,created_at,updated_at) VALUES (UUID(),'$provider_id','$invoice_number',$invoice_amount_int,'$invoice_amount_currency','$invoice_month','$invoice_year','$order_number','$proposalproduct_id','$invoice_status','Y',now(),now())";               

        // saving invoice on database
        $rs_invoice_record = $DB->executeInstruction($insert_invoice_data);
    } else {
        $update = true;
    }    
    
    // getting Invoice ID
    $rs_invoice_data    = $DB->getData($check_invoice_exist);

    $invoice_id                         = $rs_invoice_data[0]['id'];
    $invoice_amount_int_on_table        = $rs_invoice_data[0]['invoice_amount_int'];
    $invoice_amount_currency_on_table   = $rs_invoice_data[0]['invoice_amount_currency'];
    $invoice_number_on_table            = $rs_invoice_data[0]['invoice_number'];
    $order_number_on_table              = $rs_invoice_data[0]['order_number'];

    $update_columns = '';
    if(($invoice_amount_int !== '') && ($invoice_amount_int_on_table !== $invoice_amount_int)){
        $update_columns .= ", invoice_amount_int='$invoice_amount_int'";
    }
    if(($invoice_amount_currency !== '') && ($invoice_amount_currency_on_table !== $invoice_amount_currency)){
        $update_columns .= ", invoice_amount_currency='$invoice_amount_currency'";
    }
    if(($invoice_number !== '') && ($invoice_number_on_table !== $invoice_number)){
        $update_columns .= ", invoice_number='$invoice_number'";
    }
    if(($order_number !== '') && ($order_number_on_table !== $order_number)){
        $update_columns .= ", order_number='$order_number'";
    }
    // If exist data, record the waiting approval status and updated_at now()
    if($update === true){
        // RECORDING invoice data 
        $update_invoice_data = "UPDATE invoices SET invoice_status='$invoice_status' $update_columns, updated_at=now() WHERE id='$invoice_id'";
    
        // updating invoice on database
        $rs_invoice_update = $DB->executeInstruction($update_invoice_data);
    }

    // UPLOADING INVOICE FILE
    $uploading      = 'invoice';
    $imageFileType  = 'imageFileType'.$uploading;
    $file_name      = $uploading.'-'.$year_month.'.'.$$imageFileType;
    $file           = $target_dir.$file_name;
    $fileSize       = 'fileSize'.$uploading;
    if($filesSent != '')
        $filesSent .= ', ';
    $filesSent .= $uploading;

    // Checking if file is already on table
    $check_file_exist = "SELECT id FROM files WHERE file_location='$target_dir' AND file_name='$file_name' AND invoice_id='$invoice_id' AND user_id='$user_id' AND is_active='Y'";
    //$message .= "\n- $check_file_exist";

    $fileNumRows    = $DB->numRows($check_file_exist);

    if(move_uploaded_file($_FILES["invoice-file-".$uploading]["tmp_name"], $file)) {            
        $return = json_encode(["file" => $$file, "filetype" => $$imageFileType, "size" => $$fileSize]);
        $description = 'Invoice file';

        if($fileNumRows < 1){
            // creating INSERT sql to files
            $sql_insert_invoice = "INSERT INTO files (id,file_location,file_name,file_type,invoice_id,user_id,description,is_active,created_at,updated_at) VALUES (UUID(),'$target_dir','".$file_name."','".$$imageFileType."','$invoice_id','$user_id','$description','Y',now(),now())";
            
            // saving lines on database
            $rsinvoice = $DB->executeInstruction($sql_insert_invoice);

            if($rsinvoice){
                $message .= "\n- $uploading file sent succesfully";
                $return = json_encode(["status" => "OK","message" => $message]);
            }
        } else {
            // getting file ID
            $rs_file_data   = $DB->getData($check_file_exist);

            $file_id        = $rs_file_data[0]['id'];

            $sql_update_file = "UPDATE files SET updated_at=now() WHERE id='$file_id'";
            
            // updating file information on database
            $rs_invoice_update = $DB->executeInstruction($update_invoice_data);
        }
    }
    else {
        $errors++;
        $message .= "\n- $uploading file not sent";
        $return = json_encode(["status"=>"ERROR","message" => $message]);
    }

    // UPLOADING P.O FILE
    $uploading      = 'po';
    $imageFileType  = 'imageFileType'.$uploading;
    $file_name      = $uploading.'-'.$year_month.'.'.$$imageFileType;
    $file           = $target_dir.$file_name;
    $fileSize       = 'fileSize'.$uploading;
    if($filesSent != '')
        $filesSent .= ', ';
    $filesSent .= $uploading;

    // Checking if file is already on table
    $check_file_exist = "SELECT id FROM files WHERE file_location='$target_dir' AND file_name='$file_name' AND invoice_id='$invoice_id' AND user_id='$user_id' AND is_active='Y'";
    //$message .= "\n- $check_file_exist";

    $fileNumRows    = $DB->numRows($check_file_exist); 

    if (move_uploaded_file($_FILES["invoice-file-".$uploading]["tmp_name"], $file)) {
        $return = json_encode(["file" => $$file, "filetype" => $$imageFileType, "size" => $$fileSize]);
        $description = 'P.O. file';
        if($fileNumRows < 1){
            // creating INSERT sql to files
            $sql_insert_po = "INSERT INTO files (id,file_location,file_name,file_type,invoice_id,user_id,description,is_active,created_at,updated_at) VALUES (UUID(),'$target_dir','".$file_name."','".$$imageFileType."','$invoice_id','$user_id','$description','Y',now(),now())";
            
            // saving lines on database
            $rspo = $DB->executeInstruction($sql_insert_po);

            if($rspo){
                $message .= "\n- $uploading file sent succesfully";
                $return = json_encode(["status" => "OK","message" => $message]);
            }
        } else {
            // getting file ID
            $rs_file_data   = $DB->getData($check_file_exist);

            $file_id        = $rs_file_data[0]['id'];

            $sql_update_file = "UPDATE files SET updated_at=now() WHERE id='$file_id'";
            
            // updating file information on database
            $rs_invoice_update = $DB->executeInstruction($update_invoice_data);
        }
    }
    else {
        $errors++;
        $message .= "\n- $uploading file not sent";
        $return = json_encode(["status"=>"ERROR","message" => $message]);
    }

    // UPLOADING REPORT FILE
    $uploading      = 'report';
    $imageFileType  = 'imageFileType'.$uploading;
    $file_name      = $uploading.'-'.$year_month.'.'.$$imageFileType;
    $file           = $target_dir.$file_name;
    $fileSize       = 'fileSize'.$uploading;
    if($filesSent != '')
        $filesSent .= ', ';
    $filesSent .= $uploading;

    // Checking if file is already on table
    $check_file_exist = "SELECT id FROM files WHERE file_location='$target_dir' AND file_name='$file_name' AND invoice_id='$invoice_id' AND user_id='$user_id' AND is_active='Y'";
    //$message .= "\n- $check_file_exist";

    $fileNumRows    = $DB->numRows($check_file_exist);
    
    if (move_uploaded_file($_FILES["invoice-file-".$uploading]["tmp_name"], $file)) {
        $return = json_encode(["file" => $$file, "filetype" => $$imageFileType, "size" => $$fileSize]);
        $description = 'Report file';
        if($fileNumRows < 1){
            // creating INSERT sql to files
            $sql_insert_report = "INSERT INTO files (id,file_location,file_name,file_type,invoice_id,user_id,description,is_active,created_at,updated_at) VALUES (UUID(),'$target_dir','".$file_name."','".$$imageFileType."','$invoice_id','$user_id','$description','Y',now(),now())";
            
            // saving lines on database
            $rsreport = $DB->executeInstruction($sql_insert_report);

            if($rsreport){
                $message .= "\n- $uploading file sent succesfully";
                $return = json_encode(["status" => "OK","message" => $message]);
            }
        } else {
            // getting file ID
            $rs_file_data   = $DB->getData($check_file_exist);

            $file_id        = $rs_file_data[0]['id'];

            $sql_update_file = "UPDATE files SET updated_at=now() WHERE id='$file_id'";
            
            // updating file information on database
            $rs_invoice_update = $DB->executeInstruction($update_invoice_data);
        }
    }
    else {
        $errors++;
        $message .= "\n- $uploading file not sent";
        $return = json_encode(["status"=>"ERROR","message" => $message]);
    }

    // UPLOADING PRESENTATION FILE
    $uploading      = 'presentation';
    $imageFileType  = 'imageFileType'.$uploading;
    $file_name      = $uploading.'-'.$year_month.'.'.$$imageFileType;
    $file           = $target_dir.$file_name;
    $fileSize       = 'fileSize'.$uploading;
    if($filesSent != '')
        $filesSent .= ', ';
    $filesSent .= $uploading;

    // Checking if file is already on table
    $check_file_exist = "SELECT id FROM files WHERE file_location='$target_dir' AND file_name='$file_name' AND invoice_id='$invoice_id' AND user_id='$user_id' AND is_active='Y'";
   // $message .= "\n- $check_file_exist";

    $fileNumRows    = $DB->numRows($check_file_exist);

    if (move_uploaded_file($_FILES["invoice-file-".$uploading]["tmp_name"], $file)) {
        $return = json_encode(["file" => $$file, "filetype" => $$imageFileType, "size" => $$fileSize]);
        $description = 'Presentation file';
        if($fileNumRows < 1){
            // creating INSERT sql to files
            $sql_insert_presentation = "INSERT INTO files (id,file_location,file_name,file_type,invoice_id,user_id,description,is_active,created_at,updated_at) VALUES (UUID(),'$target_dir','".$file_name."','".$$imageFileType."','$invoice_id','$user_id','$description','Y',now(),now())";
            
            // saving lines on database
            $rspresentation = $DB->executeInstruction($sql_insert_presentation);

            if($rspresentation){
                $message .= "\n- $uploading file sent succesfully";
                $return = json_encode(["status" => "OK","message" => $message]);
            }
        } else {
            // getting file ID
            $rs_file_data   = $DB->getData($check_file_exist);

            $file_id        = $rs_file_data[0]['id'];

            $sql_update_file = "UPDATE files SET updated_at=now() WHERE id='$file_id'";
            
            // updating file information on database
            $rs_invoice_update = $DB->executeInstruction($update_invoice_data);
        }
    }
    else {
        $errors++;
        $message .= "\n- $uploading file not sent";
        $return = json_encode(["status"=>"ERROR","message" => $message]);
    }

    // UPLOADING XML FILE
    $uploading      = 'xml';
    $imageFileType  = 'imageFileType'.$uploading;
    $file_name      = $uploading.'-'.$year_month.'.'.$$imageFileType;
    $file           = $target_dir.$file_name;
    $fileSize       = 'fileSize'.$uploading;
    if($filesSent != '')
        $filesSent .= ', ';
    $filesSent .= $uploading;

    // Checking if file is already on table
    $check_file_exist = "SELECT id FROM files WHERE file_location='$target_dir' AND file_name='$file_name' AND invoice_id='$invoice_id' AND user_id='$user_id' AND is_active='Y'";
   // $message .= "\n- $check_file_exist";
    
    $fileNumRows    = $DB->numRows($check_file_exist);
    
    if (move_uploaded_file($_FILES["invoice-file-".$uploading]["tmp_name"], $file)) {
        $return = json_encode(["file" => $$file, "filetype" => $$imageFileType, "size" => $$fileSize]);
        $description = 'XML file';
        if($fileNumRows < 1){
            // creating INSERT sql to files
            $sql_insert_xml = "INSERT INTO files (id,file_location,file_name,file_type,invoice_id,user_id,description,is_active,created_at,updated_at) VALUES (UUID(),'$target_dir','".$file_name."','".$$imageFileType."','$invoice_id','$user_id','$description','Y',now(),now())";
            
            // saving lines on database
            $rsxml = $DB->executeInstruction($sql_insert_xml);

            if($rsxml){
                $message .= "\n- $uploading file sent succesfully";
                $return = json_encode(["status" => "OK","message" => $message]);
            }
        } else {
            // getting file ID
            $rs_file_data   = $DB->getData($check_file_exist);

            $file_id        = $rs_file_data[0]['id'];

            $sql_update_file = "UPDATE files SET updated_at=now() WHERE id='$file_id'";
            
            // updating file information on database
            $rs_invoice_update = $DB->executeInstruction($update_invoice_data);
            $return = json_encode(["status" => "OK","message" => $message]);
        }
    }
    else {
        /**************************************
         *  NOT REQUIRED
         ************************************ */
        $message .= "\n- $uploading file not sent";
       // $return = json_encode(["status"=>"ERROR","message" => $message]);
    }

    $sql_get_user = "SELECT CONCAT(p.contact_name,' ',p.contact_surname) as full_name, p.name as provider_name, u.email from view_users u INNER JOIN view_providers p ON p.contact_email = u.email WHERE u.UUID = '$user_id'";
    $rs_get_user  = $DB->getData($sql_get_user);
    $user_fullname = $rs_get_user[0]['full_name'];
    $user_email = $rs_get_user[0]['email'];
    $user_providername = $rs_get_user[0]['provider_name'];

    //changing FROM to logged user
    $from_name     = "$user_fullname";
    $from_email    = "$user_email";


    // setting history log
    $description_en     = "$user_providername ($user_fullname) sent files to invoice ($filesSent - ".substr($year_month,0,4)."/".substr($year_month,-2,2).")";
    $description_es     = "$user_providername ($user_fullname) envió archivos de factura ($filesSent - ".substr($year_month,0,4)."/".substr($year_month,-2,2).")";
    $description_ptbr   = "$user_providername ($user_fullname) enviou arquivos de fatura ($filesSent - ".substr($year_month,0,4)."/".substr($year_month,-2,2).")";
    setHistory($user_id,'invoices',$invoice_id,$description_en,$description_es,$description_ptbr,$user_token,$form_token,'text');

    $subject       = 'Notificación - GNog Providers';
    $messageHtml   = "<p>Esp: <p>$description_es </p></p>";
    $messageHtml   .= "<p>PtBR: <p>$description_ptbr </p></p>";
    $messageHtml   .= "<p>Eng: <p>$description_en </p></p>";
    
    $SendGNogMail->sendGNogMail($from_name,$from_email,$to_name,$to_email,$subject,$messageHtml,$signFilePath);
   


} else {
    $errors++;
    $message .= 'Error PANIC';
    //$return = json_encode(["status" => "error", "message" => "$message"]);
}

//$errors = 1;
if($errors > 0){
    $return = json_encode(["status" => "error", "message" => "$message"]);
}

header('Content-type: application/json');
echo $return;

//close connection
$DB->close();

?>