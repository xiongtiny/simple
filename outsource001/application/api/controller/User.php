<?php
namespace app\api\controller;

use app\common;
use think\Loader;

header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');
/**
 * 用户操作
 *
 * Class User
 * @package app\api\controller
 */
class User extends Base
{
    /**
     * 用户登录
     */
    public function login()
    {
        $data=input('post.');
        //验证手机号与密码
        $this->validate_code($data,$this->lang,'login');



//        if(!captcha_check($data['img_code'])){
//            $this->ajaxReturn(AJ_RET_FAILED, "图片验证码错误",'',$this->lang);
//        };

        $where['status']  = array('!=',0);
        $user   = $this->UsersModel->getInfo(array('mobile' => $data['mobile'],'status'=>['neq',0]),'id,mobile,nick_name,pwd,head_image,level,assets,coin,left_value,right_value,money,pid,activation_num,money_addr,release_status,last_time');
        !is_array($user) && $this->ajaxReturn(AJ_RET_FAILED, "用户不存在,被禁用",'',$this->lang);

        /* 验证用户密码 */
        pwd_md5($data['pwd'])!== $user['pwd'] && $this->ajaxReturn(AJ_RET_FAILED, "密码或账号错误",'',$this->lang);

        $user1   = $this->UsersModel->getInfo(array('id' => $user['id']),'id,last_time');
        $today      = date('Ymd');
        $last_day   = date('Ymd', strtotime($user1['last_time']));

        if($last_day >= $today){
            $user['login_status']=false;
        }else
        {
            $user['login_status']=true;
        }

        $user['token']  = md5($user['id'].time());
        session('token',$user['token']);

        $this->UsersModel->updateInfo(array('last_ip'=>ip2long(client_ip()),'token'=>$user['token']),array('id'=>$user['id'])); //更新用户登录信息
        $user['head_image'] = cover_path($user['head_image']);
        session('user',$user);

        //释放资产
        $this->release($user);
        //动态释放资产
        //$this->stateRelease($user);
        //动态释放资产（统计所有已登录过的用户）
        $this->stateRelease1($user);

        $this->ajaxReturn(AJ_RET_SUCC, '登录成功',$user,$this->lang);

    }

    /**
     * 用户注册
     */
    public function register(){
        $data=$this->data;
        //验证手机号与密码
        $this->validate_code($data,$this->lang,'register');
        $code         = session('random');
        $mobile       = session('mobile');

        $count = $this->UsersModel->getCount(array('pid'=>$data['pid']));
        $count>=2 && $this->ajaxReturn(AJ_RET_FAILED, "下级已超过限制",'',$this->lang);

        if($data['code']!= $code || $mobile!=$data['mobile'])
        {
            $this->ajaxReturn(AJ_RET_FAILED, "验证码错误或验证码已过期",'',$this->lang);
        }

        $data['pwd']     = pwd_md5($data['pwd']);
        $data['pay_pwd'] = pwd_md5($data['pay_pwd']);
        $data['head_image'] = "cover_img/head.png";
        $data['create_time'] = time();
        unset($data['code']);
        $uid    = $this->UsersModel->addUser($data);

        $money_addr = md5($uid.$data['mobile']."Damow");
        $this->UsersModel->updateInfo(['money_addr'=>$money_addr],['id'=>$uid]);

        $this->ajaxReturn(AJ_RET_SUCC, '注册成功','',$this->lang);
    }

    /**
     * 忘记密码
     */
    public function forgetPwd(){
        $data=input('post.');
        $this->validate_code($data,$this->lang,'forgetPwd');

        $user   = $this->UsersModel->getInfo(array('mobile' => $data['mobile']),'id');
        empty($user) && $this->ajaxReturn(AJ_RET_FAILED, "用户不存在",'',$this->lang);

        $code         = session('random');
        $mobile       = session('mobile');

        if($data['code']!= $code || $mobile!=$data['mobile'])
        {
            $this->ajaxReturn(AJ_RET_FAILED, "验证码错误或验证码已过期",'',$this->lang);
        }
        $pwd    = pwd_md5($data['pwd']);
        $this->UsersModel->updateInfo(array('pwd'=>$pwd),array('mobile'=>$data['mobile']));
        $this->ajaxReturn(AJ_RET_SUCC, '修改成功','',$this->lang);
    }

