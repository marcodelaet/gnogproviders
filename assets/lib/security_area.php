<script type="text/javascript">
    https://providers.gnogmedia.com/?pr=Li9wYWdlcy91c2Vycy9mb3JtZWRpdC5waHA=&cpid=d53c07c9-a35f-11ed-997f-008cfa5abdac&uid=e1122c8c-a3de-11ed-997f-008cfa5abdac
<?php 
    if(array_key_exists('pr',$_GET)){ 
        if($_GET['pr'] != 'Li9wYWdlcy91c2Vycy9sb2dpbi9pbmRleC5waHA='){
            if((($_GET['pr'] == 'Li9wYWdlcy91c2Vycy9mb3JtLnBocA==') || ($_GET['pr'] == 'Li9wYWdlcy91c2Vycy9mb3JtZWRpdC5waHA=')) && (array_key_exists('cpid',$_GET))){
                // do nothing
            } else { ?>
                authenticatedToken      = localStorage.getItem('tokenGNOG');
                authenticatedUserID     = localStorage.getItem('uuid');
                if(!authenticatedToken || !authenticatedUserID)
                    window.location.href = '?pr=Li9wYWdlcy91c2Vycy9sb2dpbi9pbmRleC5waHA=';
<?php           if(!array_key_exists('uuid',$_COOKIE)){ ?>
                    window.location.href = '?pr=Li9wYWdlcy91c2Vycy9sb2dpbi9pbmRleC5waHA=';
<?php           }
            }
        }   
    }else{?>
        window.location.href = '?pr=Li9wYWdlcy91c2Vycy9sb2dpbi9pbmRleC5waHA=';
<?php 
    }
?>
</script>