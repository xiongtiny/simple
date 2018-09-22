<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/19
 * Time: 12:10
 */
namespace app\index\controller\v1;
use app\model\Feedback;
use app\model\Order;
use app\model\SendSms;
use \think\Controller;
use \think\Validate;
use think\facade\Session;

class User extends Controller{

    /**
     * 用户资料与安全
     * @return \think\response\Json
     */
    public function user_edit(){
        $user_id = Session::get('user_id');
        if(!$user_id){
            $this->error('','/api/v1/index/login1');
        }else{
            $user_data = \app\model\User::where('id',$user_id)->find();
            $this->assign('user',$user_data);
        }
        $user_data = \app\model\User::where('id',$user_id)->find();
        if(request()->isPost()){
            $data = request()->post();
            if(!empty($data['name'])){
                $data1['name']=$data['name'];
            }
            if(!empty($data['alipay'])){
                $data1['alipay']=$data['alipay'];
            }
            if(!empty($data['password'])&&!empty($data['password2'])){
                $user_state = \app\model\User::where('phone',$user_data->phone)->where('password',md5($data['password']))->find();
                if(!empty($user_state)){
                    $data1['password']=md5($data['password2']);
                }else{
                    return error(400,'旧密码输入错误');
                }
            }

            $user = \app\model\User::where('id',$user_id)->update($data1);
            if($user){
                return success(200,'修改用户数据成功',$user);
            }else{
                return error(400,'修改用户数据失败');
            }
        }
        if(!empty($user_data)){
            $this->assign('user_data',$user_data);
        }else{
            return error(400,'获取用户信息失败');
        }
        return $this->fetch();
        
    }

    /**
     * 用户修改头像
     * @return \think\response\Json
     */
    public function user_img(){
        $user_id = Session::get('user_id');
        // header('Content-type:text/html;charset=utf-8');
        $base64_image_content = $_POST['photo'];

        //将base64编码转换为图片保存
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            $new_file = "./uploads/".date('Ymd').'/';

            if (!file_exists($new_file)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $img=time().mt_rand(1000,9999).".{$type}";
            $new_file = $new_file . $img;
            $img = substr($new_file,1);
            //将图片保存到指定的位置
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                $user = \app\model\User::where('id',$user_id)->update(['img'=>$img]);
                return success(200,'修改图片成功',$user);
            }else{

                return error(400,'修改图片失败');
            }
        }else{

            return error(400,$base64_image_content['message']);
        }
    }
