<?php
$redis = new \Redis();
$redis->connect('127.0.0.1', 6379);

$contentList = $redis->lRange('contentList',0,-1);
$pageList = $redis->lRange('pageList',0,-1);

var_dump($contentList);