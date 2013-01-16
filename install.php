<?php
if (is_file('./data/install.lock')) {
    header('Location: ./');
    exit;
}
/* 应用名称*/
define('APP_NAME', 'install');
/* 应用目录*/
define('APP_PATH', './install/');
/* 框架目录*/
define('THINK_PATH', './_core/');
/* DEBUG开关*/
define('APP_DEBUG', false);
require( THINK_PATH . "ThinkPHP.php");