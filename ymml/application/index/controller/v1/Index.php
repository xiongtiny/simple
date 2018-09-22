<?php
namespace app\index\controller\v1;

use app\index\controller\BaseController;
use app\Models\Order;
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
        if($user_data){
            $user_id = $this->user->id;
            $order = Order::where('user_id',$user_id)->where('status',3)->field('count(user_id) as order_num,SUM(price) as order_price,SUM(sum) as goods_num')->find();
            $user_order = Order::where('user_id',$user_id)->where('status',3)->where('type',0)->count();
            $order['user_order'] = $user_order;
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