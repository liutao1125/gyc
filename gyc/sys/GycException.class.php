<?php

namespace GYC\sys;

use Exception;

/**
 * 自定义的异常处理类
 * Class GycException
 * @package GYC\sys
 */
class GycException extends Exception
{
    // 重定义构造器使 message 变为必须被指定的属性
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        // 自定义的代码
        // 确保所有变量都被正确赋值
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        $getCode = $this->getCode();
        $getMessage = $this->getMessage();
        $getFile = $this->getFile();
        $getLine = $this->getLine();
        return <<<EOT
        <!DOCTYPE html>
        <html>
        <body>
<table border="1">
    <tr>
        <td><strong>Exception $getCode</strong>：$getMessage<br>
        <strong>in：</strong> $getFile <br> 
        <strong>on line：</strong> $getLine</td>
    </tr>
</table>
       </body>
       </html>
EOT;
    }
}