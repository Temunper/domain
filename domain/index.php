<?php
//    应用目录
define('APP_PATH',__DIR__ . '/');

//    调试模式
define('APP_DEBUG',true);

//加载框架文件
require(APP_PATH . 'fast_php/Fast_php.php');

//加载配置文件
$config = require(APP_PATH . 'config/config.php');

//实例化框架类
(new fast_php\Fast_php($config))->run();