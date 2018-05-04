<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/25
 * Time: 下午5:54
 */

use Illuminate\Database\Capsule\Manager as Capsule;


// 载入数据库配置文件

require_once APPPATH.'config/database.php';

// Eloquent ORM

$capsule = new Capsule;

$capsule->addConnection($db['eloquent']);

$capsule->bootEloquent();