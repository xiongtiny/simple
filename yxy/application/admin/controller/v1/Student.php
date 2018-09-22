<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/12
 * Time: 18:07
 */
namespace app\admin\controller\v1;
use app\model\Grade;
use app\model\NewsType;
use app\model\Subject;
use Request;
use Db;
use think\Controller;
use app\model\User;//操作意向用户表
use app\model\UserInfo;//操作意向用户表
use app\model\UserIson;//操作意向用户表
use app\model\Talk;//操作沟通记录表
use app\model\Grade as GradeModel;
use app\model\Admin as AdminModel;
use app\model\Role as RoleModel;
use think\Validate;

class Student extends BaseController{



    /**
     *  学生管理
     *  @return string
     */
    public function index(){
        $this->method();
        $this->auth();
        $user      = new User;
        $wheres=[];
        if(request()->has('source') && request()->get('source')!==''){
            $wheres['source']=request()->get('source');
        }

        if(request()->has('headmaster') && request()->get('headmaster')!==''){
            $wheres['headmaster']=request()->get('headmaster');
        }

        if(request()->has('consolution')  && request()->get('consolution')!==''){
            $wheres['consolution']=request()->get('consolution');
        }
        if(empty($wheres)){
            $data = $user->select();
        }else{

            $user_ids=UserInfo::where($wheres)->column('user_id');

            $data =$user->whereIn('id',$user_ids)->select();

        }
        foreach ($data as $key => $value) {
            $user_data_info = UserInfo::where(['user_id'=>$value['id']])->find();
            $grade = GradeModel::get($value['grade']);
            $admin = AdminModel::get($value['teacher']);
            $last_talk_time = Talk::where(['user_id'=>$value['id']])->order('id desc')->find();
            $data[$key]['school']   = $user_data_info['school'];
            $data[$key]['source']   = $user_data_info['source'];
            $data[$key]['headmaster']  = $user_data_info['headmaster'];
            $data[$key]['consolution'] = $user_data_info['consolution'];
            $data[$key]['grade']    = $grade['name'];
            $data[$key]['teacher']  = $admin['name'];
            $data[$key]['last_talk_time'] = $last_talk_time['talk_time'];
        }

        $headmaster=RoleModel::where('name','班主任')->find()->admins;
        $consolution=RoleModel::where('name','咨询老师')->find()->admins;

        // dump($data);die;
        return view('',compact('data','headmaster','consolution'));
    }


    /**
     *  学生管理--我的学生
     *  @return string
     */
    public function my_student(){
        $this->auth();
        $user      = new User;
        $wheres=[];
        if(request()->has('source') && request()->get('source')!==''){
            $wheres['source']=request()->get('source');
        }

        if(request()->has('headmaster') && request()->get('headmaster')!==''){
            $wheres['headmaster']=request()->get('headmaster');
        }

        if(request()->has('consolution')  && request()->get('consolution')!==''){
            $wheres['consolution']=request()->get('consolution');
        }


        $headmaster=RoleModel::where('name','班主任')->find()->admins;
        $consolution=RoleModel::where('name','咨询老师')->find()->admins;

        if(empty($wheres)){
            $data = $user->select();
        }else{

            $user_ids=UserInfo::where($wheres)->column('user_id');

            $data =$user->whereIn('id',$user_ids)->select();

        }
        foreach ($data as $key => $value) {
            $user_data_info = UserInfo::where(['user_id'=>$value['id']])->find();
            $grade = GradeModel::get($value['grade']);
            $admin = AdminModel::get($value['teacher']);
            $data[$key]['school']   = $user_data_info['school'];
            $data[$key]['consolution'] = $user_data_info['consolution'];
            $data[$key]['headmaster']  = $user_data_info['headmaster'];
            $data[$key]['grade']    = $grade['name'];
            $data[$key]['teacher']  = $admin['name'];
        }
        return view('',compact('data','headmaster','consolution'));
    }



    /**
     *  学生管理--全部学生
     *  @return string
     */

