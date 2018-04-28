<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/26
 * Time: 上午10:41
 */
return [

    'startUrl'=>'https://mp.weixin.qq.com/s/EjVfk1iOuQUjLfPxt_DJ7Q',//初始链接

    'pageUrl'=>'//section/p/a',//分页链接

    'contentUrl'=>'//section/p/a',//内容页链接

    'table'=>'',//数据表名称
    //数据库字段
    'field'=>[
        'name'=>"//h2[contains(@id,'activity-name')]",

        'content'=>"//div[contains(@id,'js_content')]",

    ],

];