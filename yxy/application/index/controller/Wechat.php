<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/4/27
 * Time: 上午10:29
 */

namespace app\index\controller;

use app\model\User;
use EasyWeChat\Foundation\Application;

class Wechat extends BaseController
{
    public function index(){
        $app = new Application(config('wechat.'));
        $order_no=request()->get('order_no');
        $oauth = $app->oauth;
        $oauth->setRedirectUrl('http://yuexueu.weilang.top/#/orderPay?order_no='.$order_no);
        return ajax_success($oauth->redirect()->getTargetUrl(),'返回成功');
    }


    public function notify(){
        $this->method('get');
        $app = new Application(config('wechat.'));
        $oauth = $app->oauth;
        try{
            $user=$oauth->user();
            ajax_success($user->getId(),'微信登录成功');

        }catch (\Exception $e){
            ajax_error('',"获取失败");
            

        }
    }
}

