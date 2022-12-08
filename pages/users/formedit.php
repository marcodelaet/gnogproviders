
<?php
$username   = null;
$password   = null;
$email      = null;
$mobile     = null;
$tid        = $_REQUEST['tid'];

if(array_key_exists('username',$_POST))
{
  $username = $_POST['username'];
  $email    = $_POST['email'];
  $mobile   = $_POST['mobile'];
}


?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/UserForm.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/userform.js" type="text/javascript"></script>

<div class='form-user-container'>
    <div class="form-container">
        <div class="form-header">Edit User</div>
        <form name='frmuser' method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="inputs-form-container">
                <div class="form-row">
                    <div class="col">
                        <label for="username">Username</label>
                        <input
                        disabled
                        name ='username' 
                        placeholder='Username'
                        title = 'username'
                        value='<?=$username?>'
                        class="form-control" 
                        type="text" 
                        maxlength="30"
                        autocomplete="username"
                        />
                        <div class="invalid-feedback">
                            Please choose a username.
                        </div>
                    </div>
                </div>
                <div class="form-row" style="margin-top:1rem">
                    <div class="col-sm-6">
                        <label for="email">E-mail</label>
                        <input
                        required
                        name ='email' 
                        placeholder='name@server.com'
                        title = 'E-mail'
                        value='<?=$email?>'
                        class="form-control" 
                        type="email" 
                        />
                        <div class="invalid-feedback">
                            Please type a valid email.
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <label for="mobile">Country</label><br/>
                        <input
                        id  = 'mobile_ddi'
                        name ='mobile_ddi' 
                        placeholder="000"
                        title = 'Country Code'
                        class="form-control" 
                        type="text" 
                        maxlength="3"
                        size="2"
                        autocomplete="phone"
                        />
                    </div>
                    <div class="col-sm-4">
                    <label for="mobile">Mobile N&ordm;</label><br/>
                        <input
                        id  = 'mobile'
                        name ='mobile' 
                        placeholder="Area Code + Number"
                        title = 'Mobile N&ordm;'
                        class="form-control" 
                        type="tel" 
                        maxlength="12"
                        
                        autocomplete="phone"
                        />
                        <div class="invalid-feedback">
                            Please type a valid mobile number.
                        </div>
                    </div>
                </div>
                <div class="form-row" style="margin-top:1rem">
                    <div class="col">
                        <label for="password">Change Password</label>
                        <input 
                        required
                        name ='password'
                        placeholder="*******"
                        title = 'Password'
                        value='<?=$password?>'
                        class="form-control" 
                        type="password" 
                        autocomplete="new-password"
                        />
                        <div class="invalid-feedback">
                            Please type a valid password
                        </div>
                    </div>
                    <div class="col">
                        <label for="retype_password">Retype Password</label>
                        <input 
                        required
                        name ='retype_password'
                        placeholder="*******"
                        title = 'Retype Password'
                        value='<?=$password?>'
                        class="form-control" 
                        type="password" 
                        autocomplete="new-password"
                        />
                        <div class="invalid-feedback">
                            Passwords must be the same
                        </div>
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <input type="hidden" name="_token" value="<?=$tid?>" />
                <button class="button" name="btnSave" type="button" onClick="handleEditSubmit('<?=$tid?>',frmuser)" >Save</button>
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


    </div>    
</div>


<?php if(array_key_exists('tid',$_REQUEST)){ ?>
<script>
    handleOnLoad("<?=$tid?>",frmuser)
</script>
<?php } ?>