<?php

return [
    'accounts' => [
        [
            'username' => 'admin',
            'name' => env('ADMIN_USER_NAME'),
            'email' => env('ADMIN_USER_EMAIL'),
            'password' => env('ADMIN_USER_PASSWORD'),
            'role' => env('ADMIN_USER_ROLE'),
            'school_name' => env('ADMIN_USER_SCHOOL'),
            'district_id' => env('ADMIN_USER_DISTRICT_ID'),
            'province_id' => env('ADMIN_USER_PROVINCE_ID'),
        ],
        [
            'username' => 'secondadmin',
            'name' => env('SECOND_ADMIN_USER_NAME'),
            'email' => env('SECOND_ADMIN_USER_EMAIL'),
            'password' => env('SECOND_ADMIN_USER_PASSWORD'),
            'role' => env('SECOND_ADMIN_USER_ROLE'),
            'school_name' => env('SECOND_ADMIN_USER_SCHOOL'),
            'district_id' => env('SECOND_ADMIN_USER_DISTRICT_ID'),
            'province_id' => env('SECOND_ADMIN_USER_PROVINCE_ID'),
        ],
        [
            'username' => 'safespace',
            'name' => env('SAFESPACE_ADMIN_USER_NAME'),
            'email' => env('SAFESPACE_ADMIN_USER_EMAIL'),
            'password' => env('SAFESPACE_ADMIN_USER_PASSWORD'),
            'role' => env('SAFESPACE_ADMIN_USER_ROLE'),
            'school_name' => env('SAFESPACE_ADMIN_USER_SCHOOL'),
            'district_id' => env('SAFESPACE_ADMIN_USER_DISTRICT_ID'),
            'province_id' => env('SAFESPACE_ADMIN_USER_PROVINCE_ID'),
        ],
    ],
];
