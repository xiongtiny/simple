<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/3/16
 * Time: 下午4:22
 */

namespace app\model;
use think\Model;

class User extends Model
{
    protected $name='user';
    public $autoUser='phone';
    public $autoPass='password';
    protected $hidden=['password'];

    // public function getSexAttr($value){
    //     $sex=['保密','男','女'];
    //     return $sex[$value];
    // }

    public function UserInfo(){
        return $this->hasOne(UserInfo::class,'user_id','id');
    }

    /**
     * @param $value
     * @return int
     */
    public function setLastIpTimeAttr($value){
        return ip2long($value);
    }


    public function getLastIpTimeAttr($value){
        return long2ip($value);
    }

    /**
     * 获取img的时候进行修改
     * @param $value
     * @return string
     */
    public function getImgAttr($value){
        return url($value,'',false,true);
    }

    /**
     *意见反馈
     * @return \think\model\relation\HasMany
     */
    public function evaluate(){
        return $this->hasMany(Evaluate::class,'user_id','id');
    }

    /**
     * 获得多对多课
     * @return \think\model\relation\BelongsToMany
     */
    public function course(){
        return $this->belongsToMany(Course::class,'UserCourse','course_id','user_id');
    }

    /**
     * 获取1v1
     */

    public function classHour(){
        return $this->belongsToMany(ClassHour::class,'UserCourse','class_hour_id','user_id');
    }


    public function setPasswordAttr($value){
        return password_hash($value,PASSWORD_BCRYPT);
    }



    public function getOrder(){
        return $this->hasMany(Order::class,'user_id','id');
    }


}