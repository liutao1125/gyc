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
     * @param $uri
     */
    public static function dispatch($uri)
    {
        $mca_array = array_values(array_filter(explode('/', $uri)));
        self::buildModule();//构建模块结构
        //
        /**
         * 1:模块 其实对应名称空间
         * 2:控制器
         * 3:动作
         */
        switch (count($mca_array)) {
            case 0: {
                $module = DEFAULT_MODULE;
                $controller = DEFAULT_CONTROLLER;
                $action = DEFAULT_ACTION;
            }
                break;
            case 1: {
                $module = $mca_array[0];
                $controller = DEFAULT_CONTROLLER;
                $action = DEFAULT_ACTION;
            }
                break;
            case 2: {
                $module = $mca_array[0];
                $controller = $mca_array[1];
                $action = DEFAULT_ACTION;
            }
                break;
            case 3: {
                $module = $mca_array[0];
                $controller = $mca_array[1];
                $action = $mca_array[2];
            }
                break;
            default: {
                //404或异常
                IS_DEBUG ? Tip::debug('URL太长') : Tip::notFound();
            }
                break;
        }
        //定义模块名
        defined('MODULE_NAME') or define('MODULE_NAME', strtolower($module));
        if (is_dir(APP_PATH . $module)) {
            $name = ucfirst($module) . '\\Controller\\' . ucfirst($controller);
            $class = new $name;
            if (method_exists($class, $action)) {
                if (is_callable(array($name, $action), false)) {
                    $class->$action();
                } else {
                    IS_DEBUG ? Tip::debug("{$module}模块,{$controller}控制器,{$action}方法不能被调用,请检查方法的修饰符") : Tip::notFound();
                }
            } else {
                IS_DEBUG ? Tip::debug("{$module}模块,{$controller}控制器,{$action}方法不存在") : Tip::notFound();
            }
        } else {
            IS_DEBUG ? Tip::debug("{$module}模块不存在") : Tip::notFound();
        }
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