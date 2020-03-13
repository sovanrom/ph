<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Add admin_url
if (!function_exists('admin_url')) {
    function admin_url($uri = '', $protocol = null)
    {
        return get_instance()->config->site_url('admin/' . $uri, $protocol);
    }
}

// Add admin_redirect
if (!function_exists('admin_redirect')) {
    function admin_redirect($uri = '', $method = 'auto', $code = null)
    {
        if (!preg_match('#^(\w+:)?//#i', $uri)) {
            $uri = site_url('admin/' . $uri);
        }
        return redirect($uri, $method, $code);
    }
}

// Add fleet_url
if (!function_exists('fleet_url')) {
    function fleet_url($uri = '', $protocol = null)
    {
        return get_instance()->config->site_url('fleet/' . $uri, $protocol);
    }
}

// Add fleet_redirect
if (!function_exists('fleet_redirect')) {
    function fleet_redirect($uri = '', $method = 'auto', $code = null)
    {
        if (!preg_match('#^(\w+:)?//#i', $uri)) {
            $uri = site_url('fleet/' . $uri);
        }
        return redirect($uri, $method, $code);
    }
}
