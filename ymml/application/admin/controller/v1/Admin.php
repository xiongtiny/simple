<?php
namespace  app\admin\controller\v1;
use app\admin\controller\v1\Base;
use  think\Request;
use app\Models\Admin as AdminModel;
use think\Validate;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14
 * Time: 14:44
 */
class Admin extends  Base{
    public function index(){
         $this->isLogin();
        return view();
    }
    public  function add(){
        return view();
    }
     public function  save(Request $request)
     {
         $name = $request->post('name');
         $pwd = $request->post('pwd');
         $repwd = $request->post('repwd');
         $data=$request->post();
         if(empty($name)){
             $this->error('用户名为空', '/admin/v1/admin/add');
         }
         if(empty($pwd)){
             $this->error('密码为空', '/admin/v1/admin/add');
         }
         if ($pwd != $repwd) {
             $this->error('两次密码不一致', '/admin/v1/admin/add');
         } else {
//             if (!empty($name) && !empty($pwd)) {
                 //判断用户是否登录
                 $select = AdminModel::where('username', $name)->where('password', $pwd)->select();

                 //print_r('select * from es_admin where username='.$name.' and password='.$pwd);
                 if (!$select->isEmpty()) {
                     //如果用户存在,跳转到首页
                     $this->error('该用户已经存在', '/admin/v1/admin/add');
                 }
                 //注册
                 $model = new AdminModel;
                 $pwd = md5($pwd);
                 $insert = AdminModel::create([
                     'username' => $name,
                     'password' => $pwd
                 ]);
                 if ($insert) {
                     $this->success('添加成功', '/admin/v1/admin/oper');
                 } else {
                     $this->error('添加失败', '/admin/v1/admin/add');
                 }
//             }
         }
     }
      /*显示所有管理员
             * */
    public function oper(){
        $this->isLogin();
        $model=new AdminModel;
        $opers=$model->paginate(10);
        $page=$opers->render();
//          print_r($goods);
//          exit;
        $this->assign('page',$page);
        $this->assign('opers',$opers);
        return $this->fetch();
    }
      /*显示资源编辑页面
       * */
      public  function edit(){
          $this->isLogin();
          $id=\request()->get('id');
//          dump($id);exit;
         $admin=AdminModel::get($id);
         $this->assign('admin',$admin);
//          dump($admin);exit;
//          dump($id);exit;
           return $this->fetch();
      }
        /*修改用户信息并保存到数据库
         * */
          public  function update(Request $request){
              $this->isLogin();
              $name = $request->post('name');
              $pwd = $request->post('pwd');
              $repwd = $request->post('repwd');
              $id=\request()->get('id');
//              dump($id);exit;
//              dump($name);
//              dump($pwd);
//              dump($repwd);exit;
              if(empty($name)){
                  $this->error('用户名为空', '/admin/v1/admin/oper');
              }
              if(empty($pwd)){
                  $this->error('密码为空', '/admin/v1/admin/oper');
              }
              if ($pwd != $repwd) {
                  $this->error('两次密码不一致', '/admin/v1/admin/oper');
              } else{
                  $model = new AdminModel;
                  $pwd = md5($pwd);
                  $update_time=date("Y-m-d H:i:s");
//                  dump($update_time);exit;
                  $save = $model->save([
                      'username' => $name,
                      'password' => $pwd,
                      'update_time'=>$update_time
                  ],compact('id'));
//                  dump($save);exit;
                  if ($save) {
                      $this->success('修改成功', '/admin/v1/admin/oper');
                  } else {
                      $this->error('修改失败', '/admin/v1/admin/add');
                  }
              }

          }
          /*删除功能
           * */
      public  function del(){
        $this->isLogin();
        $id=\request()->get('id');
        $users=AdminModel::where('id',$id)->find();
        $users_status=$users ->delete();
        if ($users_status){
            $this->success('删除成功','/admin/v1/admin/oper');
        }else{
            $this->assign('删除失败','/admin/v1/admin/oper');
        }


//
      }
}