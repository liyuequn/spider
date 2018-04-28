<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/25
 * Time: 下午7:38
 */
namespace Spider\Business;

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
        $this->targetUrl = $targetUrl;
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

        foreach ($this->field as $index => $item){
            $data[$index] = $crawler->filterXPath($item)->text();
        }

        return $data;

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
            $log->error($e->getMessage());
        }



    }

    public function save($data)
    {
        $data = array_merge($data,['link'=>$this->targetUrl]);
        return Source::create($data);
    }
}