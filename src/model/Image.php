<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2018/4/25
 * Time: 下午5:28
 */
namespace Spider\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'image';
    protected $fillable = ['url'];
}