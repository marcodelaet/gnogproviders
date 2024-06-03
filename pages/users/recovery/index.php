<?php
$username = null;
$password = null;

if(array_key_exists('username',$_POST))
{
  $username = $_POST['username'];
}

?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/Recovery.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/recovery.js" type="text/javascript"></script>

    <div class='recovery-container'>
    <div class="inputs-container">
        <form name='frmRecovery' method="post" enctype="multipart/form-data">
            <div class="inputs-inputs-container">
                <input
                name ='username' 
                placeholder='Username / E-mail'
                title = 'username'
                value='<?=$username?>'
                class="inputs-input" 
                type="text" 
                />
            </div>
            <div class="inputs-button-container">
                <Button class="button" type="button" onClick="handleRecover(frmRecovery)" >Recovery</Button>
            </div>
        </form>
    </div>    
  </div>
