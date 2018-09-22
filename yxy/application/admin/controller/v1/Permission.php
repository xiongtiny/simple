<?php
/**
 * Created by PhpStorm.
 * Name: 权限管理
 * User: shaoguo
 * Date: 2018/4/18
 * Time: 下午4:32
 */

namespace app\admin\controller\v1;
use app\model\Permission as PermissionModel;
use think\Validate;
class Permission extends BaseController
{
    /**
     * 首页
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function index(){
        $this->method();
        $this->auth();
        $permissions=PermissionModel::paginate();
//        dump($this->rbac->can("admin/v1/Course/index1"));
        return view('',compact('permissions'));
    }

    /**
     * 添加视图
     * @return \think\response\View
     */
    public function add(){
        $this->method();
        $this->auth();
        return view();
    }

    /*
     * 添加
     */
    public function addPost(){
        $this->method('post');
        $data=request()->post();
        $validate=Validate::make([
            'name'=>"require",
            'description'=>'require',
            'path'=>'require',
        ],[],[
            'name'=>'权限名',
            'description'=>'权限描述',
            'path'=>'权限路径',
        ]);

        if(!$validate->check($data)){
            ajax_error([],$validate->getError());
        }

        $permission=$this->rbac->createPermission($data);
        if(!$permission){
            ajax_error([],'添加权限失败');
        }
        ajax_success($permission,'添加权限成功');
    }

    /**
     * 修改权限视图
     * @param $id
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function edit($id){
        $this->method();
        $permission=PermissionModel::get($id);
        if(empty($permission)){
            $this->error('没有该权限');
        }
        return view('',compact('permission'));
    }

    /**
     * 修改权限
     * @throws \think\Exception
     */
    public function editPost(){
        $this->method('post');
        $id=request()->get('id');
        if(empty($id)){
            ajax_error([],'没有该权限');
        }
        $data=request()->except('id');
        $permission=$this->rbac->editPermission($data,$id);
        if(!$permission){
            ajax_error([],'修改失败');
        }

        ajax_success($permission,'修改成功');

    }
}