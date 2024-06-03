lang        = 'es-MX';
moduleGoal      = 'goal';
start_index = 0;
var csrf_token = $('meta[name="csrf-token"]').attr('content');
//alert(csrf_token);

proposal_id = '';

function handleGoalSubmit(form) {
    user_id = document.getElementsByName('user_id').value;
    rate    = document.getElementsByName('rate_id').value;
    year    = document.getElementsByName('start_year').value;
    amount  = document.getElementsByName('amount_goal[]');
    month   = document.getElementsByName('start_month[]');
    
    var formData = new FormData(form);
    //form.submit();
    errors      = 0;
    authApi     = csrf_token;
    message     = '';

    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';
    
    if(form.user_id.value == '0'){
        message += "\n- Choose an executive";
        errors++;
    }

    
    for(i=0;i<amount.length;i++){
        if(amount[i].value == ''){
            message += "\n- Please, fill amount value, month "+(i+1)+"!";
            errors++;
        }
    }

    if(errors > 0){
        alert(message);
    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/'+moduleGoal+'s/auth_'+moduleGoal+'_add_new.php';
        //alert(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(request.responseText);
                // Typical action to be performed when the document is ready:
                obj = JSON.parse(request.responseText);
                
                //alert('len: ' + objProduct.length);

                form.btnSave.innerHTML = "Save";
                //alert('Status: '+obj.status);
                if(obj.status == 'OK'){
                    if(!confirm("Goal recorded successfully! Create goals to another executive?"))
                        window.location.href = '?pr=Li9wYWdlcy91c2Vycy9pbmRleC5waHA=';
                    else { 
                        // do nothing
                    }
                }
                else {
                    alert('Please, fill all the amount values!');
                }
            }
            else{
                form.btnSave.innerHTML = "Saving...";
            }
        };
        request.open('POST', requestURL, true);
        //request.responseType = 'json';
        request.send(formData);
    }
}

