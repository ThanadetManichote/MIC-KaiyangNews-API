<?php

$settings = [
    'database' => [
        'sql' => [
            'host'     => '192.168.110.132',
            'username' => 'mic_news',
            'password' => '1qaz2wsx',
            'dbname'   => 'mic_news',
            'charset'  => 'utf8',
        ]
    ],
    'application' => [
        'repoDir'        => __DIR__.'/../../app/repositories/',
        'taskDir'        => __DIR__.'/../../app/tasks',
        'servicesDir'    => __DIR__.'/../../app/services/',
        'viewsDir'       => __DIR__.'/../../app/views/',
        'modelsDir'      => __DIR__.'/../../app/models/',
        'controllersDir' => __DIR__.'/../../app/controllers/',
        'libraryDir'     => __DIR__.'/../../app/library/',
        'testDir'        => __DIR__.'/../../app/tests/',
        'baseUri'        => 'http://staging-mic-kaiyangnews-api.eggdigital.com/',
        'staticUri'      => 'http://staging-mic-kaiyangnews-api.eggdigital.com/',
    ],
    'curl_api' => [
        'redeem'   => 'staging-kaiyang-myanmar-api-redeem.eggdigital.com/',
    ],
    'image_path'  => 'http://staging-admin-kaiyang.eggdigital.com:8840/uploads/news/',
];


