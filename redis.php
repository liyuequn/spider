<?php
define('APPPATH',dirname(__FILE__).'/');
require APPPATH.'vendor/autoload.php';

$redis = new \Predis\Client([
    'host'      =>  '127.0.0.1' ,
    'port'      =>  6379 ,
]);

$contentList = $redis->lrange('contentList',0,-1);
$pageList = $redis->lrange('pageList',0,-1);
$urlList = $redis->lrange('urlList',0,-1);



//$set = $redis->del('pageList');
//$set = $redis->del('pageListSet');
//$set = $redis->del('contentList');
//$set = $redis->del('contentListSet');
var_dump($contentList);
var_dump($urlList);
var_dump($pageList);

header("Content-type: text/html; charset=utf-8");
//利用PHP目录和文件函数遍历用户给出目录的所有的文件和文件夹，修改文件名称
function fRename($dirname){
    if(!is_dir($dirname)){
        echo "{$dirname}不是一个有效的目录！";
        exit();
    }
    $handle = opendir($dirname);
    $i = 1;
    while(($fn = readdir($handle))!==false){

        if($fn!='.'&&$fn!='..'){
            echo "<br>将名为：".$fn."\n\r";
            $curDir = $dirname.'/'.$fn;
            if(is_dir($curDir)){
                fRename($curDir);
            }else{
                $path = pathinfo($curDir);
                //改成你自己想要的新名字
                $newname = $path['dirname'].'/'.$i.'.'.$path['extension'];
                echo "替换成:".$i.'.'.$path['extension']."\r\n";
                rename($curDir,$newname);
                $i++;
            }
        }
    }
}
//给出一个目录名称可以是相对路径，也可以是绝对路径
fRename('/Users/liyuequn/www/blog/public/already');
exit();