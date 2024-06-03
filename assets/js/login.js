function handleLogin(form) {
    username    = form.username.value;
    password    = form.password.value;
    filters     = 'username='+username+'&password='+password;
    locat       = window.location.hostname;
    //alert(locat);
    if(locat.slice(-1) != '/')
        locat += '/';

       // alert(locat);

    const requestURL = window.location.protocol+'//'+locat+'api/login/authentication.php';
    //console.log(requestURL+'?'+filters);
    const request = new XMLHttpRequest();
    request.open('POST', requestURL,true);
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            obj = JSON.parse(request.responseText);
            if(obj.response === 'ERROR'){
                alert('username or password incorrect!');
                form.password.value = '';
            }
            else{
                //console.log(obj);
                // save token on LS
                localStorage.setItem('tokenGNOG', obj.token);
                localStorage.setItem('uuid', obj.data[0].uuid);
                localStorage.setItem('ulang', obj.data[0].user_language);
                localStorage.setItem('lacc', obj.data[0].user_level_account);
                localStorage.setItem('tpu', obj.data[0].user_type);
                localStorage.setItem('pid', obj.data[0].provider_id);

                var d = new Date();
                d.setTime(d.getTime() + (1*24*60*60*1000));
                var expires = "expires="+ d.toUTCString();
                document.cookie = 'tk' + "=" + obj.token+ ";" + expires + ";path=/";
                document.cookie = 'uuid' + "=" + obj.data[0].uuid+ ";" + expires + ";path=/";
                document.cookie = 'ulang' + "=" + obj.data[0].user_language+ ";" + expires + ";path=/";
                document.cookie = 'lacc' + "=" + obj.data[0].user_level_account+ ";" + expires + ";path=/";
                document.cookie = 'tpu' + "=" + obj.data[0].user_type+ ";" + expires + ";path=/";
                document.cookie = 'pid' + "=" + obj.data[0].provider_id+ ";" + expires + ";path=/";                

                window.location.href = '?pr=Li9wYWdlcy9pbnZvaWNlcy9pbmRleC5waHA=';
            }
        }
    };

    //request.responseType = 'json';
    request.send(filters);
}

function handleRecovery() {
    window.location.href = '?pr=Li9wYWdlcy91c2Vycy9yZWNvdmVyeS9pbmRleC5waHA=';
}