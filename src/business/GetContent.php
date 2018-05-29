<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/25
 * Time: 下午7:38
 */
namespace Spider\Business;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Spider\Model\Source;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class GetContent
{
    public $targetUrl;

    public $html;

    public $field;


    public function __construct($targetUrl)
    {
        $this->targetUrl = GetConf('base_uri').$targetUrl;
        if(count(GetConf("field"))>0){
            $this->field = GetConf("field");
        }else{
            throw new \Exception("未设置数据库字段");
        }
    }

    public function exec()
    {
        $this->getHtml();
        $data = $this->getContent();
        $this->save($data);

    }

    public function getContent()
    {
        $crawler = new Crawler();

        $crawler->addHtmlContent($this->html);

        $data = [];
        try{
            foreach ($this->field as $index => $item){
                $data[$index] = trim($crawler->filterXPath($item)->text());
            }
            return $data;
        }catch (\Exception $e){
            $log = new Logger('getContent');
            $log->pushHandler(new StreamHandler(APPPATH.'log/getContent.log', Logger::WARNING));
            $log->error($e->getMessage().$item);
        }


    }


    public function getHtml()
    {
        try{
            $httpClient = new Client();

            $result = $httpClient->get($this->targetUrl);
            if($result->getStatusCode()==200){

                $this->html = $result->getBody()->getContents();
                $this->html = iconv('GBK','UTF-8',$this->html);
                return $this->html;

            }
        }catch (\Exception $e){
            $log = new Logger('getContentHtml');
            $log->pushHandler(new StreamHandler(APPPATH.'log/getHtml.log', Logger::WARNING));
            $log->error($e->getMessage().$this->html);
        }



    }

    public function save($data)
    {
        try{
            if(!is_array($data)) return false;
            $data = array_merge($data,['url'=>$this->targetUrl]);
            return Source::create($data);
        }catch (\Exception $e){
            $log = new Logger('save');
            $log->pushHandler(new StreamHandler(APPPATH.'log/save.log', Logger::WARNING));
            $log->error($e->getMessage());
        }


    }
}