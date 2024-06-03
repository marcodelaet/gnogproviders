lang        = 'es-MX';
localModule      = 'contact';
start_index = 0;
var csrf_token = $('meta[name="csrf-token"]').attr('content');

function newContactForm(copy,destination){
    
    //let divRow = document.createElement("div").setAttribute('class','form-row');
    //let divCol = document.createElement("div").setAttribute('class','col');
    //divRow.appendChild(divCol);
    
    //document.getElementById(destination).after(divRow);
    start_index++;
    document.getElementById(destination).innerHTML += (document.getElementById(copy).innerHTML.replace('contact,0','contact,'+start_index).replace('contact,0','contact,'+start_index).replace('contact_0','contact_'+start_index));
    htmlRemoveButton = '<div class="form-row" id="btnRemove_'+start_index+'" >';
    htmlRemoveButton += '<div class="col" style="text-align:right;">';
    htmlRemoveButton += '<button class="btn-danger material-icons-outlined" type="button" title="Remove this '+localModule+' form - index['+start_index+']" onclick="removeContactForm('+start_index+');">remove_circle_outline</button>';
    htmlRemoveButton += '</div>';
    htmlRemoveButton += '</div>';

    document.getElementById(destination).innerHTML += htmlRemoveButton;
}

function removeContactForm(index){
    document.getElementById(localModule+'_'+index).remove();
    document.getElementById('btnRemove_'+index).remove();
}

function getId(table,where){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    // filters     = '&tid='+tid;
    xfilters    = '';
    filters     = '';

    xwhere      = where.split(",");
    for(i=0;i < xwhere.length;i++){
        ywhere      = xwhere[i].split("|||");
        filters += "&"+ywhere[0]+"="+ywhere[1];
    }

    

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURLGet = window.location.protocol+'//'+locat+'api/'+table+'s/auth_'+table+'_get.php?auth_api='+authApi+filters;
        //alert(requestURLGet);
        const requestGet = new XMLHttpRequest();
        requestGet.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                objGet = JSON.parse(requestGet.responseText);
                proposal_id = objGet[0].UUID;
                return objGet[0].UUID;
            }
            else{
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        requestGet.open('GET', requestURLGet);
        //request.responseType = 'json';
        requestGet.send();
    }
}

function addContact(form,module){
    errors                  = 0;
    locat                   = window.location.hostname;
    authApi                 = csrf_token;
    ElementID                      = form.ElementID.value;

    // alert(form.auth_api.value);
    objContactName      = document.getElementsByName('contact_name[]');
    objContactSurname   = document.getElementsByName('contact_surname[]');
    objContactEmail     = document.getElementsByName('contact_email[]');
    objContactPosition  = document.getElementsByName('contact_position[]');
    objContactPhone     = document.getElementsByName('phone[]');

    contact_name        = '';
    contact_surname     = '';
    contact_email       = '';
    contact_position    = '';
    phone_number        = '';
    phone_ddi               = document.getElementsByClassName('iti__selected-flag')[0].title.split(':')[1].replace(' ','').replace('+','');
    virg                = '';
    for(i=0; i < objContactName.length;i++)
    {
        if(i>0)
            virg = ',';

        contact_name    += virg + objContactName[i].value;
        contact_surname += virg + objContactSurname[i].value;
        contact_email   += virg + objContactEmail[i].value;
        contact_position+= virg + objContactPosition[i].value;
        phone_number    += virg + objContactPhone[i].value;
    }

    querystring = 'auth_api='+authApi+"&module="+module+"&ElementID="+ElementID+"&contact_name=["+contact_name+"]&contact_surname=["+contact_surname+"]&contact_email=["+contact_email+"]&contact_position=["+contact_position+"]&phone_ddi="+phone_ddi+"&phone_number=["+phone_number+"]";

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURLAdd = window.location.protocol+'//'+locat+'api/'+localModule+'s/auth_'+localModule+'_add_new.php';
        console.log(requestURLAdd + "\nqs: "+querystring);
        const requestAdd = new XMLHttpRequest();
        requestAdd.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                obj = JSON.parse(requestAdd.responseText);
                //obj = requestAdd.responseText;
                //console.log(obj);
//                return false;
                var redirectTo = '?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy9pbmRleC5waHA=';
                if(module == 'provider')
                    redirectTo = '?pr=Li9wYWdlcy9wcm92aWRlcnMvaW5kZXgucGhw';
                if(obj.status === 'OK'){
                    window.location.href = redirectTo;
                } else {
                    alert(obj.status);
                }
            }
            else{
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        requestAdd.open('POST', requestURLAdd, true);
        requestAdd.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        //request.responseType = 'json';
        requestAdd.send(querystring);
    }
}