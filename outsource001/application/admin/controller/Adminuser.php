<?php

namespace app\admin\controller;

use think\Session;
use think\Cookie;
use think\Loader;
use think\Response;

class AdminUser extends Base
{
    /**
     * 管理员列表页
     *
     * @access public
     *
     * @param int $pageNum 页数
     * @param int $numPerPage 页面条数
     * @param string $name 管理员名称
     *
     * @return html
     */
    public function index()
    {
        $page = input('pageNum');
        $page = $page ? (int)$page : 1;

        $page_list = input('numPerPage');
        $page_list = $page_list ? (int)$page_list : DEFAULT_PAGE;

        $name = input('name');

        $where = array();

        if ($name) {
            $where['name'] = array('like', $name);
        }

        $data = $this->AdminUsersModel->getPage($page, $page_list, $where);
        //获取全部角色并且转换为一维数组
        $roles = @array_index_value($this->AdminRolesModel->getAll(), 'id', 'name');
        //提取管理员列表中的用户编号
        $user_ids = @array_index_value($data['rows'], 'id', 'id');
        //查询管理员角色列表
        $user_has_roles = $user_ids ? $this->AdminUserHasRolesModel->getAll(array('user_id' => array('where_in', $user_ids))) : array();
        //格式化为管理员角色数组
        $user_roles_arr = array();

        foreach ((array)$user_has_roles as $k => $v) {
            $user_roles_arr[$v['user_id']] = (empty($user_roles_arr[$v['user_id']]) ? '' : $user_roles_arr[$v['user_id']]) . (isset($roles[$v['role_id']]) ? $roles[$v['role_id']] . ',' : '');
        }

        $data['name'] = $name;

        $data['user_roles_arr'] = $user_roles_arr;

        $this->showView('index', $data);
    }

    /**
     * 管理员(添加/修改)
     *
     * @access public
     *
     * @param int $id 管理员编号
     * @param string $name 管理员帐号
     * @param string $mobile 管理员联系电话 （可以用作登录验证使用）
     * @param string $password 管理员登录密码
     * @param string $newpassword 管理员修改密码 （管理员忘记密码时可用）
     * @param string $repassword 确认密码是否正确
     * @param int $status 管理员状态 （1 禁用 2 启用）
     * @param string $role_ids 管理员设置角色编号（可以设置多个角色）
     */
    public function info()
    {
        $tab = input('tab');
        if (request()->isPost()) {
            $id = input('id');
            $name = input('name');
            $real_name = input('real_name');

            $role_ids = input('role_ids');
            if ($this->login_admin_user['id'] != $this->super_admin_id && $id == $this->super_admin_id) {
                $this->ajaxReturn(AJ_RET_FAILED, '只有超级管理员可以操作超级管理员信息');
            }

            $mobile = input('mobile');

            $password = input('password');
            $newpassword = input('newpassword');
            $repassword = input('repassword');
            $status = input('status');


            if (!verify_mobile($mobile)) {
                $this->ajaxReturn(AJ_RET_FAILED, '手机号码格式错误');
            }

            //编辑管理员信息数组
            $info = array(
                'name' => $name,
                'real_name' => $real_name,
                'mobile' => $mobile,
                'status' => $status,
                'last_ip' => ip2long(client_ip()),
                'last_time' => time()
            );

            if (!empty($id)) {
                if (!empty($newpassword)) {
                    if ($newpassword == $repassword) {
                        $info['pwd'] = pwd_md5($newpassword);
                    } else {
                        $this->ajaxReturn(AJ_RET_FAILED, '新密码与确认密码不一致');
                    }
                }

                $ret = $this->AdminUsersModel->updateInfo($info, array('id' => $id));

                if ($ret) {
                    //设置管理员的所属角色
                    $this->setUserHasRoles($id, $role_ids);

                    $this->ajaxReturn(AJ_RET_SUCC, '修改成功', array(), 'close', 'Adminuser/index');
                } else {
                    //设置管理员的所属角色
                    $role_ret = $this->setUserHasRoles($id, $role_ids);

                    if ($role_ret) {
                        $this->ajaxReturn(AJ_RET_SUCC, '修改成功', array(), 'close', 'Adminuser/index');
                    } else {
                        $this->ajaxReturn(AJ_RET_FAILED, '修改失败');
                    }
                }
            } else {
                if (empty($name)) {
                    $this->ajaxReturn(AJ_RET_FAILED, '账号不能为空');
                }

                //验证管理员信息
                $check_info = $this->AdminUsersModel->getInfo(array('name' => $name));

                if ($check_info) {
                    $this->ajaxReturn(AJ_RET_FAILED, '账号已被占用，不能重复注册');
                }

                $info['name'] = $name;

                if ($password != $repassword) {
                    $this->ajaxReturn(AJ_RET_FAILED, '密码与确认密码不一致');
                }

                $info['pwd'] = pwd_md5($password);

                $info['create_time'] = time();

                $ret = $this->AdminUsersModel->addInfo($info);

                if ($ret) {
                    //设置管理员的所属角色
                    $this->setUserHasRoles($ret, $role_ids);

                    $this->ajaxReturn(AJ_RET_SUCC, '添加成功', array(), 'close', 'Adminuser/index');
                } else {
                    $this->ajaxReturn(AJ_RET_FAILED, '添加失败');
                }
            }

        } else {
            $id = input('id');
            //查询当前管理员信息
            $info = $this->AdminUsersModel->getInfo(array('id' => $id));


            //查询管理员角色
            $roles = $this->AdminUserHasRolesModel->getRolesByUserId($id);

            //管理员对应角色编号数组
            $_role_ids = array();
            //管理员对应角色名称数组
            $_role_names = array();

            foreach ((array)$roles as $v) {
                $_role_ids[] = $v['id'];
                $_role_names[] = $v['name'];
            }

            $data = array(
                'info' => $info,
                'tab' => $tab,
                'role_ids' => implode(',', $_role_ids),
                'role_names' => implode(',', $_role_names)
            );

            $this->showView('info', $data);
        }
    }

