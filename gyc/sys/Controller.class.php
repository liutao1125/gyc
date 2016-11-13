<?php
namespace Gyc\Sys;
class Controller
{
    /**
     * 加载视图
     * @param $view_file_name
     * @param array $dt
     */
    protected final function loadView($view_file_name, $dt = array())
    {
        $module = MODULE_NAME;
        $file = APP_PATH . "{$module}/view/$view_file_name.view.php";
        if (file_exists($file)) {
            if (!empty($dt)) {
                extract($dt);
            }
            include $file;
        } else {
            IS_DEBUG ? Tip::debug("视图{$file}文件不存在") : Tip::notFound();
        }
    }

    /**
     * 魔术方法必须为public
     * @param $name
     * @param $arguments
     */
    public final function __call($name, $arguments)
    {
        $class = __CLASS__;
        IS_DEBUG ? Tip::debug("调用了{$class}类中不存在的方法") : Tip::notFound();
    }
}