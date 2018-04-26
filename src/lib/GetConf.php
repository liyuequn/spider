<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/26
 * Time: 下午2:13
 */

function GetConf($filed){

    $config = require APPPATH."src/config.php";
    return $config[$filed];

}