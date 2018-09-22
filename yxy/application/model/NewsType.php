<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/13
 * Time: 11:43
 */

namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;

class NewsType extends Model
{

    protected $name = 'new_type';
    use SoftDelete;
    protected $deleteTime = 'del_time';
}