function handleEditGoalSubmit(tid,form) {
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

function handleListGoalOnLoad(currency) {
    errors      = 0;
    authApi     = csrf_token;
    var locat       = window.location.hostname;

    // getting today's date
    var today   = new Date();
    var month   = today.getMonth()+1; // getMonth starts at 0
    var year    = today.getFullYear(); 

    var filters     = '&year='+year+'&month='+month;

    xcurrency       = 'MXN';
    if((typeof currency != 'undefined') && ((currency !== '') && (currency != 'undefined'))){
        xcurrency       = currency;
    } else {
        document.getElementById('rate_id').value=xcurrency;
    }

    filters     += '&currency='+xcurrency;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/'+moduleGoal+'s/auth_'+moduleGoal+'_list.php?auth_api='+authApi+filters;
        console.log(requestURL);
        const request   = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                obj = JSON.parse(request.responseText);
                // Create our number formatter.
                var formatter = new Intl.NumberFormat(lang, {
                    style: 'currency',
                    currency: obj[0].currency,
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });
                document.getElementById('goal-0').innerHTML            = formatter.format(obj[0].total_amount / 100);
                document.getElementById('goal-2').innerHTML            = obj[0].total_amount;
                //document.getElementById('year-selected').innerHTML          = year; //month +'/'+year;
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

function handleUserGoalOnLoad(tid) {
    errors      = 0;
    authApi     = csrf_token;
    var locat       = window.location.hostname;

    // getting today's date
    var today   = new Date();
    var month   = today.getMonth()+1; // getMonth starts at 0
    var year    = today.getFullYear(); 

    var filters     = '&tid='+tid+'&groupby=UUID&year='+year;//+'&month='+month;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/'+moduleGoal+'s/auth_'+moduleGoal+'_list.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request   = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                obj = JSON.parse(request.responseText);
                // Create our number formatter.
                var formatter = new Intl.NumberFormat(lang, {
                    style: 'currency',
                    currency: obj[0].currency,
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });
                document.getElementById('goal-amount').innerHTML            = formatter.format(obj[0].total_amount / 100);
                document.getElementById('year-selected').innerHTML          = year; //month +'/'+year;
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

function handleGoalOnLoad(tid,form) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    filters     = '&tid='+tid;
  
    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/proposals/auth_proposal_get.php?auth_api='+authApi+filters;
        //alert(requestURL);
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

function handleListGoalSearch(form) {
    errors      = 0;
    authApi     = csrf_token;
    var locat       = window.location.hostname;

    // getting today's date
    var today   = new Date();
    var month   = today.getMonth()+1; // getMonth starts at 0
    var year    = today.getFullYear(); 

    var filters     = '&tid='+tid+'&groupby=UUID&year='+year;//+'&month='+month;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/'+moduleGoal+'s/auth_'+moduleGoal+'_list.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request   = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                obj = JSON.parse(request.responseText);
                // Create our number formatter.
                var formatter = new Intl.NumberFormat(lang, {
                    style: 'currency',
                    currency: obj[0].currency,
                    //maximumSignificantDigits: 2,

                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });
                document.getElementById('goal-amount').innerHTML            = formatter.format(obj[0].total_amount / 100);
                document.getElementById('year-selected').innerHTML          = year; //month +'/'+year;
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

function handleRemoveGoal(tid,locked_status){
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

function calcAmountGoalTotal(form){
    xcurrency    = form.rate_id.value;
    
    var formatter = new Intl.NumberFormat(lang, {
        style: 'currency',
        currency: xcurrency,
        //maximumSignificantDigits: 2,

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });
    
    amount = document.getElementsByName('amount_goal[]');

    total = 0;
    for(i=0;i < amount.length; i++){
        
        if(amount[i].value != ''){
            //amount[i].value = formatter.format(parseFloat(amount[i].value.replace(",",".")));
            //alert( amount[i].value+ ' - ' + typeof(amount[i].value));
        
            xaAmount        = amount[i].value.split(" ");
            if(xaAmount.length <= 1){
                xaAmount        = amount[i].value.split("$");
            }
            if(xaAmount.length <= 1){
                xaAmount        = amount[i].value.split(xcurrency);
            }
            aAmountValue1   = xaAmount[1];
            if(typeof(aAmountValue1)==='undefined')
                aAmountValue1   = xaAmount[0];
            //alert("value: "+ amount[i].value + "\n\nxaAmount: " + xaAmount + "\n0: " + xaAmount[0] + "\n1: " + xaAmount[1] + "\ntype:"+ typeof(aAmountValue1));
            axAmountS       = aAmountValue1.split(",");
            xVAmount        = '';
            for(j=0;j < axAmountS.length; j++){
                xVAmount        += axAmountS[j];
            }
            //alert(xVAmount);
            axAmountFinal   = xVAmount.split(".");
            xVAmountFinal   = '';
            for(k=0;k < axAmountFinal.length; k++){
                xVAmountFinal    += axAmountFinal[k];
            }
            //alert(xVAmountFinal);
            realAmount  = (parseInt(xVAmountFinal) * 1) / 100;
            //alert(realAmount);
            total = (parseFloat(total) * 1)+ (parseFloat(realAmount) * 1);
            //alert(total);
        } else { i=amount.length; }
    }
    form.amount_total.value = formatter.format(total);
    
}

function newProductForm(copy,destination){
    
    //let divRow = document.createElement("div").setAttribute('class','form-row');
    //let divCol = document.createElement("div").setAttribute('class','col');
    //divRow.appendChild(divCol);
    
    //document.getElementById(destination).after(divRow);
    start_index++;
    document.getElementById(destination).innerHTML += (document.getElementById(copy).innerHTML.replace('proposal,0','proposal,'+start_index).replace('proposal,0','proposal,'+start_index).replace('product_0','product_'+start_index));
    htmlRemoveButton = '<div class="form-row" id="btnRemove_'+start_index+'" >';
    htmlRemoveButton += '<div class="col" style="text-align:right;">';
    htmlRemoveButton += '<button class="btn-danger material-icons-outlined" type="button" onclick="removeProductForm('+start_index+');">remove_circle_outline</button>';
    htmlRemoveButton += '</div>';
    htmlRemoveButton += '</div>';

    document.getElementById(destination).innerHTML += htmlRemoveButton;
}

function handleListGoalAtFormOnLoad() {
    errors      = 0;
    authApi     = csrf_token;
    var locat       = window.location.hostname;

    // getting today's date
    var today   = new Date();
    var month   = today.getMonth()+1; // getMonth starts at 0
    var year    = today.getFullYear(); 

    var groupby = 'UUID,goal_month,goal_year';
    var filters     = '&year='+year+'&groupby='+groupby;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/'+moduleGoal+'s/auth_'+moduleGoal+'_list.php?auth_api='+authApi+filters;
        console.log(requestURL);
        const request   = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                obj = JSON.parse(request.responseText);
                // Create our number formatter.
                html = '';
                for(g=0;g < obj.length;g++){
                    alert(obj[g].currency);
                    var formatter = new Intl.NumberFormat(lang, {
                        style: 'currency',
                        currency: obj[g].currency,
                        //maximumSignificantDigits: 2,
    
                        // These options are needed to round to whole numbers if that's what you want.
                        //minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                    });
                    html += '<tr><td>'+obj[g].username+'</td><td>'+obj[g].goal_year+'</td><td>'+formatter.format(obj[g].total_amount / 100)+'</td>';
                }
                document.getElementById('goal-list').innerHTML  = html;
                /*
                document.getElementById('goal-0').innerHTML            = formatter.format(obj[0].total_amount / 100);
                document.getElementById('goal-2').innerHTML            = obj[0].total_amount;*/
                //document.getElementById('year-selected').innerHTML          = year; //month +'/'+year;
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