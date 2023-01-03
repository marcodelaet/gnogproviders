document.getElementById('nav-item-dashboard').setAttribute('class',document.getElementById('nav-item-dashboard').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
module_dash = 'dashboard';
module_item = 'proposal';

function returnSelectedStatuses(statuses){
    var select = statuses; 
    var selected = [...select.selectedOptions]
        .map(option => option.value); 
        return(selected);
}


function handleListOnLoad(uid,status,month,year,search,currency) {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    // getting today's date
    var today       = new Date();
    var xday        = today.getDate();
    var xmonth      = today.getMonth()+1; // getMonth starts at 0
    var xlenDate    = ('00'+ xmonth).length;
    var xyear       = today.getFullYear();
    var xcurrency   = 'MXN';

    var stringJsonDataProposals  = '['; 

    //month filter
    if((typeof month != 'undefined') && ((month !== '') && (month != 'undefined'))){
        xmonth     = month;
    } else {
        document.getElementById('month').value=xmonth;
    }
    //year filter
    if((typeof year != 'undefined') && ((year !== '') && (year != 'undefined'))){
        xyear     = year;
    } else {
        document.getElementById('year').value=xyear;
    }
    //currency filter
    if((typeof currency != 'undefined') && ((currency !== '') && (currency != 'undefined'))){
        xcurrency     = currency;
    } else {
        document.getElementById('rate_id').value=xcurrency;
    }

    //var mySQLFullDate = xyear+'-'+xmonth+'-'+xday;
    var xmonthfull  = ('00' + xmonth).substring(xlenDate-2,xlenDate);
    var yearMonth = xyear+xmonthfull;

    filters     = '&currency='+xcurrency;
    //uid
    if(typeof uid == 'undefined')
        uid  = '';
    if((uid !== '0') && (uid != 'undefined')){
        filters     += '&uid='+uid;
    }
    
    //search
    if(typeof search == 'undefined')
        search  = '';
    if((search !== '') && (search != 'undefined')){
        filters     += '&'+search;
    }
    filters += '&date='+yearMonth;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){
        
    } else{
        tableList   = document.getElementById('listDashboard');
        const requestURL = window.location.protocol+'//'+locat+'api/'+module_dash+'/auth_'+module_dash+'_list.php?auth_api='+authApi+filters;
        console.log(requestURL);
        //alert(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                if(typeof obj[0].response != 'undefined'){
                    html = '<tr><td colspan="8"><div style="margin-left:30%; margin-right:30%;text-align:center;" role="status">';
                    html += '0 proposals';
                    html += '</td></tr>';
                    tableList.innerHTML = html;    
                    }else{
                    html        = '';
                    amount_total= 0;
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
                        if(obj[i].status_percent == '100')
                            color_status = '#298c3d';
                        if(obj[i].status_percent == '90')
                            color_status = '#03fc84';
                        if(obj[i].status_percent == '75')
                            color_status = '#77fc03';
                        if(obj[i].status_percent == '50')
                            color_status = '#ebfc03';
                        if(obj[i].status_percent == '25')
                            color_status = '#fc3d03';
                            

                        agency = '';
                        if(typeof(obj[i].agency_name) === 'string')
                            agency = ' / '+obj[i].agency_name;
                        amount = obj[i].amount_int / 100;
                        amount_month = obj[i].amount_per_month_int / 100;
                        amount_total+= parseInt(obj[i].amount_per_month_int);
                        amount_total_show   = amount_total / 100;
                        percentGoalShow     = (100 * amount_total)/parseInt(document.getElementById('goal-2').innerText);
                        start_date  = new Date(obj[i].start_date);
                        stop_date   = new Date(obj[i].stop_date);
                        lastCurrency = obj[i].currency;
                        html += '<tr><td>'+obj[i].offer_name+'</td><td nowrap>'+obj[i].client_name+agency+'</td><td nowrap>'+obj[i].username+'</td><td nowrap><spam style="display:none;" class="currency-line" id="currency-'+(i)+'">'+obj[i].currency+'</spam><spam class="amount-line" id="amount-'+(i)+'">'+formatter.format(amount)+'</spam></td><td nowrap><spam class="amount-month-line" id="amount-month-'+(i)+'">'+formatter.format(amount_month)+'</spam></td><td style="text-align:center;"><span id="locked_status_'+obj[i].UUID+'" class="material-icons" title="'+obj[i].status_percent+'% '+obj[i].status_name+'" style="color:'+color_status+'">thermostat</span></td><td nowrap style="text-align:center;">';
                        // information card
                        html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvaW5mby5waHA=&tid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Information Card '+obj[i].offer_name+'">info</span></a>';

                        // Edit form
                        html += '<a href="?pr=Li9wYWdlcy9wcm9wb3NhbHMvZm9ybWVkaXQucGhw&tid='+obj[i].UUID+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit '+module_item + ' '+obj[i].offer_name+'">edit</span></a>';

                        // Remove 
                        html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj[i].UUID+'\',\''+obj[i].is_active+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove '+module_item + ' '+obj[i].offer_name+'">delete</span></a>';

                        html += '</td></tr>';
                        if(i == 0)
                            stringJsonDataProposals += '{"y":'+amount_month+',"label":"'+obj[i].offer_name+' ('+obj[i].username+')"}';
                        else 
                            stringJsonDataProposals += ', {"y":'+amount_month+',"label":"'+obj[i].offer_name+' ('+obj[i].username+')"}';
                    }
                    stringJsonDataProposals += "]";
                    createGraph('horizontalBars','graph-proposals','Proposals values in '+lastCurrency,'Proposals list',stringJsonDataProposals); // campaigns chart 
                    //createGraph('multi2','graph-goals','Reached Goals','Proposals',data1,'Goals',data2); //goals chart
                    tableList.innerHTML = html;
                    document.getElementById('goal-1').innerHTML = formatter.format(amount_total_show);
                    document.getElementById('goal-percent').innerHTML = percentGoalShow.toFixed(2) + "%";
                }
            }
            else {
                html = '<tr><td colspan="8"><div style="margin-left:45%; margin-right:45%;" class="spinner-border" style="text-align:center;" role="status">';
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

function createGraph(chartType,divName,strText,name1,data1,name2,data2,name3,data3) {
    var chart = '';
    if(chartType == 'multi2'){
        chart = new CanvasJS.Chart(divName, {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title:{
                text: strText
            },
            axisX:{
                reversed: true
            },
            axisY:{
                includeZero: true
            },
            toolTip:{
                shared: true
            },
            data: [
                {
                type: "stackedBar",
                name: name1,
                dataPoints: JSON.parse(data1)
            },{
                type: "stackedBar",
                name: name2,
                indexLabel: "#total",
                indexLabelPlacement: "outside",
                indexLabelFontSize: 15,
                indexLabelFontWeight: "bold",
                dataPoints:JSON.parse(data2)
            }]
        });
    }

    if(chartType == 'multi3'){
        chart = new CanvasJS.Chart(divName, {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title:{
                text: strText
            },
            axisX:{
                reversed: true
            },
            axisY:{
                includeZero: true
            },
            toolTip:{
                shared: true
            },
            data: [
                {
                type: "stackedBar",
                name: name1,
                dataPoints: JSON.parse(data1)
            },{
                type: "stackedBar",
                name: name2,
                dataPoints:JSON.parse(data2)
            },{
                type: "stackedBar",
                name: name3,
                indexLabel: "#total",
                indexLabelPlacement: "outside",
                indexLabelFontSize: 15,
                indexLabelFontWeight: "bold",
                dataPoints: JSON.parse(data3)
            }]
        });
    }

    if(chartType == 'horizontalBars'){
        chart = new CanvasJS.Chart(divName, {
            animationEnabled: true,
            title:{
                text: strText
            },
            axisY: {
                title: name1,
                includeZero: true,
                prefix: "$",
                suffix:  "k"
            },
            data: [{
                type: "bar",
                yValueFormatString: "$#,##0K",
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelFontWeight: "bolder",
                indexLabelFontColor: "white",
                dataPoints: JSON.parse(data1)
            }]
        });
    }

    chart.render();
}


function updateRates() {
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    // getting today's date
    var today   = new Date();
    var xday    = today.getDate();
    var xmonth   = today.getMonth()+1; // getMonth starts at 0
    var xyear    = today.getFullYear();

    //month filter
    if((typeof month != 'undefined') && ((month !== '') && (month != 'undefined'))){
        xmonth     = month;
    }
    //year filter
    if((typeof year != 'undefined') && ((year !== '') && (year != 'undefined'))){
        xyear     = year;
    }
    var mySQLFullDate = xyear+'-'+xmonth+'-'+xday;

    filters     = '';
    
    //filters += '&date='+mySQLFullDate;

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        const requestURL = window.location.protocol+'//'+locat+'api/rates/auth_rate_update.php?auth_api='+authApi+filters;
        console.log(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Maybe important to notify user about rates update
                var obj = JSON.parse(request.responseText);
                if( (obj.status === 'OK') || (obj.status = "ALREADY_UPDATED") ){
                    document.getElementById('last-update-date').innerHTML = obj.updated_at;
                }
            }
        };
        request.open('GET', requestURL);
        request.send();
    }
}