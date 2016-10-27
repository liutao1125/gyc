<?php
/*
 * 1.命名空间的首字母大写，其余小写
 * 2.类文件的首字母大写
 * 3.根url:BASE_URL最后没有/
 */

/**
 * 定义网站名称
 */
define('TITLE', '6K & 3o');


/**
 * 定义项目路径
 */
define('APP_PATH', __DIR__ . '/app/');


/**
 * 定义资源路径
 */
define('ASSET_PATH', 'http://' . $_SERVER ['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php')) . 'asset/');


/**
 * 定义根url(只有它最后没有‘/’)
 */
define('BASE_URL', 'http://' . $_SERVER ['HTTP_HOST'] . rtrim(substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php')), '/'));


/**
 * 定义框架核心路径
 */
define('SYS_PATH', __DIR__ . '/gyc/');


/**
 * 定义上传文件夹路径
 */
define('UPLOAD_PATH', __DIR__ . '/asset/upload/');

/**
 * 引入核心框架文件
 */
require './gyc/GYC.php';