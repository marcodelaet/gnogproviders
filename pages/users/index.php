<?php
$username   = null;
$search     = null;
$email      = null;
$mobile     = null;

if(array_key_exists('username',$_POST))
{
  $username = $_POST['username'];
  $email    = $_POST['email'];
  $mobile   = $_POST['mobile'];
  $search   = $_POST['search'];
}

?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/UserList.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/userlist.js" type="text/javascript"></script>

    <div class='list-user-container'>
    <div class="filter-container" style="margin-bottom:1rem;">
        
        <div class="inputs-filter-container">
            <div class="form-row">
                <div class="input-group col-sm-10">
                    &nbsp;
                </div>
                <div class="input-group col-sm-1 " style="margin-bottom:1rem;">
                    <a type="button" title="Goals" class="btn btn-outline-primary my-2 my-sm-0" style="width:100%; text-align: center; vertical-align:middle;" onClick="location.href='?pr=<?=base64_encode('./pages/users/goal/form.php')?>'"><span class="material-icons">flag</span><div class="text-button">Goals</div></a>
                </div>
                <div class="input-group col-sm-1 " style="margin-bottom:1rem;">
                    <a type="button" title="Add New" class="btn btn-outline-primary my-2 my-sm-0" style="width:100%; text-align: center; vertical-align:middle;" onClick="location.href='?pr=<?=base64_encode('./pages/users/form.php')?>'"><span class="material-icons">add_box</span><div class="text-button">New</div></a>
                </div>
            </div>
            <form name='filter' method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="input-group col-sm-8">
                        &nbsp;
                    </div>
                    <div class="input-group col-sm-4">
                        <input type="search" name="search" class="form-control rounded" placeholder="Search..." aria-label="Search" />
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="Search" type="button" onClick="handleOnLoad(filter.search.value)">search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>  
    <div class="users-list">
        <table class="table table-hover table-sm">
            <caption>List of users</caption>
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Mobile</th>
                    <th scope="col" style="text-align:center;">Active</th>
                    <th scope="col" style="text-align:center;">Settings</th>
                </tr>
            </thead>
            <tbody id="listUsers">
                <tr>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td style="text-align:center;">...</td>
                    <td style="text-align:center;">...</td>
                </tr>
            </tbody>
        </table>
    </div>  
</div>
<script>
    handleOnLoad();
</script>


