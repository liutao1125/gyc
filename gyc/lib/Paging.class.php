<?php

namespace Gyc\Lib;
/**
 * 分页类
 * Class Paging
 * @package Gyc\Lib
 */
class Paging
{
    private $totalPages;//总页数
    private $currentPage;//当前页
    private $maxPages;//显示的最多页数

    /**
     * Paging constructor.
     * @param $total
     * @param int $currentPage
     * @param int $pageSize
     * @param null $maxPages
     */
    public function __construct($total, $currentPage = 1, $pageSize = 10, $maxPages = null)
    {
        if ($total > 0 && $currentPage > 0 && $pageSize > 0) {
            $this->totalPages = ceil($total / $pageSize);
            $this->currentPage = $currentPage;
            $this->maxPages = $maxPages;
        }
    }

    /**
     * 第一页
     * @return bool|int
     */
    public function firstPage()
    {
        return $this->totalPages > 0 ? 1 : false;
    }

    /**
     * 最后一页
     * @return bool|float
     */
    public function lastPage()
    {
        return $this->totalPages();
    }

    /**
     * 上一页
     * @return bool|float
     */
    public function previousPage()
    {
        if ($this->currentPage > 1 && $this->totalPages() > 1) {
            return $this->currentPage - 1;
        } else {
            return false;
        }
    }

    /**
     * 下一页
     * @return bool|int
     */
    public function nextPage()
    {
        if ($this->totalPages() && ($this->totalPages() - $this->currentPage > 0)) {
            return $this->currentPage + 1;
        } else {
            return false;
        }
    }

    /**
     * 当前页
     * @return bool|int
     */
    public function currentPage()
    {
        return $this->currentPage > 0 ? $this->currentPage : false;
    }

    /**
     * 获得页面总个数
     * @return bool|float
     */
    public function totalPages()
    {
        return $this->totalPages > 0 ? $this->totalPages : false;
    }

    /**
     * 中间页
     * @return array
     */
    public function middlePages()
    {
        if ($this->maxPages) {//设置了
            $average = ceil($this->maxPages / 2);
            if ($this->maxPages % 2 == 0) {
                $start = $this->currentPage - $average;
                $end = $this->currentPage + $average - 1;
            } else {
                $start = $this->currentPage - $average + 1;
                $end = $this->currentPage + $average - 1;
            }
            if ($start > 0 && $end <= $this->totalPages()) {
                return range($start, $end);//在之间
            }
            if ($start > 0 && $end > $this->totalPages()) {
                //右边不足
                $i = $this->totalPages() - $this->maxPages + 1;
                if ($i > 0) {
                    return range($i, $this->totalPages());
                } else {
                    return range($start, $this->totalPages());
                }
            }
            if ($start < 1 && $end <= $this->totalPages()) {
                //左边不足
                if ($this->maxPages <= $this->totalPages()) {
                    return range(1, $this->maxPages);
                } else {
                    return range(1, $end);
                }
            }
            if ($start < 1 && $end > $this->totalPages()) {
                return range(1, $this->totalPages());//两边不足
            }
        } else {//未设置
            return range(1, $this->totalPages());
        }
    }
}