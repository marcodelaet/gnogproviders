lang        = 'es-MX';
module      = 'proposal';
start_index = 0;
document.getElementById('nav-item-proposals').setAttribute('class',document.getElementById('nav-item-proposals').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
//alert(csrf_token);
xcurrency = 'MXN';
proposal_id = '';

function handleSubmit(form) {
    if (form.name.value !== '' && form.client_id.value !== '' && form.start_date.value !== '' || form.client_id.value !== '0' || form.agency_id.value !== '0' || form.total.value !== '0,00' || form.status_id.value !== '0') {
        //form.submit();
        errors      = 0;
        authApi     = csrf_token;
        message     = '';

        pixel      = 'N';
        if(form.pixel.checked)
            pixel               = 'Y';
        xname                   = form.name.value;
        client_id               = form.client_id.value;
        agency_id               = form.agency_id.value;
        contact_id              = form.contact_id.value;
        description             = form.description.value;
        start_date              = form.start_date.value;
        stop_date               = form.stop_date.value;
        total                   = form.total.value;
        status_id               = form.status_id.value;
        currency                = form.currency.value;

        objProduct      = document.getElementsByName('product_id[]');
        objSaleModel    = document.getElementsByName('salemodel_id[]');
        objPrice        = document.getElementsByName('price[]');
        objState        = document.getElementsByName('state_id[]');
    
        objQuantity     = document.getElementsByName('quantity[]');
        objProviderId   = document.getElementsByName('provider_id[]');

        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(errors > 0){
            alert(message);
        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_add_new.php?auth_api='+authApi+'&name='+xname+'&pixel='+pixel+'&client_id='+client_id+'&agency_id='+agency_id+'&contact_id='+contact_id+'&description='+description+'&start_date='+start_date+'&stop_date='+stop_date+'&status_id='+status_id;
            //console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    obj = JSON.parse(request.responseText);
                    proposal_id = obj[0].id;
                   
                    //alert('len: ' + objProduct.length);
                    virg            = '';
                    product_id      = '';
                    salemodel_id    = '';
                    price           = '';
                    quantity        = '';
                    provider_id     = '';
                    state_id        = '';

                    for(i=0; i < objProduct.length;i++)
                    {
                        if(i>0)
                            virg = ',';

                        xprice  = '0';
                        if((objPrice[i].value != '') || (objPrice[i].value >= 0)){
                            axPrice = objPrice[i].value.split(",");
                            for(j=0;j < axPrice.length;j++){
                                apPrice     = axPrice[j].split(".");
                                for(k=0;k < apPrice.length;k++){
                                    xprice      += apPrice[k];
                                }
                            }    
                        } 
                        product_id      += virg + objProduct[i].value;
                        salemodel_id    += virg + objSaleModel[i].value;
                        price           += virg + xprice;
                        xquantity       = 1;
                        if((objQuantity[i].value != '') || (objQuantity[i].value > 0))
                            xquantity = objQuantity[i].value;
                        quantity        += virg + xquantity;
                        provider_id     += virg + objProviderId[i].value;
                        state_id        += virg + objState[i].value;
                    }
                    addProduct('['+product_id+']','['+salemodel_id+']','['+price+']',currency,'['+quantity+']','['+provider_id+']',proposal_id,'['+state_id+']');

                    form.btnSave.innerHTML = "Save";
                    window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvdGtwL2luZGV4LnBocA==';
                }
                else{
                    form.btnSave.innerHTML = "Saving...";
                }
            };
            request.open('GET', requestURL, false);
            //request.responseType = 'json';
            request.send();
        }
    } else
        alert('Please, fill all required fields (*)');
}

