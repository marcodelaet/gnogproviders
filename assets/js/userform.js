var csrf_token = $('meta[name="csrf-token"]').attr('content');
module = 'user';
//alert(csrf_token);

function handleSubmit(form) {
    if (form.email.value !== '' && form.phone.value !== '' && form.password.value !== '' && form.retype_password.value !== '') {
        errors      = 0;
        authApi     = csrf_token;
        email       = form.email.value;
        username    = form.username.value;
        if(username == ''){
            username = email;
        }        
        phone_ddi  = document.getElementsByClassName('iti__selected-flag')[0].title.split(':')[1].replace(' ','').replace('+','');
        phone      = form.phone.value;
        password    = form.password.value;
        password2   = form.retype_password.value;
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(password != password2)
        {
            errors++;
            alert('Please, retype password exactly like in the password field');
        }

        if(errors > 0){

        } else{
            const querystring   = 'auth_api='+authApi+'&username='+username+'&email='+email+'&phone_international_code='+phone_ddi+'&phone_number='+phone+'&password='+password; 
            const requestURL    = window.location.protocol+'//'+locat+'api/'+module+'s/auth_'+module+'_add_new.php';
            
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Typical action to be performed when the document is ready:
                    //obj = request.responseText;
                    //console.log(obj);
                    obj = JSON.parse(request.responseText);
                    //alert('Status: '+obj.status);
                        if(obj.status == 'OK'){
                            alert('Usuario listo para login');
                        form.btnSave.innerHTML = "Save";
                        window.location.href = '?pr=Li9wYWdlcy91c2Vycy90a3AvaW5kZXgucGhw';
                    }
                }
                else{
                    form.btnSave.innerHTML = "Saving...";
                }
            };
            request.open('POST', requestURL, true);
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            //request.responseType = 'json';
            request.send(querystring);
        }
    } else
        alert('Please, fill all required fields (*)');
}


function handleEditSubmit(tid,form) {
    if (form.password.value !== '' && form.retype_password.value !== '') {
        errors      = 0;
        authApi     = csrf_token;
        filters     = '&tid='+tid;
        password    = form.password.value;
        password2   = form.retype_password.value;
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';

        if(password != password2){
            errors++;
            alert('Please, retype password exactly like in the password field');
        }
        else{
            if(password !== ''){
                filters     += '&password='+password;
            }
        }

        if(errors > 0){

        } else{
            const requestURL = window.location.protocol+'//'+locat+'api/'+module+'s/auth_'+module+'_edit.php?auth_api='+authApi+filters;
            
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   obj = JSON.parse(request.responseText);
                   form.btnSave.innerHTML = "Save";
                   window.location.href = '?pr=Li9wYWdlcy91c2Vycy90a3BlZGl0L2luZGV4LnBocA==';
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

function handleOnLoad(cpid,form) {
    errors      = 0;
    authApi     = csrf_token;
    authApi     = cpid; //sending cpid
    locat       = window.location.hostname;

    filters     = '&cpid='+cpid;
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/'+module+'s/auth_'+module+'_get.php?auth_api='+authApi+filters;
        const request = new XMLHttpRequest();
        console.log(requestURL);
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                document.getElementById('provider-name').innerText = obj.data[0].provider_name;
                document.getElementById('contact-data').innerText = '('+obj.data[0].contact_name + ' ' + obj.data[0].contact_surname + ')';
                form.username.placeholder   = obj.data[0].contact_email + ' (login option using email)';
                //form.username.value         = obj.data[0].contact_email;
                form.email.value            = obj.data[0].contact_email;
                international_code = obj.data[0].contact_international_code;

                xvar    = '';
                xtitle  = '';
                switch (international_code) {
                    case '55':
                        xvar    = 'br';
                        xtitle  = 'Brazil (Brasil): +55';
                        break;
                    case '52':
                        xvar    = 'mx';
                        xtitle = 'Mexico (México): +52';
                        break;
                    case '1':
                        xvar    = 'us';
                        xtitle = 'United States: +1';
                        break;
                }
                selectedClass = 'iti__selected-flag';
                xclass  = 'iti__flag iti__' + xvar;
                xaria_activedescendant = 'iti-0__item-'+xvar+'-preferred';

                document.getElementsByClassName('iti__selected-flag')[0].setAttribute('aria-activedescendant',xaria_activedescendant);
                document.getElementsByClassName('iti__selected-flag')[0].setAttribute('title',xtitle);
                document.getElementsByClassName('iti__flag')[0].setAttribute('class',xclass); 
                


                form.phone.value            = obj.data[0].contact_phone_number;
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


function handleEditOnLoad(cpid,form) {
    errors      = 0;
    authApi     = csrf_token;
    authApi     = cpid; //sending cpid
    locat       = window.location.hostname;

    filters     = '&cpid='+cpid;
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/'+module+'s/auth_'+module+'_get.php?auth_api='+authApi+filters;
        const request = new XMLHttpRequest();
        console.log(requestURL);
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                document.getElementById('provider-name').innerText = obj.data[0].provider_name;
                document.getElementById('contact-data').innerText = '('+obj.data[0].contact_name + ' ' + obj.data[0].contact_surname + ')';
                form.username.placeholder   = obj.data[0].username;
                form.username.value         = obj.data[0].username;

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