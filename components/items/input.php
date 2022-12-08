<?php
function inputSelect($virtualTable,$title,$where,$order,$selected){
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    if(substr($url,-1,1) != '/')
        $url .= '/';
    $fullUrl    = $protocol . $url;
    $authApi    = 'fsdf9ejfineuf3nf93493nf';
    $table      = $virtualTable;
    $idField = 'uuid_full';
    $nameField = "name";
    $groupby = "";
    if($virtualTable == 'advertiser') {
        $groupby = "UUID";
    }
    if($virtualTable == 'proposalxproduct') {
        $groupby    = "proposalproduct_id,product_id,salemodel_id";
        $table      = "proposal";
    }
    $table_plural = $table . 's';
    if(substr($table,-1,strlen($table) ) == 's')
        $table_plural = $table . 'es';    

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&order='.$order.'&where='.$where.'&selected='.$selected.'&groupby='.$groupby.'&allRows=1';
    //return $fullUrl;
    $homepage = file_get_contents($fullUrl);
    $obj = json_decode($homepage);
    //return $obj;
    if(is_array($obj))
        $numberOfRows = count($obj);
    else{
        if($obj->response == 'OK')
            $numberOfRows = count($obj->data);
        else
            $numberOfRows = 0;
    }
    if($numberOfRows > 0 && !is_null($obj->data[0]->uuid_full)){
        $html        = '<option value="0" >'.translateText('please_select').' '.$title.'</option>';
        for($i=0;$i < $numberOfRows; $i++){
            $className      = "";
            $markingSelect = ''; 
            switch($virtualTable){
                case  'advertiser':
                    $id = $obj[$i]->uuid_full;
                    $name = $obj[$i]->corporate_name;
                    break;
                case 'user':
                    $id = $obj[$i]->uuid_full;
                    $name = $obj[$i]->username;
                    break;
                case 'billboard':
                    $id = $obj->data[$i]->uuid_full;
                    $name = $obj->data[$i]->name;
                    break;
                case 'provider':
                    $id = $obj->data[$i]->uuid_full;
                    $name = $obj->data[$i]->name;
                    break;
                case 'proposalxproduct':
                    $id = $obj->data[$i]->proposalproduct_id;
                    $name = $obj->data[$i]->name . ' / ' . $obj->data[$i]->product_name .' - '.$obj->data[$i]->salemodel_name;
                    break;
                case 'rate':
                    if(!is_null($obj[$i]->orderby))
                        $className = " class='bold' ";
                    $id = $obj[$i]->id;
                    $name = $obj[$i]->id;
                    break;
                default:
                    $id = $obj->data[$i]->$idField;
                    $name = $obj->data[$i]->$nameField;
                    break;
            }
            if(!is_null($selected)){
                if($id === $selected)
                    $markingSelect = 'selected';
            }    
            $html .= '<option '.$className.' value="'.$id.'" '.$markingSelect.' >'.$name.'</option>';
        }
    } else {
        $html = '<BR />'.translateText('any_to_select') . ' ' . $title .' '.translateText('to_select'); 
    }
    return $html;
}

