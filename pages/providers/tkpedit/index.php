<?php $moduleName = 'Provider'; ?>
<link rel="stylesheet" href="<?=$dir2?>./assets/css/Recovery.css" />
<link rel="stylesheet" href="<?=$dir2?>./assets/css/Inputs.css" />
<link rel="stylesheet" href="<?=$dir2?>./assets/css/Button.css" />

<div class='tkp-<?=strtolower($moduleName)?>-container'>
    <div class="inputs-container">
        <div class='message'>
        <?=$moduleName?> updated succesfully!!
        </div>
        <div class="inputs-button-container">
            <Button class="button" type="button" onClick="window.location='?pr=<?=base64_encode('./pages/'.strtolower($moduleName).'s/index.php')?>'" >Back to the list of <?=$moduleName?>s</Button>
        </div>
    </div>    
</div>
