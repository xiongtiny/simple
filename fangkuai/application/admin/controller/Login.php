<?php
namespace app\admin\controller;
use think\Controller;
use think\facade\Request;
use think\Db;
use app\model\Login as Loginmodel;
use think\facade\Session;

class Login extends controller{

	// 登录界面
	public function login(){
	return	$this->fetch();
	}

	// 判断登录
    public function index(){
   		if(request()->isPost()){
   			$data = request()->post();
   			$user = Loginmodel::where('user',$data['user'])->where('password',md5($data['password']))->find();
   			if(empty($user)){
   				$this->error('登录失败','/ami/login/login','',1);
   			}else{
			Session::set('id',$user['id']);
			Session::set('username',$user['user']);
   			Session::set('password',md5($user['password']));
   			$this->success('登录成功','/ami/index/index','',1);
   			}   
    	}
    }

    //退出登录
    public function loginout(){
    	Session::pull('id');
    	Session::pull('user');
    	Session::pull('username');
        $this->success('退出登录','/ami/login/login','',1);
    }

}