<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/27
 * Time: 上午11:47
 */
header("Content-type:text/html;charset=utf-8");
define('APPPATH',dirname(__FILE__).'/');
require APPPATH.'vendor/autoload.php';

require APPPATH."config/eloquent.php";

require APPPATH . "src/lib/GetConf.php";


$client = new \GuzzleHttp\Client();
//for ($i=2970;$i<3014;$i++)
//{
//    $html = $client->get("http://www.q2002.com/tu/".$i.".html")->getBody()->getContents();
//    $cr = new \Symfony\Component\DomCrawler\Crawler();
//    $cr->addHtmlContent($html);
//    $content = $cr->filterXPath('//ul[contains(@class,"dslist-group")]/li/a')->extract(array('href'));
//
//    $redis = new \Predis\Client([
//        'host'      =>  '127.0.0.1' ,
//        'port'      =>  6379 ,
//    ]);
//    foreach ($content as $url)
//    {
//        $redis->lpush('urlList',$url);
//    }
//}
$redis = new \Predis\Client([
    'host'      =>  '127.0.0.1' ,
    'port'      =>  6379 ,
]);
while ($url = $redis->rpop('urlList')){
    if(!strpos($url,'http')){
        $url = 'http://www.q2002.com'.$url;
    }
    $html = $client->get($url)->getBody()->getContents();
    $cr = new \Symfony\Component\DomCrawler\Crawler();
    $cr->addHtmlContent($html);
    $content = $cr->filterXPath('//div[contains(@class,"playpic")]/img')->attr('src');
    $time = time();
    $data = file_get_contents($content);
    $rand = rand(0,9999);
    $path ="/Users/liyuequn/www/blog/public/image/";
    $fileName = $time.$rand.".jpg";
    file_put_contents($path.$fileName,$data);
    \Spider\Model\Image::create(['url'=>$fileName]);
}

