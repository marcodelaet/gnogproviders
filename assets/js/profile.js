var csrf_token = $('meta[name="csrf-token"]').attr('content');

function handleEditProfileSubmit(tid,form) {
    if (form.username.value !== '' && form.email.value !== '' && form.mobile.value !== '') {
        //form.submit();
        errors      = 0;
        authApi     = csrf_token;
        filters     = '&tid='+tid;
        email       = form.email.value;
        if(email !== ''){
            filters     += '&email='+email;
        }
        mobile_ddi  = form.mobile_ddi.value;
        if(mobile_ddi !== ''){
            filters     += '&mobile_ddi='+mobile_ddi.replace(' ','');
        }
        mobile      = form.mobile.value;
        if(mobile !== ''){
            filters     += '&mobile='+mobile;
        }
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
            const requestURL = window.location.protocol+'//'+locat+'api/users/auth_user_edit.php?auth_api='+authApi+filters;
            
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

function handleProfileOnLoad(tid) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&tid='+tid;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/users/auth_user_get.php?auth_api='+authApi+filters;
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                document.getElementById('username').innerHTML   = obj[0].username;
                document.getElementById('card-email').innerHTML = obj[0].email;
                document.getElementById('card-phone').innerHTML = obj[0].mobile_international_code.replace(" ","") + obj[0].mobile_number.replace(" ","");
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

