<?php
namespace GYC\sys;
class Router
{
    /**
     * 匹配路由
     * @param $bcm
     */
    public static function router($bcm)
    {
        $URL_CONFIG = null;
        //加载url配置文件
        require_once SYS_PATH . 'config/url.config.php';
        //去除:
        $colon_pos = strpos($bcm, ':');
        if ($colon_pos !== false) {
            $bcm = substr($bcm, 0, $colon_pos);
        }
        //后缀名排除
        $dot_pos = strpos($bcm, '.');
        if ($dot_pos !== false) {
            if (!in_array(substr($bcm, $dot_pos + 1), explode('|', $URL_CONFIG['suffix']))) {
                ToolTip::e404();
            }
            $bcm = substr($bcm, 0, $dot_pos);//去除后缀的bcm
        }
        self::dispatcher(self::getRelBCM($bcm), $URL_CONFIG);
    }

    /**
     * 获得真实的BCM
     * @param $bcm
     * @return mixed
     */
    private static function getRelBCM($bcm)
    {
        $URL_MAP_RULE_CONFIG = null;
        //加载静态路由规则配置文件
        require_once SYS_PATH . 'config/url_map_rule.config.php';
        //计算路由
        $bcm_array = array_filter(explode('/', $bcm));
        $bcm_count = count($bcm_array);
        if ($bcm_count > 0) {
            foreach ($URL_MAP_RULE_CONFIG as $key => $value) {
                //不需要array_filter,因为$key是来自配置文件
                $key_count = count(explode('/', $key));
                //个数相同
                if ($bcm_count == $key_count) {
                    //冒号位置
                    $colon_pos = strpos($key, ':');
                    //不包含请求参数且字符串相等，即匹配成功
                    if ($colon_pos === false && $bcm == $key) {
                        return $value;
                    } elseif ($colon_pos !== false) {//包含请求参数
                        //get关键字之前的
                        $rel_key = array_filter(explode('/', substr($key, 0, $colon_pos)));
                        $tf = true;
                        for ($i = 0; $i < count($rel_key); $i++) {
                            if ($rel_key[$i] != $bcm_array[$i]) {
                                $tf = false;
                                break;
                            }
                        }
                        if ($tf) {
                            $get_key = array_map(function ($v) {
                                return ltrim($v, ':');
                            }, array_filter(explode('/', substr($key, $colon_pos))));
                            //赋值$_GET
                            foreach ($get_key as $item) {
                                $_GET[$item] = $bcm_array[$i];
                                $i++;
                            }
                            return $value;
                        }
                    }
                }
            }
        }
        return $bcm;
    }

    /**
     * 分发给对应模块、控制器、方法
     * @param $url
     * @param $URL_CONFIG
     */
    private static function dispatcher($url, $URL_CONFIG)
    {
        //拆分出模块、控制器、方法
        $bcm_array = array_filter(explode('/', $url));
        $classname = null;
        $method = null;
        /**
         *
         * 0：默认模块、默认控制器、默认方法
         * 1：自选模块、默认控制器、默认方法
         * 2：自选模块、自选控制器、默认方法
         * 3：自选模块、自选控制器、自选方法
         *
         */
        switch (count($bcm_array)) {
            case 0: {
                $filename = APP_PATH . 'controller/' . strtolower($URL_CONFIG['block']) . '/' . ucfirst($URL_CONFIG['control']) . '.class.php';
                if (file_exists($filename)) {
                    require $filename;
                    $method = $URL_CONFIG['method'];
                    $classname = '\\' . ucfirst($URL_CONFIG['block']) . '\\' . ucfirst($URL_CONFIG['control']);
                }
            }
                break;
            case 1: {
                $filename = APP_PATH . 'controller/' . strtolower($bcm_array[0]) . '/' . ucfirst($URL_CONFIG['control']) . '.class.php';
                if (file_exists($filename)) {
                    require $filename;
                    $method = $URL_CONFIG['method'];
                    $classname = '\\' . ucfirst($bcm_array[0]) . '\\' . ucfirst($URL_CONFIG['control']);
                }
            }
                break;
            case 2: {
                $filename = APP_PATH . 'controller/' . strtolower($bcm_array[0]) . '/' . ucfirst($bcm_array[1]) . '.class.php';
                if (file_exists($filename)) {
                    require $filename;
                    $method = $URL_CONFIG['method'];
                    $classname = '\\' . ucfirst($bcm_array[0]) . '\\' . ucfirst($bcm_array[1]);
                }
            }
                break;
            case 3: {
                $filename = APP_PATH . 'controller/' . strtolower($bcm_array[0]) . '/' . ucfirst($bcm_array[1]) . '.class.php';
                if (file_exists($filename)) {
                    require $filename;
                    $method = $bcm_array[2];
                    $classname = '\\' . ucfirst($bcm_array[0]) . '\\' . ucfirst($bcm_array[1]);
                }
            }
                break;
            default: {
                ToolTip::e404();
            }
        }
        if (!empty($classname) && !empty($method)) {
            (new $classname())->$method();
        } else {
            ToolTip::e404();
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