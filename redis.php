<?php
define('APPPATH',dirname(__FILE__).'/');
require APPPATH.'vendor/autoload.php';

$redis = new \Predis\Client([
    'host'      =>  '127.0.0.1' ,
    'port'      =>  6379 ,
]);

$contentList = $redis->llen('contentList');
$pageList = $redis->llen('pageList');

//$set = $redis->del('pageUrl');
var_dump($pageList);exit;