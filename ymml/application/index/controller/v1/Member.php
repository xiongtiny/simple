<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/5/3
 * Time: 上午11:19
 */

namespace app\index\controller\v1;


use app\index\controller\BaseController;
use app\Models\User;
use app\Models\SendSms;
use app\facade\Jwt;
use think\Validate;
use Db;
class Member extends BaseController
{
    /**
     * 登录
     * @return \think\response\Json
     */
    public function login(){
        $this->method('post');
        $data=request()->post();
        $userModel=new User();
        $validate=Validate::make([
            'phone'=>"require",
            'password'=>"require",
        ],[],[
            'phone'=>'手机号',
            'password'=>'密码'
        ]);
        $status = $userModel->where('phone',request()->post('phone'))->value('status');
        if($status==1){
          if(!$validate->check($data)){
                return ajax_error([],$validate->getError());
            }
            try{
                $token=Jwt::login($userModel,$data['phone'],$data['password'],$auto=false,$time='72000');
                $response['user']=Jwt::auth($token);
                $response['token']=$token;
                ajax_success($response,"登录成功");
            }catch(\Exception $e){
                ajax_error([],$e->getMessage());
            }
         
        }else{
            ajax_error(400,'审核未通过');
        
        }
    }


    /**
     * 退出
     */
    public function logout(){
        $this->auth();
        Jwt::logout();
    }


    /**
     * 注册
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function register(){
        $this->method('post');
        $data=request()->post();
        $userModel=new User();
        $validate=Validate::make([
            'phone'=>"require|unique:user",
            'password'=>"require|confirm",
            'code'=>'require',
            'name'=>"require",
            'id_card'=>'require',
            'rec_id'=>'require',
            'gen_id'=>'require',
        ],[
            'password.confirm'=>"两次输入密码不一致"
        ],[
            'phone'=>'手机号',
            'password'=>'密码',
            'code'=>'验证码',
            'name'=>'昵称',
            'id_card'=>'身份证',
            'rec_id'=>'推荐代理',  
            'gen_id'=>'总代理',           
        ]);
        if(!$validate->check($data)){
            return ajax_error([],$validate->getError());
        }
        $rec_id = $userModel->where('phone',$data['rec_id'])->value('id');
        $gen_id = $userModel->where('phone',$data['gen_id'])->value('id');
        if(empty($rec_id)){
            return ajax_error([],'推荐人手机号填写错误');
        }
        if(empty($gen_id)){
            return ajax_error([],'总代手机号填写错误');
        }
        $data1=request()->except('phone,password');
        $wheres[]=['phone','=',$data['phone']];
        $wheres[]=['code','=',$data['code']];
        // $wheres[]=['is_use','=',0];
        $wheres[]=['code_out_time','>= time',date("Y-m-d H:i:s",time())];
        $sms=SendSms::where($wheres)->find();

        if(empty($sms)){
            return ajax_error([],'验证码已失效');
        }

        /**
         * 开启事物
         */
        Db::startTrans();
        try{
            $data1['rec_id'] = $rec_id;           
            $data1['gen_id'] = $gen_id;       
            $token=Jwt::register($userModel,$data['phone'],$data['password']);
            $user=Jwt::auth($token);  
            $userModel->get($user->id)->save($data1);
//          $sms->save(['is_use'=>1]);

            /**
             * 事务运行
             */
            Db::commit();
            return ajax_success(compact('user','token'),"注册成功");
        }catch (\Exception $e){
            /**
             * 事务回滚
             */
            Db::rollback();
            return ajax_error([],$e->getMessage());

        }
    }

    /**
     * @param $phone 手机号
     * @param int $length 验证码长度
     * @param int $out_time 过期时间
     * @return \think\response\Json|void
     */
    public function sendSms()
    {
        $this->method('post');
        $data=request()->post();

        $validate=Validate::make([
            'phone'=>"require",
        ],[],[
            'phone'=>'手机号',
        ]);
        if(!$validate->check($data)){
            return ajax_error([],$validate->getError());
        }
        sendSms($data['phone'], 4, 60);
    }



    /**
     * 修改密码
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function changePassword(){
        $this->auth();
        $this->method('post');
        $data=request()->post();
        $validate=Validate::make([
            'old_password'=>"require",
            'password'=>"require|confirm|unique:user",
        ],[
            'password.confirm'=>"两次密码不一致",
            'password.unique'=>"新密码和旧密码不能一样"
        ],[
            "old_password"=>'原密码',
            'password'=>"新密码"
        ]);

        if(!$validate->check($data)){
            return ajax_error([],$validate->getError());
        }

        $user=User::get($this->user->id);
        if(!$user->save($data)){
            return ajax_error([],'修改密码');
        };

        $token=Request::header('token');
        Cache::rm($token);
        return ajax_success([],"修改密码成功，请重新登录");
    }

    /**
     * 忘记密码
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function forgetPassword(){
        $this->method('post');
        $data=request()->post();
        $validate=Validate::make([
            'phone'=>"require|number",
            'password'=>"require",
            'code'=>"require|number"
        ],[],[
            'phone'=>"手机号",
            'password'=>"密码",
            'code'=>'验证码'
        ]);

        if(!$validate->check($data)){
            ajax_error([],$validate->getError());
        }


        $wheres[]=['phone','=',$data['phone']];
        $wheres[]=['code','=',$data['code']];
        // $wheres[]=['is_use','=',0];
        $wheres[]=['code_out_time','>= time',date("Y-m-d H:i:s",time())];
        $sms=SendSms::where($wheres)->find();

        if(empty($sms)){
            return ajax_error([],'验证码已失效');
        }

        /**
         * 开启事物
         */
        Db::startTrans();
        try{
            $user=User::where('phone',$data['phone'])->find();
            $user->save(['password'=>$data['password']]);
            // $sms->save(['is_use'=>1]);

            /**
             * 事务运行
             */
            Db::commit();
            return ajax_success([],"修改密码成功");
        }catch (\Exception $e){
            /**
             * 事务回滚
             */
            Db::rollback();
            return ajax_error([],'修改密码失败');

        }
    }


    /**
     * 用户详情
     * @throws \think\exception\DbException
     */
    public function info(){
        $this->auth();
        $user_data = $this->user;
        if(request()->isPost()){
            $this->method('post');
            $date=request()->post();
            $user=User::get($this->user->id); 
            if(!$user->save($date)){
                 ajax_error($this->user,'修改失败');
            }
            $user=User::get($this->user->id);
             ajax_success($user,'修改成功');
        }else{
            ajax_success($user_data, '获取用户信息成功');
        } 
    }



    /*
    *注册时自动填充总代信息
    */
    public function automatic(){
        $rec_id = request()->post('rec_id');
        $gen_id = User::where('phone',$rec_id)->field('name,gen_id')->find();
        if(empty($gen_id)){
            return ajax_error([],'推荐人电话填写错误！');
        }else{
            $gen1 = User::where('id',$gen_id['gen_id'])->field('name,phone')->find();
            $gen['rec_name'] = $gen_id['name'];
            $gen['gen_name'] = $gen1['name'];
            $gen['gen_phone'] = $gen1['phone'];
            if($gen){
                return ajax_success($gen,'推荐人姓名,总代姓名,电话');
            }else{
                return ajax_error([],'无总代');
            } 
        }
       

    }

}