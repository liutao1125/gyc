<?php
namespace Gyc\Lib;

use Gyc\Sys\Model;

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
        $this->uidSql('CREATE TABLE if NOT EXISTS sessions(id CHAR(32) NOT NULL PRIMARY KEY,data text NULL,last_accessed datetime NOT NULL DEFAULT CURRENT_TIMESTAMP)ENGINE=InnoDB DEFAULT CHARSET=utf8;');
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