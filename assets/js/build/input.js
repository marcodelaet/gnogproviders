function inputSelect(table,title,where,order,selected){
    obj         = null;
    authApi     = 'dasdasdkasdeewef';
    tableResult   = document.getElementById('select'+table);
    locat       = window.location.hostname;
    if(locat.substring(locat.length-1,locat.length) != '/')
        locat += '/';
        //alert(locat.substring(locat.length-1,locat.length) + '/n' + locat);

    // where must be: column-value (column=value) | column/value (column like %value%) | column>value (column > value) | column<value (column<value) | column>-value (column >= value)
    const requestURL = window.location.protocol+'//'+locat+'api/'+table+'s/auth_'+table+'_view.php?auth_api='+authApi+'&order='+order+'&where='+where+'&selected='+selected;
    //alert(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            obj         = JSON.parse(request.responseText);
            //html        = '<select name="'+table+'_id" title="'+table+'_id" class="form-control" autocomplete="'+table+'_id" '+required+'>';
            html        = '<option value="0" >Please, select '+title+'</option>';
            for(var i=0;i < obj.length; i++){
                markingSelect = ''; 
                if(obj[i].uuid_full == selected)
                    markingSelect = 'selected';    
                html += '<option value="'+obj[i].uuid_full+'" '+markingSelect+' >'+obj[i].name+'</option>';
            }
            //html += '</select>';
            tableResult.innerHTML = html;
            //alert(html);
            //return html;
        }
        else{
            html = '<span class="sr-only">Loading...</span>';
            tableResult.innerHTML = html;
            //return html;
            //form.btnSave.innerHTML = "Searching...";
        }
    };
    request.open('GET', requestURL,true);
    //request.responseType = 'json';
    request.send();
}
