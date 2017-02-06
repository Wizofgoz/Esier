<?php

return [
    'Manager' => [
        'client_id'      => '',
        'secret_key'     => '',
        'callback_url'   => '',
        'default_scopes' => [
            'assets-read',
            'bookmarks-read',
            'calendar-read',
            'calendar-write',
            'contacts-read',
            'contacts-write',
            'clones-write',
            'corporation-read',
            'fittings-read',
            'fittings-write',
            'fleets-read',
            'fleets-write',
            'killmails-read',
            'location-read',
            'ship-type-read',
            'mail-organize',
            'mail-read',
            'mail-send',
            'market-read',
            'planets-manage',
            'search-structures',
            'skills-read-queue',
            'skills-read',
            'ui-open',
            'ui-waypoint-write',
            'universe-read-structures',
            'wallet-read',
        ],
    ],

    'Cache' => [
        'Handler' => \Esier\Manager\Cache\PDO::class,
        'Prefix'  => 'esier_',

        //	Driver-specific configs
        'PDO' => [
            'db_type'  => 'mysql',
            'host'     => 'localhost',
            'username' => '',
            'password' => '',
            'table'    => 'ESI_Cache',
        ],
    ],

    'Session' => [
        'Handler' => \Esier\Manager\Session\PHPSession::class,

        //	Driver-specific configs
        'PHPSession' => [
            'name'   => 'esier',    //	prefix for session cookie
            'limit'  => 0,        //	lifetime of session cookie (in seconds)
            'path'   => '/',        //	path on domain that session cookie is accessible
            'domain' => null,    //	domain that session cookieis visible to
            'secure' => null,    //	set to true to only allow cookie to be sent over secure connections
        ],
    ],
];
