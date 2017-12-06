<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\DI\FactoryDefault;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\View;
use Phalcon\Session\Adapter\Files as SessionAdapter;

use Phalcon\Mvc\Collection\Manager;
use Phalcon\Db\Adapter\MongoDB\Client;
/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

//add repository
$di->setShared('repository', function() {
    return new \App\Repositories\Repositories();
});

/**
 * connect my Sql
 */

$di->set('db', function () use ($settings) {
    return new DbAdapter($settings['database']['sql']);
});

/**
 * Connect mongo
 */
$di->setShared('mongo', function() {

    $config = $this->getShared('config');
    if (!$config->database->mongo->username || !$config->database->mongo->password) {
        $dsn = 'mongodb://' . $config->database->mongo->host.":". $config->database->mongo->port;
    } else {
        $dsn = sprintf(
            'mongodb://%s:%s@%s:%s/%s',
            $config->database->mongo->username,
            $config->database->mongo->password,
            $config->database->mongo->host,
            $config->database->mongo->port,
            $config->database->mongo->dbname
        );
    }

    $mongo = new Client($dsn);

    return $mongo->selectDatabase($config->database->mongo->dbname);
});

$di->set('collectionManager', function() {
    return new Manager();
}, true);

/**
 * Registering a router
 */
$di->set('router', function () {
    $router = new Router();
    require 'routes.php';
    return $router;
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

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function() {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});

$di->set('cookies', function() {
    $cookies = new Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(false);
    return $cookies;
});

/**
 * Registering a dispatcher
 */
$di->set('dispatcher', function() {
    // Create/Get an EventManager
    $eventsManager = new Phalcon\Events\Manager();

    // Attach a listener
    $eventsManager->attach('dispatch', function ($event, $dispatcher, $exception) {
        // The controller exists but the action not
        if ($event->getType() == 'beforeNotFoundAction') {
            $dispatcher->forward([
                'namespace'  => 'App\Controllers',
                'controller' => 'error',
                'action'     => 'page404',
            ]);
            return false;
        }

        // Alternative way, controller or action doesn't exist
        if ($event->getType() == 'beforeException') {
            switch ($exception->getCode()) {
                case Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward([
                        'namespace'  => 'App\Controllers',
                        'controller' => 'error',
                        'action'     => 'page404',
                    ]);
                    return false;
            }
        }
    });

    $dispatcher = new Phalcon\Mvc\Dispatcher();

    // Bind the EventsManager to the dispatcher
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

/**
 * Registering a util
 */
$di->set('util', function() {
    $util = new Util();
    return $util;
});

/**
 * Registering curl for connect to another server
 */
$di->set('curl', function() {
    $curl = new Curl();
    return $curl;
});

// Register a "response" service in the container
$di->set('response', function () {
    $response = new Response();
    return $response;
});

// Register a "request" service in the container
$di->set('request', function() {
    $request = new Request();
    return $request;
});

//add config and message
$di->set('config', $config, true);
$di->set('status', $status, true);
$di->set('message', $message, true);


$di->set(
    'translation',
    function () use ($di) {
        $language = 'en';

        $messages = include '../app/language/' . $language . '/errormsg.php';

        return new \Phalcon\Translate\Adapter\NativeArray([
           'content' => $messages
        ]);
    },
    true
);

$di->set(
    'trans_mm',
    function () use ($di) {
        $messages = include '../app/language/mm/errormsg.php';
        return $messages;
    },
    true
);
