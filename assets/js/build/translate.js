var formatter = new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
    //maximumSignificantDigits: 2,

    // These options are needed to round to whole numbers if that's what you want.
    //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
});

function translateText(code,toLanguage){
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    $querystring = '&fcn=translateInLanguage&dir=../.'+'&code='+code+'&lng='+toLanguage;

    if(locat.slice(-1) != '/')
        locat += '/';

    const requestURL = window.location.protocol+'//'+locat+'assets/lib/translation.php?auth_api='+authApi+$querystring;
    console.log(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        //console.log(this.readyState + '/n' + this.status);
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            xobj = JSON.parse(request.responseText);
            if(xobj.response == 'OK'){
                xresponse = xobj.translation;
                //alert(xresponse);
            } else {
                xresponse = 'Error';
            }
        }
    };
    request.open('GET', requestURL,false);
    //request.responseType = 'json';
    request.send();
    return (xresponse);
}


function copyStringToClipboard (str) {
    // Create new element
    var el = document.createElement('textarea');
    // Set value (string to be copied)
    el.value = str;
    // Set non-editable to avoid focus and move outside of view
    el.setAttribute('readonly', '');
    el.style = {position: 'absolute', left: '-9999px'};
    document.body.appendChild(el);
    // Select text inside element
    el.select();
    // Copy text to clipboard
    document.execCommand('copy');
    // Remove temporary element
    document.body.removeChild(el);
    language = localStorage.getItem('ulang');
    alert(translateText('copied_to_clipboard',language));
 }


 function xmlReader(form,fieldName) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    //querystring = '&fcn=xmlReader&dir=../.'+'&code='+code+'&lng='+toLanguage;
    var formData = new FormData(form);
    formData.append("file_field_name",fieldName)

    if(locat.slice(-1) != '/')
        locat += '/';
    xresponse = 'Error';
    const requestURL = window.location.protocol+'//'+locat+'assets/lib/xmlreader.php';
    console.log(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        //console.log(this.readyState + '/n' + this.status);
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            xobj = JSON.parse(request.responseText);
            //if(xobj.response == 'OK'){
                xresponse = xobj;
                //console.log(request.responseText);
                //console.log(xresponse.attributes.Total);
                //console.log(xresponse.attributes.Moneda);
                //alert(xresponse);
            //} else {
            //    xresponse = 'Error';
            //}
        }
    };
    request.open('POST', requestURL,false);
    //request.responseType = 'json';
    //request.setRequestHeader("Content-Type", "multipart/form-data;");
    request.send(formData);
    return (xresponse);
 }