<?php
namespace Gyc\Sys;
/**
 * 路由类
 * Class Router
 * @package Gyc\Sys
 */
class Router
{
    /**
     * 解析路由
     * @param $mca_array
     */
    public static function parseRouter($mca_array)
    {
        if (empty($mca_array)) {//没有任何路由参数
            $relMca_array = null;
        } else {//需要路由匹配
            $roules_array = array();
            foreach (explode('|', REGISTER_MODULE) as $m) {
                //合并所有模块的路由配置
                $file = APP_PATH . "$m/config/router.config.php";
                if (file_exists($file)) {
                    $roule_array = require $file;
                    $roules_array = array_merge($roules_array, $roule_array);
                }
            }
            if (!empty($roules_array)) {
                $relMca_array = self::relMCA($mca_array, $roules_array);
            } else {
                //路由配置都是空的
                $relMca_array = null;
            }
        }
        self::dispatch($relMca_array);
    }

    /**
     * 获取真实的MCA
     * @param $mca_array
     * @param $roules_array
     * @return mixed
     */
    private static function relMCA($mca_array, $roules_array)
    {
        foreach ($roules_array as $key => $value) {
            $key_array = explode('/', $key);//路由左边的值拆分成数组
            if (count($key_array) == count($mca_array)) {//数量相同才比较,可能有匹配项
                $colon_pos = strpos($key, ':');
                $has_get = false;
                if ($colon_pos !== false) {//包含GET请求
                    $has_get = true;
                    $noColon_array = array_filter(explode('/', substr($key, 0, $colon_pos)));
                } else {
                    $noColon_array = $key_array;
                }
                $is_match = true;
                for ($i = 0; $i < count($noColon_array); $i++) {
                    if ($noColon_array[$i] != $mca_array[$i]) {
                        $is_match = false;
                        break;
                    }
                }
                if ($is_match) {//有匹配项
                    if ($has_get) {//有GET参数,为$_GET赋值
                        for ($i; $i < count($key_array); $i++) {
                            $_GET[ltrim($key_array[$i], ':')] = $mca_array[$i];
                        }
                    }
                    return explode('/', $value);
                }
            }
        }
        return $mca_array;
    }

    /**
     * 根据路由表里面的真实MCA进行调度
     * @param $relMca_array
     */
    private static function dispatch($relMca_array)
    {
        /**
         * 1:模块 其实对应名称空间
         * 2:控制器
         * 3:动作
         */
        switch (count($relMca_array)) {
            case 0: {
                $module = DEFAULT_MODULE;
                $controller = DEFAULT_CONTROLLER;
                $action = DEFAULT_ACTION;
            }
                break;
            case 1: {
                $module = $relMca_array[0];
                $controller = DEFAULT_CONTROLLER;
                $action = DEFAULT_ACTION;
            }
                break;
            case 2: {
                $module = $relMca_array[0];
                $controller = $relMca_array[1];
                $action = DEFAULT_ACTION;
            }
                break;
            case 3: {
                $module = $relMca_array[0];
                $controller = $relMca_array[1];
                $action = $relMca_array[2];
            }
                break;
            default: {
                //404或异常
                IS_DEBUG ? Tip::debug('URL太长') : Tip::notFound();
            }
                break;
        }
        //定义模块名
        defined('MODULE_NAME') or define('MODULE_NAME', $module);
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
     * 防止实例化
     * Router constructor.
     */
    private function __construct()
    {

    }
}