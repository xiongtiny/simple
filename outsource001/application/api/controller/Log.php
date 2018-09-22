<?php
namespace app\api\controller;

use app\common;

header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');
/**
 * 操作日志
 * 注意：兑换 转账  释放
 *
 * Class Log
 * @package app\api\controller
 */
class Log extends Base
{
    /**
     * 所有记录
     */
    public function logs()
    {
        $data   = input('post.');
        empty($data['page']) && $data['page']=1;

        $list   = $this->LogsModel->getPage($data['page'],10,['user_id'=>$this->user['id'],'type'=>$data['type']],['id'=>'desc']);

        $this->ajaxReturn(AJ_RET_SUCC, '成功',$list,$this->lang);
    }

    /**
     * 区域流水
     */
    public function areas()
    {
        $data   = input('post.');
        $page=isset($data['page'])?(int)$data['page']:1;
        if($data['type']!='a' && $data['type']!='b')
        {
            $this->ajaxReturn(AJ_RET_FAILED, '请选择正确的操作类型','',$this->lang);
        }

        $position   = $data['type'] == 'a' ? 0 : 1;

        empty($data['page']) && $data['page']=1;

        $info   = $this->UsersModel->getInfo(array('pid' => $data['user_id'], 'position' => $position,'status'=>['neq',0]),'id,nick_name');

        empty($info) && $this->ajaxReturn(AJ_RET_SUCC, '成功',array(),$this->lang);

        $list   = $this->UsersModel->child($info['id']);

        $user_ids   = array_index_value($list, 'id', 'id');

        $arr    = $this->LogsModel->getPage($page,10,array('reuser_id' => array('where_in', $user_ids), 'type' => array('where_in', [0, 7])),['id'=>'desc']);

        foreach ((array)$arr['rows'] as $k => $v){
            $arr['rows'][$k]['count']    = $v['type'] == 7 ? "500.0000" : $v['count'];
            $arr['rows'][$k]['ret_count']    = $v['type'] == 7 ? "500.0000" : $v['ret_count'];
        }

        $this->ajaxReturn(AJ_RET_SUCC, '成功',$arr['rows'],$this->lang);
    }

    /**
     * EP和用户资产记录
     * 1ep 2资产
     */
    public function los()
    {
        $data   = input('post.');
        empty($data['page']) && $data['page']=1;
        if($data['type']==1)//EP
        {
            $arr=[1,3];
        }elseif($data['type']==2)//DOTON
        {
            $arr=[9];
        }else//资产
        {
            $arr=[2];
        }
        $list   = $this->LogsModel->getPage($data['page'],10,['user_id'=>$this->user['id'],'type'=>['where_in',$arr]],['id'=>'desc']);

        $this->ajaxReturn(AJ_RET_SUCC, '成功',$list['rows'],$this->lang);
    }
    /**
     * 兑换记录列表
     */
    public function exchange()
    {
        $data   = input('post.');
        empty($data['page']) && $data['page']=1;
        $list   = $this->LogsModel->getPage($data['page'],10,['user_id'=>$this->user['id'],'type'=>0],['id'=>'desc']);

        $this->ajaxReturn(AJ_RET_SUCC, '成功',$list,$this->lang);
    }

    /**
     * 转账记录列表
     */
    public function transfer(){
        $data   = input('post.');
        empty($data['page']) && $data['page']=1;
        $list   = $this->LogsModel->getPage($data['page'],10,['user_id'=>$this->user['id'],'type'=>1],['id'=>'desc']);

        $this->ajaxReturn(AJ_RET_SUCC, '成功',$list,$this->lang);
    }

    /**
     * 释放记录列表
     */
    public function release(){
        $data   = input('post.');
        empty($data['page']) && $data['page']=1;
        $list   = $this->LogsModel->getPage($data['page'],10,['user_id'=>$this->user['id'],'type'=>2],['id'=>'desc']);

        $this->ajaxReturn(AJ_RET_SUCC, '成功',$list,$this->lang);
    }

    /**
     * 释放奖励列表
     */
    public function releaseAward(){
        $data   = input('post.');
        empty($data['page']) && $data['page']=1;
        $list   = $this->LogsModel->getPage($data['page'],10,['user_id'=>$this->user['id'],'type'=>3],['id'=>'desc']);

        $this->ajaxReturn(AJ_RET_SUCC, '成功',$list,$this->lang);
    }

    /**
     * 充值记录列表
     */
    public function rechargeRecord(){
        $data   = input('post.');
        empty($data['page']) && $data['page']=1;
        $list   = $this->LogsModel->getPage($data['page'],10,['user_id'=>$this->user['id'],'type'=>4],['id'=>'desc']);

        $this->ajaxReturn(AJ_RET_SUCC, '成功',$list,$this->lang);
    }

    /**
     * 提现记录列表
     */
    public function withdrawalRecord(){
        $data   = input('post.');
        empty($data['page']) && $data['page']=1;
        $list   = $this->LogsModel->getPage($data['page'],10,['user_id'=>$this->user['id'],'type'=>5],['id'=>'desc']);

        $this->ajaxReturn(AJ_RET_SUCC, '成功',$list,$this->lang);
    }
}
