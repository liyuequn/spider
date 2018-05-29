<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/26
 * Time: 下午3:42
 */

namespace Spider\Business;


class Schedule
{
    protected $targetUrl;

    public function __construct()
    {
        if(GetConf('startUrl')!=''){
            $this->targetUrl = GetConf('startUrl');
        }else{
            throw new \Exception("没有设置起始URL");
        }
    }

    public function exec()
    {
        while(true){
            if($this->targetUrl){
                $targetUrl = $this->targetUrl;
                $this->targetUrl = false;

            }else{
                $targetUrl = $this->setTarget();
            }
            $getUrl = new GetUrl($targetUrl);
            $urls = $getUrl->exec();
            print_r($urls);
            $this->saveUrl($urls);
            Queue::checkQueue();

        }

    }

    public function init()
    {
        while(true){
            $url = Queue::pop('contentList');
            if($url){
                $setContent = new GetContent($url);
                $setContent->exec();
            }else{
                sleep(1);
            }
        }
    }

    public function setTarget()
    {
        $pageUrl = Queue::pop('pageList');
        if(!$pageUrl){
            echo "sleep"."\n";
            sleep(1);
        }else{
            if(!strpos($pageUrl,'http')){
                $pageUrl = GetConf('base_uri').$pageUrl;
            }
            $this->targetUrl = $pageUrl;
        }

    }

    public function saveUrl($urls)
    {
        Queue::push('pageList',$urls['pageUrl']);
        Queue::push('contentList',$urls['contentUrl']);

    }
}