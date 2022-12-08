document.getElementById('nav-item-users').setAttribute('class',document.getElementById('nav-item-users').getAttribute('class').replace(' active','') + ' active');
var csrf_token = $('meta[name="csrf-token"]').attr('content');
module = 'user';
function handleRemove(tid,locked_status){
    authApi     = csrf_token;
    filters     = '&tid='+tid+'&lk='+locked_status;
    
    locat       = window.location.hostname;
    if(locat.slice(-1) != '/')
        locat += '/';

    color_user_status = '#d60b0e';
    if(locked_status == 'Y')
        color_user_status = '#298c3d';
    const requestURL = window.location.protocol+'//'+locat+'api/'+module+'s/auth_'+module+'_remove.php?auth_api='+authApi+filters;
    //alert(requestURL);
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            obj = JSON.parse(request.responseText);
            document.getElementById('locked_status_'+tid).style = 'color:'+color_user_status;
        }
    };
    request.open('GET', requestURL);
    //request.responseType = 'json';
    request.send();
}

function handleOnLoad(search) {
    //if (form.username.value !== '' || form.email.value !== '' || form.mobile.value !== '' || form.search.value !== '') {
    //form.submit();
    errors      = 0;
    authApi     = csrf_token;
    locat       = window.location.hostname;

    var lacc    = localStorage.getItem('lacc');
    var uuid    = localStorage.getItem('uuid');

    filters     = '';
    if(lacc < 99999){
        filters += "&uid="+uuid;
    }
    if(typeof search == 'undefined')
        search  = '';
    if(search !== ''){
        filters     += '&search='+search;
    }

    if(locat.slice(-1) != '/')
        locat += '/';

    if(errors > 0){

    } else{
        tableList   = document.getElementById('listUsers');
        const requestURL = window.location.protocol+'//'+locat+'api/'+module+'s/auth_'+module+'_view.php?auth_api='+authApi+filters;
        //alert(requestURL);
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Typical action to be performed when the document is ready:
                obj         = JSON.parse(request.responseText);
                html        = '';
                for(var i=0;i < obj.length; i++){
                    color_user_status = '#d60b0e';
                    if(obj[i].account_locked == 'N')
                        color_user_status = '#298c3d';

                    html += '<tr><td>'+obj[i].username+'</td><td>'+obj[i].email+'</td><td>'+obj[i].mobile+'</td><td style="text-align:center;"><span id="locked_status_'+obj[i].uuid_full+'" class="material-icons" style="color:'+color_user_status+'">attribution</span></td><td nowrap style="text-align:center;">';
                    // information card
                    html += '<a href="?pr=Li9wYWdlcy91c2Vycy9wcm9maWxlL2luZGV4LnBocA==&tid='+obj[i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="User Information Card '+obj[i].username+'">info</span></a>';

                    // Edit form
                    html += '<a href="?pr=Li9wYWdlcy91c2Vycy9mb3JtZWRpdC5waHA=&tid='+obj[i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Edit user '+obj[i].username+'">edit</span></a>';

                    // Goal
                    html += '<a href="?pr=Li9wYWdlcy91c2Vycy9nb2FsL2Zvcm0ucGhw&tid='+obj[i].uuid_full+'"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Set Goal to '+obj[i].username+'">flag</span></a>';

                    // Remove 
                    html += '<a href="javascript:void(0)" onclick="handleRemove(\''+obj[i].uuid_full+'\',\''+obj[i].account_locked+'\')"><span class="material-icons" style="font-size:1.5rem; color:black;" title="Remove user '+obj[i].username+'">delete</span></a>';

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