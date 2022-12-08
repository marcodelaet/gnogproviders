<?php
$moduleName = 'Invoice';
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header"><?=translateText('upload')?></div>
        <form name='form<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" action="http://gnogcrm.local/api/providers/auth_provider_csv_upload.php" novalidate>
            <div class="form-row">
                <div class="input-group col-sm-7">
                </div>
                <div class="input-group col-sm-3">
                    <select class="custom-select" name="month" id="month" title="Month" autocomplete="month" >
                        <option value="1"><?=translateText('january');?></option>
                        <option value="2"><?=translateText('february');?></option>
                        <option value="3"><?=translateText('march');?></option>
                        <option value="4"><?=translateText('april');?></option>
                        <option value="5"><?=translateText('may');?></option>
                        <option value="6"><?=translateText('june');?></option>
                        <option value="7"><?=translateText('july');?></option>
                        <option value="8"><?=translateText('august');?></option>
                        <option value="9"><?=translateText('september');?></option>
                        <option value="10"><?=translateText('octuber');?></option>
                        <option value="11"><?=translateText('november');?></option>
                        <option value="12"><?=translateText('december');?></option> 
                    </select>
                </div>
                <div class="input-group col-sm-2">
                    <select class="custom-select" name="year" id="year" title="Year" autocomplete="year" >
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2029">2031</option>
                        <option value="2030">2032</option>
                    </select>
                </div>
            </div>            
            <div class="form-row">
                <div class="col">
                    <label for="product"><?=translateText('product')?></label>
                    <select class="custom-select"  name="product" id="product"  title="<?=translateText('product')?>" autocomplete="product">
                    <?=inputSelect('proposalxproduct',translateText('offer').' / '.translateText('product'),'provider_id---'.$_COOKIE['pid'],null,null)?>
                    <!--<input
                    required
                    name ='product' 
                    placeholder='<?=translateText('product')?>'
                    title = '<?=translateText('product')?>'
                    value=''
                    class="form-control" 
                    type="text" 
                    maxlength="30"
                    autocomplete="product"
                    />
                    <div class="invalid-feedback">
                        Please choose a <?=translateText('product')?>.
                    </div>-->
                    </select>
                </div>
            </div>
            <div class="form-row">&nbsp;</div>
            <div class='files-section'>
                <div class="form-row">
                    <div class="input-group mb-3">
                        <div class="sub-header">
                            <b><?=translateText('files')?></b>
                        </div>
                    </div>
                </div>
                <div class="inputs-form-container">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="<?=strtolower($moduleName)?>-file-invoice" name="<?=strtolower($moduleName)?>-file-invoice" accept="" onchange="document.getElementById('<?=strtolower($moduleName)?>-file-invoice-label').innerHTML = this.value.split(/[|\/\\]+/)[2];" aria-describedby="<?=strtolower($moduleName)?>-file-invoice">
                            <label class="custom-file-label" id="<?=strtolower($moduleName)?>-file-invoice-label" for="inputGroupFile01"><?=translateText('choose')?> <?=translateText('invoice_file')?></label>
                        </div>
                    </div>
                </div>
                <div class="inputs-form-container">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="<?=strtolower($moduleName)?>-file-po" name="<?=strtolower($moduleName)?>-file-po" accept="" onchange="document.getElementById('<?=strtolower($moduleName)?>-file-po-label').innerHTML = this.value.split(/[|\/\\]+/)[2];" aria-describedby="<?=strtolower($moduleName)?>-file-po">
                            <label class="custom-file-label" id="<?=strtolower($moduleName)?>-file-po-label" for="inputGroupFile01"><?=translateText('choose')?> <?=translateText('po_file')?></label>
                        </div>
                    </div>
                </div>
                <div class="inputs-form-container">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="<?=strtolower($moduleName)?>-file-report" name="<?=strtolower($moduleName)?>-file-report" accept="" onchange="document.getElementById('<?=strtolower($moduleName)?>-file-report-label').innerHTML = this.value.split(/[|\/\\]+/)[2];" aria-describedby="<?=strtolower($moduleName)?>-file-report">
                            <label class="custom-file-label" id="<?=strtolower($moduleName)?>-file-report-label" for="inputGroupFile01"><?=translateText('choose')?> <?=translateText('report_file')?></label>
                        </div>
                    </div>
                </div>
                <div class="inputs-form-container">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="<?=strtolower($moduleName)?>-file-presentation" name="<?=strtolower($moduleName)?>-file-presentation" accept="" onchange="document.getElementById('<?=strtolower($moduleName)?>-file-presentation-label').innerHTML = this.value.split(/[|\/\\]+/)[2];" aria-describedby="<?=strtolower($moduleName)?>-file-presentation">
                            <label class="custom-file-label" id="<?=strtolower($moduleName)?>-file-presentation-label" for="inputGroupFile01"><?=translateText('choose')?> <?=translateText('presentation_file')?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">&nbsp;
                <input type="hidden" name="pid" value="<?=$_COOKIE['pid']?>"/>
                <input type="hidden" name="uid" value="<?=$_COOKIE['uuid']?>"/>
            </div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleSubmitFiles(form<?=strtolower($moduleName)?>)" ><?=translateText('upload_files')?></button>
            </div>
        </form>
    </div>    
</div>

<script type="text/javascript">
    // getting previous month and year to show on form
    const xdate   = new Date();
    const xmonth  = xdate.getMonth();
    if(xmonth == 0){
        xmonth = 12;
    }
    const xyear  = xdate.getFullYear();

    document.getElementById('month').value = xmonth;
    document.getElementById('year').value = xyear;
</script>