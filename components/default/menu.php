<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #2774AB;">
  <a class="navbar-brand" href="#">
    <picture>
      <img src="./assets/img/logo_providers.png" class="img-fluid img-thumbnail" style="margin-top:0.51rem;margin-bottom:0.51rem;margin-left:0.91rem;margin-right:0.91rem;"/>
    </picture>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
<?php
// show icons only when logged
if(array_key_exists('tk',$_COOKIE) && (array_key_exists('uuid',$_COOKIE)) && (array_key_exists('tpu',$_COOKIE)))
{
?>
    <ul class="navbar-nav">
      <li class="nav-item" id="nav-item-payment">
        <a class="nav-link" title="<?=translateText('upload');?>" href="?pr=<?=base64_encode('./pages/invoices/index.php')?>">
          <div class="menu-option">
            <div class="menu-icon">
              <span class="material-icons-outlined" style="font-size:4rem;">cloud_upload</span>
            </div>
            <div class="menu-text">
            <?=translateText('upload');?>
            </div>
          </div>
        </a>
      </li>
      <li class="nav-item dropdown" id="nav-item-users">
        <a class="nav-link dropdown-toggle" title="Users Settings" href="?pr=<?=base64_encode('./pages/users/index.php')?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="menu-option">
            <div class="menu-icon">
              <span class="material-icons"  style="font-size:4rem;">person</span>
            </div>
            <div class="menu-text">
            Disney
            </div>
          </div>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" >
<?php if($_COOKIE['tpu'] == 'admin') { ?>
          <a class="dropdown-item" id="nav-item-users-list" title="List of Users" href="?pr=<?=base64_encode('./pages/users/index.php')?>" >
            <div class="submenu-option">
              <div class="submenu-icon">
                <span class="material-icons"  style="font-size:4rem;">people</span>
              </div>
              <div class="submenu-text">
              <?=translateText('users');?>
              </div>
            </div> 
          </a>
  <?php } ?>
          <a class="dropdown-item" title="Logout" href="?pr=<?=base64_encode('./pages/users/logout/index.php')?>">
            <div class="submenu-option">
              <div class="submenu-icon">
                <span class="material-icons"  style="font-size:4rem;">logout</span><br/>
              </div>
              <div class="submenu-text">
              <?=translateText('logout');?>
              </div>
            </div>
          </a>
        </div>
      </li>
    </ul>
<?php } ?>
  </div>

  <a class="navbar-brand" target="_blank" href="https://gnogmedia.com/">
    <picture>
      <img src="./assets/img/logo_gnog_media_y_tecnologia.svg" class="img-fluid img-thumbnail" style="background-color:#FFF; margin-top:0.51rem;margin-bottom:0.51rem;margin-left:0.91rem;margin-right:0.91rem;"/>
    </picture>
  </a>
</nav>
<?php   // echo base64_encode('./pages/maps/')?>