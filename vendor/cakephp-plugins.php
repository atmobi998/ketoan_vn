<?php
$baseDir = dirname(dirname(__FILE__));

return [
    'plugins' => [
        'ADmad/Sequence' => $baseDir . '/vendor/admad/cakephp-sequence/',
        'Authentication' => $baseDir . '/vendor/cakephp/authentication/',
        'Authorization' => $baseDir . '/vendor/cakephp/authorization/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'BootstrapUI' => $baseDir . '/vendor/friendsofcake/bootstrap-ui/',
        'Cake/TwigView' => $baseDir . '/vendor/cakephp/twig-view/',
        'Crud' => $baseDir . '/vendor/friendsofcake/crud/',
        'CrudJsonApi' => $baseDir . '/vendor/friendsofcake/crud-json-api/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Search' => $baseDir . '/vendor/friendsofcake/search/',
    ],
];
