<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/9
 * Time: 11:41
 */
namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;

class Talk extends Model{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $table='yxy_talk';


    // public function getStageAttr($value){
    //     $stage=['售前','售后'];
    //     return $stage[$value];
    // }


}