    /**
     * 忘记支付密码
     */
    public function forgetPayPwd(){
        $data=input('post.');
        $this->validate_code($data,$this->lang,'forgetPayPwd');

        $user   = $this->UsersModel->getInfo(array('mobile' => $data['mobile']),'id');
        empty($user) && $this->ajaxReturn(AJ_RET_FAILED, "用户不存在或被禁用",'',$this->lang);

        $code         = session('random');
        $mobile       = session('mobile');

        if($data['code']!= $code || $mobile!=$data['mobile'])
        {
            $this->ajaxReturn(AJ_RET_FAILED, "验证码错误或验证码已过期",'',$this->lang);
        }
        $pwd    = pwd_md5($data['pay_pwd']);
        $this->UsersModel->updateInfo(array('pay_pwd'=>$pwd),array('mobile'=>$data['mobile']));
        $this->ajaxReturn(AJ_RET_SUCC, '修改成功','',$this->lang);
    }

    /**
     * 修改密码
     */
    public function modifyPwd(){
        $data   = input('post.');
        $this->validate_code($data,$this->lang,'modifyPwd');

        $user_pwd   = $this->UsersModel->getInfo(array('id'=>$this->user['id']),'pwd');
        $pwd     = pwd_md5($data['new_pwd']);
        $pwd1    = pwd_md5($data['pwd']);

        $user_pwd!=$pwd1 && $this->ajaxReturn(AJ_RET_FAILED, '密码错误','',$this->lang);


        $this->UsersModel->updateInfo(array('pwd'=>$pwd),array('id'=>$this->user['id']));

        $this->ajaxReturn(AJ_RET_SUCC, '修改成功','',$this->lang);
    }

    /**
     * 修改支付密码
     */
    public function modifyPayPwd(){
        $data   = input('post.');
        $this->validate_code($data,$this->lang,'modifyPayPwd');

        $pay_pwd   = $this->UsersModel->getInfo(array('id'=>$this->user['id']),'pay_pwd');

        $pwd    = pwd_md5($data['pay_pwd']);
        $pwd1    = pwd_md5($data['new_pwd']);

        $pay_pwd!=$pwd && $this->ajaxReturn(AJ_RET_FAILED, '支付密码错误','',$this->lang);

        $res  =$this->UsersModel->updateInfo(array('pay_pwd'=>$pwd1),array('id'=>$this->user['id']));

        $this->ajaxReturn(AJ_RET_SUCC, '修改成功','',$this->lang);
    }

    /**
     * 修改昵称
     */
    public function modifyNick(){
        $data   = input('post.');
        $this->validate_code($data,$this->lang,'modifyNick');
        $this->UsersModel->updateInfo(array('nick_name'=>$data['nick_name']),array('id'=>$this->user['id']));

        $this->ajaxReturn(AJ_RET_SUCC, '修改成功',$data,$this->lang);
    }

    /**
     * 用户中心
     */
    public function me(){
        $id     = $this->user['id'];
        $user   = $this->UsersModel->getInfo(array('id' => $id),'id,mobile,nick_name,pwd,head_image,level,assets,coin,money,pid,activation_num,last_time');


        $user['head_image']     = isset($user['head_image'])?cover_path($user['head_image']):'';

        $res       = $this->statAssets($id);


        $user['a'] = $res['a'];
        $user['b'] = $res['b'];
        $this->ajaxReturn(AJ_RET_SUCC, '成功',$user,$this->lang);
    }

