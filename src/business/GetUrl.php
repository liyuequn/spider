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
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class GetUrl
{
    public $targetUrl;

    public $html;

    public $pageUrl;

    public $contentUrl;


    public function __construct($targetUrl)
    {
        $this->targetUrl = $targetUrl;
    }

    public function exec()
    {
        $this->getHtml();

        $this->getPageUrl();

        $this->getContentUrl();

        return $this;
    }


    public function getPageUrl()
    {
        $crawler = new Crawler();

        $crawler->addHtmlContent($this->html);

        $this->pageUrl = $crawler->filterXPath(GetConf('pageUrl'))->extract(array('href'));

        return $this->pageUrl;

    }

    public function getContentUrl()
    {
        $crawler = new Crawler();

        $crawler->addHtmlContent($this->html);

        $this->contentUrl = $crawler->filterXPath(GetConf('contentUrl'))->extract(array('href'));

        return $this->contentUrl;

    }


    public function getHtml()
    {
        try{
            $httpClient = new Client();

            $result = $httpClient->get($this->targetUrl);

            if($result->getStatusCode()==200){

                $this->html = $result->getBody()->getContents();

                return $this->html;

            }
        }catch (\Exception $e){
            $log = new Logger('getHtml');
            $log->pushHandler(new StreamHandler(APPPATH.'log/getHtml.log', Logger::WARNING));
//            $log->warning('Foo');
            $log->error($e->getMessage());
        }



    }
}