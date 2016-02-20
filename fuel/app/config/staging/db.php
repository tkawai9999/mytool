<?php
/**
 * The staging database settings. These get merged with the global settings.
 */
$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$db['dbname'] = ltrim($db['path'], '/');

return array(
	'default' => array(
		'connection'  => array(
            'dsn'        => 'mysql:host='.$db['host'].';dbname='.$db['dbname'],
            'username'   => $db['user'],
            'password'   => $db['pass'],
		),
	),
);