function handleEditSubmit(tid,form) {
    if (form.name.value !== '' && form.address.value !== '' && form.main_contact_email.value !== '' || product_id != '0' || salemodel_id != '0') {
        //form.submit();
   
        errors      = 0;
        authApi     = csrf_token;
        
        sett     = '&tid='+tid;
        xname          = form.name.value;
        if(xname !== ''){
            sett     += '&name='+name;
        }
        address                 = form.address.value;
        if(address !== ''){
            sett     += '&address='+address;
        }
        webpage_url             = form.webpage_url.value;
        if(webpage_url !== ''){
            sett     += '&webpage_url='+webpage_url;
        }
        main_contact_name       = form.main_contact_name.value;
        if(main_contact_name !== ''){
            sett     += '&main_contact_name='+main_contact_name;
        }
        main_contact_surname    = form.main_contact_surname.value;
        if(main_contact_surname !== ''){
            sett     += '&main_contact_surname='+main_contact_surname;
        }
        main_contact_email      = form.main_contact_email.value;
        if(main_contact_email !== ''){
            sett     += '&main_contact_email='+main_contact_email;
        }
        /*phone_ddi  = form.mobile_ddi.value;
        if(phone_ddi !== ''){
            sett     += '&phone_ddi='+phone_ddi.replace(' ','');
        }*/
        phone                   = form.phone.value;
        if(phone !== ''){
            sett     += '&phone='+phone.replace(" ","");
        }
        main_contact_position   = form.main_contact_position.value;
        if(main_contact_position !== ''){
            sett     += '&main_contact_position='+main_contact_position;
        }
        product_id                   = form.product_id.value;
        if(product_id !== ''){
            sett     += '&product_id='+product_id.replace(" ","");
        }
        salemodel_id                   = form.salemodel_id.value;
        if(salemodel_id !== ''){
            sett     += '&salemodel_id='+salemodel_id.replace(" ","");
        }
        product_price                   = form.product_price.value;
        if(product_price !== ''){
            sett     += '&product_price='+product_price.replace(" ","");
        }
        currency                   = form.currency.value;
        if(currency !== ''){
            sett     += '&currency='+currency.replace(" ","");
        }

        //console.log(sett);
        //alert('pausa');
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(errors > 0){
           
        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_edit.php?auth_api='+authApi+sett;
            console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   form.btnSave.innerHTML = "Save";
                   window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvdGtwZWRpdC9pbmRleC5waHA=';
                   //alert('Status: '+obj.status);
                }
                else{
                    form.btnSave.innerHTML = "Saving...";
                }
            };
            request.open('GET', requestURL);
            //request.responseType = 'json';
            request.send();
        }
    } else
        alert('Please, fill all required fields (*)');
}

function handleViewOnLoad(tid) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&tid='+tid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_get.php?auth_api='+authApi+filters;
        console.log(requestURL);
        const request   = new XMLHttpRequest();
        position        = '*****';
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                obj = JSON.parse(request.responseText);
                // Create our number formatter.
                var formatter = new Intl.NumberFormat(lang, {
                    style: 'currency',
                    currency: obj[0].currency_c,
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });
                if(obj[0].main_contact_position!='')
                    position = obj[0].main_contact_position;
                client = obj[0].client_name;
                if(obj[0].agency_name != null)
                    client += ' / ' + obj[0].agency_name;

                xxhtml                = '';
                color_status = '#d60b0e';
                if(obj[0].status_percent == '100')
                    color_status = '#298c3d';
                if(obj[0].status_percent == '90')
                    color_status = '#03fc84';
                if(obj[0].status_percent == '75')
                    color_status = '#77fc03';
                if(obj[0].status_percent == '50')
                    color_status = '#ebfc03';
                if(obj[0].status_percent == '25')
                    color_status = '#fc3d03';
                startDate           = new Date(obj[0].start_date);
                formattedStartDate  = startDate.getDate()+"/"+(parseInt(startDate.getMonth())+1)+"/"+startDate.getFullYear();
                stopDate            = new Date(obj[0].stop_date);
                formattedStopDate   = stopDate.getDate()+"/"+(parseInt(stopDate.getMonth())+1)+"/"+stopDate.getFullYear(); 
                document.getElementById('proposal-name').innerHTML          = obj[0].offer_name;
                document.getElementById('client').innerHTML                 = client;
                document.getElementById('description').innerHTML            = obj[0].description;
                document.getElementById('dates').innerHTML                  = "("+ formattedStartDate+" - "+formattedStopDate+")";
                document.getElementById('statusDropdownMenuButton').innerHTML            = '<spam class="material-icons icon-data" id="card-status-icon" style="color:'+color_status+'">thermostat</spam>' + obj[0].status_name + ' ('+ + obj[0].status_percent+'%)';
                // products list for statement
                for(i=0;i<obj.length;i++){
                    xxhtml += '<spam class="product-line">'+obj[i].quantity + ' x ' + obj[i].product_name + ' / ' + obj[i].salemodel_name+' - '+formatter.format(obj[i].amount)+'</spam><br />';
                }
                document.getElementById('products-list').innerHTML          = xxhtml;                
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