    /**
     * 释放资产
     */
    public function release($user){

        $today  = date('Ymd');

        $last_day   = date('Ymd', strtotime($user['last_time']));

        if($last_day >= $today){
            return false;
        }

        $conf   = exchange_ft_ratio($user['assets']);

        $log  = $user['assets']*$conf['release'];
        $money  = $log*0.7;//资产70%转换为money（金额）
        $coin   = $log*0.3;//资产30%转换为coin（虚拟币）
        $this->UsersModel->decField('assets',$log,['id'=>$user['id']]);
        $this->UsersModel->incField('money',$money,['id'=>$user['id']]);
        $this->UsersModel->incField('coin',$coin,['id'=>$user['id']]);

        $result =[[
            'user_id'     => $user['id'],
            'reuser_id'   => $user['id'],
            'type'        => 2,
            'count'       => $log,
            'ret_count'   => $log,
            'note'        => '释放资产',
            'source'      => $this->action,
            'create_time' => time(),

        ],[
            'user_id'     => $user['id'],
            'reuser_id'   => $user['id'],
            'type'        => 3,
            'count'       => $money,
            'ret_count'   => $money,
            'note'        => '释放奖励金额',
            'source'      => $this->action,
            'create_time' => time(),
            'subtract'    =>1
        ],[
            'user_id'     => $user['id'],
            'reuser_id'   => $user['id'],
            'type'        => 9,
            'count'       => $coin,
            'ret_count'   => $coin,
            'note'        => '释放奖励虚拟币',
            'source'      => $this->action,
            'create_time' => time(),
            'subtract'    =>1
        ]];
        $this->LogsModel->addInfo($result,true);

        //$this->UsersModel->updateInfo(array('release_assets'=>$log),['id'=>$user['id']]);//所有用户登录领取奖励状态
        $this->UsersModel->updateInfo(array('release_assets'=>$log, 'release_status'=>1), ['id'=>$user['id']]);
        //$this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }

    /**
     * 动态释放资产
     *
     * @param $user
     * @return bool
     */
    public function stateRelease($user)
    {
        $deep_num   = 5;

        $today      = date('Ymd');

        $last_day   = date('Ymd', strtotime($user['last_time']));

        if($today == 20180913 && $user['release_status'] == 0){

        }else{
            if($last_day >= $today){
                return false;
            }
        }


        $res  = $this->UsersModel->getAll(array('pid'=>$user['id']),array('id' => 'asc'));

        $result1 = isset($res[0]) ? $this->UsersModel->childDeep($res[0]['id'],$deep_num) : array();//A

        $sum1 = 0;
        if(isset($result1[0]) && ($result1[0]['release_status'] == 1 || $result1[0]['right_value'] - $result1[0]['left_value'] <= 1)){
            $sum1   = array_index_value($result1,'id', 'deep_ratio', 'sum');
        }

        $result2 = isset($res[1]) ? $this->UsersModel->childDeep($res[1]['id'],$deep_num) : array();//B

        $sum2 = 0;
        if(isset($result2[0]) && ($result2[0]['release_status'] == 1 || $result2[0]['right_value'] - $result2[0]['left_value'] <= 1)){
            $sum2   = array_index_value($result2,'id', 'deep_ratio', 'sum');
        }

        if($sum1+$sum2 > 0){
            $log  = $sum1+$sum2;
            $money  = $log*0.7;//资产70%转换为money（金额）
            $coin   = $log*0.3;//资产30%转换为coin（虚拟币）
            $this->UsersModel->decField('assets',$log,['id'=>$this->user['id']]);
            $this->UsersModel->incField('money',$money,['id'=>$this->user['id']]);
            $this->UsersModel->incField('coin',$coin,['id'=>$this->user['id']]);

            $result =[[
                'user_id'     => $user['id'],
                'reuser_id'   => $user['id'],
                'type'        => 2,
                'count'       => $log,
                'ret_count'   => $log,
                'note'        => '动态释放资产',
                'source'      => $this->action,
                'create_time' => time(),
            ],[
                'user_id'     => $user['id'],
                'reuser_id'   => $user['id'],
                'type'        => 3,
                'count'       => $money,
                'ret_count'   => $money,
                'note'        => '动态释放奖励金额',
                'source'      => $this->action,
                'create_time' => time(),
                'subtract'    =>1
            ],[
                'user_id'     => $user['id'],
                'reuser_id'   => $user['id'],
                'type'        => 9,
                'count'       => $coin,
                'ret_count'   => $coin,
                'note'        => '动态释放奖励虚拟币',
                'source'      => $this->action,
                'create_time' => time(),
                'subtract'    =>1
            ]];
            $this->LogsModel->addInfo($result,true);

            $this->UsersModel->updateInfo(array('release_status'=>1),['id'=>$user['id']]);
        }else{
            if($user['right_value']-$user['left_value'] == 1){
                $this->UsersModel->updateInfo(array('release_status'=>1),['id'=>$user['id']]);
            }
        }

        //$this->ajaxReturn(AJ_RET_SUCC, '成功', array($result1,$result2),$this->lang);
    }

    /**
     * 动态释放资产（统计所有已登录过的用户）
     *
     * @param $user
     * @return bool
     */
    public function stateRelease1($user)
    {
        $deep_num   = 5;

        $today      = date('Ymd');

        $last_day   = date('Ymd', strtotime($user['last_time']));

        if($last_day >= $today){
            return false;
        }

        $res  = $this->UsersModel->getAll(array('pid'=>$user['id']),array('id' => 'asc'));

        $result1 = isset($res[0]) ? $this->UsersModel->childDeep($res[0]['id'], $deep_num) : array();//A

        $sum1 = 0;
        foreach((array)$result1 as $k1 => $v1){
            if($v1['release_status'] == 1){
                $sum1 += $v1['deep_ratio'];
            }
        }

        $result2 = isset($res[1]) ? $this->UsersModel->childDeep($res[1]['id'], $deep_num) : array();//B

        $sum2 = 0;
        foreach((array)$result2 as $k2 => $v2){
            if($v2['release_status'] == 1){
                $sum2 += $v2['deep_ratio'];
            }
        }

        if($sum1+$sum2 > 0){
            $log  = $sum1+$sum2;
            $this->UsersModel->decField('assets',$log,['id'=>$this->user['id']]);
            $this->UsersModel->incField('money',$log,['id'=>$this->user['id']]);

            $result =[[
                'user_id'     => $user['id'],
                'reuser_id'   => $user['id'],
                'type'        => 2,
                'count'       => $log,
                'ret_count'   => $log,
                'note'        => '动态释放资产',
                'source'      => $this->action,
                'create_time' => time(),
            ],[
                'user_id'     => $user['id'],
                'reuser_id'   => $user['id'],
                'type'        => 3,
                'count'       => $log,
                'ret_count'   => $log,
                'note'        => '动态释放奖励金额',
                'source'      => $this->action,
                'create_time' => time(),
                'subtract'    =>1
            ]];
            $this->LogsModel->addInfo($result,true);
        }

        //$this->ajaxReturn(AJ_RET_SUCC, '成功', array($result1,$result2),$this->lang);
    }

    /**
     * 重置release_status状态
     */
    public function resetReleaseStatus(){

        $last_time  = strtotime("-1 day")+3600;

        $this->UsersModel->updateInfo(array('release_status'=>0, 'release_assets' => 0, 'last_time' => $last_time),['id'=>array('>', 0)]);

        $this->ajaxReturn(AJ_RET_SUCC, '重置状态成功', '', $this->lang);
    }

    /**
     * 删除会员
     */
    public function del(){
        empty($this->data['id']) && $this->ajaxReturn(AJ_RET_FAILED, "非法来源",'',$this->lang);

        $status = $this->UsersModel->getInfo(array('id'=>$this->data['id']),'status');
        !isset($status) && $this->ajaxReturn(AJ_RET_FAILED, "用户不存在或被禁用",'',$this->lang);
        $status!=1 && $this->ajaxReturn(AJ_RET_FAILED, "该用户不能删除",'',$this->lang);

        $this->UsersModel->delUser($this->data['id']);
        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }


    /**
     * 退出登录
     */
    public function loginOut(){
        empty($this->user) && $this->ajaxReturn(AJ_RET_FAILED, "未登录",'',$this->lang);
        session('user',null);
        $this->ajaxReturn(AJ_RET_SUCC, '退出登录成功','',$this->lang);
    }

    /**
     * 验证节点是否能够注册
     */
    public function check()
    {
        empty($this->data['id']) && $this->ajaxReturn(AJ_RET_FAILED, "非法来源",'',$this->lang);
        $status = $this->UsersModel->getInfo(['id'=>$this->data['id']],'status');
        if($status!=2)
        {
            $this->ajaxReturn(AJ_RET_FAILED, "接入人未激活",'',$this->lang);
        }

        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }
    /**
     * 查询用户
     */
    public function search()
    {
        $this->validate_code($this->data,$this->lang,'userTrue');
        $info      = $this->UsersModel->getInfo(array('mobile'=>($this->data['mobile']?$this->data['mobile']:$this->user['mobile'])),'id,mobile,status,pid,left_value,right_value,position');

        $list    = $this->UsersModel->childDeep($info['id'],2, $info);

        foreach($list as $k=>$v)
        {
            if($v['status']==0)
            {
                $list[$k]['status_q']="禁用";
            }elseif($v['status']==1)
            {
                $list[$k]['status_q']="未激活";
            }elseif($v['status']==2)
            {
                $list[$k]['status_q']="激活";
            }

        }
//       $list    = $this->genTree($list);
        $arr=[];

        foreach($list as $k=>$v)
        {
            $arr[$v['id']]  = $v['deep'].$v['position'];

            $key    = $v['deep'] > 1 ? $arr[$v['pid']] :'';

            $list['deep'. $key . ($v['deep'] == 0 ? '' : $v['deep'].$v['position'])] = $v;
            unset($list[$k]);
        }

        $res       = $this->statAssets($info['id']);
        $user['a'] = $res['a'];
        $user['b'] = $res['b'];

        $this->ajaxReturn(AJ_RET_SUCC, '成功',array("tree"=>$list,'val'=>$user),$this->lang);
    }

    /**
     * 激活用户
     */
    public function activation(){
        $data   = $this->data;
        $this->validate_code($data,$this->lang,'userTrue');
        $user       =  $this->UsersModel->getInfo(array('mobile' => $data['mobile']),'id,status');
        empty($user) && $this->ajaxReturn(AJ_RET_FAILED, "用户不存在",'',$this->lang);

        $user1  = $this->UsersModel->getInfo(array('id' => $this->user['id']),'id,activation_num');

        $user1['activation_num']<1 && $this->ajaxReturn(AJ_RET_FAILED, "激活次数不足",'',$this->lang);

        $user['id'] == $this->user['id'] && $this->ajaxReturn(AJ_RET_FAILED, "不能激活自己",'',$this->lang);
        $user['status'] ==0 && $this->ajaxReturn(AJ_RET_FAILED, "该用户已经被禁用",'',$this->lang);
        $user['status'] ==2 && $this->ajaxReturn(AJ_RET_FAILED, "该用户已经被激活",'',$this->lang);

        $this->UsersModel->decField('activation_num',1,['id'=>$this->user['id']]);
        $this->UsersModel->incField('status',1,['mobile'=>$data['mobile']]);

        //默认新增3000资产
        $this->UsersModel->incField('assets',3000,['mobile'=>$data['mobile']]);

        //加记录值
        $this->UsersModel->incField('money_log',500,['mobile'=>$data['mobile']]);


        $result =[
            'user_id'     => $this->user['id'],
            'reuser_id'   => $user['id'],
            'type'        => 7,
            'count'       => 1,
            'ret_count'   => 1,
            'note'        => '激活用户',
            'source'      => $this->action,
            'create_time' => time(),
        ];
        $this->LogsModel->addInfo($result);

        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }

    /**
     * 判断该用户是否存在
     */
    public function userTrue(){
        $data   = input('post.');
        $id     = $this->user['id'];
        $this->validate_code($data,$this->lang,'userTrue');
        $user   = $this->UsersModel->getInfo(array('mobile' => $data['mobile']),'id');
        empty($user) && $this->ajaxReturn(AJ_RET_FAILED, "用户不存在或被禁用",'',$this->lang);

        $user   = $this->UsersModel->getInfo(array('mobile' => $data['mobile']),'id,money,pay_pwd');
        empty($user) && $this->ajaxReturn(AJ_RET_FAILED, "用户不存在或被禁用",'',$this->lang);
        $id     == $user['id'] && $this->ajaxReturn(AJ_RET_FAILED, "转入人不能是自己",'',$this->lang);

        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }


    /**
     * 用户转账
     */
    public function transfer(){
        $data   = input('post.');
        $id     = $this->user['id'];
        $this->validate_code($data,$this->lang,'transfer1');
        $user   = $this->UsersModel->getInfo(array('mobile' => $data['mobile']),'id,money,pay_pwd');
        empty($user) && $this->ajaxReturn(AJ_RET_FAILED, "用户不存在或被禁用",'',$this->lang);
        $id     == $user['id'] && $this->ajaxReturn(AJ_RET_FAILED, "转入人不能是自己",'',$this->lang);

        $user_info   = $this->UsersModel->getInfo(array('id' => $this->user['id']),'id,assets,coin,money,pay_pwd');
        empty($user_info['pay_pwd']) && $this->ajaxReturn(AJ_RET_FAILED, "请先设置支付密码",'',$this->lang);
        pwd_md5($data['pay_pwd'])!== $user_info['pay_pwd'] && $this->ajaxReturn(AJ_RET_FAILED, "支付密码错误",'',$this->lang);

        if($data['money']>$user_info['money'])
        {
            $this->ajaxReturn(AJ_RET_FAILED, "转账金额不足",'',$this->lang);
        }


        $this->UsersModel->decField('money',$data['money'],['id'=>$id]);
        $this->UsersModel->incField('money',$data['money'],['mobile'=>$data['mobile']]);

        $result= [
            'user_id'        => $this->user['id'],
            'type'           => 1,
            'reuser_id'      => $user['id'],
            'count'          => $data['money'],
            'ret_count'      => $data['money'],
            'note'           => "转出",
            'source'         => request()->action(),
            'create_time'    => time(),
            'subtract'       => 0
        ];
        $this->LogsModel->addInfo($result);

        $result= [
            'user_id'        => $user['id'],
            'type'           => 1,
            'reuser_id'      => $this->user['id'],
            'count'          => $data['money'],
            'ret_count'      => $data['money'],
            'note'           => "转入",
            'source'         => request()->action(),
            'create_time'    => time(),
            'subtract'       => 1
        ];
        $this->LogsModel->addInfo($result);

        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }

    /**
     * 用户转账TFC
     */
    public function transferTFC(){
        $data   = input('post.');
        $id     = $this->user['id'];
        $leng   = strlen($data['money_addr']);
        if($leng<=11)
        {
            $this->validate_code($data,$this->lang,'transfer');
            $table='mobile';
        }else
        {
            $this->validate_code($data,$this->lang,'transferaddr');
            $table='money_addr';
        }

        $user_info   = $this->UsersModel->getInfo(array('id' => $this->user['id']),'id,assets,coin,money,pay_pwd');

        empty($user_info['pay_pwd']) && $this->ajaxReturn(AJ_RET_FAILED, "请先设置支付密码",'',$this->lang);
        pwd_md5($data['pay_pwd'])!== $user_info['pay_pwd'] && $this->ajaxReturn(AJ_RET_FAILED, "支付密码错误",'',$this->lang);

        $user   = $this->UsersModel->getInfo(array($table => $data['money_addr']),'id,coin');
        empty($user) && $this->ajaxReturn(AJ_RET_FAILED, "用户不存在或被禁用",'',$this->lang);
        $id     == $user['id'] && $this->ajaxReturn(AJ_RET_FAILED, "转入人不能是自己",'',$this->lang);

        $user_info   = $this->UsersModel->getInfo(array('id' => $this->user['id']),'id,assets,coin,money');

        if($data['coin']>$user_info['coin'])
        {
            $this->ajaxReturn(AJ_RET_FAILED, "余额不足",'',$this->lang);
        }

        $this->UsersModel->decField('coin',$data['coin'],['id'=>$id]);
        $this->UsersModel->incField('coin',$data['coin'],[$table => $data['money_addr']]);

        $result= [
            'user_id'        => $this->user['id'],
            'type'           => 10,
            'reuser_id'      => $user['id'],
            'count'          => $data['coin'],
            'ret_count'      => $data['coin'],
            'note'           => "转账",
            'source'         => request()->action(),
            'create_time'    => time(),
        ];

        $this->LogsModel->addInfo($result);
        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }
    /**
     * 兑换激活数
     */
    public function exchangeActivationCount(){
        $data   = input('post.');
        $this->validate_code($data,$this->lang,'exchange');
        $bili   = config('ratio');
        $money  = $data['activation_num']*$bili;
        $user   = $this->UsersModel->getInfo(array('id' => $this->user['id']),'id,assets,coin,money');

        (int)$data['activation_num']===0 && $this->ajaxReturn(AJ_RET_FAILED, "请输入正确的数量",'',$this->lang);
        if($user['money']<($data['activation_num']*$bili))
        {
            $this->ajaxReturn(AJ_RET_FAILED, "余额不足",'',$this->lang);
        }

        $this->UsersModel->decField('money',$money,['id'=>$this->user['id']]);
        $this->UsersModel->incField('activation_num',$data['activation_num'],['id'=>$this->user['id']]);

        $result= [
            'user_id'        => $this->user['id'],
            'type'           => 8,
            'count'          => $data['activation_num']*$bili,
            'ret_count'      => $data['activation_num'],
            'note'           => "兑换激活次数",
            'source'         => request()->action(),
            'create_time'    => time(),
        ];
        $this->LogsModel->addInfo($result);
        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }

    /**
     * 绑定银行卡
     */
    public function bindBank(){
        $data   = input('post.');
        $this->validate_code($data,$this->lang,'bindBank');
        $this->UsersModel->updateInfo($data,array('id'=>$this->user['id']));
        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }

    /**
     * 兑换资产
     */
    public function exchangeAssets()
    {
        empty($this->data['count']) && $this->ajaxReturn(AJ_RET_FAILED, "非法来源",'',$this->lang);

        $this->data['count']<20 && $this->ajaxReturn(AJ_RET_FAILED, "兑换金额不得小于20",'',$this->lang);
        $this->data['count']%20!=0 && $this->ajaxReturn(AJ_RET_FAILED, "必须是20的整倍数",'',$this->lang);

        $user_info   = $this->UsersModel->getInfo(array('id' => $this->user['id']),'id,money');
        if($this->data['count']>$user_info['money'])
        {
            $this->ajaxReturn(AJ_RET_FAILED, "余额不足",'',$this->lang);
        }
        $count    = $this->statAssets($this->user['id']);
        $conf     = exchange_ft_ratio($count['min']);
        $assets   = $conf['ratio']*$this->data['count'];

        $res      = $this->UsersModel->decField('money',$this->data['count'],['id'=>$this->user['id']]);

        $this->UsersModel->incField('assets',$assets,['id'=>$this->user['id']]);

        //加记录值
        $this->UsersModel->incField('money_log',$this->data['count'],['id'=>$this->user['id']]);

        $result= [
            'user_id'        => $this->user['id'],
            'reuser_id'      => $this->user['id'],
            'type'           => 0,
            'count'          => $this->data['count'],
            'ret_count'      => $this->data['count'],
            'note'           => "兑换资产",
            'source'         => request()->action(),
            'create_time'    => time(),
        ];
        $this->LogsModel->addInfo($result);


        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);

    }

