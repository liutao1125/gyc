<?php
namespace Gyc\Lib;
/**
 * 树形结构
 * Class Tree
 * @package Gyc\Lib
 */
class Tree
{
    /**
     * 把返回的数据集转换成Tree
     * @param $list
     * @param string $pk
     * @param string $pid
     * @param string $child
     * @param int $root
     * @return array
     */
    public function listToTree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
    {
        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                    $list[$key]['level'] = $root;
                } else {
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                        $list[$key]['level'] = $parent['level'] + 1;
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * 树形结构转换为排序列表，基于pid分组后的tree
     * @param $tree
     * @return array
     */
    public function treeToSort($tree)
    {
        static $arr = array();
        foreach ($tree as $key => &$value) {
            $arr[$value['id']] = $value;
            if (!empty($value['_child'])) {
                $this->treeToSort($value['_child']);
                unset($arr[$value['id']]['_child']);
            }
        }
        return $arr;
    }

    /**
     * 获得子节点编号
     * @param $list
     * @param $id
     * @return array
     */
    public function getChildsId($list, $id)
    {
        static $arr = array();
        foreach ($list as $v) {
            if ($v['pid'] == $id) {
                $arr[] = $v['id'];
                $this->getChildsId($list, $v['id']);
            }
        }
        return $arr;
    }
}