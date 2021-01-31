<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('gdriver')) {
    function gdriver($q = null)
    {
        $client = new \Google_Client();
        $client->setClientId(config('helpers.google.clientId'));
        $client->setClientSecret(config('helpers.google.clientSecret'));
        $client->refreshToken(config('helpers.google.refreshToken'));
        $service = new \Google_Service_Drive($client);
        $optParams = array(
            'q' => "name contains '$q'"
        );
        $results = $service->files->listFiles($optParams);
        $files = collect($results->files)->flatten()->map(function ($item) {
            return array('id' => $item->id, 'name' => $item->name);
        })->first();
        return $files;
    }
}
if (!function_exists('redirectTo')) {
    function redirectTo()
    {
        switch (Auth::user()->role_id) {
            case 2:
                return '/student/home';
                break;
            case 3:
                return '/teacher/home';
                break;
            case 4:
                return '/head/home';
                break;
        }
    }
}

if (!function_exists('sanitizeString')) {
    function sanitizeString($str)
    {
        return trim(preg_replace('/\s+/', ' ', $str));
    }
}
