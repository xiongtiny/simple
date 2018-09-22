<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/4/19
 * Time: 上午10:07
 */

namespace app\model;
use think\Model;

class Role extends Model
{
    protected $name='role';

    public function permission(){
        return $this->belongsToMany(Permission::class,'role_per','permission_id','role_id');
    }


    public function admins(){
        return $this->belongsToMany(Admin::class,'admin_role','user_id','role_id');
    }
}