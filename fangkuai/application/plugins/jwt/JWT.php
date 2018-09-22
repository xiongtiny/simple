<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/4/8
 * Time: 下午2:41
 */

namespace app\plugins\jwt;

use \Firebase\JWT\JWT as JWTP;
use think\Model;
use Cache;
use Request;
class JWT extends JWTP
{
    /**
     * @param Model $userModel
     * @param $user 需要验证用户名字段
     * @param $password 需要验证的密码字段
     * @param bool $auto 是否自动登录
     * @param $time 登陆时间
     */
    public function login(Model $userModel,$user='',$password='',$auto=false,$time='7200'){
        if(!$auto){
            $userModel=$userModel->where($userModel->autoUser,$user)->find();
            if(empty($user)){
                throw new \Exception("用户不存在");
            }
            $autoPass=$userModel->autoPass;
            if(!password_verify($password,$userModel->$autoPass)){
                throw new \Exception("用户名或密码错误");
            }
        }
        $jti=time();
        $api=[
            /**
             *非必须。issued at。 token创建时间，unix时间戳格式
             */
            'lat'=>$_SERVER['REQUEST_TIME'],
            /**
             *非必须。expire 指定token的生命周期。unix时间戳格式
             */
            'exp'=>$_SERVER['REQUEST_TIME']+$time,
            /**
             * 非必须。JWT ID。针对当前token的唯一标识
             */
            'jti'=>$jti,
            /**
             * 自定义字段
             */
            'userModel'=>$userModel,
        ];

        $token=self::encode($api,config('jwt.key'));
        if(!Cache::set($token,$jti,$time)){
            throw new \Exception("登录失败");
        };

        return $token;
    }

    /**
     * @param Model $userModel用户模型
     * @param $user 用户名
     * @param $password 密码
     * @return string 返回
     * @throws \Exception
     */
    public function register(Model $userModel,$user,$password){
        $user=$userModel->create([$userModel->autoUser=>$user,$userModel->autoPass=>password_hash($password,PASSWORD_BCRYPT)]);
        if(!$user->id){
            throw new \Exception("注册失败");

        }
        return $this->login($user,'','',false);
    }

    /**
     * 自动登录
     * @param $token
     * @return object
     * @throws \Exception
     */
    public function auth(){
        $token=Request::header('token');
        if(!Cache::get($token)){
            throw new \Exception("token错误或已经过期");
        }
        try{
            $userModel=self::decode($token,config('jwt.key'),config('jwt.type'));
            return $userModel;
        }catch (\Exception $e){
            throw new \Exception("请重新登录");
        }
    }
}