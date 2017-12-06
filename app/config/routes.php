<?php
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

$router->removeExtraSlashes(true);
$router->setDefaults([
    'namespace'  => 'App\Controllers',
    'controller' => 'error',
    'action'     => 'page404',
]);

$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);

//==========Route for api==========
$api = new RouterGroup([
    'namespace' => 'App\Controllers',
]);

//Invalid api key
$api->addGet('/invalidapikey', 'error::page401');

/*
 * Activity News
 */
$api->addGet('/news', 'news::datalist');
$api->addGet('/newsall', 'news::datalistall');
$api->addGet('/news/{id}', 'news::show');
$api->addPost('/news', 'news::store');
$api->addPut('/news/{id}', 'news::update');
$api->addDelete('/news/{id}', 'news::destroy');
$api->addDelete('/news/softdestroy/{id}', 'news::softdestroy');
$api->addPost('/news/delete', 'news::destroyMulti');
$api->addPut('/news/status/{id}', 'news::status');


$router->mount($api);


return $router;
