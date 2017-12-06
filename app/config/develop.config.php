<?php

$settings = [
    'database' => [
        'mongo' => [
            'host'     => 'mic-activity-api-mongo',
            'port'     => 27017,
            'username' => '',
            'password' => '',
            'dbname'   => 'mic_activity'
        ],
        'sql' => [
            'host'     => '',
            'username' => '',
            'password' => '',
            'dbname'   => '',
            'port'     => 27020,
            'charset'  => 'utf8',
        ]
    ],
    'application' => [
        'repoDir'        => __DIR__.'/../../app/repositories/',
        'servicesDir'    => __DIR__.'/../../app/services/',
        'viewsDir'       => __DIR__.'/../../app/views/',
        'modelsDir'      => __DIR__.'/../../app/models/',
        'controllersDir' => __DIR__.'/../../app/controllers/',
        'libraryDir'     => __DIR__.'/../../app/library/',
        'testDir'        => __DIR__.'/../../app/tests/',
        'baseUri'        => 'http://alpha-kaiyang-myanmar-api.eggdigital.com/',
        'staticUri'      => 'http://alpha-kaiyang-myanmar-api.eggdigital.com/',
    ],

];