    /**
     * 管理员删除
     *
     * @access public
     *
     * @param int $id 管理员编号
     *
     * @return json
     */
    public function del()
    {
        $id = input('id', null, 'int');

        $ret = $this->AdminUsersModel->deleteInfo(array('id' => $id));

        if ($ret) {
            //删除用户的菜单权限
            $this->AdminCateHasUsersModel->deleteInfo(array('user_id' => $id));
            //删除用户对应的角色
            $this->AdminUserHasRolesModel->deleteInfo(array('user_id' => $id));

            $this->ajaxReturn(AJ_RET_SUCC, '删除成功', array(), 'no', 'Adminuser/index');
        } else {
            $this->ajaxReturn(AJ_RET_FAILED, '删除失败');
        }
    }

    /**
     * 设置管理员的所属角色
     *
     * @access private
     *
     * @param int $id 管理员编号
     * @param string $role_ids 管理员设置角色编号（可以设置多个角色）
     *
     * @return bool
     */
    private function setUserHasRoles($id, $role_ids)
    {
        $this->AdminUserHasRolesModel->deleteInfo(array('user_id' => $id));

        if ($role_ids) {
            //
            $add_batch_arr = array();

            $role_ids = explode(',', $role_ids);
            $role_ids = array_unique($role_ids);

            foreach ((array)$role_ids as $v) {
                if ($v) {
                    $add_batch_arr[] = array(
                        'role_id' => $v,
                        'user_id' => $id
                    );
                }
            }

            if ($add_batch_arr) {
                return $this->AdminUserHasRolesModel->addInfo($add_batch_arr, true);
            }
        }

        return false;
    }

    /**
     * 管理员登录
     *
     * @access public
     *
     * @param string $name 管理员帐号
     * @param string $password 管理员登录密码
     * @param string $image_code 登录图片验证码（登录页面已取消）
     * @param string $sms_code 登录手机验证码（登录页面已取消）
     */
    public function login()
    {
        if (request()->isPost()) {
            $name = input('name');
            $password = input('password');
            $image_code = input('image_code');
            $sms_code = input('sms_code');


            //登录图片验证码
            $real_image_code = Session::get('image_code');

            //登录短信验证码
            $real_sms_code = Session::get('sms_code');

            //登录错误次数
            $times = Session::get('times');

            if (empty($name)) {
                $this->ajaxReturn(AJ_RET_FAILED, '登录账号不能为空');
            }

            if (empty($password)) {
                $this->ajaxReturn(AJ_RET_FAILED, '登录密码不能为空');
            }

            if (VALIDATE_IMAGE == true) {
                if (strtolower($image_code) != strtolower($real_image_code)) {
                    $this->ajaxReturn(AJ_RET_FAILED, '图片验证码错误');
                }
            }

            $info = $this->AdminUsersModel->getInfo(array('name' => $name));

            $password = pwd_md5($password);


            if ($password != $info['pwd']) {

                if ($times >= 3 && empty($sms_code)) {
                    $this->ajaxReturn(AJ_RET_FAILED, '请先输入手机验证码后再进行登录');
                }

                Session::set('times', $times + 1);

                $this->ajaxReturn(AJ_RET_FAILED, '账号或者密码错误');
            }

            if (VALIDATE_SMS == true) {
                if ($real_sms_code != $sms_code) {
                    $this->ajaxReturn(AJ_RET_FAILED, '请先获取手机验证码后再进行登录', array('code' => 'empty'));
                }
            }


            //重新设置登录成功后对应的验证信息
            Session::delete('sms_code');
            Session::delete('sms_time');

            Session::delete('times');

            Session::delete('validate_code');

            Session::set('id', $info['id']);
            Session::set('name', $info['name']);

            Cookie::set('id', $info['id']);
            Cookie::set('name', $info['name']);

            Loader::import('Xcrypt', EXTEND_PATH);

            $xcrypt = new \Xcrypt();

            $xcrypt_code = $xcrypt::encrypt($info['id'] . '|' . $info['name'] . '|' . $password);

            Cookie::set('sign', $xcrypt_code);

            $this->AdminUsersModel->updateInfo(array('last_ip' => ip2long(client_ip()), 'last_time' => time()), array('id' => $info['id']));

            $this->ajaxReturn(AJ_RET_SUCC, '登录成功', array(), 'no', 'Adminuser/index');
            //redirect(site_url('Index', 'index'));
        } else {
            $data = array(
                'seo' => config('seo')
            );
            $this->showView('login', $data);
        }
    }

