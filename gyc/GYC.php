<?php
header("X-Powered-By:GYC");

/**
 * 设置时区 'Asia/Shanghai'   亚洲/上海
 */
date_default_timezone_set('Asia/Shanghai');


/**
 * 自动加载类函数
 * @param $class_name
 */
function autoload_class($class_name)
{
    $i = strrpos($class_name, '\\');
    if ($i) {
        $class_name = substr($class_name, $i + 1);
    }
    //框架核心类库
    $file_name = SYS_PATH . "sys/$class_name.class.php";
    if (file_exists($file_name)) {
        require_once $file_name;
        return;
    }
    //框架类库
    $file_name = SYS_PATH . "lib/$class_name.class.php";
    if (file_exists($file_name)) {
        require_once $file_name;
        return;
    }
    //视图类
    $file_name = APP_PATH . "model/$class_name.class.php";
    if (file_exists($file_name)) {
        require_once $file_name;
        return;
    }
    //自定义辅助类
    $file_name = APP_PATH . "helper/$class_name.class.php";
    if (file_exists($file_name)) {
        require_once $file_name;
        return;
    }
}

/**
 * 注册自动加载类
 */
spl_autoload_register('autoload_class');


/**
 * 在本机时只关闭E_NOTICE错误提示，在服务器时关闭所有错误提示
 */
if (in_array(substr($_SERVER['HTTP_HOST'], 0, 5), array('127.0', '192.1', 'local'))) {
    error_reporting(E_ALL ^ E_NOTICE);
} else {
    set_error_handler(function ($e_number, $e_message, $e_file, $e_line, $e_vars) {
        if ($e_number != E_NOTICE) {
            echo '<div>A system error occurred . we apologize for the inconvenience.</div>';
        }
    });
}

/**
 * 获取模块,控制器,方法
 */
//index.php的位置
$index_pos = strpos($_SERVER['PHP_SELF'], 'index.php');
//直接获取了BCM,适用于不在根目录下
$bcm = trim(substr($_SERVER['PHP_SELF'], $index_pos + 9), '/');
//获取不在根目录的路径
$second_dir = trim(substr($_SERVER['PHP_SELF'], 0, $index_pos), '/');
//不在根目录下
if (empty($bcm) && empty($second_dir)) {
    //获取请求字符串的位置
    $request_pos = strpos($_SERVER['REQUEST_URI'], '?');
    if ($request_pos === false) {
        $bcm = trim($_SERVER['REQUEST_URI'], '/');
    } else {
        $bcm = trim(substr($_SERVER['REQUEST_URI'], 0, $request_pos), '/');
    }
}

//开始路由
GYC\sys\Router::router($bcm);