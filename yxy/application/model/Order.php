<?php
/**
 * Created by PhpStorm.
 * User: weilang
 * Date: 2018/4/11
 * Time: 15:50
 */
namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;

class Order extends Model{
	
    protected $table='yxy_order';
    use SoftDelete;
    protected $deleteTime = 'del_time';


     //关联课程表
    public function getCourse(){
        return $this->hasOne('course','id','course_id');
    }

    //关联课时表
    public function getClassHour(){
        return $this->hasOne('ClassHour','id','class_hour_id');
    }


}