    /**
     * 自动登录 （无需参数，更具上次登录信息自动验证登录）
     * @access public
     */
    public function autoLogin()
    {
        $id = Cookie::get('id');
        $name = Cookie::get('name');
        $sign = Cookie::get('sign');

        $zi = Cookie::get('zi');
        $za = Cookie::get('za');
        $zd_sign = Cookie::get('zd_sign');

        $real_sign = substr(md5($za . $zi . MD5_CODE), 0, 10);

        //对称加密方法
        Loader::import('Xcrypt', EXTEND_PATH);

        $xcrypt = new \Xcrypt();

        $xcrypt_arr = explode('|', $xcrypt::decrypt($sign));

        if ($id == $xcrypt_arr[0] && $name == $xcrypt_arr[1]) {
            $info = $this->AdminUsersModel->getInfo(array('name' => $name));

            if ($info['pwd'] != substr($xcrypt_arr[2], 0, 10)) {
                $this->ajaxReturn(AJ_RET_FAILED, '登录验证失败');
            }

            Session::set('id', $xcrypt_arr[0]);
            Session::set('name', $xcrypt_arr[1]);

            Cookie::set('id', $xcrypt_arr[0]);
            Cookie::set('name', $xcrypt_arr[1]);

            $this->AdminUsersModel->updateInfo(array('last_ip' => ip2long(client_ip()), 'last_time' => time()), array('id' => $xcrypt_arr[0]));

            $this->ajaxReturn(AJ_RET_SUCC, '登录成功', array(), 'no', 'Adminuser/index');
        } else {
            if ($zd_sign == $real_sign) {
                $info = $this->AdminUsersModel->getInfo(array('name' => $name));

            } else {
                $this->ajaxReturn(AJ_RET_FAILED, '验证信息失败');
            }
        }
    }

    /**
     * 退出登录（清空对应登录信息）
     *
     * @access public
     */
    public function logout()
    {
        Session::delete('id');
        Session::delete('name');

        Cookie::delete('id');
        Cookie::delete('name');
        Cookie::delete('sign');

        return redirect(BASE_URL . '/admin.php' . site_url('Adminuser', 'login'));
    }

    /**
     * 登录图片码
     *
     * @access public
     *
     * @return string
     */
    public function loginImageCode()
    {
        Loader::import('ValidateCode', EXTEND_PATH);

        $validate_code = new \ValidateCode();

        $validate_code->doimg();

        $code = $validate_code->getCode();

        if ($code) {
            Session::set('image_code', $code);
        }
    }

    /**
     * 登录手机短信码
     *
     * @access public
     * @param string $name 管理员帐号
     * @param string $password 管理员登录密码
     *
     * @return json
     */
    public function loginSendSmsCode()
    {
        $code = rand(1000, 9999);
        $name = input('name');
        $password = input('password');

        //管理员信息
        $info = $this->AdminUsersModel->getInfo(array('name' => $name));

        //加密密码
        $password = pwd_md5($password);

        if ($password != $info['pwd']) {
            $this->ajaxReturn(AJ_RET_FAILED, '账号或者密码错误');
        }

        //上一次请求短信验证码时间
        $sms_time = Session::get('sms_time');

        //距离上一次请求短信验证码时间
        $prve_time = time() - $sms_time;

        if ($prve_time < 60) {
            $this->ajaxReturn(AJ_RET_FAILED, '提交过于频繁，请耐心等待');
        }

        if ($info['mobile']) {
            $ret = $this->sendSms($info['mobile'], '管理后台登录验证码' . $code . ',请勿透露给他人使用');

            if ($ret) {
                Session::set('sms_code', $code);
                Session::set('sms_time', time());

                $this->ajaxReturn(AJ_RET_SUCC, '发送验证码成功', array(), 'no', 'Adminuser/index');

            } else {
                Session::set('sms_time', time());
                $this->ajaxReturn(AJ_RET_FAILED, '发送验证码失败，请稍一分钟后刷新页面再试');
            }
        } else {
            $this->ajaxReturn(AJ_RET_FAILED, '请先联系管理员配置管理员手机号码');
        }
    }
}