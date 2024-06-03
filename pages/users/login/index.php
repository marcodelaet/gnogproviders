<?php
$username = null;
$password = null;

if(array_key_exists('username',$_POST))
{
  $username = $_POST['username'];
}


?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/Login.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/login.js" type="text/javascript"></script>

    <div class='login-container'>
    <div class="inputs-container">
        <form name='login' method="post" enctype="multipart/form-data">
            <div class="inputs-inputs-container">
                <input
                name ='username' 
                placeholder='Username'
                title = 'username'
                value='<?=$username?>'
                class="inputs-input" 
                type="text" 
                autocomplete="username"
                />
                <input 
                name ='password'
                placeholder="Password"
                title = 'Password'
                value='<?=$password?>'
                class="inputs-input" 
                type="password" 
                autocomplete="current-password"
                />
            </div>
            <div class="inputs-button-container">
                <button class="button" type="button" onClick="handleLogin(login)" >Login</button>
            </div>
            <div class="recoverylink-container">
                <a class='recoverylink-link' onClick="handleRecovery();">I don't remember!</a>
            </div>
        </form>
    </div>    
  </div>
