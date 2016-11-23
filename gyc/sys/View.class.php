<?php
namespace Gyc\Sys;
class View
{
    protected $dtV = array();

    private function __construct()
    {

    }

    public static function getInstance()
    {
        static $obj;
        if (!isset($obj)) {
            $obj = new View();
        }
        return $obj;
    }

    /**
     * 为视图赋值
     * @param $key
     * @param $value
     */
    public function assign($key, $value)
    {
        $this->dtV[$key] = $value;
    }

    /**
     * 输出视图
     * @param $view_file_name
     * @param $dt
     */
    public function display($view_file_name, $dt = array())
    {
        if (!empty($dt) && is_array($dt)) {
            $this->dtV = array_merge($this->dtV, $dt);
        }
        $module = MODULE_NAME;
        $file = APP_PATH . "{$module}/view/$view_file_name.view.php";
        if (file_exists($file)) {
            if (!empty($this->dtV)) {
                extract($this->dtV);
            }
            include $file;
        } else {
            IS_DEBUG ? Tip::debug("视图{$file}文件不存在") : Tip::notFound();
        }
    }
}