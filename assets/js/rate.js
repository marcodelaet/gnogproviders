lang = "es-MX";
var csrf_token = $('meta[name="csrf-token"]').attr('content');
module_rate = "rate";

function getCurrencyValue(base,to,value,localSite){
    if(base != to){
        errors      = 0;
        authApi     = csrf_token;
        message     = '';
    
        querystring = new Array('&base='+base+'&to='+to+'&value='+value);
        for(i=0;i<value.length;i++){
            newValueDot_ = '';
            newIntValue_ = '';
            newValue = value.replace(base,'').replace('$','').replace(' ','').replace('&nbsp;','');
            arrayNewValueComma_ = newValue.split(',');
            for(indexNewValueComma_ = 0;indexNewValueComma_ < arrayNewValueComma_.length;indexNewValueComma_++){
                newValueDot_ += arrayNewValueComma_[indexNewValueComma_];
            }
            arrayNewValueDot_ = newValueDot_.split('.');
            for(indexNewValueDot_ = 0;indexNewValueDot_ < arrayNewValueDot_.length;indexNewValueDot_++){
                newIntValue_ += arrayNewValueDot_[indexNewValueDot_];
            }
            value = newIntValue_;
        }
        valueArray  = value.split("---");
        //alert(valueArray);
        if(valueArray.length > 1){
            for(k=0;k<valueArray.length;k++){
                querystring[k] = '&index='+k+'&base='+base+'&to='+to+'&value='+((valueArray[k])/100);
                //alert(querystring[i]);
            }
        }
    
        locat       = window.location.hostname;
        if(locat.slice(-1) != '/')
            locat += '/';
    
        if(errors > 0){
            alert(message);
        } else{
            index = 0;
            for(j=0;j<querystring.length;j++){
                const requestURL = window.location.protocol+'//'+locat+'api/'+module_rate+'s/auth_'+module_rate+'_get.php?auth_api='+authApi+querystring[j];
                setTimeout(function() {
                    
                  }, 1000);
                //alert(requestURL);
                console.log(requestURL)
                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Typical action to be performed when the document is ready:
                        obj = JSON.parse(request.responseText);
                        // Create our number formatter.
                        var formatter = new Intl.NumberFormat(lang, {
                            style: 'currency',
                            currency: obj.to,
                        });
                        //alert(formatter.format(obj.newValue));
                        switch(localSite){
                            case 'dashboard':
                               // alert('show: '+index);
                               if(index < 2)
                                    document.getElementById('goal-'+index).innerHTML = formatter.format(obj.newValue);
                                else
                                    document.getElementById('goal-'+index).innerHTML = parseInt(obj.newValue * 100) ;
                            break;
                            default:
        
                            break; 
                        }
                        index++;
                        document.getElementById('goal-currency').innerHTML = obj.to;
                    }
                    else{
                        //form.btnSave.innerHTML = "Saving...";
                    }
                };
                request.open('GET', requestURL, true);
                //request.responseType = 'json';
                request.send();
            }
        }
    }
}

function updateCurrencyListValue(base,to,value,localSite){
    errors      = 0;
    authApi     = csrf_token;
    message     = '';

    // starting variable
    querystring = new Array('&base='+base+'&to='+to+'&value='+value);
    valueArray      = [];
    currencyArray   = [];
    lineAidsArray   = []; 


    // getting values to convertion
    for(indexOfValues=0;indexOfValues < value.length;indexOfValues++){
        // forcing parse in INT
        newValueDot     = '';
        newIntValue     = '';
        currencyArray.push(base[indexOfValues].innerHTML);
        newValue = value[indexOfValues].innerHTML.replace(currencyArray[indexOfValues],'').replace('$','').replace(' ','').replace('&nbsp;','');
        arrayNewValueComma = newValue.split(',');
        for(indexNewValueComma = 0;indexNewValueComma < arrayNewValueComma.length;indexNewValueComma++){
            newValueDot += arrayNewValueComma[indexNewValueComma];
        }
        arrayNewValueDot = newValueDot.split('.');
        for(indexNewValueDot = 0;indexNewValueDot < arrayNewValueDot.length;indexNewValueDot++){
            newIntValue += arrayNewValueDot[indexNewValueDot];
        }
        valueArray.push(parseInt(newIntValue));
        lineAidsArray.push(value[indexOfValues].id);
        //alert("ID: " + value[indexOfValues].id);
    }
    
    //alert(valueArray[0]);
    //alert(valueArray);
    if(valueArray.length > 1){
        for(i=0;i<valueArray.length;i++){
            querystring[i] = '&index='+i+'&base='+currencyArray[i]+'&to='+to+'&value='+((valueArray[i])/100);
            
            //alert(querystring[i]);
        }
    }

    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        alert(message);
    } else{
        indexx = 0;
        for(j=0;j<querystring.length;j++){
            if(currencyArray[j] != to){
                const requestURL = window.location.protocol+'//'+locat+'api/'+module_rate+'s/auth_'+module_rate+'_get.php?auth_api='+authApi+querystring[j];
                setTimeout(function() {
                    
                  }, 1000);
                //alert(requestURL);
                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Typical action to be performed when the document is ready:
                        obj = JSON.parse(request.responseText);
                        // Create our number formatter.
                        var formatter = new Intl.NumberFormat(lang, {
                            style: 'currency',
                            currency: obj.to,
                            //maximumSignificantDigits: 2,
    
                            // These options are needed to round to whole numbers if that's what you want.
                            //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                        });
                        //alert(formatter.format(obj.newValue));
                        switch(localSite){
                            case 'dashboard':
                               // alert('show: '+indexx);
                               //alert('show a: '+lineAidsArray[indexx]);
                                    document.getElementById(lineAidsArray[indexx]).innerHTML = formatter.format(obj.newValue);
                            break;
                            default:
        
                            break; 
                        }
                        document.getElementById('currency-'+indexx).innerHTML = obj.to;
                        indexx++;
                        //form.btnSave.innerHTML = "Save";
                        //alert('Status: '+obj.status);
                        //window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvdGtwL2luZGV4LnBocA==';
                    }
                    else{
                        //form.btnSave.innerHTML = "Saving...";
                    }
                };
                request.open('GET', requestURL, true);
                //request.responseType = 'json';
                request.send();
            }
        }
    }
}

