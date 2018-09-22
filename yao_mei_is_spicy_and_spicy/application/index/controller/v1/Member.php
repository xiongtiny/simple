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
        if(!$validate->check($data)){
            return ajax_error([],$validate->getError());
        }
        /**
         * 开启实物
         */
        Db::startTrans();
        try{
            $token=Jwt::login($userModel,$data['phone'],$data['password'],$auto=false,$time='7200000');
            $response['user']=Jwt::auth($token);
            $response['token']=$token;
            ajax_success($response,"登录成功");
        }catch(\Exception $e){
            ajax_error([],$e->getMessage());
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
            'phone'=>"require|unique:user|min:11|max:11",
            'password'=>"require|confirm",
            'code'=>'require',
            'name'=>"require",
            'id_card'=>'require|idCard',
            'rec_id'=>'require',
            'gen_id'=>'require',
        ],[
            'password.confirm'=>"两次输入密码不一致",
            'phone.min'=>"手机号只能为11位",
            'phone.max'=>"手机号只能为11位"
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
        $gen_id = $userModel->where('name',$data['gen_id'])->value('id');
        if(empty($rec_id)){
            return ajax_error([],'推荐人手机号填写错误');
        }
        if(empty($gen_id)){
            return ajax_error([],'总代手机号填写错误');
        }
        $wheres[]=['phone','=',$data['phone']];
        $wheres[]=['code','=',$data['code']];
        $wheres[]=['is_use','=',0];
        $wheres[]=['code_out_time','>= time',date("Y-m-d H:i:s",time())];
        $sms=SendSms::where($wheres)->find();

        if(empty($sms)){
            return ajax_error([],'验证码已失效');
        }
        $user_state = User::where('phone',$data['phone'])->select();
        if(!$user_state->isEmpty()){
            return ajax_error(400,'该手机号已经被注册');
        } 

        /**
         * 开启事物
         */
        Db::startTrans();
        try{
            $data['rec_id'] = $rec_id;           
            $data['gen_id'] = $gen_id;
            $data['password'] = $data['password'];
            $sexint = substr($data['id_card'], 16, 1);
            if($sexint%2 == 0){
                $data['sex'] = 2;
            }else{
                $data['sex'] = 1;
            }
            $useraa = new User;
            $useraa->create($data);
            $sms->save(['is_use'=>1]);

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
        $data['password'] = $data['password'];
        $user=User::get($this->user->id);
        if(!$user->save($data)){
            return ajax_error([],'修改密码');
        }
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
        $wheres[]=['is_use','=',0];
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
            $sms->save(['is_use'=>1]);

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
     * 用户详情及信息修改
     * @throws \think\exception\DbException
     */
    public function info(){
        $this->auth(); 
        $id = request()->get('id');       
        $user_data = User::where('id',$id)->find();
        if(request()->isPost()){
            $data = request()->post();
            $validate=Validate::make([
                'phone'=>"require",
                'id_card'=>"require|idCard",
                'code'=>"require"
            ],[
                
            ],[
                "phone"=>'原密码',
                "id_card"=>'身份证',
                "code"=>'验证码',
            ]);

            if(!$validate->check($data)){
                return ajax_error([],$validate->getError());
            }
            $user = new User;
            $user->save($data,['id'=>$this->user->id]);
            if(!$user){
                return ajax_error(400,'修改失败');
            }else{
                $wheres[]=['phone','=',$data['phone']];
                $wheres[]=['code','=',$data['code']];
                $wheres[]=['is_use','=',0];
                $wheres[]=['code_out_time','>= time',date("Y-m-d H:i:s",time())];
                $sms=SendSms::where($wheres)->find();
                if(empty($sms)){
                    return ajax_error([],'验证码已失效');
                }else{
                    $sms->save(['is_use'=>1]);
                    return ajax_success($user,'修改成功'); 
                }   

                    
            }       
        }else{            
            $user_lower = User::where('status',0)->where('gen_id',$id)->select();
            $user_data['user_lower'] = $user_lower;
            if(empty($user_lower)){
                $user_lower = '';
            }
            return ajax_success($user_data, '获取用户信息成功'); 
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
            if(empty($gen_id['gen_id'])){
                $gen['rec_names'] = $gen_id['name'];
                $gen['gen_phone'] = $gen_id['name'];
                // $gen['gen_phone'] = $rec_id;
            }else{
                $gen['rec_names'] = $gen_id['name'];
                $gen['gen_phone'] = $gen1['name'];
                // $gen['gen_phone'] = $gen1['phone'];
            }              
           
        }
        if($gen){
            return ajax_success($gen,'推荐人姓名,总代姓名,电话');
        }else{
            return ajax_error([],'无总代');
        } 
       

    }

}