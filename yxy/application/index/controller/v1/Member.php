<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/4/9
 * Time: 下午4:39
 * 前端会员控制器
 */

namespace app\index\controller\v1;
use think\Validate;
use app\facade\Jwt;
use app\model\User;
use app\model\UserInfo;
use app\model\SendSms;
use Db;
use Cache;
use Request;
class Member extends BaseController
{
    /**
     * 我的首页
     */
    public function index(){
        $this->method();
        $this->auth();
        $user=User::get($this->user->id);
        $user_info=UserInfo::get($this->user->id);
        /**
         * 获得学籍天数
         */
        $day=ceil((time()-strtotime($user->create_time))/60/60/24);
        /**
         * 班级课时
         */
        $courses=$user->course();
        $course_hours=$courses->sum('hours');
        /**
         * 1v1课时
         */
        $class_hours=$user->classHour();
        $c_hours=$class_hours->sum('hours');

        /**
        * 累计课时
        */
        $hours=$course_hours+$c_hours;

        /**
         * 剩余1v1课时
         */
        $s_hours=$courses->where('type','2')->sum('hours');
        $surplus=$c_hours-$s_hours;

        /**
         * 省市区
         */
        $user_pro = Db::table('yxy_province')->where('code',$user_info['province'])->find();
        // dump($user_pro);die;
        $user['pro'] = $user_pro['name'];
        $user_city = Db::table('yxy_city')->where('code',$user_info['city'])->find();
        $user['cit'] = $user_city['name'];
        $user_area = Db::table('yxy_area')->where('code',$user_info['area'])->find();
        $user['are'] = $user_area['name'];

        $response=compact('user','user_info','day','hours','c_hours','surplus');

        return ajax_success($response,'获取成功');

    }

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
            return ajax_error([],$validate->getError());#
        }
        try{
            $token=Jwt::login($userModel,$data['phone'],$data['password'],$auto=false,$time='72000');
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
            'phone'=>"require|unique:user",
            'password'=>"require|confirm",
            'code'=>'require',
            'username'=>"require",
        ],[
            'password.confirm'=>"两次输入密码不一致"
        ],[
            'phone'=>'手机号',
            'password'=>'密码',
            'code'=>'验证码',
            'username'=>'真实姓名'
        ]);
        if(!$validate->check($data)){
            return ajax_error([],$validate->getError());
        }
        $data1=request()->except('phone,password');
        //学籍号生成
        $number_nowday = substr(date('Ymd'),2,6);
        $user          = new User;
        $number_user_max    = $user->max('number');
        $number_user_max    = substr($number_user_max,2,6);
        $number = $number_nowday > $number_user_max ? $number_nowday.'00001' : $number_user_max+1;
        $data1['number'] = $number;//学籍号-18042300001（年月日+排序）
        //类型type
        $data1['type'] = 0;
        
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
            $token=Jwt::register($userModel,$data['phone'],$data['password']);
            $user=Jwt::auth($token);

            $userModel->get($user->id)->save($data1);
//            $sms->save(['is_use'=>1]);

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
     * 个人详情
     * @return \think\response\Json
     */
    public function info(){
        $this->method('post');
        $this->auth();
        $user=[];
        $UserInfo=[];
/*        $data=request()->post();*/
        $img=uploadImageOne('img',2);
        if($img['status']==0){
            $user['img']=$img['message'];

        }

        if(request()->has('sex')){
            $user['sex']=request()->post('sex');
        }

        if(request()->has('username')){
            $user['username']=request()->post('username');
        }

        if(request()->has('grade')){
            $UserInfo['grade']=request()->post('grade');
        }

        if(request()->has('school')){
            $UserInfo['school']=request()->post('school');
        }

        if(request()->has('province')){
            $UserInfo['province']=request()->post('province');
        }

        if(request()->has('city')){
            $UserInfo['city']=request()->post('city');
        }

        if(request()->has('area')){
            $UserInfo['area']=request()->post('area');
        }

        if(request()->has('address')){
            $UserInfo['address']=request()->post('address');
        }

        if(request()->has('email')){
            $validate=Validate::make([
                'email'=>"require|email",
            ],[],[
                'email'=>"邮箱"
            ]);
            if(!$validate->check(['email'=>request()->post('email')])){
                ajax_error('',$validate->getError());
            }
            $UserInfo['email']=request()->post('email');
        }

        if(request()->has('weixin')){
            $UserInfo['weixin']=request()->post('weixin');
        }

        if(request()->has('alipay')){
            $UserInfo['alipay']=request()->post('alipay');
        }

        if(request()->has('bank_card')){
            $UserInfo['bank_card']=request()->post('bank_card');
        }
        // $user = request()->post();
        // print_r($user);
        // print_r($UserInfo);
        
        // return ajax_success($user,"111");
        // die;

        /**
         * 开启事物
         */
        Db::startTrans();
        try{
            $userModel=User::get($this->user->id);

            if(!empty($user)){
                $userModel->update($user,['id'=>$userModel->id]);
            }

//            dump($userModel->UserInfo);
            $userInfoObject= $userModel->UserInfo;
            if(empty($userInfoObject)){
               $userModel->UserInfo()->save($UserInfo);
            }else{
                $userModel->UserInfo->save($UserInfo);
            }
            $user=User::get($this->user->id);
            $userInfo=$user->UserInfo;
            /**
             * 事务运行
             */
            Db::commit();
            return ajax_success(compact('user','userInfo'),"修改资料成功");
        }catch (\Exception $e){
            /**
             * 事务回滚
             */
            Db::rollback();
            return ajax_error([],$e->getMessage());

        }
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
        $user=User::get($this->user->id);

        if(!$validate->check($data)){
            return ajax_error([],$validate->getError());
        }

        if(!password_verify(request()->post('old_password'),$user->password)){
            return ajax_error([],"原始密码不对");
        }

        if(password_verify(request()->post('password'),$user->password)){
            return ajax_error([],"不能和原密码相同");
        }

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
        $wheres[]=['is_use','=',0];
        $wheres[]=['code_out_time','>= time',date("Y-m-d H:i:s",time())];
        $sms=SendSms::where($wheres)->find();

        if(empty($sms)){
            return ajax_error([],'验证码已失效');
        }

        $user=User::where('phone',$data['phone'])->find();

        if(password_verify(request()->post('password'),$user->password)){
            return ajax_error([],"不能和原密码相同");
        }
        /**
         * 开启事物
         */
        Db::startTrans();
        try{
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
     * 上传头像
     */
     public function img(){
         $this->method('post');
         $this->auth();
         $img=uploadImageOne('img',2);
         if($img['status']==0){
             $user=User::get($this->user->id);
             if($user->save(['img'=>$img['message']])){
                 $user=User::get($this->user->id);

                 return ajax_success($user->img,'上传头像成功');

             }else{
                 return ajax_error([],'上传头像失败1');
             }

         }else{
             return ajax_error([],$img['message']);


         }

     }


}