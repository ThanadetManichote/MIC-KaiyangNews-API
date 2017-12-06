<?php

$settings = [
    'database' => [
        'host'     => '192.168.2.102',
        'username' => 'admin_kaiyang',
        'password' => 'KaiyangGFvSmm2017DB!',
        'dbname'   => 'kaiyang',
        'port'     => 3306,
        'charset'  => 'utf8',
    ],
    'application' => [
        'repoDir'        => __DIR__.'/../../app/repositories/',
        'servicesDir'    => __DIR__.'/../../app/services/',
        'viewsDir'       => __DIR__.'/../../app/views/',
        'modelsDir'      => __DIR__.'/../../app/models/',
        'controllersDir' => __DIR__.'/../../app/controllers/',
        'libraryDir'     => __DIR__.'/../../app/library/',
        'testDir'        => __DIR__.'/../../app/tests/',
        'baseUri'        => 'https://api.cpfivestarmyanmarapp.com',
        'staticUri'      => 'https://api.cpfivestarmyanmarapp.com',
    ],
    'curl_api' => [
        'redeem'   => 'https://api-ms-redeem.cpfivestarmyanmarapp.com/',
        'otp'      => 'https://api-ms-otp.cpfivestarmyanmarapp.com/',
        'location' => 'rpp-location-ms-api.dev/'
    ],
    // 'sendsms' => [
    //     'url'      => 'http://api-smsgw.eggdigital.com/sms/57b17f6a260b260505c56b58/text/single',
    //     'username' => 'testforsms',
    //     'password' => '123456',
    // ],
    'sendsms' => [
        'url'      => 'http://api-smsgw.eggdigital.com/sms/59436b7a260b265b247eb2c7/text/single',
        'username' => 'chickenmyanmar',
        'password' => 'Xa8p87ax',
    ],
    'cdn_path'  => '/data/cdn/',
    'card_path' => [
        'pic'        => 'https://api.cpfivestarmyanmarapp.com/image/card.png',
        'picdefault' => 'https://api.cpfivestarmyanmarapp.com/image/carddefault.png',
        'font'       => ''
    ]
];
