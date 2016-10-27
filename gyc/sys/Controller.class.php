<?php
namespace GYC\sys;
class Controller
{
    /**
     * 加载视图
     * @param $view_file_name
     * @param array $dt
     * @throws GycException
     */
    protected final function loadView($view_file_name, $dt = array())
    {
        $file = APP_PATH . "view/$view_file_name.view.php";
        try {
            if (file_exists($file)) {
                if (!empty($dt)) {
                    extract($dt);
                }
                include $file;
            } else {
                throw new GycException('视图不存在！');
            }
        } catch (GycException $e) {
            echo $e;
        }
    }

    /**
     * 魔术方法必须为public
     * @param $name
     * @param $arguments
     */
    public final function __call($name, $arguments)
    {
        ToolTip::e404();
    }
}