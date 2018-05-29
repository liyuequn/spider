<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/26
 * Time: 上午10:41
 */
return [
    'base_uri'=>'',

    'startUrl'=>'',//初始链接

    'pageUrl'=>'//div[contains(@class,"pagination")]/a',//分页链接

    'contentUrl'=>'//div[contains(@class,"channel")]/ul/li/a',//内容页链接

    'table'=>'',//数据表名称
    //数据库字段
    'field'=>[
        'name'=>'//div[contains(@class,"page_title")]',

        'content'=>'//div[contains(@class,"content")]',

    ],

];

