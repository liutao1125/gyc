<?php
namespace Gyc\Sys;

/**
 * 调度类
 * Class Dispatcher
 * @package Gyc\Sys
 */
class Dispatcher
{
    /**
     * 调度
     */
    public static function dispatch()
    {
        self::buildModule();//构建模块结构
        //
        $index_pos = strpos($_SERVER['PHP_SELF'], 'index.php');
        $mca = substr($_SERVER['PHP_SELF'], $index_pos + 9);
        if (!empty($mca)) {
            $dot_pos = strrpos($mca, '.');
            if ($dot_pos !== false) {
                $suffix = substr($mca, $dot_pos + 1);
                if (!in_array($suffix, explode('|', ALLOW_SUFFIX))) {
                    IS_DEBUG ? Tip::debug("不允许{$suffix}后缀") : Tip::notFound();//404页面
                }
                $mca = substr($mca, 0, $dot_pos);
            }
            $mca_array = array_filter(explode('/', trim($mca, '/')));
        } else {
            $mca_array = null;
        }
        Router::parseRouter($mca_array);
    }

    /**
     * 构建模块目录结构
     */
    private static function buildModule()
    {
        new Build();
    }

    /**
     * Dispatcher constructor.防止实例化
     */
    private function __construct()
    {

    }
}