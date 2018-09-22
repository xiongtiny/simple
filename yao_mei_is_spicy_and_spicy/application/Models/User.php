<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/5/3
 * Time: 上午11:55
 */

namespace app\Models;


use think\Model;
use think\model\concern\SoftDelete;
class User extends Model
{
    protected $name='user';
    protected $hidden=['password'];
    protected $deleteTime='del_time';
    public $autoUser='phone';
    public $autoPass='password';

    public function setPasswordAttr($value){
        return password_hash($value,PASSWORD_BCRYPT);
    }
      public function getPro(){
        return $this->hasOne('Province','code','province_code');
}
     public function getCity(){
        return $this->hasOne('City','code','city_code');
    }      
     public function getArea(){
        return $this->hasOne('Area','code','area_code');
    }
          public function getGoods(){
         return $this->hasOne('Goods','id','goods_id');
          }
        public function getRecName(){
        return $this->hasOne('User','id','rec_id');
        }
        public function getGenName(){
        return $this->hasOne('User','id','gen_id');
        }

        public function getOrder(){
            return $this->hasMany(Order::class,'user_id','id');
        }
}