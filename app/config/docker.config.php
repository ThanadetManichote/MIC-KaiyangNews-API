<?php

$settings = [
    'database' => [
        'mongo' => [
            'host'     => '',
            'port'     => 27017,
            'username' => '',
            'password' => '',
            'dbname'   => 'mic_activity'
        ],
        'sql' => [
            'host'     => 'mic-feednews-api-mysql',
            'username' => 'root',
            'password' => '123456',
            'dbname'   => 'mic_news',
            'port'     => 3306,
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
        'baseUri'        => 'http://alpha-feed-myanmar-api.eggdigital.com/',
        'staticUri'      => 'http://alpha-feed-myanmar-api.eggdigital.com/',
    ],
    'image_path'  => 'http://feed.dev:8840/uploads/news/',
];
