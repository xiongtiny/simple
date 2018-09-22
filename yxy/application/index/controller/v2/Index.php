<?php
namespace app\index\controller\v2;

use app\model\User;
use app\plugins\alipay\AopClient;
use app\plugins\alipay\request\AlipayTradePagePayRequest;
use EasyWeChat\Foundation\Application;
class Index
{
    public function index()
    {
//        config('wechat.auth');

        $app = new Application(config('wechat.'));

        $oauth = $app->oauth;
        return $oauth->redirect();

    }

    public function index2()
    {
        $app = new Application(config('wechat.'));
        $oauth = $app->oauth;

// 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        dump($user->getId());

        $targetUrl = empty($_SESSION['target_url']) ? '/' : $_SESSION['target_url'];
//        redirect($targetUrl);
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