    /**
     * 赠送激活卡
     */
    public function giveActivation()
    {
        $data   = input('post.');
        $this->validate_code($data,$this->lang,'giveActivation');
        $user_info   = $this->UsersModel->getInfo(array('id' => $this->user['id']),'id,activation_num');
        $user   = $this->UsersModel->getInfo(array('mobile' => $data['mobile']),'id,money');
        empty($user) && $this->ajaxReturn(AJ_RET_FAILED, "用户不存在或被禁用",'',$this->lang);
        $this->user['id']== $user['id'] && $this->ajaxReturn(AJ_RET_FAILED, "赠送人不能是自己",'',$this->lang);
        $user_info['activation_num']<$data['count'] && $this->ajaxReturn(AJ_RET_FAILED, "激活次数不足",'',$this->lang);

        $this->UsersModel->decField('activation_num',$data['count'],['id'=>$this->user['id']]);
        $this->UsersModel->incField('activation_num',$data['count'],['mobile'=>$data['mobile']]);

        $result= [
            'user_id'        => $this->user['id'],
            'type'           => 6,
            'reuser_id'      => $user['id'],
            'count'          => $data['count'],
            'ret_count'      => $data['count'],
            'note'           => "转增激活次数",
            'source'         => request()->action(),
            'create_time'    => time(),
        ];
        $result2= [
            'user_id'        => $user['id'],
            'type'           => 6,
            'reuser_id'      => $this->user['id'],
            'count'          => $data['count'],
            'ret_count'      => $data['count'],
            'note'           => "获得激活次数",
            'source'         => request()->action(),
            'create_time'    => time(),
        ];
        $this->LogsModel->addInfo($result);
        $this->LogsModel->addInfo($result2);
        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }

    /**
     * 生成二维码
     */
    public function qrcode (){
        Loader::import('phpqrcode',EXTEND_PATH . 'qrcode'.DS);
        $qrcode                 = new \QRcode();

        if(empty($this->data['type']))
        {
            $this->data['type']=1;
        }
        if($this->data['type']==1)
        {
            $value = $this->user['mobile'];//二维码跳转的
        }else
        {
            $value = $this->user['money_addr'];//二维码跳转的
        }
        $errorCorrectionLevel = 'L';  //容错级别
        $matrixPointSize = 8;      //生成图片大小
        //生成二维码图片
        $file_name = $this->user['id'] ? substr($this->user['id'],0,2).'/'.substr($this->user['id'],2,2):'';

        $dir = ROOT_PATH.'public/static/upload/qrcode/'.$file_name;
        mkdirs($dir);

        if($this->data['type']==1)
        {
            $filename = ROOT_PATH.'public/static/upload/qrcode/'.$file_name.'/'.$this->user['id'].'mb.png';
            $imgsec=STATIC_URL . 'upload/qrcode/'.$file_name.'/'.$this->user['id'].'mb.png';
            $money_addr             = $this->user['mobile'];
        }else
        {
            $filename = ROOT_PATH.'public/static/upload/qrcode/'.$file_name.'/'.$this->user['id'].'qb.png';
            $money_addr             = md5($this->user['id'].$this->user['mobile']."Damow");
            $imgsec=STATIC_URL . 'upload/qrcode/'.$file_name.'/'.$this->user['id'].'qb.png';
        }



        $qrcode->png($value,$filename , $errorCorrectionLevel, $matrixPointSize, 2);
        $QR = $filename;        //已经生成的原始二维码图片文件
        $QR = imagecreatefromstring(file_get_contents($QR));

        //输出图片
        imagepng($QR, $filename);
        imagedestroy($QR);

        $this->ajaxReturn(AJ_RET_SUCC, '成功', array('img'   => $imgsec,'money_addr'=>$money_addr),$this->lang);
    }