function handleListEditOnLoad(ppid) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&ppid='+ppid;
    orderby     = '&orderby=state ASC,proposalproduct_id,billboard_name';
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_get.php?auth_api='+authApi+filters+orderby;
        console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                obj = JSON.parse(request.responseText);

                // Create our number formatter.
                var formatter = new Intl.NumberFormat(lang, {
                    //style: 'currency',
                    //currency: obj[0].currency,
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });

                advertiser_name = obj[0].client_name;
                if(obj[0].agency_name != '')
                    advertiser_name += " / " + obj[0].agency_name; 
                document.getElementById('offer-name').innerText  = obj[0].offer_name;
                document.getElementById('advertiser-name').innerText  = advertiser_name;

                // Create our number formatter.
                var formatter = new Intl.NumberFormat('pt-BR', {
                    style: 'currency',
                    currency: 'MXN', // believing every currency will be MXN
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });


                productOld = 0;
                html = '';
                numberProducts = 0;
                for(i=0;i < obj.length; i++){
                    // list products
                    product = obj[i].salemodel_name + obj[i].state;
                    if(product != productOld){
                        numberProducts++;
                        html += '<div class="row list-products-row">' +
                        '<div class="col-sm-1">'+(numberProducts)+'</div>' +
                        '<div class="col-sm-3">'+obj[i].salemodel_name+'</div>' +
                        '<div class="col-sm-2">'+obj[i].state+'</div>' + 
                        //'<div class="col-sm-2">Rate % All</div>' +
                        '<div class="col-sm-2"><a href="?pr=Li9wYWdlcy9tYXBzL2luZGV4LnBocA==&smid='+obj[i].salemodel_id+'&ppid='+ppid+'&pppid='+obj[i].proposalproduct_id+'&state='+obj[i].state+'"><span class="material-icons" style="font-size:1.2rem;">map</span></a></div>' +
                        '</div>';    
                    }
                    // css to special times
                    deletedbillboard = '';
                    if(obj[i].is_proposalbillboard_active != 'Y'){
                        deletedbillboard = 'deleted-billboard';
                    }
                    // list billboards
                    if((obj[i].billboard_name != '')&&(obj[i].billboard_name != null)){
                        html += '<div class="row list-billboards-row">' +
                        '<div class="col list-billboards-container">' +
                            '<div class="row" >' +
                                '<div class="col-sm-2 line-list-'+obj[i].billboard_id+' '+deletedbillboard+'">'+obj[i].billboard_name+'</div>' +
                                '<div class="col-sm-2 line-list-'+obj[i].billboard_id+' '+deletedbillboard+'">'+(parseFloat(obj[i].billboard_width)/100).toFixed(1)+' x '+(parseFloat(obj[i].billboard_height)/100).toFixed(1)+'</div>' +
                                '<div class="col-sm-1 line-list-'+obj[i].billboard_id+' '+deletedbillboard+'">'+obj[i].billboard_viewpoint_name+'</div>' +
                                '<div class="col-sm-3 line-list-'+obj[i].billboard_id+' '+deletedbillboard+'">'+formatter.format(obj[i].billboard_cost)+' / <span id="price-'+obj[i].billboard_id+'">'+formatter.format(obj[i].billboard_price)+'</span></div>' +
                                '<div class="input-group col-sm-3" id="rate-delete-'+obj[i].billboard_id+'">';
                                if(deletedbillboard == '') {
                                    //html += '<label for="fee-'+obj[i].billboard_id+'">Fee rate</label>' +
                                    html += '<input name="fee-'+obj[i].billboard_id+'" id="fee-'+obj[i].billboard_id+'" placeholder="% Fee" title="Percent (%) fee" aria-label="Percent (%) fee" value="30" class="form-control" style="height:1.5rem !important; width:3.5rem !important;" type="percent" maxlength="2" autocomplete="fee" />'+
                                    '<div class="input-group-append" style="height:1.5rem !important; width:3.5rem !important;"><span class="input-group-text">% ' +
                                    '<a href="javascript:void(0);" onclick="executeFeeOnPrice(\''+obj[i].proposalproduct_id+'\',\''+obj[i].billboard_id+'\','+obj[i].billboard_cost_int+',\''+obj[i].billboard_name+'\');">'+
                                    '<span class="material-icons" style="font-size:1.5rem; color:black;" title="Calcula Fee para '+obj[i].billboard_salemodel_name+' '+obj[i].billboard_name+'">calculate</span>'+
                                    '</a></span></div>';
                                }
                                html += '</div>' + 
                                '<div class="col-sm-1" id="button-delete-'+obj[i].billboard_id+'">';

                        if(deletedbillboard == '')
                            html += '<a href="javascript:void(0);" onclick="if(confirm(\'Confirma quitar '+obj[i].salemodel_name+' clave '+obj[i].billboard_name+' en la lista del estado de '+obj[i].state+'?\')){handleRemoveFromList(\''+obj[i].proposalproduct_id+'\',\''+obj[i].billboard_id+'\');}">'+
                            '<span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove '+obj[i].billboard_salemodel_name+' '+obj[i].billboard_name+' from list">delete</span></a>';
                        html += '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';    
                    }
                    productOld = obj[i].salemodel_name + obj[i].state;
                }
                document.getElementById('list-products').innerHTML = html;

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

