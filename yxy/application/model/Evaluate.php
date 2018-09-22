<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/4/12
 * Time: 上午11:06
 */

namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;
class Evaluate extends Model
{
    use SoftDelete;
    protected $name='evaluate';
    protected $deleteTime = 'del_time';

    /**
     * 序列化
     * @param $values
     * @return string
     */
    public function setPictureAttr($values){
        return serialize($values);
    }

    /**
     * 反序列化
     * 修改图片字段
     * @param $values
     * @return array
     */
    public function getPictureAttr($values){
       if(empty($values)){
           return [];
       }
        $values=unserialize($values);
        $pic=array();
        if(!empty($values)){
            foreach($values as $value){
                $pic[]=url($value,'',false,true);
            }
        }


        return $pic;
    }


    public function getUser(){
        return $this->belongsTo(User::class,'user_id','id');
    }




    public function getType(){
        return $this->belongsTo(EvaluateType::class,'type_id','id');
    }
}