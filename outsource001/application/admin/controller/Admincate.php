<?php
namespace app\admin\controller;

class Admincate extends Base
{
    /**
     * 管理菜单列表页
     * @access public
     * @param int		$pageNum				页数
     * @param int		$numPerPage				页面条数
     * @param string	$name					管理菜单名称
     * @return html
     */
    public function index()
    {
        $page       = input('pageNum');
        $page       = $page ? (int)$page : 1;
        $page_list  = input('numPerPage');
        $page_list  = $page_list ? (int)$page_list : DEFAULT_PAGE;
        $name       = input('name');
        //列表查询条件
        $where      = array();
        if($name){
            $where['name'] = array('like', $name);
        }

        //列表排序条件
        $order_by               = array('left_value'    => 'asc');

        $data                   = $this->AdminCatesModel->getPage($page, $page_list, $where, $order_by);
        $data['name']           = $name;

        $this->showView('index', $data);
    }

    /**
     * 管理员(添加/修改)
     *
     * @access public
     *
     * @param int		$id						管理菜单编号
     * @param int		$old_pid				管理菜单当前父级编号
     * @param string	$name					管理菜单名称
     * @param int		$pid				    管理菜单修改后的父级编号
     * @param string	$url				    管理菜单请求url地址
     * @param int       $status                 管理菜单显示状态
     * @param int       $rank                   管理菜单排序值
     *
     * @return html/json
     */
    public function info(){
        if(request()->isPost()){
            $id         = input('id');

            $old_pid    = input('old_pid');

            $name       = input('name');
            $pid        = input('pid');
            $url        = input('url');
            $status     = input('status');
            $rank       = input('rank');
            $link       = input('link');
            $project_id = input('project_id');

            //编辑菜单数组
            $info = array(
                'rel'           => $url ? md5($url) : md5($name),
                'name'          => $name,
                'url'           => $url ? ucfirst(strtolower($url)) : '',
                'status'        => $status,
                'pid'           => $pid,
                'rank'          => $rank,
                'link'          => $link,
                'last_ip'       => ip2long(client_ip()),
                'last_time'     => time(),
                'project_id'    => $project_id
            );

            if($id > 0){
                $ret = $this->AdminCatesModel->updateInfo($info, array('id' => $id));

                if ($ret) {
                    //设置对应菜单的所属角色
                    $this->addCateHasRoles($id);

                    //移动菜单
                    if($old_pid != $pid){
                        if($this->super_admin_id == $this->login_admin_user['id']){
                            $ret_move = $this->AdminCatesModel->moveCate($id, $pid);

                            if (!$ret_move) {
                                $this->ajaxReturn(AJ_RET_FAILED, '移动菜单失败');
                            }else{
                                $this->ajaxReturn(AJ_RET_SUCC, '移动菜单成功');
                            }
                        }else{
                            $this->ajaxReturn(AJ_RET_FAILED, '只有超级管理员才能移动菜单~');
                        }
                    }

                    $this->ajaxReturn(AJ_RET_SUCC, '修改成功', array(), 'close', 'Admincate/index');
                } else {

                    //设置对应菜单的所属角色
                    $role_ret = $this->addCateHasRoles($id);

                    if ($role_ret) {
                        $this->ajaxReturn(AJ_RET_SUCC, '修改成功', array(), 'close', 'Admincate/index');
                    } else {
                        $this->ajaxReturn(AJ_RET_FAILED, '修改失败');
                    }
                }
            }else{
                $info['create_time']    = time();
                $ret = $this->AdminCatesModel->addCate($info);

                if ($ret) {
                    //设置对应菜单的所属角色
                    $this->addCateHasRoles($ret, 'add');

                    $this->ajaxReturn(AJ_RET_SUCC, '添加成功', array(), 'close', 'Admincate/index');
                } else {
                    $this->ajaxReturn(AJ_RET_FAILED, '添加失败');
                }
            }
        }else{
            $id             = request()->get('id');

            $data           = array();

            //菜单对应角色编号数组
            $_role_ids      = array();
            //菜单对应角色名称数组
            $_role_names    = array();


            if($id){
                //当前菜单信息
                $info   = $this->AdminCatesModel->getInfo(array('id'    => $id));

                $data['info']   = $info;

                //当前菜单父级菜单
                if ($info['pid'] > 0) {
                    $pinfo = $this->AdminCatesModel->getInfo(array('id' => $info['pid']));
                } else {
                    //设置默认顶级父级菜单
                    $pinfo = array(
                        'id'=>0,
                        'title'=>'管理中心'
                    );
                }

                //获取对应角色信息
                $role_list = $this->AdminRolesModel->getRolesByCateId($id);

                foreach ((array)$role_list as $v) {
                    $_role_ids[]    = $v['id'];
                    $_role_names[]  = $v['name'];
                }

            }else{
                //查询菜单最大排序值（设置默认排序值用）
                $rank = $this->AdminCatesModel->getMaxRank();

                $info['rank']   = $rank;

                $pinfo = array(
                    'id'    => '',
                    'title' => ''
                );
            }
            //页面数据信息数组
            $data = array(
                'info'          => $info,
                'pinfo'         => $pinfo,
                'role_ids'      => implode(',', $_role_ids),
                'role_names'    => implode(',', $_role_names),
            );

            $this->showView('info', $data);
        }
    }

