<script>

</script>

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
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?=translateText('invoice')?></span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="<?=strtolower($moduleName)?>-file-invoice" name="<?=strtolower($moduleName)?>-file-invoice" accept=".xls,.xlsx,.xml" onchange="document.getElementById('<?=strtolower($moduleName)?>-file-invoice-label').innerHTML = this.value.split(/[|\/\\]+/)[2];" aria-describedby="<?=strtolower($moduleName)?>-file-invoice">
                            <label class="custom-file-label" id="<?=strtolower($moduleName)?>-file-invoice-label" for="<?=strtolower($moduleName)?>-file-invoice"><?=translateText('choose')?> <?=translateText('invoice_file')?></label>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?=translateText('xml')?></span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="<?=strtolower($moduleName)?>-file-xml" name="<?=strtolower($moduleName)?>-file-xml" accept=".xml" onchange="document.getElementById('<?=strtolower($moduleName)?>-file-xml-label').innerHTML = this.value.split(/[|\/\\]+/)[2]; xmlobj=xmlReader(form<?=strtolower($moduleName)?>,this.name); form<?=strtolower($moduleName)?>.currency.value=xmlobj.attributes.Moneda; form<?=strtolower($moduleName)?>.invoice_value.value=xmlobj.attributes.Total; form<?=strtolower($moduleName)?>.invoice_value.setAttribute('readonly',true); form<?=strtolower($moduleName)?>.currency.setAttribute('readonly',true); form<?=strtolower($moduleName)?>.invoice_number.value=xmlobj.attributes.Serie +'-'+xmlobj.attributes.Folio; form<?=strtolower($moduleName)?>.invoice_number.setAttribute('readonly',true);" aria-describedby="<?=strtolower($moduleName)?>-file-xml">
                            <label class="custom-file-label" id="<?=strtolower($moduleName)?>-file-xml-label" for="<?=strtolower($moduleName)?>-file-xml"><?=translateText('choose')?> <?=translateText('xml_file')?></label>
                        </div>
                    </div>
                </div>  
                <div class="inputs-form-container">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?=translateText('currency')?></span>
                        </div>
                        <select
                        required
                        name ='currency' 
                        title = '<?=translateText('currency');?>'
                        class="form-control"
                        autocomplete="currency"
                        onchange="if(this.value=='BRL'){document.getElementById('currency-symbol').innerText='R$';} else {document.getElementById('currency-symbol').innerText='$';}">
                            <option value="MXN">MXN</option>
                            <option value="USD">USD</option>
                            <option value="BRL">BRL</option>
                        </select> &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="currency-symbol">$</span>
                                <span class="input-group-text">0.00</span>
                            </div>
                            <input type='currency' class="form-control" placeholder="Monto de la factura" name="invoice_value" id="invoice_value"  title="Monto de la Factura" autocomplete="invoice_value" onkeypress="$(this).mask('#,###,##0.00', {reverse: true});"/>
                        <div class="col-4">
                            <!--<label for="invoice_number">Numero de la factura</label>-->
                            <input type='text' class="form-control" placeholder="<?=translateText('invoice_number')?>" name="invoice_number" id="invoice_number"  title="Numero de la factura" autocomplete="invoice_number" />
                        </div>
                    </div>
                </div>
                <div class="inputs-form-container">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?=translateText('po')?></span>
                        </div>
                        <div class="col">                            
                            <input type="file" class="custom-file-input" id="<?=strtolower($moduleName)?>-file-po" name="<?=strtolower($moduleName)?>-file-po" accept=".xls,.xlsx,.xml" onchange="document.getElementById('<?=strtolower($moduleName)?>-file-po-label').innerHTML = this.value.split(/[|\/\\]+/)[2];" aria-describedby="<?=strtolower($moduleName)?>-file-po">
                            <label class="custom-file-label" id="<?=strtolower($moduleName)?>-file-po-label" for="<?=strtolower($moduleName)?>-file-po"><?=translateText('choose')?> <?=translateText('po_file')?></label>
                        </div>
                        <div class="col-4">
                        <!--<label for="invoice_number">Numero de la ordem de cuempra</label>-->
                        <input type='text' class="form-control" placeholder="<?=translateText('po_number')?>" name="po_number" id="po_number"  title="Numero de la ordem de cuempra" autocomplete="po_number" />
                    </div>
                    </div>

                </div>
                <div class="inputs-form-container">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?=translateText('report')?></span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="<?=strtolower($moduleName)?>-file-report" name="<?=strtolower($moduleName)?>-file-report" accept=".xls,.xlsx,.xml" onchange="document.getElementById('<?=strtolower($moduleName)?>-file-report-label').innerHTML = this.value.split(/[|\/\\]+/)[2];" aria-describedby="<?=strtolower($moduleName)?>-file-report">
                            <label class="custom-file-label" id="<?=strtolower($moduleName)?>-file-report-label" for="<?=strtolower($moduleName)?>-file-report"><?=translateText('choose')?> <?=translateText('report_file')?></label>
                        </div>
                    </div>
                </div>
                <div class="inputs-form-container">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?=translateText('presentation')?></span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="<?=strtolower($moduleName)?>-file-presentation" name="<?=strtolower($moduleName)?>-file-presentation" accept=".doc,.docx,.xls,.xlsx,.pdf,.ppt,.pptx" onchange="document.getElementById('<?=strtolower($moduleName)?>-file-presentation-label').innerHTML = this.value.split(/[|\/\\]+/)[2];" aria-describedby="<?=strtolower($moduleName)?>-file-presentation">
                            <label class="custom-file-label" id="<?=strtolower($moduleName)?>-file-presentation-label" for="<?=strtolower($moduleName)?>-file-presentation"><?=translateText('choose')?> <?=translateText('presentation_file')?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">&nbsp;
                <input type="hidden" name="pid" value="<?=$_COOKIE['pid']?>"/>
                <input type="hidden" name="uid" value="<?=$_COOKIE['uuid']?>"/>
                <input type="hidden" name="authApi" />
                <input type="hidden" name="usrTk" />
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