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
            'host'     => '192.168.199.102',
            'username' => 'feed_mm_news',
            'password' => '1qaz2wsx',
            'dbname'   => 'feed_ms_news',
            'port'     => 33061,
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
        'baseUri'        => 'http://staging-feed-myanmar-api-news.eggdigital.com/',
        'staticUri'      => 'http://staging-feed-myanmar-api-news.eggdigital.com/',
    ],
    'image_path'  => 'http://staging-feed-myanmar-api-news.eggdigital.com/uploads/news/',
];

