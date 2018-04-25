<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/25
 * Time: 下午7:38
 */
namespace Spider\Business;

use Spider\Business\Queue;
use Spider\Model\Source;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class GetContent
{
    public function exec()
    {

        $httpClient = new Client();


        while(1){
            $crawler = new Crawler();

            $link = Queue::pop();

            if(!$link){
                sleep(1);
            }else{
                $result = $httpClient->get($link);

                if($result->getStatusCode()==200){
                    $html = $result->getBody()->getContents();
                }

                $crawler->addHtmlContent($html);

                $text1 = $crawler->filterXPath("//h2[contains(@id,'activity-name')]")->text();
                $text2 = $crawler->filterXPath("//div[contains(@id,'js_content')]")->text();

                //存数据库

                $data = [
                    'name'=>trim($text1),
                    'content'=>trim($text2),
                    'link'=>$link,
                ];

                Source::create($data);
            }


        }


    }
}