function updateCurrencyListMonthlyValue(base,to,value,localSite){
    errors      = 0;
    authApi     = csrf_token;
    message     = '';

    // starting variable
    querystring = new Array('&base='+base+'&to='+to+'&value='+value);
    valueArray      = [];
    currencyArray   = [];
    lineidsArray    = [];


    // getting values to convertion
    for(indexOfValues=0;indexOfValues < value.length;indexOfValues++){
        // forcing parse in INT
        newValueDot     = '';
        newIntValue     = '';
        currencyArray.push(base[indexOfValues].innerHTML);
        newValue = value[indexOfValues].innerHTML.replace(currencyArray[indexOfValues],'').replace('$','').replace(' ','').replace('&nbsp;','');
        arrayNewValueComma = newValue.split(',');
        for(indexNewValueComma = 0;indexNewValueComma < arrayNewValueComma.length;indexNewValueComma++){
            newValueDot += arrayNewValueComma[indexNewValueComma];
        }
        arrayNewValueDot = newValueDot.split('.');
        for(indexNewValueDot = 0;indexNewValueDot < arrayNewValueDot.length;indexNewValueDot++){
            newIntValue += arrayNewValueDot[indexNewValueDot];
        }
        valueArray.push(parseInt(newIntValue));
        lineidsArray.push(value[indexOfValues].id);
        //alert("ID: " + value[indexOfValues].id);
    }
    
    //alert(valueArray[0]);
    //alert(valueArray);
    if(valueArray.length > 1){
        for(i=0;i<valueArray.length;i++){
            querystring[i] = '&index='+i+'&base='+currencyArray[i]+'&to='+to+'&value='+((valueArray[i])/100);
            
            //alert(querystring[i]);
        }
    }

    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        alert(message);
    } else{
        indexm = 0;
        for(m=0;m<querystring.length;m++){
            if(currencyArray[m] != to){
                const requestURL = window.location.protocol+'//'+locat+'api/'+module_rate+'s/auth_'+module_rate+'_get.php?auth_api='+authApi+querystring[m];
                setTimeout(function() {
                    
                  }, 1000);
                //alert(requestURL);
                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Typical action to be performed when the document is ready:
                        obj = JSON.parse(request.responseText);
                        // Create our number formatter.
                        var formatter = new Intl.NumberFormat(lang, {
                            style: 'currency',
                            currency: obj.to,
                            //maximumSignificantDigits: 2,
    
                            // These options are needed to round to whole numbers if that's what you want.
                            //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                        });
                        //alert(formatter.format(obj.newValue));
                        switch(localSite){
                            case 'dashboard':
                               // alert('show: '+indexm);
                               //alert('show: '+lineidsArray[indexm]);
                                    document.getElementById(lineidsArray[indexm]).innerHTML = formatter.format(obj.newValue);
                            break;
                            default:
        
                            break; 
                        }
                        document.getElementById('currency-'+indexm).innerHTML = obj.to;
                        indexm++;
                        //form.btnSave.innerHTML = "Save";
                        //alert('Status: '+obj.status);
                        //window.location.href = '?pr=Li9wYWdlcy9wcm9wb3NhbHMvdGtwL2luZGV4LnBocA==';
                    }
                    else{
                        //form.btnSave.innerHTML = "Saving...";
                    }
                };
                request.open('GET', requestURL, true);
                //request.responseType = 'json';
                request.send();
            }
        }
    }
}