<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/5/7
 * Time: 下午4:37
 */

namespace app\model;


use think\Model;

class NewImg extends Model
{
    protected $name='new_img';
    /**
     * 获取img的时候进行修改
     * @param $value
     * @return string
     */
    public function getImgAttr($value){
        return url($value,'',false,true);
    }
}