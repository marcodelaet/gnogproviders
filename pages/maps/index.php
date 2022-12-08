<?php
$proposalproduct_id = 0;
if(array_key_exists('pppid',$_REQUEST)){
    $proposalproduct_id = $_REQUEST['pppid'];
}
?>
<link rel="stylesheet" href="<?=$dir?>./assets/css/map.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Inputs.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/RecoveryLink.css">
<link rel="stylesheet" href="<?=$dir?>./assets/css/Button.css">

<div class='list-map-container'>
    <div class="cart-session">
        <span class="material-symbols-outlined cart-item">shopping_bag</span>
        <span id="units-on-cart" class="cart-item"></span>
    </div>
    <!--The div element for the map -->
    <input id="searchTextField" type="text" size="50" placeholder="Buscar en el Google Maps!" ><button type="button" onclick="searchLocation()" >Buscar</button>
    <div id="map" ></div>
</div>

<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAh0CRvF_GoQflq2OxsMeAk7GRN5ljY5fA&libraries=places&callback=initMap&v=weekly" defer>
</script>
<script >
    updateUnitsOnCart('<?=$proposalproduct_id?>');
</script>
