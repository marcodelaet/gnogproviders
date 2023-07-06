<?php
// running database settings
require_once('./database/.config');

// const
$PUBLIC_URL = "./public";


//only for internal pages
$dir='';
$dir2='';
if(1==2)
{
  $dir  = '../../.';
  $dir2 = "../../../.";
}

$LOCALSERVER  = explode(".",$_SERVER['HTTP_HOST'])[2];
$SUBDOMAIN    = explode(".",$_SERVER['HTTP_HOST'])[0];
?>