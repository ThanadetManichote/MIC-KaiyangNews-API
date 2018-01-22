<?php

if (getenv('ENVIRONMENT') === 'develop') {
    $environment = 'develop';
} elseif (getenv('ENVIRONMENT') === 'staging') {
    $environment = 'staging';
} elseif (getenv('ENVIRONMENT') === 'staging_feed') {
    $environment = 'staging_feed';
} elseif (getenv('ENVIRONMENT') === 'production') {
    $environment = 'production';
} elseif (getenv('ENVIRONMENT') === 'production_feed') {
    $environment = 'production_feed';
} elseif (getenv('ENVIRONMENT') === 'docker') {
    $environment = 'docker';
} else {
    $environment = 'staging';
}

require $environment . '.config.php';

return new \Phalcon\Config($settings);