    /**
     * 管理菜单删除
     *
     * @access public
     *
     * @param int		$id						管理菜单编号
     *
     * @return json
     */
    public function del()
    {
        $id         = input('id');

        //当前菜单信息
        $info = $this->AdminCatesModel->getInfo(array('id' => $id));

        if ($info['right_value'] - $info['left_value'] > 1) {
            $this->ajaxReturn(AJ_RET_FAILED, '该菜单下有子菜单，不能删除！');
        }

        $ret = $this->AdminCatesModel->delCate($id);

        if ($ret) {
            //同时删除菜单关联的角色和管理员关联
            $this->AdminCateHasRolesModel->deleteInfo(array('cate_id' => $id));
            $this->AdminCateHasUsersModel->deleteInfo(array('cate_id' => $id));

            $this->ajaxReturn(AJ_RET_SUCC, '删除成功', array(), 'no', 'Admincate/index');
        } else {
            $this->ajaxReturn(AJ_RET_FAILED, '删除失败');
        }
    }

    /**
     * 设置管理员父级菜单页面
     *
     * @access public
     *
     * @return html
     */
    public function setParentCate()
    {
        $parent_cate = $this->getUserHasCates();

        $this->showView('setParentCate', array('parent_cate' => $parent_cate));
    }

    /**
     * 设置管理员所拥有的菜单
     *
     * @access public
     *
     * @param int		$cate_ids				管理菜单编号(多个以逗号分隔)
     * @param int		$user_id				管理员编号
     *
     * @param string    $dialog_rel             弹窗标识(用于对页面的刷新操作用)
     *
     * @return html/json
     */
    public function setCateHasUser(){
        if(request()->isPost()){
            $cate_ids   = input('cate_ids');
            $user_id    = input('user_id');

            $this->AdminCateHasUsersModel->deleteInfo(array('user_id' => $user_id));

            if(empty($cate_ids)){
                $this->ajaxReturn(AJ_RET_SUCC, '权限设置成功', array(), 'close', 'Admincate/index');
            }

            //管理菜单所属管理员关联数组
            $cate_user_arr = array();

            if ($cate_ids) {
                $cate_ids = explode(',', $cate_ids);
                $cate_ids = array_unique($cate_ids);
                foreach ((array)$cate_ids as $v) {
                    if ($v) {
                        $cate_user_arr[] = array(
                            'cate_id'   => $v,
                            'user_id'   => $user_id
                        );
                    }
                }
            }

            $ret = false;
            if ($cate_user_arr) {
                $ret = $this->AdminCateHasUsersModel->addInfo($cate_user_arr, true);
            }

            if ($ret) {
                $this->ajaxReturn(AJ_RET_SUCC, '权限设置成功', array(), 'close', 'Admincate/index');
            } else {
                $this->ajaxReturn(AJ_RET_FAILED, '权限设置失败');
            }
        }else{
            $dialog_rel = input('dialog_rel');

            $user_id    = input('user_id');

            //用户拥有的管理菜单数组
            $user_cate_ids = array();

            if ($user_id) {
                $user_cate_ids = $this->getCateIdsByUserId($user_id);
            }

            //查询用户显示菜单数组
            $cate_arr = $this->getUserHasCates();

            //页面数据信息数组
            $data = array(
                'cate_arr'      => $cate_arr,
                'user_cate_ids' => $user_cate_ids,
                'user_id'       => $user_id,
                'dialog_rel'    => $dialog_rel
            );

            $this->showView('setCateHasUser', $data);
        }
    }

