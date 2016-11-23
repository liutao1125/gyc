<?php
/**
 * 真正的路由
 */
$router = new \Gyc\Sys\Router();


$router->get('/article/(\d+).html', 'Home\Controller\Blog@index');

$router->get('/cate/(\d+).html', 'Home\Controller\Blog@cate');

$router->get('/time/([a-z0-9_-]+).html', 'Home\Controller\Blog@areldt');

$router->get('/update/([a-z0-9_-]+).html', 'Home\Controller\Blog@update');

$router->get('/tag/([^/]+)?(/\d+)?.html', 'Home\Controller\Blog@update');

$router->get('/talk.html', 'Home\Controller\Talk@index');

$router->get('/talk/(\d+).html', 'Home\Controller\Talk@index');

$router->get('/about.html', 'Home\Controller\About@index');

$router->get('/thanks.html', 'Home\Controller\Thanks@index');


$router->run();