function handleListOnLoad(search) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '';
    if(typeof search == 'undefined')
        search  = '';
    if(search !== ''){
        filters     += '&search='+search;
    }

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        tableList   = document.getElementById('listProposals');
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_list.php?auth_api='+authApi+filters;
        console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                if(typeof obj[0].response != 'undefined'){
                    html = '<tr><td colspan="8"><div style="margin-left:45%; margin-right:45%;text-align:center;" role="status">';
                    html += '0 Results';
                    html += '</td></tr>';
                    tableList.innerHTML = html;    
                }else{
                    html        = ''; 
                    for(var i=0;i < obj.length; i++){
                        var formatter = new Intl.NumberFormat(lang, {
                            style: 'currency',
                            currency: obj[i].currency,
                            //maximumSignificantDigits: 2,
                    
                            // These options are needed to round to whole numbers if that's what you want.
                            //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                        });
                        color_status = '#d60b0e';
                        if(obj[i].is_active == 'Y')
                            color_status = '#298c3d';
                        agency = '';
                        if(typeof(obj[i].agency_name) === 'string')
                            agency = ' / '+obj[i].agency_name;
                        amount = obj[i].amount;
                        start_date  = new Date(obj[i].start_date);
                        stop_date   = new Date(obj[i].stop_date);
                        html += '<tr><td>'+obj[i].offer_name+'</td><td nowrap>'+obj[i].client_name+agency+'</td><td nowrap>'+obj[i].username+'</td><td nowrap>'+formatter.format(amount)+'</td><td>'+start_date.toLocaleString(lang).split(" ")[0].replace(",","")+'</td><td>'+stop_date.toLocaleString(lang).split(" ")[0].replace(",","")+'</td><td style="text-align:center;"><span id="locked_status_'+obj[i].UUID+'" class="material-icons" style="color:'+color_status+'">attribution</span></td><td nowrap style="text-align:center;">';
                        // information card
                        html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvaW5mby5waHA=&ppid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Information Card '+obj[i].offer_name+'">info</span></a>';

                        // Edit form
                        html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&ppid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit '+module + ' '+obj[i].offer_name+'">edit</span></a>';

                        // Remove 
                        html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj[i].UUID+'\',\''+obj[i].is_active+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove '+module + ' '+obj[i].offer_name+'">delete</span></a>';

                        html += '</td></tr>';
                    }
                    tableList.innerHTML = html;
                }
            }
            else{
                html = '<tr><td colspan="8"><div style="margin-left:45%; margin-right:45%;" class="spinner-border" style="text-align:center;" role="status">';
                //html += '<span class="sr-only">Loading...</span>';
                html += '<span class="sr-only">0 results</span>';
                html += '</div></td></tr>';
                tableList.innerHTML = html;
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
    // window.location.href = '?pr=Li9wYWdlcy91c2Vycy9saXN0LnBocA==';
}

// remove billboard from proposals / product list
function handleRemoveFromList(proposalproduct_id,billboard_id){
    authApi     = csrf_token;
    filters     = '&pppid='+proposalproduct_id+'&pbid='+billboard_id;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposalproduct_remove.php?auth_api='+authApi+filters;
    //alert(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            console.log(request.responseText);
            obj = JSON.parse(request.responseText);
            if(obj.response == 'OK'){
                arrayLineList = document.getElementsByClassName('line-list-'+billboard_id);
                buttonDelete = document.getElementById('button-delete-'+billboard_id);
                rateDelete = document.getElementById('rate-delete-'+billboard_id);
                for(all=0;all < arrayLineList.length;all++){
                    arrayLineList[all].setAttribute('class',arrayLineList[all].getAttribute('class')+ ' deleted-billboard');
                }
                buttonDelete.innerHTML='';
                rateDelete.innerHTML='';
            }
            
        }
    };
    request.open('GET', requestURL);
    //request.responseType = 'json';
    request.send();
}


