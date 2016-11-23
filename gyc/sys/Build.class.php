<?php
namespace Gyc\Sys;
/**
 * 构建类
 * Class Build
 * @package Gyc\Sys
 */
class Build
{
    public function __construct()
    {
        self::create(DEFAULT_MODULE);
    }

    /**
     * 创建模块目录
     * @param $name
     */
    private function create($name)
    {
        $path = APP_PATH . "$name/";
        if (!is_dir($path) && is_writeable(APP_PATH)) {
            $dirs = array(
                $path,
                $path . 'helper/',
                $path . 'config/',
                $path . 'controller/',
                $path . 'model/',
                $path . 'view/',
            );
            foreach ($dirs as $dir) {
                mkdir($dir);
                fopen($dir . 'index.html', "w");
            }
            file_put_contents($dirs[3] . 'Welcome.class.php', $this->getControllerContent($name));
        }
    }

    /**
     * 获得控制器内容
     * @param $name
     * @return string
     */
    private function getControllerContent($name)
    {
        $name = ucfirst($name);
        return "<?php
namespace $name\\Controller;

use Gyc\\Sys\\Controller;

class Welcome extends Controller
{
    public function index()
    {
        echo 'Hello Gyc!';
    }
}";
    }
}