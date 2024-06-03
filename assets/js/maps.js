var csrf_token = $('meta[name="csrf-token"]').attr('content');
var x=document.getElementById("demo");
var unitsOnCart = 0;


var map;
var service;
var infowindowSearch;
var myLatLng;
var marker;
var markers;
var markerCluster;

//const input = document.getElementById("pac-input");



function getLocation()
{
    if (navigator.geolocation)
    {
      //navigator.geolocation.getCurrentPosition(showPosition);
    }
    else{x.innerHTML="O seu navegador não suporta Geolocalização.";}
}
function showPosition(position)
{
    latit = position.coords.latitude; 
    longit = position.coords.longitude;
}
getLocation();
  
function searchLocation(){
    var input = document.getElementById('searchTextField');
    //alert(input.value);
    // Services
    map = new google.maps.Map(
        document.getElementById('map'), {center: myLatLng, zoom: 15});
  
    infowindowSearch = new google.maps.InfoWindow();

    var requestMap = {
        query: input.value,
        fields: ['icon' ,'geometry', 'name'],
    };

    var service = new google.maps.places.PlacesService(map);
    //service.textSearch(requestMap, function);
    service.findPlaceFromQuery(requestMap, function(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
        }
        map.setCenter(results[0].geometry.location);
        }
    });

    markerCluster = new markerClusterer.MarkerClusterer({map, markers});
      
}
  //alert('lat:'+latit+'\nlong:'+longit);
