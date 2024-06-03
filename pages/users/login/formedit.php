
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
        <div class="form-header">Change Password / Cambiar contraseña</div>
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
                    <div class="col">
                        <label for="email">E-mail</label>
                        <input
                        disabled
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
                </div>
                <div class="form-row" style="margin-top:1rem">
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="password-label">Change Password</span>
                            </div>
                            <input 
                            required
                            name ='password'
                            id='password1'
                            placeholder="*******"
                            title = 'Password'
                            value='<?=$password?>'
                            class="form-control" 
                            type="password" 
                            autocomplete="new-password"
                            />
                            <div class="input-group-prepend">
                                <img id="olho1" onmousedown="changeView('password1',document.getElementById('password1').type);" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABDUlEQVQ4jd2SvW3DMBBGbwQVKlyo4BGC4FKFS4+TATKCNxAggkeoSpHSRQbwAB7AA7hQoUKFLH6E2qQQHfgHdpo0yQHX8T3exyPR/ytlQ8kOhgV7FvSx9+xglA3lM3DBgh0LPn/onbJhcQ0bv2SHlgVgQa/suFHVkCg7bm5gzB2OyvjlDFdDcoa19etZMN8Qp7oUDPEM2KFV1ZAQO2zPMBERO7Ra4JQNpRa4K4FDS0R0IdneCbQLb4/zh/c7QdH4NL40tPXrovFpjHQr6PJ6yr5hQV80PiUiIm1OKxZ0LICS8TWvpyyOf2DBQQtcXk8Zi3+JcKfNafVsjZ0WfGgJlZZQxZjdwzX+ykf6u/UF0Fwo5Apfcq8AAAAASUVORK5CYII="/>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="password-retype-label">Retype Password</span>
                            </div>
                            <input 
                            required
                            name ='retype_password'
                            id='password2'
                            placeholder="*******"
                            title = 'Retype Password'
                            value='<?=$password?>'
                            class="form-control" 
                            type="password" 
                            autocomplete="new-password"
                            />
                            <div class="input-group-prepend">
                                <img id="olho2" onmousedown="changeView('password2',document.getElementById('password2').type);" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABDUlEQVQ4jd2SvW3DMBBGbwQVKlyo4BGC4FKFS4+TATKCNxAggkeoSpHSRQbwAB7AA7hQoUKFLH6E2qQQHfgHdpo0yQHX8T3exyPR/ytlQ8kOhgV7FvSx9+xglA3lM3DBgh0LPn/onbJhcQ0bv2SHlgVgQa/suFHVkCg7bm5gzB2OyvjlDFdDcoa19etZMN8Qp7oUDPEM2KFV1ZAQO2zPMBERO7Ra4JQNpRa4K4FDS0R0IdneCbQLb4/zh/c7QdH4NL40tPXrovFpjHQr6PJ6yr5hQV80PiUiIm1OKxZ0LICS8TWvpyyOf2DBQQtcXk8Zi3+JcKfNafVsjZ0WfGgJlZZQxZjdwzX+ykf6u/UF0Fwo5Apfcq8AAAAASUVORK5CYII="/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inputs-button-container">
                <input type="hidden" name="_token" value="<?=$tid?>" />
                <button class="button" name="btnSave" type="button" onClick="handleEditLoginSubmit('<?=$tid?>',frmuser)" >Save changes</button>
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
    handleEditLoginOnLoad("<?=$tid?>",frmuser)
</script>
<?php } ?>