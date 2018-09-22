<?php
namespace app\api\controller;

use app\common;
use think\Session;

header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');
/**
 * 消息通知
 *
 * Class Message
 * @package app\api\controller
 */
class Message extends Base
{
    /**
     * 消息通知
     */
    public function notice(){
        $page=input('post.page');
        $where  = array(
            'status'    =>1 ,
            'to_user_id'    => array('where_in', array($this->user['id'], 0))
        );
        $result  = $this->MessagesModel->getPage($page,10,$where);

        $ids        = array_index_value($result['rows'], 'id', 'id');

        $flags      = array_index_value($this->MessageFlagsModel->getAll(array('message_id' => array('where_in', $ids))), 'message_id', 'message_id');
        foreach($result['rows'] as $k=>$v)
        {
//            $table=$this->MessageFlagsModel->getInfo(['message_id'=>$v['id']]);
           $result['rows'][$k]['status_w']= isset($flags[$v['id']]) ? '已读':'未读';
        }
        $this->ajaxReturn(AJ_RET_SUCC, '成功',$result,$this->lang);
    }

    /**
     * 读取消息
     */
    public function read(){
        !isset($this->data['id']) && $this->ajaxReturn(AJ_RET_FAILED, '非法来源',$this->lang);
        $info   =  $this->MessagesModel->getInfo(['id'=>$this->data['id']]);
        empty($info) && $this->ajaxReturn(AJ_RET_FAILED, '找不到该记录或已被删除','',$this->lang);
        $info_ms   =  $this->MessageFlagsModel->getInfo(['message_id'=>$this->data['id']]);

        empty($info_ms) && $this->MessageFlagsModel->addInfo(['message_id'=>$this->data['id'],'user_id'=>$this->user['id'],'create_time'=>time()]);

        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }
}
