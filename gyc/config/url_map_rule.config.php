<?php

/*
 *
 * 静态路由规则
 *
 */

$URL_MAP_RULE_CONFIG = array(
    //home
    'about' => 'home/about',
    'talk' => 'home/talk',
    'thanks' => 'home/thanks',
    'book' => 'home/book',
    'book/help' => 'home/book/help',
    /**/
    'book/:bid' => 'home/book/single',
    'cate/:cid' => 'home/blog/cate',
    'tag/:tname/:tid' => 'home/blog/tag',
    'time/:areldt' => 'home/blog/areldt',
    'article/:aid' => 'home/blog',
    'talk/:p' => 'home/talk',
    //admin
);