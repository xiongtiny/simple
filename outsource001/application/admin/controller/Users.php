<?php
/**
 * Created by PhpStorm.
 * User: Damow
 * Date: 2018/8/23
 * Time: 14:19
 */
namespace app\admin\controller;

use think\Response;

class Users extends Base
{
    /**
     * 所有会员页
     * @access public
     * @param int		$pageNum				页数
     * @param int		$numPerPage				页面条数
     * @param string	$name					会员名称
     * @return html
     */
    public function index()
    {
        $page       = input('pageNum');
        $page       = $page ? (int)$page : 1;
        $page_list  = input('numPerPage');
        $page_list  = $page_list ? (int)$page_list : DEFAULT_PAGE;
        $id         = input('id');
        $where      = array();
        $name       = input('name');

        isset($name) && $where['nick_name'] = array('like', $name);

        $data       = $this->UsersModel->getPage($page, $page_list, $where,array('id'=>'desc'));

        $data['id']     = $id;
        $data['name']           = $name;
        $this->showView('index', $data);
    }

    /**
     * 编辑修改会员
     * @return [json/html]
     */
    public function info()
    {
        if(request()->isPost()){
            $data                = input('post.');

            !isset($data['mobile']) && $this->ajaxReturn(AJ_RET_FAILED, '手机号码不能为空');

            !verify_mobile($data['mobile']) && $this->ajaxReturn(AJ_RET_FAILED, '手机号码格式错误');

            //验证是否存在该会员
            $check_info = $this->UsersModel->getInfo(array('id' => $data['id']));



            if($data['id'] > 0){
                unset($data['mobile']);
                unset($data['pwd']);
                unset($data['pay_pwd']);
                unset($data['pid']);

                empty($check_info) && $this->ajaxReturn(AJ_RET_FAILED, '未找到该会员');

                $ret = $this->UsersModel->updateInfo($data,array('id'=>$data['id']));

                isset($ret)?$this->ajaxReturn(AJ_RET_SUCC, '修改成功', array(), 'close', 'Users/index'):$this->ajaxReturn(AJ_RET_FAILED, '修改失败');
            }else{
                $data['pwd']         = pwd_md5($data['pwd']);
                $data['pay_pwd']         = pwd_md5($data['pay_pwd']);
                $data['nick_name']   = $data['mobile'];
                $data['create_time']   = time();

                $check_mobile = $this->UsersModel->getinfo(array('mobile'=>$data['mobile']));
                !empty($check_mobile) && $this->ajaxReturn(AJ_RET_FAILED, '该手机号已经注册了会员，请更换手机号码注册');


                !empty($check_info) && $this->ajaxReturn(AJ_RET_FAILED, '会员已存在');
                !isset($data['pwd']) && $this->ajaxReturn(AJ_RET_FAILED, '密码不能为空');

                $ret = $this->UsersModel->addUser($data);
                $money_addr = md5($ret.$data['mobile']."Damow");
                $this->UsersModel->updateInfo(['money_addr'=>$money_addr],['id'=>$ret]);

                isset($ret)?$this->ajaxReturn(AJ_RET_SUCC, '添加成功', array(), 'close', 'Users/index'):$this->ajaxReturn(AJ_RET_FAILED, '添加失败');
            }

        }else{

            $id = input('id');
            $pid = input('pid');
            //页面数据信息数组
            $data   = array();
            //查询当前角色信息
            $info   = array();
            isset($id)  && $info = $this->UsersModel->getInfo(array('id' => $id));
            isset($pid) && $data['pid']=$pid;

            $data['user_level']=config('UserLevel');
            $data['info'] = $info;


            $this->showView('info', $data);
        }
    }

    /**
     * 会员
     * @access public
     * @param int  $id	会员分类
     * @return json
     */
    public function save(){
        $id     = input('id');
        $status = input('status');

        $ret = $this->UsersModel->getInfo(array('id' => $id));

        empty($ret) && $this->ajaxReturn(AJ_RET_FAILED, '找不到该会员');

        $this->UsersModel->updateInfo(array('status'=>$status),array('id'=>$id));
        $this->ajaxReturn(AJ_RET_SUCC, '操作成功', array(), 'no', 'Users/index');
    }


    /**
     * 删除会员
     * @access public
     * @param int  $id	会员分类
     * @return json
     */
    public function del()
    {
        $id     = input('id');
        $this->UsersModel->delUser($id);
        $this->ajaxReturn(AJ_RET_SUCC, '操作成功', array(), 'no', 'Users/index');
    }


}