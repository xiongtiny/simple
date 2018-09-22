<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/4/9
 * Time: 下午5:03
 */

namespace app\index\controller\v1;
use app\facade\Jwt;
use app\model\SendSms;
class BaseController
{
    protected $user;
    /**
     * 判断是否登陆
     */
    public function auth()
    {
        try{
            $this->user=Jwt::auth();

        }catch (\Exception $e){
             ajax_error([],$e->getMessage());

        }
    }

    public function method($method='get'){
        $is_method="is".ucfirst($method);
        if(!request()->$is_method()){
            ajax_error('','请求方式此错误');
        }
    }

}