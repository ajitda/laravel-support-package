<?php

if ( !function_exists('sproute') ) {
    //Same parameters and a new $lang parameter
    function sproute($name, $parameters = [], $absolute = true, $lang = null)
    {
        /*
        * Remember the ajax routes we wanted to exclude from our lang system?
        * Check if the name provided to the function is the one you want to
        * exclude. If it is we will just use the original implementation.
        **/
        $admin_prefix = config('support.support_path_prefix');
        if (Illuminate\Support\Str::contains($name, [$admin_prefix,'ajax','autocomplete'])){
            return app('url')->route($name, $parameters, $absolute);
        }
    
        //Check if $lang is valid and make a route to chosen lang
        if ( $lang && in_array($lang, config('app.alt_langs')) ){
            return app('url')->route($lang .'.'. $name, $parameters, $absolute);
        }
    
        /**
        * For all other routes get the current locale_prefix and prefix the name.
        */
        
        return app('url')->route($admin_prefix .'.'. $name, $parameters, $absolute);
    }
    }