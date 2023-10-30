<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'enums' => [],
    'messages' => [
        'logged_in' => 'User Successfully Logged In',
        'registered' => 'User Successfully Registered',
        'logged_out' => 'User Successfully Logged Out',
        'tkn_refreshed' => 'New Access Token Generated',
        'user_found' => 'User Data Successfully Found',
    ],
    'validations' => [],
    'errors' => [
        'failed' => 'These credentials do not match our records.',
        'password' => 'The provided password is incorrect.',
        'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
        'unauthorized' => 'You Are Not Authorized'
    ],

];
