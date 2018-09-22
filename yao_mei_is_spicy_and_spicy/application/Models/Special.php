<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/6/5
 * Time: 15:58
 */
namespace app\Models;
use think\Model;
use think\model\concern\SoftDelete;
class Special extends Model
{
    protected $name='special';
    protected $deleteTime='del_time';
    public  function getName(){
        return  $this->hasOne('User','id','user_id');
    }
      public function getGoods(){
        return $this->hasOne('Goods','id','goods_id');
      }
}