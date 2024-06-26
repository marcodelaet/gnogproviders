<?php 
session_start();
//require_once __DIR__ . '/vendor/autoload.php';


/* ****************************
* MAINTENANCE MODE d1 != d2
******************************/
$d1 = 1;
$d2 = 1;
/* ***************************/
if(array_key_exists('ulang',$_COOKIE)){
   $lang = $_COOKIE['ulang'];
} else {
   $lang = 'en';
   $_COOKIE['ulang'] = 'esp';
}
if($lang == 'eng')
   $lang = 'en';
if($lang == 'esp')
   $lang = 'es';


//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', true);

//require_once __DIR__.'/vendor/shuchkin/simplexlsx/src/SimpleXLSX.php';

//use Shuchkin\SimpleXLSX;

require_once('./assets/conf.main.php'); 
require_once('./assets/lib/security_area.php');
require_once('./components/items/input.php');
require_once('./assets/lib/translation.php');
?>
<!DOCTYPE html>
<html lang="<?=$lang?>">
<?php
   require_once('./components/header.main.php');
?>
  <body <?php if($_REQUEST['pr'] == base64_encode('./pages/maps/index.php')) { ?> onload="theMap('<?=$_REQUEST['smid']?>','<?=$_REQUEST['state']?>','<?=$_REQUEST['pppid']?>');" <?php } ?>>
    <noscript>You need to enable JavaScript to run this app.</noscript>
<?php
    if($LOCALSERVER == 'local') {
?>
<div id="develop-area">
      DEVELOP AREA   -   DEVELOP AREA   -   DEVELOP AREA   -   DEVELOP AREA   -   DEVELOP AREA  -   DEVELOP AREA   
    </div>
<?php  
} else {
  if(substr($SUBDOMAIN,0,4) == 'beta') {
    ?> 
    <div id="beta-notify">
    BETA HOMOLOGATION - BETA HOMOLOGATION - BETA HOMOLOGATION - BETA HOMOLOGATION - BETA HOMOLOGATION
    </div>
    <?php
  } else { 
    // nothing  
  }
}
?>
    <div id="root">
      <?php
require('./components/menu.main.php');
require('./components/content.main.php');
require_once('./components/footer.main.php');

//echo '?pr='.base64_encode('./pages/users/form.php').'&cpid=';
//echo '?pr='.base64_encode('./pages/users/formedit.php').'&cpid=';


?>
      </div>
   </body>
</html>