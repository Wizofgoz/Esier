<?php
return array(
	'Scopes' => array(
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
		'wallet-read'
	),
	'Cache' => array(
		'Handler' => \Esir\Manager\Cache\PDO::class,
		'Prefix' => 'esir_',
		//	Driver-specific configs
		'PDO' => array(
			'db_type' => 'mysql',
			'host' => 'localhost',
			'username' => '',
			'password' => '',
			'table' => 'ESI_Cache'
		),
	),
	'Session' => array(
		'Handler' => \Esir\Manager\Session\PHPSession::class,
		'Prefix' => 'esir_',
		//	Driver-specific configs
		'PHPSession' => array(
			''
		),
	),
);
