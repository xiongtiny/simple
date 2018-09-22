<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/6/4
 * Time: 10:18
 */
namespace app\Models;
use think\Model;

class Order extends Model
{
    // protected $autoWriteTimestamp=true;
    protected $name='order';
    protected $updateTime = 'update_time';

    protected $createTime = 'create_time';
    public  function  getPro(){
     return   $this->hasOne('Province','code','province_code');
    }
    public  function getCity(){
        return $this->hasOne(City::class,'code','city_code');
    }
    public function getArea(){
        return $this->hasOne(Area::class,'code','area_code');
    }
    public function getUser(){
        return $this->hasOne('User','id','user_id');
    }
    public function getGoods(){
        return $this->hasMany('OrderGoods','order_no','order_no');
    }

}