function handleRemove(tid,locked_status){
    authApi     = csrf_token;
    filters     = '&tid='+tid+'&lk='+locked_status;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    color_status = '#298c3d';
    if(locked_status == 'Y')
        color_status = '#d60b0e';
    const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_remove.php?auth_api='+authApi+filters;
    //alert(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            obj = JSON.parse(request.responseText);
            document.getElementById('locked_status_'+tid).style = 'color:'+color_status;
        }
    };
    request.open('GET', requestURL);
    //request.responseType = 'json';
    request.send();
}

function calcAmountTotal(form,index){
    currency    = document.getElementsByName('currency');
    xcurrency   = currency[0].value;
    var formatter = new Intl.NumberFormat(lang, {
        style: 'currency',
        currency: xcurrency,
        //maximumSignificantDigits: 2,

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });
    price       = document.getElementsByName('price[]');
    xprice      = price[index].value;
    quantity    = document.getElementsByName('quantity[]');
    xquantity   = quantity[index].value;
    if(xprice > '0' && xquantity > '0'){
        amount = document.getElementsByName('amount[]');
        amount[index].value   = formatter.format(parseFloat(transformToInt(xprice)) * parseInt(xquantity));

        total = 0;
        for(i=0;i < amount.length; i++){
            xaAmount        = amount[i].value.split(" ");
            if(xaAmount.length <= 1){
                xaAmount        = amount[i].value.split("$");
            }
            aAmountValue1   = xaAmount[1];
            //alert("value: "+ amount[i].value + "\n\nxaAmount: " + xaAmount + "\n0: " + xaAmount[0] + "\n1: " + xaAmount[1])
            axAmountS       = aAmountValue1.split(",");
            xVAmount        = '';
            for(j=0;j < axAmountS.length; j++){
                xVAmount        += axAmountS[j];
            }
            axAmountFinal   = xVAmount.split(".");
            xVAmountFinal   = '';
            for(k=0;k < axAmountFinal.length; k++){
                xVAmountFinal    += axAmountFinal[k];
            }
            realAmount  = (parseInt(xVAmountFinal) * 1) / 100;
            total = (parseFloat(total) * 1)+ (parseFloat(realAmount) * 1);
            //alert(total);
        }
        form.total.value = formatter.format(total);
    }
}

function transformToInt(value){
    arrayValue = value.split('.');
    lenArrayValue = arrayValue.length;
    stringValue = '';
    for(i = 0;i < lenArrayValue; i++){
        stringValue += arrayValue[i];
    }

    arrayValue = stringValue.split(',');
    lenArrayValue = arrayValue.length;
    stringValue = '';
    for(j = 0;j < lenArrayValue; j++){
        stringValue += arrayValue[j];
    }
    finalValue = parseInt(stringValue) / 100;
    return finalValue;
}

