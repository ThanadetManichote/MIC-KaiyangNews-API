<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//Get Error All
if (getenv('ENVIRONMENT') === 'docker') {
    error_reporting(E_ALL);
}

//Set timezone
date_default_timezone_set('Asia/Yangon');

try {

    /**
     * Read the configuration
     */
    $config  = include __DIR__ . '/../app/config/config.php';
    $message = include __DIR__ . '/../app/config/message.php';
    $status  = include __DIR__ . '/../app/config/status.php';
    $helper  = include __DIR__ . '/../app/helper/global.php';

    /**
     * Read auto-loader
     */
    include __DIR__ . '/../app/config/loader.php';

    /**
     * Read services
     */
    include __DIR__ . '/../app/config/services.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}
