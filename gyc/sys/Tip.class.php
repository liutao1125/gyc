<?php
namespace Gyc\Sys;

/**
 * 提示
 * Class Tip
 * @package Gyc\Sys
 */
class Tip
{
    /**
     * 404页面
     */
    public static function notFound()
    {
        include GYC_PATH . 'template/404.php';
        exit();
    }

    /**
     * 页面跳转
     * @param $to_title
     * @param $url
     * @param $reason
     */
    public static function go($to_title, $url, $reason)
    {
        include GYC_PATH . 'template/go.php';
        exit();
    }

    /**
     * 调试模式的提示信息
     * @param $desc
     */
    public static function debug($desc)
    {
        include GYC_PATH . 'template/debug.php';
        exit();
    }

    /**
     * 异常
     * @param \Exception $e
     */
    public static function e(\Exception $e)
    {
        $code = $e->getCode();
        $message = $e->getMessage();
        $file = $e->getFile();
        $line = $e->getLine();
        include GYC_PATH . 'template/debug.php';
        exit();
    }
}