function inputFilterSelect($table,$title,$where,$order,$selected){

    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    if(substr($url,-1,1) != '/')
        $url .= '/';
    $fullUrl    = $protocol . $url;
    $authApi    = 'fsdf9ejfineuf3nf93493nf';
    $table_plural = $table . 's';
    if(substr($table,-1,strlen($table) ) == 's')
        $table_plural = $table . 'es';

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&order='.$order.'&where='.$where.'&selected='.$selected;
    //return ($fullUrl);
    $homepage = file_get_contents($fullUrl);
    $obj = json_decode($homepage);
    //return $homepage;
    $html        = '<option value="0" >'.$title.'</option>';
    for($i=0;$i < count($obj); $i++){
        $className      = "";
        $markingSelect  = ''; 
        switch($table){
            case  'advertiser':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->corporate_name;
                break;
            case 'user':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->username;
                break;
            case 'rate':
                if(!is_null($obj[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj[$i]->id;
                $name = $obj[$i]->id;
                break;
            default:
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->name;
                break;
        }             
        if($id == $selected)
            $markingSelect = 'selected';    
        $html .= '<option '.$className.' value="'.$id.'" '.$markingSelect.' >'.$name.'</option>';
    }
    return $html;
}


function inputFilterNoZeroSelect($table,$title,$where,$order,$selected){
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    if(substr($url,-1,1) != '/')
        $url .= '/';
    $fullUrl    = $protocol . $url;
    $authApi    = 'fsdf9ejfineuf3nf93493nf';
    $table_plural = $table . 's';
    if(substr($table,-1,strlen($table) ) == 's')
        $table_plural = $table . 'es';

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&order='.$order.'&where='.$where.'&selected='.$selected;
    //return $fullUrl;
    $homepage = file_get_contents($fullUrl);
    $obj = json_decode($homepage);
    $html        = '';
    for($i=0;$i < count($obj); $i++){
        $className      = "";
        $markingSelect = ''; 
        switch($table){
            case  'advertiser':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->corporate_name;
                break;
            case 'user':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->username;
                break;
            case 'rate':
                if(!is_null($obj[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj[$i]->id;
                $name = $obj[$i]->id;
                break;
            default:
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->name;
                break;
        }             
        if($id == $selected)
            $markingSelect = 'selected';      
        $html .= '<option '.$className.' value="'.$id.'" '.$markingSelect.' >'.$name.'</option>';
    }
    return $html;
}

function inputDropDownStyle($table,$where,$order,$selected){
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    if(substr($url,-1,1) != '/')
        $url .= '/';
    $fullUrl    = $protocol . $url;
    $authApi    = 'fsdf9ejfineuf3nf93493nf';
    $table_plural = $table . 's';
    if(substr($table,-1,strlen($table) ) == 's')
        $table_plural = $table . 'es';

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&order='.$order.'&where='.$where.'&selected='.$selected;
    //return $fullUrl;
    $homepage = file_get_contents($fullUrl);
    $obj = json_decode($homepage);
    $html        = '';
    $html       .= '<div class="dropdown">';
    $html       .= '<button class="btn btn-secondary dropdown-toggle" type="button" id="'.$table.'DropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';

    $html       .= '</button>';
    $html       .= '<div class="dropdown-menu" aria-labelledby="'.$table.'DropdownMenuButton">';
    for($i=0;$i < count($obj); $i++){
        $className      = "";
        $markingSelect  = ''; 
        $icon           = '';

        switch($table){
            case 'status':
                $color_status = '#d60b0e';
                if($obj[$i]->percent == '100')
                    $color_status = '#298c3d';
                if($obj[$i]->percent == '90')
                    $color_status = '#03fc84';
                if($obj[$i]->percent == '75')
                    $color_status = '#77fc03';
                if($obj[$i]->percent == '50')
                    $color_status = '#ebfc03';
                if($obj[$i]->percent == '25')
                    $color_status = '#fc3d03';
                $icon = '<spam class="material-icons icon-data" id="card-status-icon" style="color:'.$color_status.'">thermostat</spam>';
                $id = $obj[$i]->uuid_full;
                $name = translateText($obj[$i]->simple_name) . ' ('.$obj[$i]->percent.'%)';
                break;
            case  'advertiser':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->corporate_name;
                break;
            case 'user':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->username;
                break;
            case 'rate':
                if(!is_null($obj[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj[$i]->id;
                $name = $obj[$i]->id;
                break;
            default:
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->name;
                break;
        }             
        /*if($id == $selected)
             = 'selected';    */  
        $html .= '<a class="dropdown-item" href="#">'.$icon.' '.$name.'</a>';
    }
    $html .= '</div></div>';
    return $html;
}

function inputDropDownSearchStyle($table,$title,$where,$order,$selected){
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
    $url = $_SERVER['HTTP_HOST'];
    $groupby    = '0';
    $field      = $table;
    if(substr($url,-1,1) != '/')
        $url .= '/';
    
    if($table == 'state'){
        $table  = 'billboard';
        $field  = 'state';
        $groupby= '&groupby=state';
    }
    $fullUrl    = $protocol . $url;
    $authApi    = 'fsdf9ejfineuf3nf93493nf';
    $table_plural = $table . 's';
    
    
    if(substr($table,-1,strlen($table) ) == 's')
        $table_plural = $table . 'es';

    

    $fullUrl .= 'api/'.$table_plural.'/auth_'.$table.'_view.php?auth_api='.$authApi.'&orderby='.$order.'&where='.$where.'&selected='.$selected.'&allRows=1'.$groupby;
    //return $fullUrl;
    $homepage   = file_get_contents($fullUrl);

    $obj        = json_decode($homepage);
    if(is_array($obj))
        $numberOfRows = count($obj);
    else{
        $numberOfRows   = count($obj->data);
        $obj            = $obj->data;
        
    }
    $html        = '';
    $html       .= '<div class="dropdown" style="margin-top:1.2rem">';
    $html       .= '<button class="btn btn-primary dropdown-toggle" type="button" id="'.$field.'DropdownMenuButton_0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >'; 
    $html       .= '<span class="caret" id="'.$field.'Value_0">'.translateText($title).'</span>';
    $html       .= '</button>';
    $html       .= '<ul class="dropdown-menu" aria-labelledby="'.$field.'DropdownMenuButton">';
    $html       .= '<input class="'.$field.'Name[]" name="'.$field.'Name" id="'.$field.'Name_0" type="text" placeholder="Search..">';
    for($i=0;$i < $numberOfRows; $i++){
        $className      = "";
        $markingSelect  = ''; 
        $icon           = '';

        switch($table){
            case 'status':
                $color_status = '#d60b0e';
                if($obj[$i]->percent == '100')
                    $color_status = '#298c3d';
                if($obj[$i]->percent == '90')
                    $color_status = '#03fc84';
                if($obj[$i]->percent == '75')
                    $color_status = '#77fc03';
                if($obj[$i]->percent == '50')
                    $color_status = '#ebfc03';
                if($obj[$i]->percent == '25')
                    $color_status = '#fc3d03';
                $icon = '<spam class="material-icons icon-data" id="card-status-icon" style="color:'.$color_status.'">thermostat</spam>';
                $id = $obj[$i]->uuid_full;
                $name = translateText($obj[$i]->simple_name) . ' ('.$obj[$i]->percent.'%)';
                break;
            case  'advertiser':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->corporate_name;
                break;
            case 'user':
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->username;
                break;
            case 'rate':
                if(!is_null($obj[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj[$i]->id;
                $name = $obj[$i]->id;
                break;
            case 'billboard':
                if(!is_null($obj[$i]->orderby))
                    $className = " class='bold' ";
                $id = $obj[$i]->$field;
                $name = $obj[$i]->$field;
                break;
            default:
                $id = $obj[$i]->uuid_full;
                $name = $obj[$i]->name;
                break;
        }             
        /*if($id == $selected)
             = 'selected';    */ 
             //$html .=  '\'++++\'++++\'';
        $html .= '<li><a class="dropdown-item" href="#'.$field.'DropdownMenuButton_0" onclick="document.getElementById(\''.$field.'Value_0\').innerText=\''.$name.'\'; document.getElementById(\''.$field.'Id_0\').value=\''.$id.'\'; document.getElementById(\''.$field.'Name_0\').value=\''.$name.'\'; ">'.$icon.' '.$name.'</a></li>';
    }
    $html .= '</ul></div>';
    return $html;
}
?>