<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/25
 * Time: 下午7:18
 */
namespace Spider\Business;

use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class GetLinks
{
    public $startUrl;

    public function __construct($startUrl)
    {
        $this->startUrl = $startUrl;
    }

    public function exec()
    {
        $crawler = new Crawler();

        $httpClient = new Client();

        $result = $httpClient->get($this->startUrl);

        if($result->getStatusCode()==200){
            $html = $result->getBody()->getContents();
        }

        $crawler->addHtmlContent($html);


        $arr = $crawler->filterXPath("//section/p/a")->extract(array('href'));

        Queue::push($arr);
    }
}