<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/11
 * Time: 15:27
 */
namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;

class ClassHour extends Model{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $name='class_hour';


    /**
     * 获取年级
     */
    public function grade(){
        return $this->belongsTo(Grade::class,'grade_id','id');
    }

}