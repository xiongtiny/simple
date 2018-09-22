<?php
namespace  app\admin\controller\v1;
use app\admin\controller\v1\Base;
use think\Request;
use app\Models\Admin as AdminModel;
use think\Validate;
use think\facade\Session;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/10
 * Time: 14:10
 */
/* 显示资源列表
 * */
class Index extends  Base{
    public function index(){
        $this->isLogin();
        return view();
    }
    public  function dologin(Request $request){
        /*获取登录信息
         * */
        $username=$request->post('username');
        $password=($request->post('password'));
//        dump($username);exit;
     $rule=[
         'username'=>'require|max:25',
         'password'=>'require'
     ];
   $msg=[
       'username.require'=>'名称必须填写',
       'username.max'=>'名称最多不超过25个字符',
       'password.requre'=>'密码必须填写'
   ];
       $data=[
           'username'=>$username,
           'password'=>$password
       ];
         $validate=Validate::make($rule,$msg);
         $result=$validate->check($data,$rule);
         if(!$result){
             return $this->error($validate->getError());
         }
        /*操作数据查询
         * */
//        var_dump($data);exit;
          $model=new AdminModel;
        $row=$model->where('username','=',$username)->where('password','=',md5($password))->find();
        if($row){
              Session::set('name',$username);
//            print_r(session('name'));
//            exit;
//            $this->success();
//            $this->error()
             $this->success('登录成功','/admin/v1/index/index/');
        }else{
            $this->error('登录失败,','/admin/v1/index/login/');
        }
    }
    /*显示资源列表
     * */
    public function  login(){

        return view();
    }
    /*退出登录
     * */
    public function logout(){
        Session::delete('name');
        return   $this->redirect(url('/admin/v1/index/login'));
    }
}