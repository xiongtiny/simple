<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/20
 * Time: 14:59
 */
namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;

class Order extends Model
{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $table='fk_order';

    public function getFarm(){
        return $this->hasOne('Farm','id','farm_id');
    }
}