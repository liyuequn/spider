<?php
define('APPPATH',dirname(__FILE__).'/');
// Autoload 自动载入

require APPPATH.'vendor/autoload.php';

require APPPATH."config/eloquent.php";

require APPPATH."config/etc.php";

require APPPATH . "src/lib/GetConf.php";

if($argv){
    if($argv[1]=='run') {
        //异步获取链接
        $schedule = new \Spider\Business\Schedule();
        $schedule->exec();
    }

    if($argv[1]=='init') {
        //异步获取文章内容
        $schedule = new \Spider\Business\Schedule();
        $schedule->init();
    }
}








