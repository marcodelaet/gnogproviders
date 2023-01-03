<div class="general-container">
<?php
// security

//call page
if (array_key_exists('QUERY_STRING',$_SERVER)){
  if(array_key_exists('pr',$_REQUEST)){
    $pageToGo = base64_decode($_REQUEST['pr']);
    //echo $pageToGo;
    require($pageToGo);
    //echo base64_encode('./pages/users/list.php');
  }

}



?>  
</div>