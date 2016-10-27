<?php
namespace GYC\sys;
class ToolTip
{
    /**
     * 普通异常
     * @param \Exception $e
     */
    public static function exception(\Exception $e)
    {
        self::html($e);
    }

    /**
     * 数据库类异常
     * @param \PDOException $e
     */
    public static function pdoException(\PDOException $e)
    {
        self::html($e);
    }

    /**
     * 加载404页面
     */
    public static function e404()
    {
        include SYS_PATH . 'tooltip/404.php';
        exit();
    }

    /**
     * 重定向页面
     * @param $to_title
     * @param $url
     * @param $reason
     */
    public static function redirect($to_title, $url, $reason)
    {
        include SYS_PATH . 'tooltip/redirect.php';
        exit();
    }

    /**
     * 输出exception
     * @param $e
     */
    private static function html($e)
    {
        $getCode = $e->getCode();
        $getMessage = $e->getMessage();
        $getFile = $e->getFile();
        $getLine = $e->getLine();
        echo <<<EOT
<!DOCTYPE html>
<html>
<body>
<table border="1">
    <tr>
        <td><strong>Exception $getCode</strong>：$getMessage<br>
            <strong>in：</strong> $getFile <br>
            <strong>on line：</strong> $getLine
        </td>
    </tr>
</table>
</body>
</html>
EOT;
    }
}