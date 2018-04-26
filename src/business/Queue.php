<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/25
 * Time: 下午7:04
 */
namespace Spider\Business;

class Queue
{
    protected $redis;

    public static $num;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    /**
     * @param $list
     * @param $urls
     * @return bool
     * @throws \Exception
     */
    public static function push ($list,$urls)
    {
        if(!is_array($urls)){

            throw new \Exception("获取到的结果不是数组");

        }else{
            foreach ($urls as $url){

                $queue = new self();
                //如果集合已经存在，就没必要继续加进队列
                if($queue->redis->sIsMember('pageUrl',$url)==0){
                    $queue->redis->lpush($list,$url);
                    //把列表页的url放进集合一份
                    if($list=='pageList'){
                        $queue->redis->sAdd('pageUrl',$url);
                    }
                }

            }
        }
        return true;

    }

    public static function pop ($list)
    {
        $queue = new self();
        return $queue->redis->rpop($list);
    }

    public static function checkQueue(){
        $queue = new self();
        $num = $queue->redis->llen('contentList') + $queue->redis->llen('pageList');
        if($num==0){
            die('运行结束');
        }
    }



}