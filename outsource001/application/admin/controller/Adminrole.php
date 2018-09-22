<?php
namespace app\admin\controller;

class Adminrole extends Base
{
    /**
     * 管理角色列表页
     *
     * @access public
     *
     * @param int		$pageNum				页数
     * @param int		$numPerPage				页面条数
     * @param string	$name					管理角色名称
     *
     * @return html
     */
    public function index()
    {
        $page       = input('pageNum');
        $page       = $page ? (int)$page : 1;

        $page_list  = input('numPerPage');
        $page_list  = $page_list ? (int)$page_list : DEFAULT_PAGE;

        $name       = input('name');

        $where      = array();

        if($name){
            $where['name'] = array('like', $name);
        }

        $data   = $this->AdminRolesModel->getPage($page, $page_list, $where, array('rank' => 'desc'));

        $data['name']  = $name;

        $this->showView('index', $data);
    }

    /**
     * 管理角色(添加/修改)
     *
     * @access public
     *
     * @param int		$id						管理角色编号
     * @param string	$name					管理角色名称
     * @param int       $status                 管理角色显示状态
     * @param int       $rank                   管理角色排序值
     *
     * @return html/json
     */
    public function info(){
        if(request()->isPost()){
            $id     = input('id');

            $name   = input('name');
            $rank   = input('rank');
            $status = input('status');

            //编辑角色数组
            $data = array(
                'name'      => $name,
                'rank'      => $rank,
                'status'    => $status
            );

            if (empty($name)) {
                $this->ajaxReturn(AJ_RET_FAILED, '参数错误');
            }

            //验证角色信息
            $check_info = $this->AdminRolesModel->getInfo(array('name' => $name));

            if($check_info && $check_info['id'] != $id){
                $this->ajaxReturn(AJ_RET_FAILED, '当前角色已存在');
            }

            if($id > 0){
                $ret = $this->AdminRolesModel->updateInfo($data, array('id' => $id));

                if ($ret) {
                    $this->ajaxReturn(AJ_RET_SUCC, '修改成功', array(), 'close', 'Adminrole/index');
                } else {
                    $this->ajaxReturn(AJ_RET_FAILED, '修改失败');
                }
            }else{
                $ret = $this->AdminRolesModel->addInfo($data);

                if ($ret) {
                    $this->ajaxReturn(AJ_RET_SUCC, '添加成功', array(), 'close', 'Adminrole/index');
                } else {
                    $this->ajaxReturn(AJ_RET_FAILED, '添加失败');
                }
            }

        }else{
            $id = input('id');

            //页面数据信息数组
            $data   = array();

            //查询当前角色信息
            $info   = array();

            if($id){
                $info = $this->AdminRolesModel->getInfo(array('id' => $id));
            }

            $data['info'] = $info;

            $this->showView('info', $data);
        }
    }

    /**
     * 管理角色删除
     *
     * @access public
     *
     * @param int		$id						管理角色编号
     *
     * @return json
     */
    public function del(){
        $id = input('id');

        $ret = $this->AdminRolesModel->deleteInfo(array('id' => $id));

        if ($ret) {
            //同时删除角色对应的管理员和菜单关联关系
            $this->AdminCateHasRolesModel->deleteInfo(array('role_id' => $id));
            $this->AdminUserHasRolesModel->deleteInfo(array('role_id' => $id));

            $this->ajaxReturn(AJ_RET_SUCC, '删除成功', array(), 'no', 'Adminrole/index');
        } else {
            $this->ajaxReturn(AJ_RET_FAILED, '删除失败');
        }
    }

    /**
     * 设置管理员角色管理
     *
     * @access public
     *
     * @param string	$name					管理角色名称
     * @param int		$role_ids				管理角色编号（多个以逗号分隔）
     * @param int		$user_id				管理员编号
     * @param string    $parent_rel             调用父级页面标识
     * @param string    $dialog_rel             弹窗页面标识
     * @param string    $set_type               设置类型
     *
     * @return html / json
     */
    public function setRoles(){
        $name = input('name');

        if (request()->isPost() && empty($name)) {

            $role_ids   = input('role_ids');
            $user_id    = input('user_id', null, 'int');

            if (!$user_id) {
                $this->ajaxReturn(AJ_RET_FAILED, '缺少用户参数');
            }

            if (!$role_ids) {
                $this->ajaxReturn(AJ_RET_FAILED, '至少选择一个角色');
            }

            $this->AdminUserHasRolesModel->deleteInfo(array('user_id' => $user_id));

            $ret = false;
            if ($role_ids) {
                //批量添加管理员关联角色数组
                $add_arr = array();
                //分隔$role_ids字符串为数组
                $role_ids = explode(',', $role_ids);
                $role_ids = array_unique($role_ids);

                foreach ($role_ids as $v) {
                    if ($v) {
                        $add_arr[] = array(
                            'user_id'   => $user_id,
                            'role_id'   => $v
                        );
                    }
                }

                if ($add_arr) {
                    $ret = $this->AdminUserHasRolesModel->addInfo($add_arr, true);
                }
            }

            if ($ret) {
                $this->ajaxReturn(AJ_RET_SUCC, '角色设置成功', array(), 'close', 'Admincate/index');
            } else {
                $this->ajaxReturn(AJ_RET_FAILED, '修改失败');
            }
        } else {
            $user_id    = input('user_id', null, 'int');

            $dialog_rel = input('dialog_rel');
            $parent_rel = input('parent_rel');

            $set_type   = input('set_type');

            //角色数组
            $role_ids = array();

            if ($user_id) {
                //查询用户拥有的角色数组
                $user_roles = $this->AdminUserHasRolesModel->getRolesByUserId($user_id);

                $role_ids = array();
                foreach ($user_roles as $v) {
                    $role_ids[] = $v['id'];
                }
            }

            //查询管理员角色列表条件
            $where = array();

            if ($name) {
                $where['name'] = array('like', $name);
            }

            //角色列表
            $list = $this->AdminRolesModel->getAll($where);

            $data = array(
                'parent_rel'    => $parent_rel,
                'dialog_rel'    => $dialog_rel,
                'list'          => $list,
                'name'          => $name,
                'set_type'      => $set_type,
                'user_id'       => $user_id,
                'role_ids'      => implode(",", $role_ids)
            );

            $this->showView('setRoles', $data);
        }
    }
}