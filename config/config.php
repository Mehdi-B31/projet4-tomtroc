<?php

session_start();

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'tomtroc');
define('DB_USER', 'root');
define('DB_PASS', '');

define('TEMPLATE_VIEW_PATH', './views/templates/');
define('MAIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'main.php');