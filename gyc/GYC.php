<?php

/**
 * 设置X-Powered-By
 */

header("X-Powered-By:GYC");

/**
 * PHP的版本判断
 */
if (version_compare(PHP_VERSION, '5.2.0') == -1) {
    echo '<p>Gyc 要求PHP版本高于5.2.0</p>';
    exit();
}


/**
 * 设置时区 'Asia/Shanghai'   亚洲/上海
 */
date_default_timezone_set('Asia/Shanghai');


/**
 * 定义应用路径
 */
defined('APP_PATH') or define('APP_PATH', './app/');

/**
 * 定义资源路径
 */
defined('ASSET_PATH') or define('ASSET_PATH', './asset/');

/**
 * 决定使用http或https
 */
if ($_SERVER['SERVER_PORT'] == '80') {
    $transfer_protocol = 'http://';
} elseif ($_SERVER['SERVER_PORT'] == '443') {
    $transfer_protocol = 'https://';
}

/**
 * 定义根url
 */
defined('BASE_URL') or define('BASE_URL', "$transfer_protocol{$_SERVER ['HTTP_HOST']}" . substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php')));


/**
 * 定义资源URL
 */
defined('ASSET_URL') or define('ASSET_URL', "$transfer_protocol{$_SERVER ['HTTP_HOST']}" . substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php')) . 'asset/');


/**
 * 定义框架路径
 */
defined('GYC_PATH') or define('GYC_PATH', './gyc/');


/**
 * 加载MCA配置
 */
include GYC_PATH . 'config/mca.config.php';

/**
 * 加载调试配置
 */
include GYC_PATH . 'config/debug.config.php';

/**
 * 屏蔽NOTICE级别错误
 */
if (NO_NOTICE) {
    error_reporting(E_ALL ^ E_NOTICE);
}


/**
 * 自动加载类
 */
spl_autoload_register(function ($class) {
    $name_array = array_map(function ($item) {
        return lcfirst($item);
    }, explode('\\', $class));
    $path = null;
    $count = count($name_array);
    for ($i = 0; $i < $count; $i++) {
        $path .= "{$name_array[$i]}/";
        if ($i == $count - 2) {
            $c = ucfirst($name_array[$i + 1]);
            $path .= $c;
            break;
        }
    }
    $path_array = array(
        "./$path.class.php",
        APP_PATH . "$path.class.php",
    );
    foreach ($path_array as $p) {
        if (file_exists($p)) {
            require $p;
            break;
        }
    }
});


Gyc\Sys\Dispatcher::dispatch();