    public function all_student(){
        $this->auth();
        $user      = new User;
        $headmaster=RoleModel::where('name','班主任')->find()->admins;
        $consolution=RoleModel::where('name','咨询老师')->find()->admins;
        $wheres=[];
        if(request()->has('source') && request()->get('source')!==''){
            $wheres['source']=request()->get('source');
        }

        if(request()->has('headmaster') && request()->get('headmaster')!==''){
            $wheres['headmaster']=request()->get('headmaster');
        }

        if(request()->has('consolution')  && request()->get('consolution')!==''){
            $wheres['consolution']=request()->get('consolution');
        }
        if(empty($wheres)){
            $data = $user->select();
        }else{

            $user_ids=UserInfo::where($wheres)->column('user_id');

            $data =$user->whereIn('id',$user_ids)->select();

        }
        foreach ($data as $key => $value) {
            $user_data_info = UserInfo::where(['user_id'=>$value['id']])->find();
            $grade = GradeModel::get($value['grade']);
            $admin = AdminModel::get($value['teacher']);
            $data[$key]['school']   = $user_data_info['school'];
            $data[$key]['consolution'] = $user_data_info['consolution'];
            $data[$key]['headmaster']  = $user_data_info['headmaster'];
            $data[$key]['grade']    = $grade['name'];
            $data[$key]['teacher']  = $admin['name'];
        }
        return view('',compact('data','headmaster','consolution'));
    }



    /**
     *  学生管理--新增学生()
     *  @return string
     */
    public function add(){
        $this->auth();
        $data           = Request::post();
        if($data){
            //判断改手机号是否被注册
            $user          = new User;
            $phone = $user->where('phone',$data['phone'])->find();
            if($phone){
                ajax_error($phone,'该电话号码已被注册，请重新输入');
            }
            $password_len = mb_strlen($data['password']);
            if($password_len < 6){
                ajax_error($password_len,'密码长度不可小于6位数');
            }
            $data['type']  = 2;//类型，后台添加
            $data['teacher'] = $this->user->id;//获取当前管理员（班主任id）
            $number_nowday = substr(date('Ymd'),2,6);
            $number_user_max    = $user->max('number');
            $number_user_max    = substr($number_user_max,2,6);
            $number = $number_nowday > $number_user_max ? $number_nowday.'00001' : $number_user_max+1;
            $data['number'] = $number;//学籍号-18042300001（年月日+排序）
            // dump($data);die;
            $add = $user->create($data);
            if($add){
                ajax_success($add,'新增成功');
            }else{
                ajax_error($add,'新增失败');
            }
        }else{
            return $this->fetch();
        }   
       
    }



    /**
     *  学生管理--编辑学生信息页面
     *  @return string
     */
    public function edit_student(){
        $this->auth();
        $id = $_GET['id'];
        $user           = new User;
        $user_data      = $user->where(['id'=>$id])->find();
        $UserInfo      = new UserInfo;
        $user_data_info = $UserInfo->where(['user_id'=>$id])->find();
        $data           = Request::post();
        $grades=Grade::order("listor")->select();
        $subjects=Subject::order("listor")->select();
        $headmaster=RoleModel::where('name','班主任')->find()->admins;
        $consolution=RoleModel::where('name','咨询老师')->find()->admins;

        $this->assign('user_data',$user_data);
        $this->assign('grades',$grades);
        $this->assign('subjects',$subjects);
        $this->assign('user_data_info',$user_data_info);
        $this->assign('headmaster',$headmaster);
        $this->assign('consolution',$consolution);
        return $this->fetch();
    }


