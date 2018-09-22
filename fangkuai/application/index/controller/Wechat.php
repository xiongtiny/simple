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
use \think\facade\Session;
class Wechat
{
    public function index(){
        $app = new Application(config('wechat.'));
        $oauth = $app->oauth;
        $oauth->setRedirectUrl('http://www.fineclab.com/api/wechat/notify');
        return $oauth->redirect();
    }


    public function notify(){
        $this->method('get');
        $app = new Application(config('wechat.'));
        $oauth = $app->oauth;
        $openid = $oauth->user()->getId();
        redirect('http://www.fineclab.com/api/v2/farm/farm_?openid='.$openid."&farm_id=".Session::get('farm_id'));
    }
}

