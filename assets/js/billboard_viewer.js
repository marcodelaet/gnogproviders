var csrf_token = $('meta[name="csrf-token"]').attr('content');
module  = 'billboard';

function handleViewOnLoad(bid) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&bid='+bid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/billboards/auth_billboard_get.php?auth_api='+authApi+filters;
        console.log(requestURL);
        const request   = new XMLHttpRequest();
        request.onreadystatechange = function() {
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

                    // JPG
                    baseUrl     = '/public/billboards/';
                    photo_url   = 'img/' + obj['data'][0].name+'.jpg.jpg';
                    if(doesFileExist(baseUrl+photo_url) === false){
                        // JPEG
                        photo_url   = 'img/' + obj['data'][0].name+".jpg.jpeg";
                        if(doesFileExist(baseUrl+photo_url) === false){
                            // PNG
                            photo_url   = 'img/' + obj['data'][0].name+".jpg.png";
                            if(doesFileExist(baseUrl+photo_url) === false){
                                // JPG VARIATION N
                                photo_url   = 'img/' + obj['data'][0].name+"N.jpg.jpg";
                                if(doesFileExist(baseUrl+photo_url) === false){
                                    // JPG VARIATION (1)
                                    photo_url   = 'img/' + obj['data'][0].name+".jpg (1).jpg";
                                    if(doesFileExist(baseUrl+photo_url) === false){
                                        // JPG VARIATION (2)
                                        photo_url   = 'img/' + obj['data'][0].name+".jpg (2).jpg";
                                        if(doesFileExist(baseUrl+photo_url) === false){
                                            // JPG VARIATION C
                                            photo_url   = 'img/' + obj['data'][0].name+"C.jpg.jpg";
                                            if(doesFileExist(baseUrl+photo_url) === false){
                                                // JPG VARIATION JPG
                                                photo_url   = 'img/' + obj['data'][0].name+".JPG.jpg";
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

                    //alert(baseUrl+photo_url + ' / ' + doesFileExist(baseUrl+photo_url));

                    document.getElementById('field-key-text').innerHTML         = obj['data'][0].name;
                    document.getElementById('field-address-text').innerHTML     = obj['data'][0].address;
                    document.getElementById('field-salemodel-text').innerHTML   = obj['data'][0].salemodel_name;
                    document.getElementById('field-viewpoint-text').innerHTML   = obj['data'][0].viewpoint_name;
                    document.getElementById('field-coordenates-text').innerHTML = obj['data'][0].coordenates;
                    document.getElementById('field-dimension-text').innerHTML   = parseFloat(obj['data'][0].height).toFixed(1) + ' x ' + parseFloat(obj['data'][0].width).toFixed(1);
                    document.getElementById('field-image-photo').src            = baseUrl+photo_url;
                } else {
                    alert(obj['response']);
                }
            }
            else{
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
}


function ImageExist(url) 
{
   var img = new Image();
   img.src = url;
   return img.height != 0;
}


function doesFileExist(urlToFile)
{
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();

    if (xhr.status == "404") {
        console.log("File doesn't exist");
        return false;
    } else {
        console.log("File exists");
        return true;
    }
}