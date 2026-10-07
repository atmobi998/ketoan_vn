<?php

use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\Fixture\SchemaLoader;

// @codingStandardsIgnoreFile

$findRoot = function () {
    $root = dirname(__DIR__);
    if (is_dir($root . '/vendor/cakephp/cakephp')) {
        return $root;
    }

    $root = dirname(dirname(__DIR__));
    if (is_dir($root . '/vendor/cakephp/cakephp')) {
        return $root;
    }

    $root = dirname(dirname(dirname(__DIR__)));
    if (is_dir($root . '/vendor/cakephp/cakephp')) {
        return $root;
    }
};

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('ROOT', $findRoot());
define('APP_DIR', 'test_app');
define('WEBROOT_DIR', 'webroot');
define('APP', ROOT . '/tests/test_app/src/');
define('CONFIG', ROOT . '/tests/test_app/config/');
define('WWW_ROOT', ROOT . DS . WEBROOT_DIR . DS);
define('TESTS', ROOT . DS . 'tests' . DS);
define('TMP', ROOT . DS . 'tmp' . DS);
define('LOGS', TMP . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);
define('CAKE_CORE_INCLUDE_PATH', ROOT . '/vendor/cakephp/cakephp');
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);

require ROOT . '/vendor/autoload.php';
require CORE_PATH . 'config/bootstrap.php';

Cake\Core\Configure::write(
    'App',
    [
        'namespace' => 'CrudJsonApi\Test\App',
        'encoding' => 'UTF-8',
        'fullBaseUrl' => 'http://localhost'
    ]
);
Cake\Core\Configure::write('debug', true);

$tmps = ['models', 'persistent', 'views'];
foreach ($tmps as $tmp) {
    if (!is_dir(sprintf('%scache/%s', TMP, $tmp))) {
        mkdir(sprintf('%scache/%s', TMP, $tmp), 0777, true);
    }
}

$cache = [
    'default' => [
        'engine' => 'File'
    ],
    # This config key wasn't deprecated until CakePHP 5.1.
    # @link https://book.cakephp.org/5/en/core-libraries/caching.html#configuring-cache-engines
    '_cake_core_' => [
        'className' => 'File',
        'prefix' => 'crud_myapp_cake_core_',
        'path' => CACHE . 'persistent/',
        'serialize' => true,
        'duration' => '+10 seconds'
    ],
    '_cake_translations_' => [
        'className' => 'File',
        'prefix' => 'crud_myapp_cake_translations_',
        'path' => CACHE . 'persistent/',
        'serialize' => true,
        'duration' => '+10 seconds'
    ],
    '_cake_model_' => [
        'className' => 'File',
        'prefix' => 'crud_my_app_cake_model_',
        'path' => CACHE . 'models/',
        'serialize' => 'File',
        'duration' => '+10 seconds'
    ]
];

Cake\Cache\Cache::setConfig($cache);
Cake\Core\Configure::write(
    'Session',
    [
        'defaults' => 'php'
    ]
);

// Ensure default test connection is defined
if (!getenv('DB_URL')) {
    putenv('DB_URL=sqlite:///:memory:');
}

// Configure both 'default' and 'test' datasources.
$dbConfig = [
    'url' => getenv('DB_URL'),
    'timezone' => 'UTC'
];

ConnectionManager::setConfig('default', $dbConfig);
ConnectionManager::setConfig('test', $dbConfig);
ConnectionManager::alias('test', 'default');

$loader = new SchemaLoader();
$loader->loadInternalFile(ROOT . '/tests/Fixture/schema.php');

Plugin::getCollection()->add(new \Crud\CrudPlugin());
Plugin::getCollection()->add(new \CrudJsonApi\Plugin());
