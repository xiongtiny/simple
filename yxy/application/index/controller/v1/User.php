<?php
namespace app\index\controller\v1;

use app\model\User as userModel;//操作用户表
use app\model\UserInfo;//操作用户详情表
use app\model\UserIson;//意向学员
use app\plugins\alipay\AopClient;
use app\plugins\alipay\request\AlipayTradePagePayRequest;
use app\plugins\jwt\JWT;
use think\facade\Request;
class User
{


    /**
     * 用户查询
     * @return string
     */
    public function index(){
        $user = userModel::all();
        if(!$user->isEmpty()){
            return ajax_success($user,'获取用户成功');
        }else{
            return ajax_error($user,'暂无用户信息');
        }
    }


    /**
     * 新增用户
     * @return string
     */
    public function add(){
        $user           = new userModel;
        // $data           = Request::post();
        // $user->save($data);
        $user->username     = 'weilang';
        if($user->save()){
            return ajax_success($user,'新增用户成功');
        }else{
            return ajax_error($user,'新增用户失败');
        }
    }


    /**
     * 修改用户
     * @return string
     */
    public function edit(){
        $user           = userModel::get(1);//get()括号里放需要操作的主键id
        $user->name     = 'weilang';
        if($user->save()){
            return ajax_success($user,'修改用户成功');
        }else{
            return ajax_error($user,'修改用户失败');
        }
    }


    /**
     * 删除用户
     * @return string
     */
    public function delete(){
        $user           = userModel::get(3);//get()括号里放需要操作的主键id
        $user->name     = 'weilang';
        if($user->delete()){
            return ajax_success($user,'删除用户成功');
        }else{
            return ajax_error($user,'删除用户失败');
        }
    }



/**
     * 新增意向用户
     * @return string
     */
    public function add_UserIson(){
        $user           = new UserIson;
        $data           = Request::post();
        // $user->save($data);
        $user->name     = $data['mame'];
        $user->grade    = $data['grade'];
        $user->subject  = $data['subject'];
        $user->phone    = $data['phone'];
        $user->status   = 0;
        if($user->save()){
            return ajax_success($user,'新增意向用户成功');
        }else{
            return ajax_error($user,'新增意向用户失败');
        }
    }




}