    /**
     *  学生管理--编辑我的学生
     *  @return string
     */
    public function edit_my_student(){
        $this->auth();
        $id = $_GET['id'];
        $user           = new User;
        $user_data      = $user->where(['id'=>$id])->find();
        $UserInfo      = new UserInfo;
        $user_data_info = $UserInfo->where(['user_id'=>$id])->find();
        $data           = Request::post();
        $grades=Grade::order("listor")->select();
        $subjects=Subject::order("listor")->select();
        $headmaster=RoleModel::where('name','班主任')->find()->admins;
        $consolution=RoleModel::where('name','咨询老师')->find()->admins;

        if(request()->has('email')) {
            $validate = Validate::make([
                'email' => "require|email",
            ], [], [
                'email' => "邮箱"
            ]);
            if (!$validate->check(['email' => request()->post('email')])) {
                ajax_error('', $validate->getError());
            }
        }
        $this->assign('grades',$grades);
        $this->assign('subjects',$subjects);
        $this->assign('headmaster',$headmaster);
        $this->assign('consolution',$consolution);
        $this->assign('user_data',$user_data);
        $this->assign('user_data_info',$user_data_info);
        return $this->fetch(); 
    }


     /**
     *  学生管理--编辑学生信息
     *  @return string
     */
    public function edit_post(){
        $this->auth();
        $data           = Request::post();
        // dump($data);die;
        if($data){
            $user           = new User;
            $data_user = $user->get($data['id']);
            $UserInfo      = new UserInfo;
            $data_UserInfo = $UserInfo->where(['user_id'=>$data['id']])->find();
            $data_pro_ci_ar = explode("/",$data['pro_ci_ar']);
            $pro = Db::table('yxy_province')->where('name',$data_pro_ci_ar[0])->find();
            if($pro){
                $cit = Db::table('yxy_city')->where('name',$data_pro_ci_ar[1])->find();
                if($cit){
                    $are = Db::table('yxy_area')->where('name',$data_pro_ci_ar[2])->find();
                    if($are){
                        $data['province'] = $pro['code'];
                        $data['city'] = $cit['code'];
                        $data['area'] = $are['code'];
                    }
                }
            }
            //开启事物
            Db::startTrans();
            try {
                if(empty($data_UserInfo)){
                    $data['user_id'] = $data['id'];
                    $add_UserInfo = UserInfo::create($data);
                    $add_user = $data_user->save($data);
                }else{
                    $add_user = $data_user->save($data);
                    $add_UserInfo = $data_UserInfo->save($data);
                }
                // dump(333);
                //事务运行
                Db::commit();
                // dump(444);
                ajax_success($add_UserInfo,'提交成功');
            }catch (\Exception $e){
                // 回滚事务
                Db::rollback();
                // dump(555);die;
                ajax_error($add_UserInfo,'提交失败');
            }
        }
    }



    /**
     *  学生管理--沟通历史
     *  @return string
     */
    public function talk(){
        $this->auth();
        $id = $_GET['id'];
        $talk_data = Talk::select();
        $user = User::get($id);
        $this->assign('data',$talk_data);
        $this->assign('id',$id);
        $this->assign('user_data',$user);
        return $this->fetch();
    }


    /**
     *  学生管理--沟通历史
     *  @return string
     */
    public function add_talk(){
        $this->auth();
        if(Request::isAjax()){
            $data = Request::post();
            $validate=Validate::make([
                'note_user'=>"require",
                'type'=>'require',
                'stage'=>'require',
                'content'=>'require',
            ],[],[
                'note_user'=>'记录人姓名',
                'type'=>'沟通类型',
                'stage'=>'选择阶段',
                'content'=>'沟通内容'
            ]);

            if(!$validate->check($data)){
                ajax_error('',$validate->getError());
            }
            // dump($data);die;
            $add_talk = Talk::create($data);
            if($add_talk){
                ajax_success($data,'新增成功');
            }else{
                ajax_error('','新增失败');
            }
        }else{
            $id = $_GET['id'];
            $user = User::get($id);
            $this->assign('user_data',$user);
            return $this->fetch();
        }
    }



    /**
     *  学生管理--删除学生
     *  @return string
     */
    public function talk_delete($id){
        $this->auth();
        $this->method('post');
        if(Talk::destroy($id)){
            ajax_success('','删除成功');

        }

        ajax_error('','删除失败');

    }



}