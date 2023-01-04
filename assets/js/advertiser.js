document.getElementById('nav-item-advertisers').setAttribute('class',document.getElementById('nav-item-advertisers').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
//alert(csrf_token);
module  = 'advertiser';

function handleSubmit(form) {
    if (form.corporate_name.value !== '' && form.address.value !== '') {
        //form.submit();
        errors      = 0;
        authApi     = 'dasdasdkasdeewef';

        agency      = 'N';
        if(form.agency.checked)
            agency              = 'Y';
        corporate_name          = form.corporate_name.value;
        address                 = form.address.value;
        
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(corporate_name == '')
        {
            errors++;
            alert('Please, type a corporate name');
        }

        if(errors > 0){

        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/advertisers/auth_advertiser_add_new.php?auth_api='+authApi+'&agency='+agency+'&corporate_name='+corporate_name+'&address='+address;
            console.log(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   form.btnSave.innerHTML = "Save";
                   console.log('Status: '+obj.status);
                   window.location.href = '?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy90a3AvaW5kZXgucGhw';
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

function handleSubmitCSV(form){
    if (form.advertiser_file.value !== '') {
        //form.submit();
        errors      = 0;
        authApi     = 'dasdasdkasdeewef';

        file        = form.advertiser_file;
        var formData = new FormData(form);
        //formData.append("advertiser_file", fileInputElement.advertiser_file);
        
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
            const requestURL = window.location.protocol+'//'+locat+'api/advertisers/auth_advertiser_csv_upload.php';
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    console.log(request.responseText);
                    obj = JSON.parse(request.responseText);
                    form.btnSave.innerHTML = "Upload list of Advertisers";
                    if(obj.status === "OK")
                        window.location.href = '?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy90a3BlZGl0L2luZGV4LnBocA==';
                    else
                        alert(obj.message);
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
    if (form.corporate_name.value !== '' && form.address.value !== '' && form.main_contact_email.value !== '') {
        //form.submit();
   
        errors      = 0;
        authApi     = 'dasdasdkasdeewef';

        agency      = 'N';
        if(form.agency.checked)
            agency              = 'Y';
        
        sett     = '&tid='+tid;
        sett     += '&agency='+agency;
        corporate_name          = form.corporate_name.value;
        if(corporate_name !== ''){
            sett     += '&corporate_name='+corporate_name;
        }
        address                 = form.address.value;
        if(address !== ''){
            sett     += '&address='+address;
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
        
        console.log(sett);
        //alert('pausa');
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(errors > 0){
           
        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/advertisers/auth_advertiser_edit.php?auth_api='+authApi+sett;
            //alert(requestURL);
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   form.btnSave.innerHTML = "Save";
                   window.location.href = '?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy90a3BlZGl0L2luZGV4LnBocA==';
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

function handleViewOnLoad(aid) {
    errors      = 0;
    authApi     = 'dasdasdkasdeewef';
    locat       = window.location.hostname;

    filters     = '&aid='+aid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/'+module+'s/auth_'+module+'_get.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request   = new XMLHttpRequest();
        agency          = 'Direct';
        position        = '*****';
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if(obj[0].is_agency == 'Y')
                    agency = 'Agency';
                phone_number = obj[0].phone_number.replace(" ","");
                if((obj[0].phone_prefix!='') && (obj[0].phone_prefix!='0'))
                    phone_number = obj[0].phone_prefix+obj[0].phone_number.replace(" ","");
                document.getElementById('advertiser_name').innerHTML                    = obj[0].corporate_name;
                document.getElementById('group').innerHTML                              = agency;
                document.getElementById('card-address').innerHTML                       = obj[0].address;

                xhtml = '';
                for(i=0;i < obj.length; i++){
                    if(obj[i].contact_position!='')
                        position = obj[i].contact_position;
                    xhtml += '<div class="space-blank">&nbsp;</div>';
                    xhtml += '<div class="'+module+'-data">';
                    xhtml += '    <spam id="card-contact-fullname-and-position">'+obj[i].contact_name + ' ' + obj[i].contact_surname + ' ('+position+')</spam>';
                    xhtml += '</div>';
                    xhtml += '<div class="'+module+'-data">';
                    xhtml += '    <spam class="material-icons icon-data">email</spam>';
                    xhtml += '    <spam id="card-email">'+obj[i].contact_email+'</spam>';
                    xhtml += '</div>';
                    xhtml += '<div class="'+module+'-data">';
                    xhtml += '    <spam class="material-icons icon-data">phone</spam>';
                    xhtml += '    <spam id="card-phone">+'+obj[i].phone_international_code.replace(" ","") + phone_number+'</spam>';
                    xhtml += '</div>';
                }
                document.getElementById("list-contacts").innerHTML = xhtml;
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
    authApi     = 'dasdasdkasdeewef';
    locat       = window.location.hostname;

    filters     = '&tid='+tid;
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/advertisers/auth_advertiser_get.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                if(obj[0].is_agency == 'Y')
                    form.agency.checked = true;
                form.corporate_name.value           = obj[0].corporate_name;
                form.address.value                  = obj[0].address;
                form.main_contact_name.value        = obj[0].main_contact_name;
                form.main_contact_surname.value     = obj[0].main_contact_surname;
                form.main_contact_email.value       = obj[0].main_contact_email;
                //form.phone_ddi.value              = obj[0].phone_international_code.replace(" ","");
                form.phone.value                    = obj[0].phone_number.replace(" ","");
                form.main_contact_position.value    = obj[0].main_contact_position;
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

    groupby     = '&groupby=UUID';
    addColumn   = '&addcolumn=count(contact_client_id) as qty_contact';

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
        tableList   = document.getElementById('listAdvertisers');
        const requestURL = window.location.protocol+'//'+locat+'api/advertisers/auth_advertiser_view.php?auth_api='+authApi+filters+groupby+addColumn;
        //console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                html        = '';
                country     = '';
                for(var i=0;i < obj.length; i++){
                    color_status = '#d60b0e';
                    if(obj[i].is_active == 'Y')
                        color_status = '#298c3d';
                    
                    advertiser_type = 'Direct';
                    if(obj[i].is_agency == 'Y')
                        advertiser_type = 'Agency';

                        switch (obj[i].phone_international_code) {
                            case '52':
                                country = 'MEX';
                                break;
                            case '55':
                                country = 'BRA';
                                break;
                            case '1':
                                country = 'USA';
                                break;
                            default:
                                country = 'XXX';
                        }
                    string_qty_contact = "No contacts";
                    if(obj[i].qty_contact > 0)
                        string_qty_contact = obj[i].qty_contact + ' contact';
                    if(obj[i].qty_contact > 1)
                        string_qty_contact += 's';
                        
                    html += '<tr><td>'+obj[i].corporate_name+'</td><td>'+advertiser_type+'</td><td nowrap>'+string_qty_contact+'</td><td style="text-align:center;"><span id="locked_status_'+obj[i].uuid_full+'" class="material-icons" style="color:'+color_status+'">circle</span></td><td nowrap style="text-align:center;">';
                    // information card
                    html += '<a href="?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy9pbmZvLnBocA==&tid='+obj[i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Information Card '+obj[i].corporate_name+'">info</span></a>';

                    // Edit form
                    html += '<a href="?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy9mb3JtZWRpdC5waHA=&tid='+obj[i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit '+module + ' '+obj[i].corporate_name+'">edit</span></a>';

                    // Remove 
                    html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj[i].uuid_full+'\',\''+obj[i].is_active+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove '+module + ' '+obj[i].corporate_name+'">delete</span></a>';

                    // Add Contact
                    html += '<a href="?pr=Li9wYWdlcy9hZHZlcnRpc2Vycy9jb250YWN0cy9mb3JtLnBocA==&md=Advertiser&tid='+obj[i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Add a contact to '+module + ' '+obj[i].corporate_name+'">contact_mail</span></a>';

                    html += '</td></tr>';
                }
                tableList.innerHTML = html;
            }
            else{
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

function handleRemove(tid,locked_status){
    authApi     = 'dasdasdkasdeewef';
    filters     = '&tid='+tid+'&lk='+locked_status;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    color_status = '#298c3d';
    if(locked_status == 'Y')
        color_status = '#d60b0e';
    const requestURL = window.location.protocol+'//'+locat+'api/advertisers/auth_advertiser_remove.php?auth_api='+authApi+filters;
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