<?php

namespace Gyc\Sys;
/**
 * ActiveRecords模式的ORM模型
 * Class ActiveRecord
 * @package Gyc\Sys
 */
class ActiveRecord
{
    private $data = array();

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function insert()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}