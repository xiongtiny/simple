<?php
namespace app\admin\controller;
use think\Controller;
use think\facade\Request;
use think\Db;
use think\facade\Session;

class Check  extends Controller {

    public function  __construct(){
        parent::__construct();      
        // 获取登录的Session
        $arr = Session::get('username');
        // dump($arr);die;
        // 判断是否登录
        if(!$arr){
            //  跳转登录界面
           $this->success('请先登录','/ami/login/login','',1);
            die;
        }else{
            $this->id = Session::get('id');
            $this->user = Session::get('username');
            $this->password = Session::get('password');
        }      
        
    }
}

