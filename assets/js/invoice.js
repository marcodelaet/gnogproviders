document.getElementById('nav-item-payment').setAttribute('class',document.getElementById('nav-item-payment').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
module  = 'invoice';
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
            const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_add_new.php?auth_api='+authApi+'&name='+xname+'&webpage_url='+webpage_url+'&address='+address+'&product_id='+product_id+'&salemodel_id='+salemodel_id+'&product_price='+product_price+'&currency='+currency;
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

function handleSubmitFiles(form){
    file1           = document.getElementById('invoice-file-invoice');
    file2           = document.getElementById('invoice-file-po');
    file3           = document.getElementById('invoice-file-report');
    file4           = document.getElementById('invoice-file-presentation');
    file5           = document.getElementById('invoice-file-xml');
    product_id      = document.getElementById('product');
    btnSave         = form.btnSave;
    btnText         = btnSave.innerText;
    if ((file1.value !== '') && (file2.value !== '') && (file3.value !== '') && (file4.value !== '')) {
        if (product_id.value !== '0'){
            //form.submit();
            errors      = 0;
            authApi     = csrf_token;
            document.getElementsByName('authApi')[0].value = authApi;
            document.getElementsByName('usrTk')[0].value = localStorage.getItem('tokenGNOG');
            

            var formData = new FormData(form);
            //formData.append("provider_file", fileInputElement.provider_file);
            
            locat       = window.location.hostname;
            if(locat.slice(-1) != '/')
                locat += '/';
 
            if(errors > 0){

            } else{
                const requestURL = window.location.protocol+'//'+locat+'api/invoices/auth_invoice_file_upload.php';
                const request = new XMLHttpRequest();
                console.log(requestURL);
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Typical action to be performed when the document is ready:
                        console.log(request.responseText);
                        obj = JSON.parse(request.responseText);

                        btnSave.innerText = btnText;
                        //alert('Status: '+obj.status);
                        if(obj.status === "OK")
                            window.location.href = '?pr=Li9wYWdlcy9pbnZvaWNlcy9pbmRleC5waHA=';
                        else
                            alert(obj.message);
                    }
                    else{
                        if(this.status == 500){
                            console.log(request.responseText);
                            //const myWindow = ;
                            //window.open(document.write(request.responseText));
                        }
                        btnSave.innerText = "Uploading...";
                    }
                };
                request.open('POST', requestURL);
                //request.responseType = 'json';
                request.send(formData);
            }
        } else {
            alert('Please, select the invoicing product from the list (*)');
        }
    } else {
        alert('Please, choose files to upload (*)');
    }
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
            const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_edit.php?auth_api='+authApi+sett;
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

function handleViewOnLoad(tid) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&tid='+tid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_get.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request   = new XMLHttpRequest();
        position        = '*****';
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                obj = JSON.parse(request.responseText);
                // Create our number formatter.
                var formatter = new Intl.NumberFormat('es-MX', {
                    style: 'currency',
                    currency: obj[0].currency,
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });
                if(obj[0].main_contact_position!='')
                    position = obj[0].main_contact_position;
                phone_number = obj[0].phone_number.replace(" ","");
                if(obj[0].phone_prefix!='')
                    phone_number = obj[0].phone_prefix+obj[0].phone_number.replace(" ","");
                document.getElementById('provider_name').innerHTML          = obj[0].name;
                document.getElementById('group').innerHTML                  = obj[0].webpage_url;
                document.getElementById('card-contact-fullname').innerHTML  = obj[0].main_contact_name + ' ' + obj[0].main_contact_surname
                document.getElementById('card-contact-position').innerHTML  = ' ('+position+')';
                document.getElementById('card-address').innerHTML           = obj[0].address;
                document.getElementById('card-email').innerHTML             = obj[0].main_contact_email;
                document.getElementById('card-phone').innerHTML             = '+'+obj[0].phone_international_code.replace(" ","") + phone_number;
                document.getElementById('card-product').innerHTML           = obj[0].product_name;
                document.getElementById('card-product-price').innerHTML     = formatter.format(obj[0].product_price);
                document.getElementById('card-salemodel').innerHTML         = obj[0].salemodel_name;
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
        const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_get.php?auth_api='+authApi+filters;
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

