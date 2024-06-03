<?php
$username = null;
$password = null;
$email    = null;
$phone   = null;

if(array_key_exists('cpid',$_REQUEST)){
    $cpid    = $_REQUEST['cpid'];
}

?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/UserForm.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/userform.js" type="text/javascript"></script>

<div class='form-user-container'>
    <div class="form-container">
        <div class="form-header"><?=translateText('new')?> <?=translateText('user')?> - <span id="provider-name"></span> <span id="contact-data"></span></div>
        <form name='frmuser' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row">
                    <div class="col">
                        <label for="username"><?=translateText('username')?></label>
                        <input
                        required
                        name ='username' 
                        placeholder='<?=translateText('username')?>'
                        title = '<?=translateText('username')?>'
                        value=''
                        class="form-control" 
                        type="text" 
                        maxlength="30"
                        autocomplete="username"
                        />
                        <div class="invalid-feedback">
                            Please choose a <?=translateText('username')?>.
                        </div>
                    </div>
                </div>
                <div class="form-row" style="margin-top:1rem">
                    <div class="col">
                        <label for="email"><?=translateText('email')?></label>
                        <input
                        required
                        name ='email' 
                        placeholder='name@server.com'
                        title = '<?=translateText('email')?>'
                        value='<?=$email?>'
                        class="form-control" 
                        type="email" 
                        readonly
                        />
                        <div class="invalid-feedback">
                            Please type a valid <?=translateText('email')?>.
                        </div>
                    </div>
                    <div class="col">
                        <label for="phone"><?=translateText('phone_number')?> (Mobile)</label><br/>
                        <input
                        id  = 'phone'
                        name ='phone' 
                        placeholder="<?=translateText('areacode')?> + <?=translateText('number')?>"
                        title = '<?=translateText('phone_number')?>'
                        value=''
                        class="form-control" 
                        type="tel" 
                        maxlength="12"
                        pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}"
                        autocomplete="phone"
                        />
                        <div class="invalid-feedback">
                            Please type a valid <?=translateText('phone_number')?>.
                        </div>
                    </div>
                </div>
                <div class="form-row" style="margin-top:1rem">
                    <div class="col">
                        <label for="password"><?=translateText('password')?></label>
                        <input 
                        required
                        name ='password'
                        placeholder="*******"
                        title = '<?=translateText('password')?>'
                        value='<?=$password?>'
                        class="form-control" 
                        type="password" 
                        autocomplete="new-password"
                        />
                        <div class="invalid-feedback">
                            Please type a valid <?=translateText('password')?>
                        </div>
                    </div>
                    <div class="col">
                        <label for="retype_password"><?=translateText('retype')?> <?=translateText('password')?></label>
                        <input 
                        required
                        name ='retype_password'
                        placeholder="*******"
                        title = '<?=translateText('retype')?> <?=translateText('password')?>'
                        value='<?=$password?>'
                        class="form-control" 
                        type="password" 
                        autocomplete="new-password"
                        />
                        <div class="invalid-feedback">
                        <?=translateText('password')?>s must be the same
                        </div>
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <button class="button" name="btnSave" type="button" onClick="handleSubmit(frmuser)" ><?=translateText('save')?></button>
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

<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
      // allowDropdown: false,
      // autoHideDialCode: false,
      // autoPlaceholder: "off",
      // dropdownContainer: document.body,
      // excludeCountries: ["us"],
      // formatOnDisplay: false,
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
      // hiddenInput: "full_number",
      initialCountry: "mx",
      // localizedCountries: { 'de': 'Deutschland' },
      // nationalMode: false,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      // placeholderNumberType: "MOBILE",
       preferredCountries: ['mx', 'br', 'us'],
      // separateDialCode: true,
      utilsScript: "/assets/js/build/utils.js",
    });/*
$("input").intlTelInput({
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
  });*/
</script>
    </div>    
</div>

<?php if(array_key_exists('cpid',$_REQUEST)){ ?>
<script>
    handleOnLoad("<?=$cpid?>",frmuser)
</script>
<?php } ?>
