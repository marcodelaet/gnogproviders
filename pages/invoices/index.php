<?php
$moduleName = 'Invoice';

//PRIVATE AREA
$token=true;
if($token === true) {
    $dir='';
$dir2='';
if(1==2)
{
  $dir  = '../../.';
  $dir2 = "../../../.";
}
?>
    <link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName?>.css">
    <link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
    <link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
    <script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>
    <script src="<?=$dir?>./assets/js/rate.js" type="text/javascript"></script>
    <script src="<?=$dir?>./assets/js/goal.js" type="text/javascript"></script>
    
    <div class="filter-container" style="margin-bottom:1rem;">        
        <div class="inputs-filter-container">
            <div class="form-row">
                <div class="input-group col-sm-11">
                    &nbsp;
                </div>
                <div class="input-group col-sm-1 button-with-title" style="margin-bottom:1rem;">
                    <a type="button" title="Upload <?=strtolower($moduleName)?>s files" class="btn btn-outline-primary my-2 my-sm-0" type="button" style="width:100%; text-align: center; vertical-align:middle;" onClick="location.href='?pr=<?=base64_encode('./pages/'.strtolower($moduleName).'s/formupload.php')?>'"><span class="material-icons-outlined">file_upload</span><div class="text-button">Upload</div></a>
                </div>
            </div>
            <form name='filter' method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="input-group col-sm-8">
                        &nbsp;
                    </div>
                    <div class="input-group col-sm-4">
                        <input type="search" name="search" class="form-control rounded" placeholder="<?=translateText('search');?>..." aria-label="<?=translateText('search');?>" />
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="<?=translateText('search');?>" type="button" onClick="handleListOnLoad(filter.search.value)">search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>  

    <div class='<?=strtolower($moduleName)?>-container'>
        <div class="result-container">
            <div class="row">
                <div class="col">
                    Provider Private Area
                    <table class="table table-hover table-sm">
                        <caption>Offers / Files</caption>
                        <thead>
                            <tr>
                                <th scope="col"><?=translateText('offer_campaign');?></th>
                                <th scope="col"><?=translateText('assign_executive');?></th>
                                <th scope="col"><?=translateText('amount');?></th>
                                <th scope="col"><?=translateText('month');?></th>
                                <th scope="col"><?=translateText('payed_at');?></th>
                                <th scope="col"><?=translateText('status');?></th>
                                <th scope="col" style="text-align:center;"><?=translateText('settings');?></th>
                            </tr>
                        </thead>
                        <tbody id="listDashboard">
                            <tr>
                                <td class="table-column-offerName">Disney</td>
                                <td class="table-column-AssignedExecutive">...</td>
                                <td class="table-column-Amount">...</td>
                                <td class="table-column-Month">...</td>
                                <td class="table-column-Payed-at">...</td>
                                <td class="table-column-Status">...</td>
                                <td style="text-align:center;">...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>        
        </div>
    </div>

    <script>
        updateRates();
        handleListGoalOnLoad();
        handleListOnLoad();
    </script>
<?php 

#Matriz utilizada para gerar os graficos

    

}
?>