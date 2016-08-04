<?php

if (! function_exists('mixed_get')) {
    function mixed_get($object, $key, $default = null)
    {
        return \Helper::mixedGet($object, $key, $default);
    }
}

if (! function_exists('getUserLanguage')) {
    function getUserLanguage()
    {
        return \Helper::getUserLanguage();
    }
}

if (! function_exists('__')) {
    function __($message, $arguments = [])
    {
        return \Helper::translate($message, $arguments);
    }
}

if (! function_exists('is_route')) {
    function is_route($route)
    {
        return \Helper::isRoute($route);
    }
}

if (! function_exists('is_json')) {
    function is_json($json)
    {
        return \Helper::isJson($json);
    }
}

if (! function_exists('is_active_ldap')) {
    function is_active_ldap()
    {
        return \Helper::isActiveLdap();
    }
}

if (! function_exists('get_stub')) {
    function get_stub($file)
    {
        return \Helper::getStub($file);
    }
}

if (! function_exists('carbon_datetime')) {
    function carbon_datetime(\Carbon\Carbon $carbon)
    {
        return \Helper::formatCarbonDatetime($carbon);
    }
}