function handleListOnLoad(search) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    addColumn   = '';
    groupby     = '';

    uuid        = localStorage.getItem('uuid');
    //groupby     = '&groupby=invoice_id';
    //addColumn   = '&addcolumn=count(contact_provider_id) as qty_contact';



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
        tableList   = document.getElementById('listInvoices');
        const requestURL = window.location.protocol+'//'+locat+'api/invoices/auth_invoice_view.php?auth_api='+authApi+'&uid='+uuid+filters+groupby+addColumn;
        console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            //console.log(this.readyState + '/n' + this.status);
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                //console.log(request.responseText);
                obj         = JSON.parse(request.responseText);
                if(obj.rows > 0){
                    html        = '';
                    invoice_id  = '';
                    countingstars = 0; // counting files

                    for(var i=0;i < obj.data.length; i++){
                        
                        // Create our number formatter.
                        var formatter = new Intl.NumberFormat('pt-BR', {
                            style: 'currency',
                            currency: obj.data[0].invoice_amount_currency,
                            //maximumSignificantDigits: 2,

                            // These options are needed to round to whole numbers if that's what you want.
                            minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                        });
                        amount_paid = formatter.format(obj.data[i].invoice_amount_paid);
                        if((obj.data[i].invoice_amount_paid_int == '') || (obj.data[i].invoice_amount_paid_int == 0) || (obj.data[i].invoice_amount_paid_int == 'null') ){
                            amount_paid = formatter.format(0);
                        }
                        last_payment_date = obj.data[i].invoice_last_payment_date;
                        if((last_payment_date == '') || (last_payment_date == 0) || (last_payment_date == 'null') || (last_payment_date == null) ){
                            last_payment_date = '';
                        }
                        invoice_status = translateText(obj.data[i].invoice_status,localStorage.getItem('ulang'));
                        

                        if(invoice_id != obj.data[i].invoice_id){
                            html += '<tr><td nowrap>'+obj.data[i].offer_name+' / '+obj.data[i].product_name+' - '+obj.data[i].salemodel_name+'</td>';
                            html += '<td style="text-align:center" nowrap>'+obj.data[i].order_number+'</td>';
                            html += '<td style="text-align:center" nowrap>'+obj.data[i].invoice_number+'</td>';
                            html += '<td style="text-align:right" nowrap>'+formatter.format(obj.data[i].invoice_amount)+'</td>';
                            html += '<td style="text-align:center" nowrap>'+obj.data[i].invoice_updated_at+'</td>';
                            html += '<td style="text-align:center" nowrap>'+obj.data[i].invoice_month+'/'+obj.data[i].invoice_year+'</td>';
                            html += '<td style="text-align:right" nowrap>'+amount_paid+'</td>';
                            html += '<td nowrap>'+last_payment_date+'</td>';
                            html += '<td style="text-align:center" nowrap>'+invoice_status+'</td>';
                            html += '<td nowrap style="text-align:center;">';
                        }
                        // FILES
                        // adding files icons / links
                        html += '<a href="'+obj.data[i].file_location+obj.data[i].file_name+'" target="_blank"><span class="material-icons" style="font-size:1.5rem; color:black;" title="'+obj.data[i].file_name+'">download</span></a>';

                        if(invoice_id != obj.data[i].invoice_id){
                            countingstars = 0; // reseting counting files
                            if(countingstars > 0)
                                html += '</td></tr>';
                            // setting new invoice id
                            invoice_id = obj.data[i].invoice_id;
                        } else {
                            countingstars++;
                        }
                    }
                } else {
                    if(search !== ''){
                        alert('la busqueda no hay retornado resultos para: ' + search);
                        html = '<tr><td colspan="10" style="text-align:center;">0 resultos para <b>'+search+'</b></td></tr>';
                    } else {
                        html = '<tr><td colspan="10" style="text-align:center;">0 resultos</td></tr>';
                    }
                } 
                tableList.innerHTML = html;
            }
            else{
                html = '<tr><td colspan="10"><div style="margin-left:45%; margin-right:45%;" class="spinner-border" style="text-align:center;" role="status">';
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

function handleRemove(tid,locked_status){
    authApi     = csrf_token;
    filters     = '&tid='+tid+'&lk='+locked_status;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    color_status = '#298c3d';
    if(locked_status == 'Y')
        color_status = '#d60b0e';
    const requestURL = window.location.protocol+'//'+locat+'api/providers/auth_provider_remove.php?auth_api='+authApi+filters;
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