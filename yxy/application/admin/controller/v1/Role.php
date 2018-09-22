<?php
/**
 * Created by PhpStorm.
 * Name: 角色
 * User: shaoguo
 * Date: 2018/4/18
 * Time: 下午4:31
 */

namespace app\admin\controller\v1;
use app\model\Role as RoleModel;
use think\Db;
use think\Validate;
use app\model\Permission;
class Role extends BaseController
{
    /**
     * 首页
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function index(){
        $this->method();
        $this->auth();
        $roles=RoleModel::all();
        return view('',compact('roles'));
    }

    /**
     * 添加视图
     * @return \think\response\View
     */
    public function add(){
        $this->method();
        $this->auth();
        $permissions=Permission::all();
        return view('',compact('permissions'));
    }

    /**
     * 添加行为
     * @throws \think\Exception
     */
    public function addPost(){
        $this->method('post');
        $this->auth();
        $data=request()->post();
        $validate=Validate::make([
            'name'=>'require',
            'description'=>'require',
        ],[],[
            '管理员组名'=>'name',
            '管理员组'=>'description',

        ]);

        if(!$validate->check($data)){
            ajax_error([],$validate->getError());
        }

        Db::startTrans();
        try{
            $role=RoleModel::create($data);
            $insert=$this->rbac->assignRolePermission($role->id,$data['permission_id']);
            Db::commit();
            ajax_success([],'添加角色成功');

        }catch (\Exception $e){
            Db::rollback();
            ajax_error([],'添加角色失败');

        }

    }

    /**
     * 修改
     * @param $id
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function edit($id){
        $this->method();
        $this->auth();
        $this->method();
        $role=RoleModel::get($id);
        return view('',compact('role'));
    }

    /**
     * 修改行为
     * @throws \think\Exception
     */
    public function editPost(){
        $this->method();
        $this->auth();
        $this->method('post');
        $id=request()->post('id');
        $data=request()->post();
        if(empty($id)){
            ajax_error([],'角色不存在');
        }

        $role=$this->rbac->editRole($data);
        if(!$role){
            ajax_error([],'修改角色失败');

        }

        ajax_success($role,'修改角色成功');
    }

    /**
     * 分配权限视图
     * @param $id
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function addPer($id){
        $this->method();
        $this->auth();
        $role=RoleModel::get($id);
        return view('',compact('role'));
    }

    /**
     * 分配权限
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function addPerPost(){
        $this->method();
        $this->auth();
        $id=request()->get("id");
        $data=request()->get('permission_id');
        $insert=$this->rbac->assignRolePermission($id,$data);
        $role=RoleModel::get($id);
        if($insert>0){
            ajax_error([],'增加权限成功');

        }

        ajax_success($role,'增加失败');

    }


}