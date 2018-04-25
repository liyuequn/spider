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

    protected $num;



    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public static function push ($links)
    {
        if(!is_array($links)){
            return false;
        }else{
            foreach ($links as $link){
                $queue = new self();
                $queue->redis->lpush('mylist',$link);
            }
        }

    }

    public static function pop ()
    {
        $queue = new self();
        return $queue->redis->rpop('mylist');
    }
}