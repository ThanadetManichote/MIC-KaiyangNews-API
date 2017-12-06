<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->libraryDir,
        $config->application->servicesDir,
        $config->application->repoDir,
        $config->application->viewsDir,
        $config->application->modelsDir,
        $config->application->controllersDir,
        $config->application->testDir,
    )
);

$loader->registerNamespaces(array(
    'App\\Controllers'     => $config->application->controllersDir,
    'App\\Repositories'    => $config->application->repoDir,
    'App\\Services'        => $config->application->servicesDir,
    'App\\Library'         => $config->application->libraryDir,
    'App\\Model'           => $config->application->modelsDir,
    'App\\Tests'           => $config->application->testDir,
));

$loader->register();
include __DIR__ . '/../../vendor/autoload.php';
