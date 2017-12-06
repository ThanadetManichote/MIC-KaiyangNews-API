<?php

use Phalcon\DI,
    Phalcon\DI\FactoryDefault;

ini_set('display_errors', 1);
error_reporting(E_ALL);
// ob_start();

defined('APP_PATH') || define('APP_PATH', realpath(dirname(__FILE__)) . '/../../app');
defined('BASE_PATH') || define('BASE_PATH', realpath(dirname(__FILE__)) . '/../..');

if(!defined('ROOT_PATH')) define('ROOT_PATH', __DIR__);
if(!defined('PATH_LIBRARY')) define('PATH_LIBRARY', __DIR__ . '/../library/');
if(!defined('PATH_SERVICES')) define('PATH_SERVICES', __DIR__ . '/../services/');
if(!defined('PATH_RESOURCES')) define('PATH_RESOURCES', __DIR__ . '/../resources/');

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

// Helpers
require_once ROOT_PATH . '/../helper/global.php';

$di = new FactoryDefault();

define('ENVIRONMENT', 'docker');

$message = include ROOT_PATH . '/../config/message.php';
$status  = include ROOT_PATH . '/../config/status.php';
$config  = include ROOT_PATH . '/../config/config.php';
$di->set('config', $config);


/**
 * Read auto-loader
 */
include ROOT_PATH . '/../config/loader.php';

$loader->registerDirs(array(
    rtrim(ROOT_PATH, '/') . '/'
));

/**
 * Read load di models
 */
// $di_model = include ROOT_PATH . '/../config/loaddi_model.php';

/**
 * Read services
 */
require ROOT_PATH . "/../config/services.php";

// required for phalcon/incubator
include ROOT_PATH . "/../../vendor/autoload.php";

DI::reset();

// add any needed services to the DI here

DI::setDefault($di);
