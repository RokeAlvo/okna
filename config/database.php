<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'novosibirsk'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'novosibirsk' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'timezoneSettings' => 'Asia/Novosibirsk',
            'shortName' => 'nsk',
            'workTime' => ['09:00', '18:00']
        ],

        'sankt-peterburg' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'smartcrm_spb',
            'username' => 'adminsmartcrm',
            'password' => '0H0u7K1u',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'timezoneSettings' => 'Europe/Moscow',
            'shortName' => 'spb',
            'workTime' => ['09:00', '18:00']
        ],

        'barnaul' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'smartcrm_brn',
            'username' => 'adminsmartcrm',
            'password' => '0H0u7K1u',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'timezoneSettings' => 'Asia/Barnaul',
            'shortName' => 'brn',
            'workTime' => ['09:00', '18:00']
        ],

        'perm' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'smartcrm_prm',
            'username' => 'adminsmartcrm',
            'password' => '0H0u7K1u',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'timezoneSettings' => 'Asia/Yekaterinburg',
            'shortName' => 'prm',
            'workTime' => ['09:00', '18:00']
        ],

        'krasnoyarsk' => [
			'driver' => 'mysql',
			'host' => '127.0.0.1',
			'port' => '3306',
			'database' => 'smartcrm_kry',
			'username' => 'adminsmartcrm',
			'password' => '0H0u7K1u',
			'unix_socket' => env('DB_SOCKET', ''),
			'charset' => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix' => '',
			'strict' => true,
			'engine' => null,
			'timezoneSettings' => 'Asia/Krasnoyarsk',
			'shortName' => 'kry',
            'workTime' => ['09:00', '18:00']
        ],

        'ryazan' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'smartcrm_ryz',
            'username' => 'adminsmartcrm',
            'password' => '0H0u7K1u',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'timezoneSettings' => 'Europe/Moscow',
            'shortName' => 'ryz',
            'workTime' => ['09:00', '18:00']
        ],

        'moskva' => [
			'driver' => 'mysql',
			'host' => '127.0.0.1',
			'port' => '3306',
			'database' => 'smartcrm_msk',
			'username' => 'adminsmartcrm',
			'password' => '0H0u7K1u',
			'unix_socket' => env('DB_SOCKET', ''),
			'charset' => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix' => '',
			'strict' => true,
			'engine' => null,
			'timezoneSettings' => 'Europe/Moscow',
			'shortName' => 'msk',
            'workTime' => ['09:00', '18:00']
        ],

        'voronezh' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'smartcrm_vrn',
            'username' => 'adminsmartcrm',
            'password' => '0H0u7K1u',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'timezoneSettings' => 'Europe/Moscow',
            'shortName' => 'vrn',
            'workTime' => ['09:00', '18:00']
        ],

        'kirov' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'smartcrm_kir',
            'username' => 'adminsmartcrm',
            'password' => '0H0u7K1u',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'timezoneSettings' => 'Europe/Moscow',
            'shortName' => 'kir',
            'workTime' => ['09:00', '18:00']
        ],

        'krasnodar' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'smartcrm_krd',
            'username' => 'adminsmartcrm',
            'password' => '0H0u7K1u',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'timezoneSettings' => 'Europe/Moscow',
            'shortName' => 'krd',
            'workTime' => ['09:00', '18:00']
        ],

        'krym' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'smartcrm_krm',
            'username' => 'adminsmartcrm',
            'password' => '0H0u7K1u',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'timezoneSettings' => 'Europe/Moscow',
            'shortName' => 'krm',
            'workTime' => ['09:00', '18:00']
        ],

        'orel' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'smartcrm_orl',
            'username' => 'adminsmartcrm',
            'password' => '0H0u7K1u',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'timezoneSettings' => 'Europe/Moscow',
            'shortName' => 'orl',
            'workTime' => ['09:00', '18:00']
        ],

        'penza' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'smartcrm_pnz',
            'username' => 'adminsmartcrm',
            'password' => '0H0u7K1u',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'timezoneSettings' => 'Europe/Moscow',
            'shortName' => 'pnz',
            'workTime' => ['09:00', '18:00']
        ],

        'chelyabinsk' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'smartcrm_chl',
            'username' => 'adminsmartcrm',
            'password' => '0H0u7K1u',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'timezoneSettings' => 'Asia/Yekaterinburg',
            'shortName' => 'chl',
            'workTime' => ['09:00', '18:00']
        ],

        'testing' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ],

        //@preg_city_config_path метка для обозначения места для программной инъекции конфигов дб, системно необходима

        /*'mysql-old-local' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'okna_novosib',
            'username' => 'okna_novosib',
            'password' => 'R7w5J5g3',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysql-old-test' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'okna_novosib_dev',
            'username' => 'okna_novosib',
            'password' => 'R7w5J5g3',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysql-old-prod' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'okna_novosib',
            'username' => 'okna_novosib',
            'password' => 'R7w5J5g3',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],*/

        /*'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],*/

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
