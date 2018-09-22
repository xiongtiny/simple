<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/4/18
 * Time: 下午4:26
 */

namespace app\admin\controller\v1;
use app\model\Admin as AdminModel;
use think\Db;
use think\Validate;
class User extends BaseController
{
    /**
     * 首页
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function index(){
        $this->auth();
        $this->method();
        $admins=AdminModel::paginate();
        return view('',compact('admins'));
    }

    /**
     * 添加视图
     * @return \think\response\View
     */
    public function add(){
        $this->auth();
        $this->method();
        $roles=\app\model\Role::all();
        return view('',compact('roles'));
    }

    /**
     * 添加行为
     * @throws \think\Exception
     */
    public function addPost(){
        $this->auth();
        $this->method('post');
        $data=request()->post();
        $validate=Validate::make([
            'number'=>"require",
            'password'=>"require|confirm"
        ]);
        if(!$validate->check($data)){
            ajax_error('',$validate->getError());
        }

        $data['password']=password_hash($data['password'],PASSWORD_BCRYPT);
        $user=AdminModel::create($data);
        Db::startTrans();
        try{
            $user=AdminModel::create($data);
            $this->rbac->assignUserRole($user->id,$data['role_id']);
            Db::commit();
            ajax_success($user,'添加成功');

        }catch (\Exception $e){
            Db::rollback();
            ajax_error('',$e->getMessage());

        }
    }

    /**
     * 修改视图
     * @param $id
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function edit($id){
        $this->auth();
        $this->method();
        $admin=AdminModel::get($id);
        if(empty($admin)){
            $this->error('没有该用户');
        }
        return view('',compact('admin'));
    }

    /**
     * 修改行为
     * @throws \think\exception\DbException
     */
    public function editPost(){
        $this->auth();
        $this->method('post');
        $id=request()->post('id');
        $data=request()->except('id');
        $user=AdminModel::get($id);
        if(empty($user)){
            ajax_error('没有该用户');
        }

        if(!$user->save($data)){
            ajax_error('','修改失败');
        }
        $user=AdminModel::get($id);

        ajax_success($user,'修改成功');
    }

    /**
     * 登录视图
     * @return \think\response\View
     */
    public function login(){

        return view('v1/login/login');
    }

    /**
     * 登录行为
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function postLogin(){
        $this->method('post');
        $data=request()->post();
        $validate=Validate::make([
            'number'=>'require',
            'password'=>'require'
        ],[],[
            'number'=>'工号',
            'password'=>"密码"
        ]);
        if(!$validate->check($data)){
            ajax_error('',$validate->getError());
        }

        $wheres['number']=$data['number'];
        $admin=AdminModel::where($wheres)->find();
        if(empty($admin) || !password_verify($data['password'],$admin->password)){
            ajax_error('',"用户名或密码错误");
        }

        session('user_id',$admin->id,'admin');
        $this->rbac->cachePermission($admin->id);
        ajax_success($admin,url('/admin/v1/index/index'));


    }

    /**
     * 添加角色视图
     * @param $id
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function addRole($id){
        $this->auth();
        $this->method();
        $role=AdminModel::get($id);
        return view('',compact('role'));
    }

    /**
     * 添加角色行为
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function addRolePost(){
        $this->auth();
        $this->method('post');
        $id=request()->get("id");
        $data=request()->get('permission_id');
        $insert=$this->rbac->assignUserRole($id,$data);
        $role=AdminModel::get($id);
        if($insert>0){
            ajax_error([],'增加角色成功');

        }

        ajax_success($role,'增加角色失败');

    }


}