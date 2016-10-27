<?php
namespace GYC\sys;

use PDO;
use PDOException;

class Model
{
    private static $dbp = null;
    private $where_str = null;

    public function __construct()
    {
        $DB_CONFIG = null;
        require SYS_PATH . 'config/db.config.php';//加载数据库配置文件
        /*
         * 连接数据库
         */
        if (!self::$dbp instanceof PDO) {
            try {
                self::$dbp = new PDO("mysql:host={$DB_CONFIG['h']};dbname={$DB_CONFIG['db']}", $DB_CONFIG['u'], $DB_CONFIG['p']);
                self::$dbp->exec("SET NAMES 'utf8'");
            } catch (PDOException $e) {
                ToolTip::pdoException($e);
            }
        }
    }

    /**
     * 纯sql语句,查询并返回一条索引为结果集列名的一维数组,
     * @param $sql
     * @return bool|mixed
     */
    protected final function findSql($sql)
    {
        try {
            $stmt = self::$dbp->prepare($sql);
            $stmt->execute();
            if ($stmt->columnCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            ToolTip::pdoException($e);
        }
    }

    /**
     * 纯sql语句,查询并返回多条索引为结果集列名的二维数组,
     * @param $sql
     * @return array|bool
     */
    protected final function selectSql($sql)
    {
        try {
            $stmt = self::$dbp->prepare($sql);
            $stmt->execute();
            if ($stmt->columnCount() > 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            ToolTip::pdoException($e);
        }
    }

    /**
     * 通过纯Sql语句方式对数据库进行插入，删除，修改操作，成功返回受影响的行数，失败返回false
     * @param $sql
     * @return bool|int
     */
    protected final function uidSql($sql)
    {
        try {
            $stmt = self::$dbp->prepare($sql);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                return $rowCount;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            ToolTip::pdoException($e);
        }
    }

    /**
     * 查询多条数据,返回二维数组
     * @param $table
     * @param string $fields
     * @param array $where_data
     * @return array|bool
     */
    protected final function select($table, $fields = '*', $where_data = array())
    {
        $sql = "select $fields from $table";
        if (!empty($this->where_str)) {
            $sql .= $this->where_str;
        }
        try {
            $stmt = self::$dbp->prepare($sql);
            if (empty($where_data)) {
                $stmt->execute();
            } else {
                $stmt->execute($where_data);
            }
            if ($stmt->columnCount() > 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            ToolTip::pdoException($e);
        } finally {
            $this->where_str = null;
        }
    }

    /**
     * 查询单条数据，返回一维数组
     * @param $table
     * @param string $fields
     * @param array $where_data
     * @return bool|mixed
     */
    protected final function find($table, $fields = '*', $where_data = array())
    {
        $sql = "select $fields from $table";
        if (!empty($this->where_str)) {
            $sql .= $this->where_str;
        }
        try {
            $stmt = self::$dbp->prepare($sql);
            if (empty($where_data)) {
                $stmt->execute();
            } else {
                $stmt->execute($where_data);
            }
            if ($stmt->columnCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            ToolTip::pdoException($e);
        } finally {
            $this->where_str = null;
        }
    }

    /**
     * 执行更新操作,成功返回受影响的行数，失败返回false
     * @param $table
     * @param array $sets
     * @param array $where_data
     * @return bool|int
     */
    protected final function update($table, $sets = array(), $where_data = array())
    {
        $sql = "update $table set ";
        $set_str = null;
        foreach ($sets as $k => $v) {
            if (strpos($k, ':') === false) {
                $set_str .= ltrim($k, ':') . "=$v,";
            } else {
                $set_str .= ltrim($k, ':') . '=' . self::$dbp->quote($v) . ',';
            }
        }
        $sql .= rtrim($set_str, ',') . " {$this->where_str}";
        try {
            self::$dbp->beginTransaction();
            $stmt = self::$dbp->prepare($sql);
            if (empty($where_data)) {
                $stmt->execute();
            } else {
                $stmt->execute($where_data);
            }
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                self::$dbp->commit();
                return $rowCount;
            } else {
                self::$dbp->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            ToolTip::pdoException($e);
        } finally {
            $this->where_str = null;
        }
    }

    /**
     * 执行插入操作,成功返回受影响的行数，失败返回false
     * @param $table
     * @param array $value_data
     * @return bool|int
     */
    protected final function insert($table, $value_data = array())
    {
        $fields = implode(',', array_map(function ($v) {
            return ltrim($v, ':');
        }, array_keys($value_data)));
        $value_str = implode(',', array_keys($value_data));
        $sql = "insert into $table ($fields) VALUES ($value_str)";
        try {
            self::$dbp->beginTransaction();
            $stmt = self::$dbp->prepare($sql);
            $stmt->execute($value_data);
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                self::$dbp->commit();
                return $rowCount;
            } else {
                self::$dbp->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            ToolTip::pdoException($e);
        }
    }

    /**
     * 执行替换操作,有则替换,无则插入成功返回受影响的行数，失败返回false
     * @param $table
     * @param array $value_data
     * @return bool|int
     */
    protected final function replace($table, $value_data = array())
    {
        $fields = implode(',', array_map(function ($v) {
            return ltrim($v, ':');
        }, array_keys($value_data)));
        $value_str = implode(',', array_keys($value_data));
        $sql = "replace into $table ($fields) VALUES ($value_str)";
        try {
            self::$dbp->beginTransaction();
            $stmt = self::$dbp->prepare($sql);
            $stmt->execute($value_data);
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                self::$dbp->commit();
                return $rowCount;
            } else {
                self::$dbp->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            ToolTip::pdoException($e);
        }
    }

    /**
     * 执行删除操作,成功返回受影响的行数，失败返回false
     * @param $table
     * @param array $where_data
     * @return bool|int
     */
    protected final function delete($table, $where_data = array())
    {
        $sql = "delete from $table {$this->where_str}";
        try {
            self::$dbp->beginTransaction();
            $stmt = self::$dbp->prepare($sql);
            if (empty($where_data)) {
                $stmt->execute();
            } else {
                $stmt->execute($where_data);
            }
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                self::$dbp->commit();
                return $rowCount;
            } else {
                self::$dbp->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            ToolTip::pdoException($e);
        } finally {
            $this->where_str = null;
        }
    }

    /**
     * 设置条件，不是条件值：calories < :calories AND colour = :colour';
     * @param $str
     * @return $this
     */
    protected final function where($str)
    {
        $this->where_str = ' ' . $str;
        return $this;
    }

    /**
     * 针对MySQL,自增字段，获得刚刚插入的id
     * @return bool
     */
    public final function getLastInsertId()
    {
        try {
            $sql = 'select LAST_INSERT_ID() as id';
            $stmt = self::$dbp->query($sql);
            if ($stmt->columnCount() > 0) {
                return $stmt->fetch()['id'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            ToolTip::pdoException($e);
        }
    }

    /**
     * 销毁dbp对象
     */
    /* public final function __destruct()
     {
         self::$dbp = null;
     }*/
}