// Initialize and add the map
function theMap(salemodel_id, state, pppid) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    xpppid      = '';
    if(typeof(pppid) != 'undefined'){
        xpppid  = '&pppid='+pppid;
    }
  
    filters     = '';
    if(typeof salemodel_id == 'undefined')
      salemodel_id  = '';
    if(salemodel_id !== ''){
        if(filters == '')
            filters = '&where=';
        else
            filters += '***';
        filters     += 'salemodel_id|||'+salemodel_id;
    }

    if(typeof state == 'undefined')
      state  = '';
    if(state !== ''){
        if(filters == '')
            filters = '&where=';
        else
            filters += '***';
        filters     += 'state|||'+state;
    }

    order       = '&orderby=coordenates';

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
      
    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/billboards/auth_billboard_view.php?auth_api='+authApi+'&allRows=1'+xpppid+filters+order;
        console.log(requestURL);
          
        const request   = new XMLHttpRequest();
        request.onreadystatechange = function() {
        //  alert('oi');
         // alert(this.status + ' \n ' + this.readyState);
            if (this.readyState == 4 && this.status == 200) {
                obj = JSON.parse(request.responseText);
                
                if(obj['response'] == 'OK'){
                  
                    // Create our number formatter.
                    var formatter = new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'MXN',
                        //maximumSignificantDigits: 2,

                        // These options are needed to round to whole numbers if that's what you want.
                        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                    });

                    // The location of Uluru
                    const myLatLng = { lat: parseFloat(obj['data'][0].latitud), lng: parseFloat(obj['data'][0].longitud) };
                    //var centeredLocal = new google.maps.LatLng(parseFloat(obj['data'][0].latitud), parseFloat(obj['data'][0].longitud));

                    // map options
                    const mapOptions = {
                        zoom: 6,
                        center: myLatLng
                    };

                    // Services
                    var requestMap = {
                        query: 'restaurante',
                        fields: ['places'],
                      };
                    
                    // Create a bounding box with sides ~10km away from the center point
                    const defaultBounds = {
                        north: myLatLng.lat + 0.1,
                        south: myLatLng.lat - 0.1,
                        east: myLatLng.lng + 0.1,
                        west: myLatLng.lng - 0.1,
                    };
                    //const input = document.getElementById("pac-input");
                    var input = document.getElementById('searchTextField');

                    var searchBox = new google.maps.places.SearchBox(input, {
                    bounds: defaultBounds
                    });

                    const options = {
                        bounds: defaultBounds,
                        componentRestrictions: { country: "mx" },
                        fields: ["address_components", "geometry", "icon", "name"],
                        strictBounds: false,
                        types: ["establishment"],
                    };
                    const autocomplete = new google.maps.places.Autocomplete(input, options);

                    // Listen for the event fired when the user selects a prediction and retrieve
                    // more details for that place.
                    searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    // Clear out the old markers.
                    markers.forEach((marker) => {
                        marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    const bounds = new google.maps.LatLngBounds();

                    places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                        }

                        const icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25),
                        };

                        // Create a marker for each place.
                        markers.push(
                        new google.maps.Marker({
                            map,
                            icon,
                            title: place.name,
                            position: place.geometry.location,
                        })
                        );
                        if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                        } else {
                        bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                    });

                    

                    // The map, centered 
                    const map = new google.maps.Map(document.getElementById("map"), mapOptions);

                    // calculo valor total comissão = total / margem_requerida

                    const image = "/public/billboards/utils/cartelera.png";
                    
                    labels          = [];
                    const locations = [];
                    previousCoordenate  = 0;
                    previousName        = '';
                    countIqualsMultipl  = 1;
                    for(dt=0; dt < obj['data'].length;dt++){
                        // JPG
                        baseUrl     = '/public/billboards/';
                        photo_url   = 'img/' + obj['data'][dt].name+'.jpg.jpg';
                        dimension   = parseFloat(obj['data'][dt].height).toFixed(1) + ' x ' + parseFloat(obj['data'][dt].width).toFixed(1);
                        if(doesFileExist(baseUrl+photo_url) === false){
                            // JPEG
                            photo_url   = 'img/' + obj['data'][dt].name+".jpg.jpeg";
                            if(doesFileExist(baseUrl+photo_url) === false){
                                // PNG
                                photo_url   = 'img/' + obj['data'][dt].name+".jpg.png";
                                if(doesFileExist(baseUrl+photo_url) === false){
                                    // JPG VARIATION N
                                    photo_url   = 'img/' + obj['data'][dt].name+"N.jpg.jpg";
                                    if(doesFileExist(baseUrl+photo_url) === false){
                                        // JPG VARIATION (1)
                                        photo_url   = 'img/' + obj['data'][dt].name+".jpg (1).jpg";
                                        if(doesFileExist(baseUrl+photo_url) === false){
                                            // JPG VARIATION (2)
                                            photo_url   = 'img/' + obj['data'][dt].name+".jpg (2).jpg";
                                            if(doesFileExist(baseUrl+photo_url) === false){
                                                // JPG VARIATION C
                                                photo_url   = 'img/' + obj['data'][dt].name+"C.jpg.jpg";
                                                if(doesFileExist(baseUrl+photo_url) === false){
                                                    // JPG VARIATION JPG
                                                    photo_url   = 'img/' + obj['data'][dt].name+".JPG.jpg";
                                                    if(doesFileExist(baseUrl+photo_url) === false){
                                                        // NOT FOUND
                                                        photo_url   = 'utils/sinImagen.png';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        xname = obj['data'][dt].name;

                        //console.log('\nname: '+obj['data'][dt].name+'\nprevious: '+previousCoordenate + '\ncoord: ' + obj['data'][dt].coordenates);
                        if(obj['data'][dt].coordenates == previousCoordenate){
                            countIqualsMultipl++;
                            //console.log('igual');
                            xname += " / " + previousName;
                        } else {
                            previousCoordenate  = obj['data'][dt].coordenates;
                            previousName        = obj['data'][dt].name;
                            descriptionLocation = '';
                            countIqualsMultipl  = 1;
                            //console.log('diferente');
                        }

                        widthFull           = 96;
                        widthDescription    = widthFull / countIqualsMultipl;
                        withSubstitution    = widthFull / countIqualsMultipl; 
                        if(countIqualsMultipl > 1){
                            for(ctn=countIqualsMultipl; ctn > 1;ctn--){
                                withSubstitution    = widthFull / (ctn - 1);
                            }
                            intervalBetween     = 4 - (countIqualsMultipl - 1);
                            descriptionLocation = descriptionLocation.replace("width:"+withSubstitution+"%", "width:"+widthDescription+"%");
                            descriptionLocation += "<div style='width:"+intervalBetween+"%'>&nbsp;&nbsp;</div>";
                            labels.pop();
                            locations.pop();
                            //console.log('iguais: '+countIqualsMultipl);
                        }

                        //console.log('multipl: ' + countIqualsMultipl + '\nwidth: ' + widthDescription + '\nSubst: ' + withSubstitution);

                        descriptionLocation += '<div id="content" style="width:'+widthDescription+'%">' +
                        '<div id="siteNotice">' +
                        "</div>" +
                        '<h1 id="firstHeading" class="firstHeading">'+obj['data'][dt].name+'</h1>' +
                        '<div id="bodyContent">' +
                        '<p><img id="field-image-photo" src="'+baseUrl+photo_url+'" height="100" class="view-photo"/></p>' +
                        '<p><b>Dirección: </b><br/>'+obj['data'][dt].address+' </p>' +
                        '<p><b>Modelo de Venta: </b><br/>'+obj['data'][dt].salemodel_name+' </p> ' +
                        '<p><b>Visualización: </b><br/>'+obj['data'][dt].viewpoint_name+' </p> ' +                          
                        '<p><b>Dimensión: </b><br/>'+dimension+' </p> ' +
                        '<p><b>Proveedor: </b><br/>'+obj['data'][dt].provider_name+' </p> ' +
                        '<p><b>Costo: </b><br/>'+formatter.format(parseFloat(obj['data'][dt].cost/100))+' </p> ' +

                        '<Button class="btn btn-lg btn-primary btn-lg btn-block" type="button" id="add-'+obj['data'][dt].uuid_full+'-button" onClick="addBillboardOnList(\''+obj['data'][dt].uuid_full+'\',\''+pppid+'\','+obj['data'][dt].cost_int+',\''+obj['data'][dt].provider_id+'\')" >Add => Propuesta</Button>' +
                        '</div> ' +
                        '</div> ';
                        //console.log('descript: '+descriptionLocation);

                        labels.push(xname);
                        locations.push(
                            {
                            lat: parseFloat(obj['data'][dt].latitud), 
                            lng: parseFloat(obj['data'][dt].longitud), 
                            description: '<div class="md-12" style="width:100%; display: flex;">'+
                                descriptionLocation +
                            "</div>"
                            }
                        );

                    }

                    // The markers
                    markers = locations.map((position, i) => {
                        const label = labels[i];
                        const marker = new google.maps.Marker({
                            position,
                            label,
                            icon: image,
                        });

                        const infowindow = new google.maps.InfoWindow({
                            content: locations.description,
                            ariaLabel: obj['data'][0].salemodel_name + ' - ' + obj['data'][0].state,
                        });

                        //marker.setMap(map);
                        // markers open info window when marker is clicked

                        google.maps.event.addListener(marker, "click", () => {
                            infowindow.setContent(position.description);
                            infowindow.open(map, marker);
                        });
                        return marker;
                    });

                    //MarkerClusterer({ map, markers });

                    // Add a marker clusterer to manage the markers
                    markerCluster = new markerClusterer.MarkerClusterer({map, markers});

                    service = new google.maps.places.PlacesService(map);
                    //service.textSearch(requestMap, function);

                    autocomplete.setOptions({ strictBounds: true });
                    autocomplete.bindTo("bounds", map);

                } else {alert(obj['response'])}
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
}  

function doesFileExist(urlToFile)
{
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();

    if (xhr.status == "404") {
        //console.log("File doesn't exist");
        return false;
    } else {
        //console.log("File exists");
        return true;
    }
}


function addBillboardOnList(billboard_id, proposalproduct_id,price,provider_id){
    if (billboard_id !== '' && proposalproduct_id !== '' && price !== '') {
        
        errors      = 0;
        authApi     = csrf_token;
        message     = '';

        buttonID      = 'add-'+billboard_id+'-button';

        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(errors > 0){
            alert(message);
        } else {
            // disable button
            $('#'+buttonID).prop('disabled','disabled');
            document.getElementById(buttonID).innerText='Added';

            const requestURL = window.location.protocol+'//'+locat+'api/billboards/auth_billboard_add_to_proposal.php?auth_api='+authApi+'&bid='+billboard_id+'&pppid='+proposalproduct_id+'&pc='+price+'&pid='+provider_id;
            console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   //alert('Status: '+obj.response);
                   if(obj.response == 'OK'){
                        // add number of selected billboards to cart
                        updateUnitsOnCart(proposalproduct_id);
                   }
                }
                else{
                    //form.btnSave.innerHTML = "Saving...";
                }
            };
            request.open('GET', requestURL);
            //request.responseType = 'json';
            request.send();
        }
    } else
        alert('Please, fill all required fields (*)');
}

function createMarker(place) {
    if (!place.geometry || !place.geometry.location) return;
  
    const marker = new google.maps.Marker({
      map,
      position: place.geometry.location,
    });
  
    google.maps.event.addListener(marker, "click", () => {
      infowindow.setContent(place.name || "");
      infowindow.open(map);
    });
  }

function updateUnitsOnCart(proposalproduct_id){
    errors      = 0;
    authApi     = csrf_token;
    message     = '';
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        alert(message);
    } else {
        const requestURL = window.location.protocol+'//'+locat+'api/billboards/auth_billboard_by_proposalproduct_get_num_rows.php?auth_api='+authApi+'&pppid='+proposalproduct_id;
        console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                //alert('Status: '+obj.response);
                if(obj.response == 'OK'){
                    unitsOnCart = obj.data[0].numRows;
                    salemodel = obj.data[0].salemodel_name;
                    state = obj.data[0].state;
                    textSelected = 'seleccionada';
                    if(unitsOnCart == 0){
                        unitsOnCart = checkMaleFemale('unit',salemodel);
                    } 
                    if(unitsOnCart > 1){
                        salemodel = returningPlural(salemodel);
                        textSelected = returningPlural(textSelected);
                    }


                    document.getElementById('units-on-cart').innerText = unitsOnCart +' '+salemodel + ' ' + textSelected +' en '+ state;
                }
            }
            else{
                //form.btnSave.innerHTML = "Saving...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
}

// returning plural
function returningPlural(xtext){
    let aText = xtext.split(' ');
    let xxtext = '';
    for(s=0;s < aText.length;s++){
        plural = aText[s] + 's';
        if(aText[s] == 'digital'){
            plural = aText[s] + 'es';
        }
        xxtext += plural;
    }
    return xxtext;
}

// returning correct phrase
function checkMaleFemale(type,salemodel){
    let xtext = '';
    if(type == 'unit'){
        xtext = 'Ninguna';
        if(salemodel == 'muro'){
            xtext = 'Ningún';
        }
    }
    
    return xtext;
}