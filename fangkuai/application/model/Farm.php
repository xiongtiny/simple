<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/19
 * Time: 16:58
 */
namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;

class Farm extends Model
{
    use SoftDelete;
    protected $deleteTime = 'del_time';

    protected $table='fk_farm';

    public function getServiceAttr($value){
    	return Service::whereIn('id',$value)->column('name');
    }

}