    /**
     * 生成二维码
     */
    public function qrcode_two(){
        Loader::import('phpqrcode',EXTEND_PATH . 'qrcode'.DS);
        $qrcode                 = new \QRcode();

        if(empty($this->data['type']))
        {
            $this->data['type']=1;
        }
        if($this->data['type']==1)
        {
            $value = $this->user['mobile'];//二维码跳转的
        }else
        {
            $value = $this->user['money_addr'];//二维码跳转的
        }
        $errorCorrectionLevel = 'L';  //容错级别
        $matrixPointSize = 8;      //生成图片大小
        //生成二维码图片
        $file_name = $this->user['id'] ? substr($this->user['id'],0,2).'/'.substr($this->user['id'],2,2):'';

        $dir = ROOT_PATH.'public/static/upload/qrcode/'.$file_name;
        mkdirs($dir);

        if($this->data['type']==1)
        {
            $filename = ROOT_PATH.'public/static/upload/qrcode/'.$file_name.'/'.$this->user['id'].'mb.png';
            $imgsec=STATIC_URL . 'upload/qrcode/'.$file_name.'/'.$this->user['id'].'mb.png';
            $money_addr             = $this->user['mobile'];
        }else
        {
            $filename = ROOT_PATH.'public/static/upload/qrcode/'.$file_name.'/'.$this->user['id'].'qb.png';
            $money_addr             = md5($this->user['id'].$this->user['mobile']."Damow");
            $imgsec=STATIC_URL . 'upload/qrcode/'.$file_name.'/'.$this->user['id'].'qb.png';
        }



        $qrcode->png($value,$filename , $errorCorrectionLevel, $matrixPointSize, 2);
        $QR = $filename;        //已经生成的原始二维码图片文件
        $QR = imagecreatefromstring(file_get_contents($QR));

        //输出图片
        imagepng($QR, $filename);
        imagedestroy($QR);

        $this->ajaxReturn(AJ_RET_SUCC, '成功', array('img'   => $imgsec,'money_addr'=>$money_addr),$this->lang);
    }


