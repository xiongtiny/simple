<?php
/**
 * Created by Sublime.
 * User: weilang
 * Date: 2018/4/10
 * Time: 11:19
 */

namespace app\model;
use think\Model;

class UserInfo extends Model
{
    protected $name='user_info';

    public function getGrade(){
        return $this->belongsTo(Grade::class,'grade','id');
    }


    public function getProvince(){
        return $this->belongsTo(Province::class,'province','code');
    }

    public function getCity(){
        return $this->belongsTo(City::class,'city','code');
    }


    public function getArea(){
        return $this->belongsTo(Area::class,'area','code');
    }
}