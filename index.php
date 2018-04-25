<?php
define('APPPATH',dirname(__FILE__).'/');

require APPPATH."config/eloquent.php";
//
//异步获取文章内容
$getContent = new \Spider\Business\GetContent();
$getContent->exec();
//获取文章链接
$getLink = new \Spider\Business\GetLinks('https://mp.weixin.qq.com/s/EjVfk1iOuQUjLfPxt_DJ7Q');
$getLink->exec();



