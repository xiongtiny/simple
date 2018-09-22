<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/10
 * Time: 12:05
 */
namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;

class Subject extends Model{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $table='yxy_subject';
}