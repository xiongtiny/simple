<?php
namespace app\api\controller;

use app\common;

header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');
/**
 * 验证
 *
 * Class Verify
 * @package app\api\controller
 */
class Verify extends Base
{
    /**
     * 发送短信验证码
     */
    public function sms(){
        $data=input('post.');
        //验证手机号
        $validate=validate('users');
        if(!$validate->scene('sms')->check($data)){
            $this->ajaxReturn(AJ_RET_FAILED, $validate->getError());
        }
        $user_info=$this->UsersModel->getInfo(['mobile'=>$data['mobile']],'id');

        if($data['type']==1)
        {
            !empty($user_info) && $this->ajaxReturn(AJ_RET_FAILED, '用户已存在，请勿重复注册','',$this->lang);
        }else
        {
            empty($user_info) && $this->ajaxReturn(AJ_RET_FAILED, '该用户还未注册','',$this->lang);
        }


        $statusStr = array(
            "0" => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
        );
        $smsapi = config('sms.smsapi');
        $user   = config('sms.user'); //短信平台帐号
        $pass   = md5(config('sms.pass')); //短信平台密码

        $random =  rand_str();
        session('random',$random);
        session('mobile',$data['mobile']);
        $content= "您的手机验证码为：".$random."，3分钟内有效！【".config("seo.site_name")."】";//要发送的短信内容

        $phone  = $data['mobile'];//要发送短信的手机号码
        $sendurl= $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        $result =file_get_contents($sendurl) ;
        $result!=0 && $this->ajaxReturn(AJ_RET_FAILED, '发送失败，请联系客服','',$this->lang);

        $this->ajaxReturn(AJ_RET_SUCC, '发送成功','',$this->lang);
    }
}
