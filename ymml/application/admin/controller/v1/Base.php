<?php
namespace  app\admin\controller\v1;
use think\Controller;
use think\Request;
use think\facade\Session;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/10
 * Time: 18:05
 */
class Base extends  Controller{

     public function isLogin(){
         $name=Session::has('name');
       if(empty($name)){
           $this->redirect('/admin/v1/index/login');
       }
     }
}
