<?php $moduleName = 'Provider'; ?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>
<?php if(array_key_exists('tid',$_REQUEST)){ ?>
<script>
    handleViewOnLoad("<?=$_REQUEST['tid']?>")
</script>
<?php } ?>
<div class="card bg-light mb-3" id="<?=strtolower($moduleName)?>-card">
    <div class="card-header">
        <div class="<?=strtolower($moduleName)?>-header">
            <div class="photo-container" >
                <img class="<?=strtolower($moduleName)?>-photo" id="<?=strtolower($moduleName)?>-proto-<?=$_REQUEST['tid']?>" src="/public/<?=strtolower($moduleName)?>/images/logo_example.png" style="background-color:#FFF"/>
            </div>
            <div class="<?=strtolower($moduleName)?>-main" >
                <spam id="<?=strtolower($moduleName)?>_name"><?=$moduleName?></spam>
                <spam class="<?=strtolower($moduleName)?>-group" id="group"></spam>
            </div>
        </div>
    </div>
    <div class="card-body <?=strtolower($moduleName)?>-body">
        <!--***************************************
        ****** Contact Section *******************-->
        <h5 class="card-title main-contact-header">Contact</h5>
        <div class="<?=strtolower($moduleName)?>-data">
            <spam id="card-contact-fullname">aaaaaa bbbbbb da xxxx </spam><spam id="card-contact-position"> (zzzzz)</spam>
        </div>
        <div class="<?=strtolower($moduleName)?>-data">
        <div class="<?=strtolower($moduleName)?>-data">
            <spam class="material-icons icon-data">location_on</spam>
            <spam id="card-address">99, example, street</spam>
        </div>
        </div>
        <div class="<?=strtolower($moduleName)?>-data">
            <spam class="material-icons icon-data">email</spam>
            <spam id="card-email">email@dma.com</spam>
        </div>
        <div class="<?=strtolower($moduleName)?>-data">
            <spam class="material-icons icon-data">phone</spam>
            <spam id="card-phone">+5255999999</spam>
        </div>
        <!--***************************************
        ****** Products Section *******************-->
        <h5 class="card-title main-contact-header" style="margin-top:2rem;">Product</h5>
        <div class="<?=strtolower($moduleName)?>-data">
            <spam id="card-product">aaaaaa bbbbbb da xxxx </spam> - <spam id="card-product-price"> $$$</spam>
        </div>    
        <div class="<?=strtolower($moduleName)?>-data">
            <spam id="card-salemodel">xxxx</spam>
        </div>
        <div class="inputs-button-container">
            <Button class="button" type="button" onClick="window.location='?pr=<?=base64_encode('./pages/'.strtolower($moduleName).'s/index.php')?>'" >Back to <?=$moduleName?>s</Button>
        </div>
    </div>
</div>
