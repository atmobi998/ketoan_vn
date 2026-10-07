<?php

use function Cake\Core\env;

/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */
return [
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),

    'Maintenance' => [
        'enable' => false, // Chuyển từ true thành false
    ],

    /*
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', 'd162aecaca8ed8b34ef76d758473260315527a9df6139c810b3637968d86efc2'),
    ],

    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        'default' => [
            'persistent' => false,
            'host' => '127.0.0.1',
            'port' => '3306',
            'username' => 'ketoan_vn',
            'password' => '=KJ8mh[[OOOx',
            'database' => 'ketoan_vn',
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'log' => false,
            'quoteIdentifiers' => false,
            'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
            'url' => 'mysql://ketoan_vn:=KJ8mh[[OOOx@127.0.0.1:3306/ketoan_vn',
            'unix_socket' => null,
        ],

        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'persistent' => false,
            'host' => '127.0.0.1',
            'port' => '3306',
            'username' => 'ketoan_vn',
            'password' => '=KJ8mh[[OOOx',
            'database' => 'ketoan_vn',
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'log' => false,
            'quoteIdentifiers' => false,
            'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
            'url' => 'mysql://ketoan_vn:=KJ8mh[[OOOx@127.0.0.1:3306/ketoan_vn',
            'unix_socket' => null,
        ],
        'debug_kit' => [
            'persistent' => false,
            'host' => '127.0.0.1',
            'port' => '3306',
            'username' => 'ketoan_vn',
            'password' => '=KJ8mh[[OOOx',
            'database' => 'ketoan_vn',
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'log' => false,
            'quoteIdentifiers' => false,
            'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
            'url' => 'mysql://ketoan_vn:=KJ8mh[[OOOx@127.0.0.1:3306/ketoan_vn',
            'unix_socket' => null,
        ],
    ],

    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'host' => '://smtp.streetplan.net',
            'port' => 587,
            'timeout' => 300,
            'username' => 'staff@streetplan.net',
            'password' => 'sqAyA2zp9c3D',
            'client' => null,
            'tls'=>true,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
];
