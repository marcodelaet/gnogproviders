<script type="text/javascript">
<?php 
    if(array_key_exists('pr',$_GET)){ 
        if($_GET['pr'] != 'Li9wYWdlcy91c2Vycy9sb2dpbi9pbmRleC5waHA='){
            if(($_GET['pr'] == 'Li9wYWdlcy91c2Vycy9mb3JtLnBocA==') && (array_key_exists('cpid',$_GET))){
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