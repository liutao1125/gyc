<?php
namespace Gyc\Lib;

use Gyc\Sys\Model;

class Session
{
    public function __construct($type = null)
    {
        $t = SAVE_SESSION;
        if (isset($type)) {
            $t = $type;
        }
        switch ($t) {
            case 'db': {
                session_set_save_handler(new SessionDb(), true);
            }
                break;
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


class SessionDb extends Model implements \SessionHandlerInterface
{
    public function close()
    {
        return true;
    }

    public function destroy($session_id)
    {
        $this->where('where id=:id')->delete('sessions',
            array(
                ':id' => $session_id
            ));
        // Clear the $_SESSION array:
        $_SESSION = array();
        return true;
    }

    public function gc($maxlifetime)
    {
        $this->where("where DATE_ADD(last_accessed, INTERVAL $maxlifetime SECOND) < NOW()")->delete('sessions');
        return true;
    }

    public function open($save_path, $name)
    {
        $this->sqlExec('CREATE TABLE if NOT EXISTS sessions(id CHAR(32) NOT NULL PRIMARY KEY,data text NULL,last_accessed datetime NOT NULL DEFAULT CURRENT_TIMESTAMP)ENGINE=InnoDB DEFAULT CHARSET=utf8;');
        return true;
    }

    public function read($session_id)
    {
        $result = $this->where('where id=:id')->find('sessions', 'data', array(
            ':id' => $session_id
        ));
        if ($result) {
            return $result['data'];
        } else {
            return '';
        }
    }

    public function write($session_id, $session_data)
    {
        $this->replace('sessions', array(
            ':id' => $session_id,
            ':data' => $session_data
        ));
        return true;
    }
}