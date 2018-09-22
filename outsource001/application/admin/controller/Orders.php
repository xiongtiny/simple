<?php
/**
 * Created by PhpStorm.
 * User: Damow
 * Date: 2018/8/23
 * Time: 16:02
 */
namespace app\admin\controller;

use think\Response;

class Orders extends Base
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
        $mobile       = input('mobile');

        $user_info  = $this->UsersModel->getInfo(array('mobile' => $mobile));

        if($user_info){
            $where['user_id']   = $user_info['id'];
        }else{
            isset($mobile) && $where['user_id'] = 0;
        }

        $data       = $this->OrdersModel->getPage($page, $page_list, $where,array('id'=>'desc'));


        foreach($data['rows'] as $k=>$v)
        {
            $v['status']==1?$data['rows'][$k]['is_status']=0:$data['rows'][$k]['is_status']=1;
        }

        $data['id']     = $id;
        $data['mobile']           = $mobile;

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

            if($data['id'] > 0){

                //验证是否存在该会员
                $check_info = $this->OrdersModel->getInfo(array('id' => $data['id']));
                empty($check_info) && $this->ajaxReturn(AJ_RET_FAILED, '未找到订单');

                $ret = $this->OrdersModel->updateInfo($data,array('id'=>$data['id']));
                isset($ret)?$this->ajaxReturn(AJ_RET_SUCC, '修改成功', array(), 'close', 'orders/index'):$this->ajaxReturn(AJ_RET_FAILED, '修改失败');
            }else{

                $ret = $this->OrdersModel->addInfo($data);
                isset($ret)?$this->ajaxReturn(AJ_RET_SUCC, '添加成功', array(), 'close', 'orders/index'):$this->ajaxReturn(AJ_RET_FAILED, '添加失败');
            }

        }else{
            $id = input('id');
            //页面数据信息数组
            $data   = array();
            //查询当前角色信息
            $info   = array();
            isset($id) && $info = $this->OrdersModel->getInfo(array('id' => $id));

            $data['user_level']=config('UserLevel');
            $data['info'] = $info;
            $this->showView('info', $data);
        }
    }

    /**
     * 删除会员
     * @access public
     * @param int		$id					会员分类
     * @return json
     */
    public function save(){
        $id     = input('id');
        $status = input('status');

        $ret = $this->OrdersModel->getInfo(array('id' => $id));
        empty($ret) && $this->ajaxReturn(AJ_RET_FAILED, '找不到该记录');

        $this->OrdersModel->updateInfo(['status'=>$status],['id'=>$id]);
        $this->ajaxReturn(AJ_RET_SUCC, '操作成功', array(), 'no', 'orders/index');
    }
}