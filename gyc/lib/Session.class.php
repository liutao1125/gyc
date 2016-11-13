<?php
namespace Gyc\Lib;

class Session
{
    public function __construct($db = null)
    {
        if ($db == 'db') {
            session_set_save_handler(new SessionDb(), true);
        }
    }

    /**
     * 设置Session
     * @param $prefix
     * @param $k
     * @param $v
     * @param null $path
     * @return mixed
     */
    public final function set($prefix, $k, $v, $path = null)
    {
        session_start();
        if (!empty($path)) {
            session_save_path($path);
        }
        return $_SESSION["{$prefix}_$k"] = $v;
    }

    /**
     * 获得Session
     * @param $prefix
     * @param $k
     * @return null
     */
    public final function get($prefix, $k)
    {
        session_start();
        if (isset($_SESSION["{$prefix}_$k"])) {
            return $_SESSION["{$prefix}_$k"];
        } else {
            return null;
        }
    }

    /**
     * 删除指定Session
     * @param $prefix
     * @param $k
     * @return bool
     */
    public final function del($prefix, $k)
    {
        session_start();
        unset($_SESSION["{$prefix}_$k"]);
        return true;
    }

    /**
     * 销毁Session
     * @return bool
     */
    public final function destroy()
    {
        session_start();
        return session_destroy();
    }
}