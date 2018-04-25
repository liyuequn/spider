<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/25
 * Time: 下午5:28
 */
namespace Spider\Model;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = 'source';
    protected $fillable = ['name','link','content'];
}