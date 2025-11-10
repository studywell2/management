<?php

return [

    'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'student' => [
            'driver' => 'session',
            'provider' => 'students',
        ],

        'school' => [
            'driver' => 'session',
            'provider' => 'schools',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'students' => [
            'driver' => 'eloquent',
            'model' => App\Models\Student::class,
        ],

        'schools' => [
            'driver' => 'eloquent',
            'model' => App\Models\School::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'students' => [
            'provider' => 'students',
            'table' => 'student_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'schools' => [
            'provider' => 'schools',
            'table' => 'school_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
