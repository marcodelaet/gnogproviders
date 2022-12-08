document.getElementById('nav-item-users').setAttribute('class',document.getElementById('nav-item-users').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
module  = 'billboard';
//alert(csrf_token);

function handleSubmit(form) {
    if (form.name.value !== '' && form.address.value !== '' && form.main_contact_email.value !== '' || product_id != '0' || salemodel_id != '0') {
        //form.submit();
        errors      = 0;
        authApi     = csrf_token;
        message     = '';

        xname                   = form.name.value;
        address                 = form.address.value;
        webpage_url             = form.webpage_url.value;
        product_id              = form.product_id.value;
        if(product_id == '0'){
            message += 'Please, select a product!\n';
            errors++;
        }
        salemodel_id            = form.salemodel_id.value;
        if(salemodel_id == '0'){
            message += 'Please, select a sale model!\n';
            errors++;
        }
        product_price           = form.product_price.value;
        currency                = form.currency.value;

        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(errors > 0){
            alert(message);
        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/billboards/auth_billboard_add_new.php?auth_api='+authApi+'&name='+xname+'&webpage_url='+webpage_url+'&address='+address+'&product_id='+product_id+'&salemodel_id='+salemodel_id+'&product_price='+product_price+'&currency='+currency;
            console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   form.btnSave.innerHTML = "Save";
                   //alert('Status: '+obj.status);
                   window.location.href = '?pr=Li9wYWdlcy9wcm92aWRlcnMvdGtwL2luZGV4LnBocA==';
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

function handleSubmitXLSX(form){
    if (form.billboard_file.value !== '') {
        //form.submit();
        errors      = 0;
        authApi     = csrf_token;

        file        = form.billboard_file;
        var formData = new FormData(form);
        //formData.append("billboard_file", fileInputElement.billboard_file);
        
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(file == '')
        {
            errors++;
            alert('Please, type a corporate name');
        }

        if(errors > 0){

        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/billboards/auth_billboard_xlsx_upload.php';
            console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    //document.write(request.responseText);
                    console.log(request.responseText);
                    obj = JSON.parse(request.responseText);

                    form.btnSave.innerHTML = "Upload list of billboards";
                    //alert('Status: '+obj.status);
                    if(obj.status === "OK")
                        window.location.href = '?pr=Li9wYWdlcy9iaWxsYm9hcmRzL2luZGV4LnBocA==';
                    else{
                        console.log(obj.message);
                        alert(obj.message);
                    }
                        
                }
                else{
                    form.btnSave.innerHTML = "Uploading...";
                }
            };
            request.open('POST', requestURL);
            //request.responseType = 'json';
            request.send(formData);
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
            sett     += '&name='+xname;
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
            const requestURL = window.location.protocol+'//'+locat+'api/billboards/auth_billboard_edit.php?auth_api='+authApi+sett;
            console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   form.btnSave.innerHTML = "Save";
                   window.location.href = '?pr=Li9wYWdlcy9wcm92aWRlcnMvdGtwZWRpdC9pbmRleC5waHA=';
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
        //alert(requestURL);
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
                    document.getElementById('field-key').innerHTML          = obj['data'][0].name;
                    document.getElementById('field-address').innerHTML      = obj['data'][0].address;
                    document.getElementById('field-salemodel').innerHTML    = obj['data'][0].salemodel_name;
                    document.getElementById('field-viewpoint').innerHTML    = obj['data'][0].viewpoint_name;
                    document.getElementById('field-coordenates').innerHTML  = obj['data'][0].coordenates;
                    document.getElementById('field-dimension').innerHTML    = (parseInt(obj['data'][0].height)/100).toFixed(1) + 'x' + (parseInt(obj['data'][0].width)/100).toFixed(1);
                    document.getElementById('field-image-photo').src  = '/assets/img/logo_gnog_media_y_tecnologia.svg';
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

function handleOnLoad(tid,form) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&tid='+tid;
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/billboards/auth_billboard_get.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                obj = JSON.parse(request.responseText);

                    // Create our number formatter.
                    var formatter = new Intl.NumberFormat('pt-BR', {
                        //style: 'currency',
                        //currency: obj[0].currency,
                        //maximumSignificantDigits: 2,

                        // These options are needed to round to whole numbers if that's what you want.
                        minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                    });

                form.name.value                     = obj[0].name;
                form.address.value                  = obj[0].address;
                form.webpage_url.value              = obj[0].webpage_url;
                form.main_contact_name.value        = obj[0].main_contact_name;
                form.main_contact_surname.value     = obj[0].main_contact_surname;
                form.main_contact_email.value       = obj[0].main_contact_email;
                //form.phone_ddi.value              = obj[0].phone_international_code.replace(" ","");
                form.phone.value                    = obj[0].phone_number.replace(" ","");
                form.main_contact_position.value    = obj[0].main_contact_position;
                form.product_price.value            = formatter.format(obj[0].product_price);
                form.product_id.value               = obj[0].product_id;
                form.salemodel_id.value             = obj[0].salemodel_id;
                form.currency.value                 = obj[0].currency;
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

function handleListOnLoad(search,page) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    groupby     = '';
    addColumn   = '';

    filters     = '';
    if(typeof search == 'undefined')
        search  = '';
    if(search !== ''){
        filters     += '&search='+search;
    }

    pages       = '';
    if(typeof page == 'undefined')
        page  = '1';
    if(page !== '1'){
        pages     += '&p='+(parseInt(page)-1);
    }

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        tableList   = document.getElementById('listBillboards');
        const requestURL = window.location.protocol+'//'+locat+'api/billboards/auth_billboard_view.php?auth_api='+authApi+filters+groupby+addColumn+pages;
        console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                html        = '';
                country     = '';
                
                for(var i=0;i < obj['data'].length; i++){
                    color_status = '#d60b0e';
                    if(obj['data'][i].is_active == 'Y') {
                        color_status = '#298c3d';
                    }
                    color_iluminated = '#d60b0e';
                    if(obj['data'][i].is_iluminated == 'Y') {
                        color_status = '#298c3d';
                    }
                    color_digital = '#d60b0e';
                    if(obj['data'][i].is_digital == 'Y') {
                        color_status = '#298c3d';
                    }
                    
                    html += '<tr><td>'+obj['data'][i].provider_name+'</td><td>'+obj['data'][i].name+'</td><td nowrap>'+obj['data'][i].viewpoint_name+'</td><td nowrap>'+parseFloat(obj['data'][i].height).toFixed(2)+' x '+parseFloat(obj['data'][i].width).toFixed(2)+'</td><td nowrap>'+obj['data'][i].salemodel_name+'</td><td style="text-align:center;"><span id="locked_status_'+obj['data'][i].uuid_full+'" class="material-icons" style="color:'+color_status+'">circle</span></td><td nowrap style="text-align:center;">';
                    // information card
                    html += '<a onclick=\'window.open("./pages/billboards/info.php?bid='+obj['data'][i].uuid_full+'","billboard-'+obj['data'][i].uuid_full+'","height=510.2,width=652,resizable=0,scrollbars=0,status=0,titlebar=0,toolbar=0,location=0,menubar=0")\'><span class="material-icons" style="font-size:1.5rem; color:black;" title="Information Card - '+obj['data'][i].salemodel_name+' '+obj['data'][i].name+'">info</span></a>';

                    // Edit form
                    html += '<a href="?pr=Li9wYWdlcy9iaWxsYm9hcmRzL2luZm8ucGhw&bid='+obj['data'][i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit - '+obj['data'][i].salemodel_name+' '+obj['data'][i].name+'">edit</span></a>';

                    // Remove 
                    html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj['data'][i].uuid_full+'\',\''+obj['data'][i].is_active+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove - '+obj['data'][i].salemodel_name+' '+obj['data'][i].name+'">delete</span></a>';

                    // Add Contact
                    //html += '<a href="?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy9jb250YWN0cy9mb3JtLnBocA==&md=billboard&tid='+obj['data'][i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Add a contact to '+module + ' '+obj['data'][i].name+'">contact_mail</span></a>';

                    html += '</td></tr>';
                }
                tableList.innerHTML = html;
                pagesController(page,obj['pages']);
                if(parseInt(page) > parseInt(obj['pages'])){
                    page        = 1;
                    filter.goto.value = 1;
                }
            }
            else {
                html = '<tr><td colspan="5"><div style="margin-left:45%; margin-right:45%;" class="spinner-border" style="text-align:center;" role="status">';
                html += '<span class="sr-only">Loading...</span>';
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

function pagesController(actualpage,totalpages){
    document.getElementById('btn_firstpage').disabled=false;
    document.getElementById('btn_beforepage').disabled=false;
    document.getElementById('btn_nextpage').disabled=false;
    document.getElementById('btn_lastpage').disabled=false;

    if(parseInt(filter.goto.value) <= 1){ 
        document.getElementById('btn_firstpage').disabled=true;
        document.getElementById('btn_beforepage').disabled=true;
    }
    if(parseInt(filter.goto.value) >= totalpages){ 
        document.getElementById('btn_nextpage').disabled=true;
        document.getElementById('btn_lastpage').disabled=true;
    }

    filter.totalpages.value = totalpages;
    document.getElementById('text-totalpages').innerText = totalpages;

}

function gotoLast(){
    totalpages = filter.totalpages.value;
    if(parseInt(filter.goto.value) <= totalpages){
        handleListOnLoad(filter.search.value,totalpages); 
        filter.goto.value = totalpages;
    }else{
        document.getElementById('btn_lastpage').disabled=true;
    }
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
    const requestURL = window.location.protocol+'//'+locat+'api/billboards/auth_billboard_remove.php?auth_api='+authApi+filters;
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