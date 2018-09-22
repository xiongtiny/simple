<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/5/3
 * Time: 上午11:11
 */

namespace app\index\controller;
use think\Controller;
use app\facade\Jwt;

class BaseController extends Controller
{
    protected $user;
    /**
     * 判断是否登陆
     */
    public function auth($flag=true)
    {
        try{
            $this->user=Jwt::auth();

        }catch (\Exception $e){
            if($flag){
                ajax_error([],$e->getMessage());
            }

        }
    }

    public function method($method='get'){
        $is_method="is".ucfirst($method);
        if(!request()->$is_method()){
            ajax_error('','请求方式此错误');
        }
    }


}