function newProductForm(copy,destination,items){
    
    //let divRow = document.createElement("div").setAttribute('class','form-row');
    //let divCol = document.createElement("div").setAttribute('class','col');
    //divRow.appendChild(divCol);
    
    //document.getElementById(destination).after(divRow);
    start_index++;
    document.getElementById(destination).innerHTML += (document.getElementById(copy).innerHTML.replace('proposal,0','proposal,'+start_index).replace('proposal,0','proposal,'+start_index).replace('product_0','product_'+start_index).replace('state_0','state_'+start_index).replace('price_0','price_'+start_index).replace('amount_0','amount_'+start_index).replace('DropdownMenuButton_0','DropdownMenuButton_'+start_index));

    for(iteration=0; iteration <= items; iteration++){
        //alert(items + ' - '+ iteration)
        document.getElementById(destination).innerHTML = document.getElementById(destination).innerHTML.replace('Value_0','Value_'+start_index).replace('Name_0','Name_'+start_index).replace('Id_0','Id_'+start_index).replace('DropdownMenuButton_0','DropdownMenuButton_'+start_index);
    }
    htmlRemoveButton = '<div class="form-row" id="btnRemove_'+start_index+'" >';
    htmlRemoveButton += '<div class="col" style="text-align:right;">';
    htmlRemoveButton += '<button class="btn-danger material-icons-outlined" type="button" onclick="removeProductForm('+start_index+');">remove_circle_outline</button>';
    htmlRemoveButton += '</div>';
    htmlRemoveButton += '</div>';

    document.getElementById(destination).innerHTML += htmlRemoveButton;
}

function removeProductForm(index){
    document.getElementById('product_'+index).remove();
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

function addProduct(product_id,salemodel_id,price,currency,quantity,provider_id,proposal_id,state){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    // filters     = '&tid='+tid
    //fields  = "product_id,salemodel_id,price,currency,quantity,provider_id,proposal_id";
    //values  = "'"+product_id+"','"+salemodel_id+"',"+price+",'"+currency+"',"+quantity+",'"+provider_id+"','"+proposal_id+"'";
    querystring = 'auth_api='+authApi+"&product_id="+product_id+"&salemodel_id="+salemodel_id+"&price="+price+"&currency="+currency+"&quantity="+quantity+"&provider_id="+provider_id+"&proposal_id="+proposal_id+"&state="+state


    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURLAdd = window.location.protocol+'//'+locat+'api/products/auth_product_add_new.php';
        //console.log(requestURLAdd + "\n?"+querystring);
        const requestAdd = new XMLHttpRequest();
        requestAdd.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                obj = JSON.parse(requestAdd.responseText);
                //console.log(obj);
//                return false;
            }
            else{
                //console.log(this.status + '\n' + JSON.parse(requestAdd.responseText));
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        requestAdd.open('POST', requestURLAdd, false);
        requestAdd.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        //request.responseType = 'json';
        requestAdd.send(querystring);
    }
}

function listAdvertiserContacts(aid){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;
    submodule   = 'contact';

    if(locat.slice(-1) != '/')
        locat += '/';

    filters     = '&aid='+aid;

    if(errors > 0){

    } else{
        tableList   = document.getElementById('div-selectContact');
        const requestURL = window.location.protocol+'//'+locat+'api/'+submodule+'s/auth_'+submodule+'_list.php?auth_api='+authApi+filters;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            html    = '<label for="contact_id">Contact</label>';
            html   += '<spam id="scontact">'
            html   += '<SELECT name="contact_id" title="contact_id" class="form-control" autocomplete="contact_id">';
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if( (obj.response != 'error') && (obj.response != 'ZERO_RETURN')){
                    for(var i=0;i < obj.length; i++){
                        contact_fullname = obj[i].contact_name + ' ' + obj[i].contact_surname + ' (' + obj[i].contact_email + ')';
                        html += '<OPTION value="'+obj[i].contact_id+'"/>'+contact_fullname;
                    }
                    html    += '</SELECT>';
                    html    += '</spam>';
                }
                else {
                    html    = '';
                }
                tableList.innerHTML = html;
            }
            else{
                html    += '<OPTION value="0000"/>Loading...';
                html    += '</SELECT>';
                tableList.innerHTML = html;
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    } 
}

function listProviderContacts(pid){

}

