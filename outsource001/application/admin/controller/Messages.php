<?php
/**
 * Created by PhpStorm.
 * User: Damow
 * Date: 2018/8/24
 * Time: 11:40
 */
namespace app\admin\controller;

use think\Response;

class Messages extends Base
{
    /**
     * 所有消息页
     * @access public
     * @param int		$pageNum				页数
     * @param int		$numPerPage				页面条数
     * @param string	$name					消息名称
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
        $title       = input('title');
        isset($title) && $where['title'] = array('like', $title);
        $data       = $this->MessagesModel->getPage($page, $page_list, $where,array('id'=>'desc'));

        foreach($data['rows'] as $k=>$v)
        {
            $v['status']==1?$data['rows'][$k]['is_status']=0:$data['rows'][$k]['is_status']=1;
        }

        $data['id']     = $id;
        $data['title']   = $title;

        $this->showView('index', $data);
    }

    /**
     * 编辑修改消息
     * @return [json/html]
     */
    public function info()
    {
        if(request()->isPost()){
            $data                = input('post.');
            $data['show_time']   = strtotime($data['show_time']);
            if($data['id'] > 0){

                //验证是否存在该消息
                $check_info = $this->MessagesModel->getInfo(array('id' => $data['id']));
                empty($check_info) && $this->ajaxReturn(AJ_RET_FAILED, '未找到订单');

                $ret = $this->MessagesModel->updateInfo($data,array('id'=>$data['id']));
                isset($ret)?$this->ajaxReturn(AJ_RET_SUCC, '修改成功', array(), 'close', 'Messages/index'):$this->ajaxReturn(AJ_RET_FAILED, '修改失败');
            }else{

                $ret = $this->MessagesModel->addInfo($data);
                isset($ret)?$this->ajaxReturn(AJ_RET_SUCC, '添加成功', array(), 'close', 'Messages/index'):$this->ajaxReturn(AJ_RET_FAILED, '添加失败');
            }

        }else{
            $id = input('id');
            //页面数据信息数组
            $data   = array();

            //查询当前角色信息
            $info   = array();

            isset($id) && $info = $this->MessagesModel->getInfo(array('id' => $id));

            $data['user_level']=config('UserLevel');
            $data['info'] = $info;
            $this->showView('info', $data);
        }
    }

    /**
     * 删除消息
     * @access public
     * @param int		$id					消息分类
     * @return json
     */
    public function save(){
        $id     = input('id');
        $status = input('status');

        $ret = $this->MessagesModel->getInfo(array('id' => $id));
        empty($ret) && $this->ajaxReturn(AJ_RET_FAILED, '找不到该记录');

        $this->MessagesModel->updateInfo(['status'=>$status],['id'=>$id]);
        $this->ajaxReturn(AJ_RET_SUCC, '操作成功', array(), 'no', 'Messages/index');
    }


}