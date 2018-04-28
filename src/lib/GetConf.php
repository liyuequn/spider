<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/26
 * Time: 下午2:13
 */

function GetConf($field){

    $config = require APPPATH."src/config.php";

    return $config[$field];

}