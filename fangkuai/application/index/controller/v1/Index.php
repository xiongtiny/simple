<?php
namespace app\index\controller\v1;
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/19
 * Time: 19:40
 */

use app\model\SendSms;
use app\model\Service;
use think\Controller;
use think\facade\Session;
use think\Validate;

class Index extends Controller{

    /**
     *  用户注册
     *  @return \think\response\Json
     */
    public function register1()
    {
        return $this->fetch();
    }
    public function register(){
        
        $data=request()->post();
        $validate=Validate::make([
            'phone'=>"require",
            'password'=>"require",
            // 'code'=>'require'
        ],[],
            [
                'phone'=>'手机号',
                'password'=>'密码',
                'code'=>'验证码'
            ]);
        if(!$validate->check($data)){
            return error(400,$validate->getError());
        }

        $wheres[]=['phone','=',$data['phone']];
        $wheres[]=['code','=',$data['code']];
        $wheres[]=['code_out_time','>=',date("Y-m-d H:i:s",time())];
        $sms = SendSms::where($wheres)->find();
        if(empty($sms)){
            return error(400,'验证码已失效');
        }
        $user_state = \app\model\User::where('phone',$data['phone'])->select();
        if(!$user_state->isEmpty()){
            return error(400,'该手机号已经被注册');
        }
        $user = \app\model\User::create([
            'name' =>$data['phone'],
            'phone'  => $data['phone'],
            'password' => md5($data['password'])
        ]);
        if( $user->id){
            return success(200,'注册成功',$user->id);
        }else{
            return error(400,'注册失败');
        }
        
    }

    /**
     * 登录
     * @return \think\response\Json
     */
    public function login1()
    {
        return $this->fetch();
    }
    public function login(){
        
        $data=request()->post();
        $validate=Validate::make([
            'phone'=>"require",
            'password'=>"require",
        ],[],[
            'phone'=>'手机号',
            'password'=>'密码'
        ]);
        if(!$validate->check($data)){
            return error(400,$validate->getError());
        }
        $user_state = \app\model\User::where('phone',$data['phone'])->select();
        if(!$user_state->isEmpty()){
            $wheres[]=['phone','=',$data['phone']];
            $wheres[]=['password','=',md5($data['password'])];
            $user = \app\model\User::where($wheres)->find();
            if($user){
                  //保存用户id
                Session::set('user_id',$user->id);
                Session::set('user',$user->name);
                Session::set('phone',$user->phone);
                return success(200,'登陆成功',$user);
              
            }else{
                return error(400,'密码有误!');
            }
        }else{
            return error(400,'手机号有误!');
        }

    }
    /**
     * 找回密码
     * @return \think\response\Json
     */
    public function retrieve_password1()
    {
        return $this->fetch();
    }
    public function retrieve_password(){
        if(request()->isPost()){
            $data = request()->post();
            $validate=Validate::make([
                'phone'=>"require",
                'password'=>"require",
                'code'=>'require'
            ],
                [
                    'phone'=>'手机号',
                    'password'=>'密码',
                    'code'=>'验证码'
                ]);
            if(!$validate->check($data)){
                return error(400,$validate->getError());
            }
            $wheres[]=['phone','=',$data['phone']];
            $wheres[]=['code','=',md5($data['code'])];
            $wheres[]=['code_out_time','>=',date("Y-m-d H:i:s",time())];
            $sms = SendSms::where($wheres)->find();
            if(empty($sms)){
                return error(400,'验证码已失效');
            }
            $user_state = \app\model\User::where('phone',$data['phone'])->find();
            if(empty($user_state)){
                return error(400,'该手机号未注册,请核对手机号');
            }
            $user = \app\model\User::where('phone',$data['phone'])->update(['password' => md5($data['password'])]);
            if($user){
                return success(200,'修改密码成功',$user);
            }else{
                return error(400,'修改密码失败');
            }
        }
        return $this->fetch();
    }
    /**
     * 用户
     * @return \think\response\Json
     */
    
    public function sendSms()
    {
        $data=request()->post();

        $validate=Validate::make([
            'phone'=>"require",
        ],[],[
            'phone'=>'手机号',
        ]);
        if(!$validate->check($data)){
            return error([],$validate->getError());
        }
        sendSms($data['phone'], 4, 60);
    }

    /**
     * 用户退出登录
     * @return \think\response\Json
     */
    public function exit_login(){
        Session::delete('user_id');
        Session::delete('user');
        Session::delete('phone');
        $this->redirect("/index.php/api/v1/index/login1");
    }

    public function hls(){
        return $this->fetch();
    }
    public function index()
    {
        $farm_data = \app\model\Farm::where('type',0)->order('create_time desc')->limit(9)->select();
        foreach ($farm_data as $k=>$v){
            $v['service'] = Service::whereIn('id',$v['service'])->column('name');
        }
        if(!$farm_data->isEmpty()){
            $this->assign('data',$farm_data);
            $this->assign('service',$v['service']);
        }else{
            // return error(400,'暂无农场信息');
        }
        $this->assign('data',$farm_data);
        $this->assign('service',$v['service']);
        return $this->fetch();
    }
}
