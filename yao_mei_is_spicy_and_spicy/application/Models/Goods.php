<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/5/29
 * Time: 上午11:55
 */

namespace app\Models;


use think\Model;

class Goods extends Model
{
    protected $name='goods';

public function getImgAttr($v){
        return url($v,'',false,true);
    }
}