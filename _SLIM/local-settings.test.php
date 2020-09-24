<?php

// Protect against web entry
if (!defined('ANSWEROPEDIA')) {
    exit('No web entry');
}

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

define('SITE_URL_NAME', 'answeropedia');
define('SITE_URL_DOMAIN', 'org');
define('SITE_URL', 'https://answeropedia.org');
define('IMAGE_URL', SITE_URL . '/assets/img');
define('JS_URL', SITE_URL . '/assets/js');

// paths
define('ROOT_PATH', __DIR__);
define('TEMPLATE_PATH', ROOT_PATH . '/app/Templates');

define('YANDEX_XML_KEY', '');
