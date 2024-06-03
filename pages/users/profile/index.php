<link rel="stylesheet" href="<?=$dir?>./assets/css/Profile.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/profile.js" type="text/javascript"></script>
<script src="<?=$dir?>./assets/js/goal.js" type="text/javascript"></script>
<?php if(array_key_exists('tid',$_REQUEST)){ ?>
<script>
    const tid = "<?=$_REQUEST['tid']?>";
    handleProfileOnLoad(tid);
    handleUserGoalOnLoad(tid);
</script>
<?php } ?>
<div class="card bg-light mb-3 profile-card">
    <div class="card-header">
        <div class="profile-header">
            <div class="photo-container" >
                <img class="profile-photo" id="profile-proto-<?=$_REQUEST['tid']?>" src="/public/profile/images/person.svg" style="background-color:#FFF"/>
            </div>
            <div class="profile-main" >
                <spam class="profile-username" id="username">Username</spam>
                <spam class="profile-group" id="group">[Group]</spam>
            </div>
        </div>
    </div>
    <div class="card-body profile-body">
        <h5 class="card-title profile-full-name">[Missing Full Name]</h5>
        <div class="profile-data">
            <spam class="material-icons icon-data">flag</spam>
            <spam id="goal-amount">(No goal</spam> on <spam id="year-selected">now)</spam>
        </div>
        <div class="profile-data">
            <spam class="material-icons icon-data">email</spam>
            <spam id="card-email">email@dma.com</spam>
        </div>
        <div class="profile-data">
            <spam class="material-icons icon-data">phone</spam>
            <spam id="card-phone">+525599999999</spam></div>
        <div class="inputs-button-container">
            <Button class="button" type="button" onClick="window.location='?pr=<?=base64_encode('./pages/users/index.php')?>'" >Back to the list of users</Button>
        </div>
    </div>
</div>
