<?php
if (! function_exists('in_array_2d')) {
    function in_array_2d($key, $array) {

        if(!is_array($array))
            return false;
        
        foreach($array as $row){

            if(!is_array($row))
                return false;

            if(in_array($key, $row))
                return true;
        }

        return false;
    }
}

if (! function_exists('lang')) {
    function lang($name = null) {
        
        if (session()->has('locale'))
            \App::setLocale(session()->get('locale'));

        $language = app()->getLocale();
        
        if(empty($language)) 
            $language = "en";
        if(empty($name)) 
            return $language;

        return $name .'_'. $language;
    }
}
?>