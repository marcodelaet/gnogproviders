<link rel="stylesheet" href="<?=$dir2?>./assets/css/Recovery.css" />
<link rel="stylesheet" href="<?=$dir2?>./assets/css/Inputs.css" />
<link rel="stylesheet" href="<?=$dir2?>./assets/css/Button.css" />
<script src="<?=$dir2?>./assets/js/recovery.js" type="text/javascript"></script>

<div class='tkp-user-container'>
    <div class="inputs-container">
        <div class='message'>
            User login updated succesfully!!
        </div>
        <div class="inputs-button-container">
            <Button class="button" type="button" onClick="window.location='?pr=<?=base64_encode('./pages/users/index.php')?>'" >Back to the list of users</Button>
        </div>
    </div>    
</div>
