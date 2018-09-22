<?php
namespace app\admin\controller;

use think\Controller;
use think\facade\Request;
use think\Db;
use app\model\User;
use app\model\Order;
use app\model\Farm;
use app\model\Login;
use think\facade\Session;

class Auth extends Check{

    public function __construct(){
        parent::__construct();
    }
   
// 首页
    public function index(){ 
        return $this->fetch();
       
    }
    public function add(){
      $user = input('post.user');
      $password = input('post.password');
      $data = [
        'user' => $user, 
        'password' => md5($password)
      ];
      $find = Login::where('user',$user)->find();      
      if($find){
        $this->error('该账号已存在','/ami/auth/index');
      }else{
        $res = Login::insert($data);
        $this->success('添加账号成功','/ami/auth/index');
        
      }
    }

   


}
