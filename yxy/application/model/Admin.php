<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/10
 * Time: 16:04
 */
namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $table = 'yxy_admin';

    /**
     * 获取img的时候进行修改
     * @param $value
     * @return string
     */
    public function getPictureAttr($value){
        $picture=url($value,'',false,true);
        if(empty($value)){
             $picture=url('/admin/avatars/user.jpg','',false,true);
        }

        return $picture;
    }


    public function role(){
        return $this->belongsToMany(Role::class,'admin_role','role_id','user_id');
    }
}