    /**
     * 设置角色所拥有的菜单
     *
     * @access public
     *
     * @param int		$cate_ids				管理菜单编号(多个以逗号分隔)
     * @param int		$role_id				管理角色编号
     *
     * @param string    $dialog_rel             弹窗标识(用于对页面的刷新操作用)
     *
     * @return html/json
     */
    public function setCateHasRole(){
        if(request()->isPost()){
            $role_id    = input('role_id');
            $cate_ids   = input('cate_ids');

            $this->AdminCateHasRolesModel->deleteInfo(array('role_id' => $role_id));

            //管理菜单所属角色关联数组
            $cate_role_arr = array();

            if ($cate_ids) {
                $cate_ids = explode(',', $cate_ids);
                $cate_ids = array_unique($cate_ids);
                foreach ((array)$cate_ids as $v) {
                    if ($v) {
                        $cate_role_arr[] = array(
                            'cate_id'   => $v,
                            'role_id'   => $role_id
                        );
                    }
                }
            }

            $ret = false;
            if ($cate_role_arr) {
                $ret = $this->AdminCateHasRolesModel->addInfo($cate_role_arr, true);
            }

            if ($ret) {
                $this->ajaxReturn(AJ_RET_SUCC, '权限设置成功', array(), 'close', 'Admincate/index');
            } else {
                $this->ajaxReturn(AJ_RET_FAILED, '权限设置失败');
            }
        }else{
            $role_id    = input('id');
            $dialog_rel = input('dialog_rel');

            //对应角色的管理菜单数组
            $roles = $this->AdminCateHasRolesModel->getAll(array('role_id' => $role_id));

            //菜单id数组
            $cate_ids = array();

            foreach ($roles as $v) {
                $cate_ids[] = $v['cate_id'];
            }

            //查询用户菜单数组
            $cate_arr = $this->getUserHasCates();

            //页面数据信息数组
            $data = array(
                'role_id'       => $role_id,
                'cate_arr'      => $cate_arr,
                'cate_ids'      => $cate_ids,
                'dialog_rel'    => $dialog_rel
            );

            $this->showView('setCateHasRole', $data);
        }
    }

    /**
     * 获取用户拥有的菜单权限（并且格式化成菜单树）
     *
     * @return array
     */
    private function getUserHasCates()
    {
        $login_uid  = $this->login_admin_user['id'];

        //查询条件
        $where = array();

        if($login_uid != $this->super_admin_id){
            $cate_ids = $this->getCateIdsByUserId($login_uid);

            if($cate_ids){
                $where  = array(
                    'id'  => array(
                        'where_in', $cate_ids
                    )
                );
            }
        }

        //查询菜单列表
        $cate_list = $this->AdminCatesModel->getAll($where, array('rank' => 'asc'));

        return $this->genTree($cate_list);
    }

    /**
     * 设置对应菜单的所属角色
     *
     * @param $id
     * @param string $type （add 添加  edit 编辑）
     *
     * @return bool
     */
    private function addCateHasRoles($id, $type = 'edit')
    {
        if($type != 'add'){
            $this->AdminCateHasRolesModel->deleteInfo(array('cate_id' => $id));
        }

        //请求的角色编号
        $role_ids   = input('role_ids');

        if ($role_ids) {
            //批量添加角色管理菜单关联数组
            $add_batch_arr = array();

            $role_ids = explode(',', $role_ids);
            $role_ids = array_unique($role_ids);
            foreach ((array)$role_ids as $v) {
                if ($v) {
                    $add_batch_arr[] = array(
                        'role_id' => $v,
                        'cate_id' => $id
                    );
                }
            }

            if ($add_batch_arr) {
                return $this->AdminCateHasRolesModel->addInfo($add_batch_arr, true);
            }
        }

        return false;
    }
}