//


    /**
     * 用户意见反馈
     * @return \think\response\Json
     */
    public function feedback(){
        $user_id = Session::get('user_id');
        if(!$user_id){
            $this->error('','/api/v1/index/login1');
        }else{
            $user_data = \app\model\User::where('id',$user_id)->find();
            $this->assign('user',$user_data);
        }
        if(request()->isPost()){
            $data = request()->post();
            $validate=Validate::make([
                'phone'=>"require",
                'content'=>"require",
            ],
                [
                    'phone'=>'手机号',
                    'content'=>'反馈内容',
                ]);
            if(!$validate->check($data)){
                return error(400,$validate->getError());
        }
            $feedback = Feedback::create([
                'user_id'=>$user_id,
                'phone'=>$data['phone'],
                'content'=>$data['content']
            ]);
            if($feedback->id){
                return success(200,'反馈提交成功',$feedback->id);
            }else{
                return error(400,'反馈提交失败');
            }
        }
        return $this->fetch();
        
    }

    /**
     * 用户发布的农场
     * @return \think\response\Json
     */

    public function user_release(){

        $user_id = Session::get('user_id');
        if(!$user_id){
            $this->error('','/api/v1/index/login1');
        }else{
            $user_data = \app\model\User::where('id',$user_id)->find();
            $this->assign('user',$user_data);
        }
        $user_farm = \app\model\Farm::where('user_id',$user_id)->order('type')->paginate(9);
        if(!$user_farm->isEmpty()){
            foreach ($user_farm as $v){
                if($v['type']!=0&&$v['type']!=3){
                    $order = Order::where('farm_id',$v['id'])->find();
                    $create_time = explode(' ',$order->create_time)[0];
                    $end_time = explode(' ',$order->end_time)[0];
                    // dump($v);die;
                    if($v['type']==1){
                        //判断是否租赁是否到期
                        if($order->end_time < date('Y-m-d H:i:s',time()) && $v['type']!=2){
                            $v['type'] = 2;
                            $v['start_time'] = $create_time;
                            $v['downline_time'] = $end_time;
                            $farm_state = \app\model\Farm::where('id',$v['id'])->update(['type'=>2]);
                        }else{
                            $v['start_time'] = $create_time;
                            $v['downline_time'] = $end_time;
                        }
                    }
                    if($v['type']==2){
                        $v['start_time'] = $create_time;
                        $v['downline_time'] = $end_time;
                    }
                    if($v['type']==3){
                        $v['start_time'] = explode(' ',$v['create_time'])[0];
                        $v['downline_time'] = explode(' ',$v['downline_time'])[0];
                    }
                }else{
                    $v['start_time'] =$v['create_time'];
                }
            }
            // return success(200,'获取农场成功',$user_farm);
        }
        $this->assign('data',$user_farm);
        return $this->fetch();

    }

    /**
     * 用户租赁的农场
     * @return \think\response\Json
     */

    public function user_lease(){
        $user_id = Session::get('user_id');
        if(!$user_id){
            $this->error('','/api/v1/index/login1');
        }else{
            $user_data = \app\model\User::where('id',$user_id)->find();
            $this->assign('user',$user_data);
        }
        $user_farm = Order::where('user_id',$user_id)->whereIn('type',[1,3])->paginate(9);
        if(!$user_farm->isEmpty()){
            foreach ($user_farm as $v){
                $v['start_time'] = explode(' ',$v['create_time'])[0];
                $v['downline_time'] = explode(' ',$v['end_time'])[0];
                $v['getFarm'] = \app\model\Farm::withTrashed()->where('id',$v['farm_id'])->find();
                //判断租赁的到期时间 1代表租赁 3代表过期
                if($v['end_time'] < date('Y-m-d H:i:s',time()) && $v['type']!=3){
                    $v['type'] = 3;
                    $order_type = Order::where('id',$v['id'])->where('user_id',$user_id)->update(['type'=>3]);
                }
            }
            // return success(200,'获取用户租赁农场成功',$user_farm);

        }
        // dump($user_farm);die;
        $this->assign('data',$user_farm);
        return $this->fetch();

    }

    /**
     * 用户交易记录
     * @return \think\response\Json
     */

    public function transaction_record(){
        $user_id = Session::get('user_id');
        if(!$user_id){
            $this->error('','/api/v1/index/login1');
        }else{
            $user_data = \app\model\User::where('id',$user_id)->find();
            $this->assign('user',$user_data);
        }
        $user_record = \app\model\Order::withTrashed()->where('user_id',$user_id)->paginate(15);
        if(!$user_record->isEmpty()){
            foreach ($user_record as $v){
                $v['farm_name'] = \app\model\Farm::withTrashed()->where('id',$v['farm_id'])->value('name');
                if($v['type']==1){
                    $v['type'] = '租赁农场';
                }else{
                    $v['type'] = '租出农场';
                }
            }
            $this->assign('data',$user_record);
            // return success(200,'获取交易记录成功',$user_record);
        }else{
            $this->assign('data',$user_record);
            // return error(400,'暂未交易记录');
        };

        return $this->fetch();

    }

    /**
     * @return \think\response\Json
     * 农场主手动下线农场(未租出状态)
     */
    public function downline(){
        $user_id = Session::get('user_id');
        $farm_id = request()->post('farm_id');
        $date = date('Y-m-d H:i:s',time());
        $farm = \app\model\Farm::where('user_id',$user_id)->where('id',$farm_id)->update(['type'=>3,'downline_time'=>$date]);
        if($farm){
            return success(200,'下线成功',$farm);
        }else{
            return error(400,'下线失败');
        }
    }

    /**
     * 农场主删除农场(未租出和租赁到期状态)
     * @return \think\response\Json
     */
    public function del_farm(){
        $user_id = Session::get('user_id');
        $farm_id = request()->post('farm_id');
        $farm = \app\model\Farm::where('user_id',$user_id)->where('id',$farm_id)->find();
        $state = $farm->delete();
        $this->assign('data',$farm);
        if($state){
            return success(200,'删除成功',$state);
        }else{
            return error(400,'删除失败');
        }
    }

    /**
     * 删除租赁到期农场
     * @return \think\response\Json
     */
    public function del_expire(){
        $user_id = Session::get('user_id');
        // dump($user_id);die;
        $order_id = request()->post('order_id');
        $order = Order::where('user_id',$user_id)->where('id',$order_id)->find();
        $state = $order->delete();
        if($state){
            return success(200,'删除成功',$state);
        }else{
            return error(400,'删除失败');
        }
    }



}