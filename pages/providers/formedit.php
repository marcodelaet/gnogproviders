<?php
$moduleName = 'Provider';
$tid        = $_REQUEST['tid'];
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

<div class='form-<?=strtolower($moduleName)?>-container'>
    <div class="form-container">
        <div class="form-header">Edit <?=$moduleName?></div>
        <form name='<?=strtolower($moduleName)?>' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row">
                    <div class="col">
                        <label for="name">Name</label>
                        <input
                        required
                        name ='name' 
                        placeholder='Name'
                        title = 'name'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="40"
                        autocomplete="provider_name"
                        />
                        <div class="invalid-feedback">
                            Please type the Corporate name
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <label for="name">Webpage</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                        </div>
                        <input
                        required
                        name ='webpage_url' 
                        placeholder='Type the URL here'
                        title = 'webpage_url'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="200"
                        autocomplete="webpage_url"
                        />
                        <div class="invalid-feedback">
                            Please type the Corporate name
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="address">Address</label>
                        <textarea
                        required
                        name ='address' 
                        placeholder='99, Address - City - Country - Postal Code'
                        title = 'address'
                        value=''
                        class="form-control"  
                        autocomplete="address"
                        ></textarea>
                        <div class="invalid-feedback">
                            Please type the Address of the <?=$moduleName?>
                        </div>
                    </div>
                </div>
                <div class="form-row main-contact-section">
                    <div class="col">
                        <div class="form-row" >
                            <div class="col main-contact-header">
                                Main Contact
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="col">
                                <label for="main_contact_name">Contact Name</label>
                                <input
                                required
                                name ='main_contact_name' 
                                placeholder='Name of main contact'
                                title = 'Name of main contact'
                                value=''
                                class="form-control" 
                                type="name" 
                                />
                                <div class="invalid-feedback">
                                    Please type the name of main contact.
                                </div>
                            </div>
                            <div class="col">
                                <label for="main_contact_surname">Last name</label>
                                <input
                                required
                                name ='main_contact_surname' 
                                placeholder='Last name of main contact'
                                title = 'Last name of main contact'
                                value=''
                                class="form-control" 
                                type="surname" 
                                />
                                <div class="invalid-feedback">
                                    Please type the last name of main contact.
                                </div>
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="col">
                                <label for="main_contact_email">E-mail</label>
                                <input
                                required
                                name ='main_contact_email' 
                                placeholder='name@server.com'
                                title = 'E-mail'
                                value=''
                                class="form-control" 
                                type="email" 
                                />
                                <div class="invalid-feedback">
                                    Please type a valid email.
                                </div>
                            </div>
                            <div class="col">
                                <label for="phone">Phone N&ordm;</label><br/>
                                <input
                                id='phone'
                                name ='phone' 
                                placeholder="Area Code + Number"
                                title = 'Phone N&ordm;'
                                value=''
                                class="form-control" 
                                type="tel" 
                                maxlength="12"
                                pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}"
                                autocomplete="phone"
                                />
                                <div class="invalid-feedback">
                                    Please type a valid phone number.
                                </div>
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="col">
                                <label for="main_contact_position">Position</label>
                                <input
                                required
                                name ='main_contact_position' 
                                placeholder='Position of the main contact'
                                title = 'Position'
                                value=''
                                class="form-control" 
                                type="position" 
                                />
                                <div class="invalid-feedback">
                                    Please type the position / role of the main contact.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row product-section">
                    <div class="col">
                        <div class="form-row" >
                            <div class="col product-header">
                                Product
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="col">
                                <label for="product_id">Product</label>
                                <spam id="sproduct">
                                    <select name="product_id" id="selectproduct" title="product_id" class="form-control" autocomplete="product_id" required>
                                        <?=inputSelect('product','Product','','name','');?>
                                    </select>
                                </spam>

                                
                                <div class="invalid-feedback">
                                    Please choose a product for the Provider.
                                </div>
                            </div>
                            <div class="col">
                                <label for="product_price">Product Price</label>
                                <input
                                required
                                name ='product_price' 
                                placeholder='0,00'
                                title = 'Product Price'
                                value=''
                                class="form-control" 
                                type="currency" 
                                autocomplete="price"
                                />
                                <div class="invalid-feedback">
                                    Please type the price for each product.
                                </div>
                            </div>
                            <div class="col-2">
                                <label for="currency">&nbsp;</label>
                                <select
                                required
                                name ='currency' 
                                title = 'Currency'
                                class="form-control"
                                autocomplete="currency">
                                    <option value="MXN">MXN</option>
                                    <option value="USD">USD</option>
                                    <option value="BRL">BRL</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please type the price for each product.
                                </div>
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="col">
                                <label for="salemodel_id">Sale Model</label>
                                <spam id="ssalemodel">
                                    <select name="salemodel_id" id="selectsalemodel" title="salemodel_id" class="form-control" autocomplete="salemodel_id" required>
                                        <?=inputSelect('salemodel','Sale model','','name','')?>
                                    </select>
                                </spam>
                                <div class="invalid-feedback">
                                    Please choose a sale model.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleEditSubmit('<?=$tid?>',<?=strtolower($moduleName)?>)" >Save</button>
            </div>
        </form>
      <?php
      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $myIP     = $ip;
    //$region   = geoip_country_code_by_name($myIP);
    // echo "IP: ".$myIP."<BR/>Region: ".$region;
 ?>


<?php if(array_key_exists('tid',$_REQUEST)){ ?>
<script>
    handleOnLoad("<?=$tid?>",<?=strtolower($moduleName)?>)
</script>
<?php } ?>