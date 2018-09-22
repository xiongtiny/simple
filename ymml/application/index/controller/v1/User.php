<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/5/28
 * Time: 14:20
 */
namespace app\index\controller\v1;

use app\index\controller\BaseController;
use think\Db;
use think\Validate;

class User extends BaseController{

    /**
     *  审核下级--列表
     * @return string
     */
    public function examine_list(){
        $this->auth();  //判断用户是否登录
        $this->method();  //提交方式
        $user_data = $this->user;
        $user_list = \app\Models\User::where('gen_id',$user_data->id)->where('status',0)->select();
        if(!$user_list->isEmpty()){
            return ajax_error($user_list,'获取需审核用户成功!');
        }else{
           return ajax_error([],'暂无需审核用户!');
        }
    }

    /**
     *  审核下级--用户详情
     * @return string
     */
    public function examine_details(){
        $user_id = request()->get('user_id');//获取用户id
        $user_det = \app\Models\User::where('id',$user_id)->find();
        $user_det['rec_id'] = \app\Models\User::where('rec_id',$user_det['rec_id'])->value('name');
        $user_det['gen_id'] = \app\Models\User::where('gen_id',$user_det['gen_id'])->value('name');
        if(empty($user_det)){
            return ajax_error([],'获取用户信息失败');
        }else{
            return ajax_success($user_det,'获取用户信息成功');
        }
    }

    /**
     *  审核下级
     * @return string
     */
    public function examine(){
        $user_id = request()->get('user_id');//获取用户id
        $status = request()->get('status');//获取审核结果
        $user_status = \app\Models\User::where('id',$user_id)->update(['status'=>$status]);
        if($user_status){
            return ajax_success($user_status,'操作成功!');
        }else{
            return ajax_error([],'操作失败');
        }
    }

//    /**
//     *  个人业绩
//     * @return string
//     */
//    public function achievement(){
//        $this->auth();  //判断用户是否登录
//        $this->method();  //提交方式
//        $user_data = $this->user;
//        $user_id = request()->get('user_id');
//        if(empty($user_id)){
//            $user_id = $user_data->id;
//        }
//
//    }

}