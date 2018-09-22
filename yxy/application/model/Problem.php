<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/5/4
 * Time: 下午5:16
 */

namespace app\model;


use think\Model;

class Problem extends Model
{
    protected $name='problem';

    public function getType(){
        return $this->belongsTo(ProblemType::class,'type_id','id');
    }


    public function setContentAttr($value){
        return htmlspecialchars($value);
    }

    public function getContentAttr($value){
        return htmlspecialchars_decode($value);
    }

}