function refilterProductsType(typeInt){
    typeInt++;
    if(typeInt > 1)
        typeInt = 0;
    document.getElementById('customSwitch2').value = typeInt;
    
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;
    submodule   = 'product';

    if(locat.slice(-1) != '/')
        locat += '/';

    filters     = "&digyn=Y";
    if(typeInt == '0')
        filters     = "&digyn=N";

    if(errors > 0){

    } else{
        productList   = document.getElementById('div-selectProduct');
        const requestURL = window.location.protocol+'//'+locat+'api/'+submodule+'s/auth_'+submodule+'_list.php?auth_api='+authApi+filters;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            html    = '<label for="product_id[]">Product</label>';
            html   += '<spam id="sproduct">'
            html   += '<SELECT name="product_id[]" title="product_id" class="form-control" autocomplete="product_id"  required>';
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if( (obj.response != 'error') && (obj.response != 'ZERO_RETURN')){
                    html += '<OPTION value="0"/>Please, select Product';
                    for(var i=0;i < obj.length; i++){
                        html += '<OPTION value="'+obj[i].uuid_full+'"/>'+obj[i].name;
                    }
                    html    += '</SELECT>';
                    html    += '</spam>';
                }
                else {
                    html    = '';
                }
                productList.innerHTML = html;
            }
            else{
                html    += '<OPTION value="0000"/>Loading...';
                html    += '</SELECT>';
                productList.innerHTML = html;
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
    refilterSaleModel(typeInt);
}

function refilterSaleModel(typeInt){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;
    submodule   = 'salemodel';

    if(locat.slice(-1) != '/')
        locat += '/';

    filters     = "&digyn=Y";
    if(typeInt == '0')
        filters     = "&digyn=N";

    if(errors > 0){

    } else{
        salemodelList   = document.getElementById('div-selectSaleModel');
        const requestURL = window.location.protocol+'//'+locat+'api/'+submodule+'s/auth_'+submodule+'_list.php?auth_api='+authApi+filters;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            html    = '<label for="salemodel_id[]">Sale Model</label>';
            html   += '<spam id="ssalemodel">'
            html   += '<SELECT name="salemodel_id[]" title="salemodel_id" class="form-control" autocomplete="salemodel_id" required>';
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if( (obj.response != 'error') && (obj.response != 'ZERO_RETURN')){
                    html += '<OPTION value="0"/>Please, select Sale Model';
                    for(var i=0;i < obj.length; i++){
                        html += '<OPTION value="'+obj[i].uuid_full+'"/>'+obj[i].name;
                    }
                    html    += '</SELECT>';
                    html    += '</spam>';
                }
                else {
                    html    = '';
                }
                salemodelList.innerHTML = html;
            }
            else{
                html    += '<OPTION value="0000"/>Loading...';
                html    += '</SELECT>';
                salemodelList.innerHTML = html;
                //form.btnSave.innerHTML = "Searching...";
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
}

function executeFeeOnPrice(proposalproduct_id,billboard_id,price_int,name){
    authApi     = csrf_token;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';
    
    var formatter = new Intl.NumberFormat(lang, {
        style: 'currency',
        currency: xcurrency,
        //maximumSignificantDigits: 2,

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });
    price = parseInt(price_int) / 100;
    feeInput = document.getElementById('fee-'+billboard_id);
    newPrice = price/((100 - parseFloat(feeInput.value))/100);
    newPrice_int = parseInt(newPrice * 100);
    filters     = '&npc='+newPrice_int+'&pbid='+billboard_id+'&pppid='+proposalproduct_id;

    if(confirm('Confirma el cambio de '+feeInput.value+'% ('+(formatter.format(price))+' para '+formatter.format(newPrice)+') en '+name)){
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposalproduct_change_price.php?auth_api='+authApi+filters;
        console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                //console.log(request.responseText);
                obj = JSON.parse(request.responseText);
                if(obj.response == 'OK'){
                    
                    priceSPAM   = document.getElementById('price-'+billboard_id);
                    priceSPAM.innerText=formatter.format(newPrice);
                }
                
            }
        };
        request.open('GET', requestURL);
        //request.responseType = 'json';
        request.send();
    }
}