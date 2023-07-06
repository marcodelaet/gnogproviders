<?php
// security
$failDiv = '-fail';
if($d1==$d2){
  $failDiv = '';
}
?>
<div class="general-container<?=$failDiv?>">
<?php
if($d1==$d2){
  //call page
  if (array_key_exists('QUERY_STRING',$_SERVER)){
    if(array_key_exists('pr',$_REQUEST)){
      $pageToGo = base64_decode($_REQUEST['pr']);
      //echo $pageToGo;
      require($pageToGo);
      //echo base64_encode('./pages/users/list.php');
    }

  }
} else {
  ?>
  <div>
    <p class="alert-fail" Language-Tag='pt-BR'>
      <spam  style="font-weight: bolder;">Desculpe, estamos com problemas nos servidores de nosso HOST (GoDaddy)</spam><BR/>
      <spam>Ainda sem previsão para solução, mas não se preocupe, estamos em contato com o suporte técnico deles, trabalhando para solucionar o problema o mais rápido possível</spam>
    </p>

    <p class="alert-fail" Language-Tag='esp-MX'>
      <spam  style="font-weight: bolder;">Lo sentimos, estamos teniendo problemas en los servidores de nuestro HOST (GoDaddy)</spam><BR/>
      <spam>Aun sin fecha para solución, pero no te preocupes, estamos en contacto con el suporte, trabajando para solucionar el problema lo mas rapido posible</spam>
    </p>
    
    <p class="alert-fail" Language-Tag='en-US'>
      <spam  style="font-weight: bolder;">Sorry, we are having problems on our HOST server (GoDaddy Service)</spam><BR/>
      <spam>No fix date yet, but don't worry, we're in contact with their tech support, working to get the service back ASAP</spam>
    </p>
  </div>
  <?php  
}