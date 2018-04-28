<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/27
 * Time: 上午11:47
 */
define('APPPATH',dirname(__FILE__).'/');

require APPPATH."config/eloquent.php";

require APPPATH . "src/lib/GetConf.php";

$cr = new \Symfony\Component\DomCrawler\Crawler();

$client = new \GuzzleHttp\Client();

$html = $client->get("https://mp.weixin.qq.com/s?__biz=MzAxOTc0NzExNg==&mid=2665513059&idx=1&sn=a2eaf97d9e3000d15a33681d1b720463&scene=19#wechat_redirect")->getBody()->getContents();

$cr->addHtmlContent($html);
$content = $cr->filterXPath("//div[contains(@id,'js_content')]")->text();

print_r($content);