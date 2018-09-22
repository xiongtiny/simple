<?php
namespace app\Models;
use think\Model;
use think\model\concern\SoftDelete;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14
 * Time: 9:02
 */
class Admin extends Model
{
    use SoftDelete;
    protected $table='ym_admin';
    protected $deleteTime='del_time';
}