    /**
     *  二维码验证
     */
    public function qrcodeUrl()
    {
        if(empty($this->data['mobile']))
        {
            $this->data['mobile']='';
        }
        if(empty($this->data['money_addr']))
        {
            $this->data['money_addr']='';
        }

        if(!$this->data['mobile'] && !$this->data['money_addr'])
        {
            $this->ajaxReturn(AJ_RET_FAILED, '请提交有效的二维码','',$this->lang);
        }
        if(!empty($this->data['mobile']))
        {
            $info1   = $this->UsersModel->getInfo(array('mobile' => $this->data['mobile'],'status'=>['neq',0]),'id,mobile,money_addr');
            empty($info1) && $this->ajaxReturn(AJ_RET_FAILED, '二维码扫描识别错误','',$this->lang);
        }

        if(!empty($this->data['money_addr']))
        {
            $info2   = $this->UsersModel->getInfo(array('money_addr' => $this->data['money_addr'],'status'=>['neq',0]),'id,mobile,money_addr');

            empty($info2) && $this->ajaxReturn(AJ_RET_FAILED, '二维码扫描识别错误','',$this->lang);
        }

        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }

    /**
     * 修改头像
     */
    public function saveCoverimg()
    {
        $data   = input('post.');
        $this->validate_code($data,$this->lang,'saveCoverimg');
        $id     = $this->user['id'];
        $path   = save_base64_cover_img("data:image/png;base64,".$data['head_image'],'cover_img',$id);

        $id     = $this->user['id'];
        $this->UsersModel->updateInfo(array('head_image'=>$path),array('id'=>$id));
        $result = cover_path($path);
        $this->ajaxReturn(AJ_RET_SUCC, '修改成功',$result,$this->lang);
    }



    /**
     * 切换语言
     */
    public function language()
    {
        $language=isset($this->data['language']) ? $this->data['language'] : 1;

        if($language=='cn')
        {
            session('language',1);
            $msg="succeed";
        }else
        {
            session('language',null);
            $msg="成功";
        }

        $this->ajaxReturn(AJ_RET_SUCC, $msg,'',$this->lang);
    }


    /**
     * 银行卡信息
     */
    public function bank()
    {
        $info   = $this->UsersModel->getInfo(array('id' => $this->user['id'],'status'=>['neq',0]),'id,nick_name,bank_address,bank_account,bank');
        $this->ajaxReturn(AJ_RET_SUCC, '成功',$info,$this->lang);
    }

    /**
     * 图片验证码
     */
    public function codeImg()
    {
        echo captcha_src();
    }

    /**
     * 转账手机号提示
     */
    public function mobilecode()
    {
        $this->validate_code($this->data,$this->lang,'userTrue');
        $this->ajaxReturn(AJ_RET_SUCC, '成功','',$this->lang);
    }
}
