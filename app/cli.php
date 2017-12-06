<?php
use Phalcon\CLI\Console as ConsoleApp,
    Phalcon\DI\FactoryDefault\CLI as CliDI;

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View;

// Using the CLI factory default services container
$di = new CliDI();


// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__)));

$loader = new \Phalcon\Loader();

$loader->registerDirs([
    __DIR__.'/tasks',
]);
$loader->registerNamespaces([

    'App\\Repositories' => __DIR__.'/repositories/',
    'App\\Tasks'        => __DIR__.'/tasks/',
    'App\\Services'     => __DIR__.'/services/',
    'App\\Models'       => __DIR__.'/models/',
]);

$loader->register();

// Add repository
$di->setShared('repository', function () {
    return new \App\Repositories\Repositories();
});

/**
 * Load the configuration all bank
 */
$configFile = __DIR__.'/config/config.php';

if (is_readable($configFile)) {
    $config = include $configFile;
    $di->set('config', $config);
}

// Create a console application
$console = new ConsoleApp();
$console->setDI($di);
/**
 * Process the console arguments
 */
$arguments = [];

foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments["task"] = $arg;
    } elseif ($k === 2) {
        $arguments["action"] = $arg;
    } elseif ($k >= 3) {
        $arguments["params"][] = $arg;
    }
}
/**
 * connect db
 */
$di->set('db', function () use ($settings) {
    return new DbAdapter($settings['database']);
});
/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    $view->registerEngines([
        '.volt' => function ($view, $di) {
            $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
            $volt->setOptions([
                'compileAlways' => true,
            ]);
            return $volt;
        },
    ]);
    return $view;
});
$di->setShared('console', $console);
//Load vendor
include __DIR__ . '/../vendor/autoload.php';
try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    echo $e->getMessage();
    exit(255);
}
