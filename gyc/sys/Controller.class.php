<?php
namespace Gyc\Sys;
class Controller
{
    protected $view = null;

    /**
     * Ajax返回
     * @param $data
     * @param string $type
     */
    protected function ajaxReturn($data, $type = 'json')
    {
        switch (strtolower($type)) {
            case 'json': {
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            }
                break;
            case 'text': {
                // 返回文本
                header('Content-Type:text/html; charset=utf-8');
                echo $data;
            }
                break;
            default: {
                echo $data;
            }
        }
        exit();
    }

    /**
     * 给视图类赋值
     * @param $key
     * @param $value
     */
    protected function assign($key, $value)
    {
        $this->view = View::getInstance();
        $this->view->assign($key, $value);
    }

    /**
     * 加载视图
     * @param $view_file_name
     * @param array $dt
     */
    protected function display($view_file_name, $dt = array())
    {
        $this->view = View::getInstance();
        $this->view->display($view_file_name, $dt);
    }

    /**
     * 魔术方法必须为public
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $class = __CLASS__;
        IS_DEBUG ? Tip::debug("调用了{$class}类中不存在的方法") : Tip::notFound();
    }
}