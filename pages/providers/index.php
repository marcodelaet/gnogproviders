<?php
$moduleName = 'Provider';
$username   = null;
$search     = null;
$email      = null;
$mobile     = null;

?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/<?=$moduleName;?>.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">
<script src="<?=$dir?>./assets/js/<?=strtolower($moduleName)?>.js" type="text/javascript"></script>

    <div class='list-<?=strtolower($moduleName)?>-container'>
    <div class="filter-container" style="margin-bottom:1rem;">
        
        <div class="inputs-filter-container">
            <div class="form-row">
                <div class="input-group col-sm-10">
                    &nbsp;
                </div>
                <div class="input-group col-sm-1 button-with-title" style="margin-bottom:1rem;">
                    <a type="button" title="Add New" class="btn btn-outline-primary my-2 my-sm-0" type="button" style="width:100%; text-align: center; vertical-align:middle;" onClick="location.href='?pr=<?=base64_encode('./pages/'.strtolower($moduleName).'s/form.php')?>'"><span class="material-icons">add_box</span><div class="text-button">New</div></a>
                </div>
                <div class="input-group col-sm-1 button-with-title" style="margin-bottom:1rem;">
                    <a type="button" title="Import <?=strtolower($moduleName)?>s from CSV file" class="btn btn-outline-primary my-2 my-sm-0" type="button" style="width:100%; text-align: center; vertical-align:middle;" onClick="location.href='?pr=<?=base64_encode('./pages/'.strtolower($moduleName).'s/formcsv.php')?>'"><span class="material-icons-outlined">file_upload</span><div class="text-button">CSV</div></a>
                </div>
            </div>
            <form name='filter' method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="input-group col-sm-8">
                        &nbsp;
                    </div>
                    <div class="input-group col-sm-4">
                        <input type="search" name="search" class="form-control rounded" placeholder="Search..." aria-label="Search" />
                        <button class="material-icons btn btn-outline-primary my-2 my-sm-0" title="Search" type="button" onClick="handleListOnLoad(filter.search.value)">search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>  
    <div class="<?=strtolower($moduleName)?>s-list">
        <table class="table table-hover table-sm">
            <caption>List of <?=$moduleName?>s</caption>
            <thead>
                <tr>
                    <th scope="col">Provider</th>
                    <th scope="col">Webpage</th>
                    <th scope="col">&nbsp;</th>
                    <th scope="col" style="text-align:center;">Active</th>
                    <th scope="col" style="text-align:center;">Settings</th>
                </tr>
            </thead>
            <tbody id="list<?=$moduleName?>s">
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
    handleListOnLoad();
</script>


