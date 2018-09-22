<?php
namespace app\index\controller\v1;

use app\index\controller\BaseController;
use app\Models\Order;
use app\Models\User;
use app\facade\Jwt;
use think\Validate;
use Db;

class Index extends BaseController {
    /*
    首页展示
    */
    public function index(){
        $this->auth(false);
        $user_data = $this->user;
        $grade = $this->user->grade;
        $name = $this->user->name;
        if($user_data){
            $user_id = $this->user->id;
            $order = Order::where('user_id',$user_id)->where('status',3)->field('count(user_id) as order_num,SUM(price) as order_price,SUM(sum) as goods_num')->find();
            $user_order = Order::where('user_id',$user_id)->where('status',0)->where('type',0)->count();
            $order['user_order'] = $user_order;
            if(empty($order['order_price'])){ $order['order_price']= 0;}
            if(empty($order['goods_num'])){ $order['goods_num']= 0;}
            // 总代
            if($grade == 0){
                // 我的订单未审核小红点
                $order_red1 = Order::where('user_id',$user_id)->where('type',2)->where('status',2)->where('order_red',1)->select();
                // 我的订单已审核小红点
                $order_red2 = Order::where('user_id',$user_id)->where('type',2)->where('status',3)->where('order_red',2)->select();
                // 我的订单已驳回小红点
                $order_red3 = Order::where('user_id',$user_id)->where('type',2)->where('status',4)->where('order_red',3)->select();               
                // 我的下级
                $one_user = User::where('gen_id',$user_id)->where('grade',1)->column('id');
                // 我的下级订单未审核小红点
                $order_red4 = Order::whereIn('user_id',$one_user)->whereIn('type','0,1')->where('status',1)->where('order_red',4)->select();
                // 我的下级订单已审核小红点
                $order_red5 = Order::whereIn('user_id',$one_user)->where('type',1)->where('status',3)->where('order_red',4)->select();
                // 我的下级订单已驳回小红点
                $order_red6 = Order::whereIn('user_id',$one_user)->where('type',1)->where('status',4)->where('order_red',4)->select();
                $order['order_red4'] = $order_red4;
                $order['order_red5'] = $order_red5;
                $order['order_red6'] = $order_red6; 
            }else{
                // 我的订单未审核小红点
                $order_red1 = Order::where('user_id',$user_id)->where('type',1)->where('status',2)->where('order_red',0)->select();
                // 我的订单已审核小红点
                $order_red2 = Order::where('user_id',$user_id)->where('type',1)->where('status',3)->where('order_red',2)->select();
                // 我的订单已驳回小红点
                $order_red3 = Order::where('user_id',$user_id)->where('type',1)->where('status',4)->where('order_red',3)->select();
                 $order['order_red4'] = '';
                $order['order_red5'] = '';
                $order['order_red6'] = ''; 
                
            }
                $order['order_red1'] = $order_red1;
                $order['order_red2'] = $order_red2;
                $order['order_red3'] = $order_red3;
                $order['name'] = $name;
                
            if($order){
                return ajax_success($order,'获取成功');
            }else{
                return ajax_error(400,'获取失败');
            }
        }else{
            return ajax_error(400,'请先登录');
        }
   }

}