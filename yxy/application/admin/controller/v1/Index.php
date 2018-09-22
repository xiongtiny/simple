<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/4/9
 * Time: 下午5:03
 */

namespace app\admin\controller\v1;
use app\model\User;//操作意向用户表
use app\model\Order;//操作意向用户表
use Request;
use Db;
use think\Controller;
use think\helper\Time;
class Index extends BaseController
{

    /**
     * 
     */
    public function index()
    {
        $this->auth();
        $user      = new User;
        //当日新增的意向学员
        $now_day = date('Y-m-d');
        $today = $user->where(['type'=>1])->field('create_time')->select();
        $i = 0;
        foreach ($today as $key => $value) {
            $time = strtotime($value['create_time']);
            $today[$key]['time'] = date('Y-m-d', $time);
            if($today[$key]['time'] == $now_day){
                $i++;
            }
        }
        $this->assign('i',$i);
        //在校学员
        $new_add = $user->where('type','<>',1)->field('create_time')->select();
        $j = 0;
        foreach ($new_add as $key => $value) {
            $time = strtotime($value['create_time']);
            $new_add[$key]['time'] = date('Y-m-d', $time);
            if($new_add[$key]['time'] == $now_day){
                $j++;
            }
        }
        $all = $user->where('type','<>',1)->count();
        $this->assign('j',$j);
        $this->assign('all',$all);
        //订单
        $order      = new Order;
        //当日新增订单数
        $now_order_num = $order->where(['status'=>1])->field('pay_time,price')->select();
        $k = 0;
        $count_price = 0;
        foreach ($now_order_num as $key => $value) {
            $time = strtotime($value['pay_time']);
            $now_order_num[$key]['time'] = date('Y-m-d', $time);
            if($now_order_num[$key]['time'] == $now_day){
                $k++;
            }
        }
        //当日新增订单金额
        $aa = Time::today();
        $count_price = $order
            ->where(['status'=>1])
            ->where('pay_time','>=',date('Y-m-d H:i:s',$aa[0]))
            ->where('pay_time','<=',date('Y-m-d H:i:s',$aa[1]))
            ->sum('price');
        //退费
        $count_price_refund = $order->where(['status'=>3])->sum('price');    
        $this->assign('k',$k);
        $this->assign('count_price',$count_price);
        $this->assign('count_price_refund',$count_price_refund);
        return view();
    }


}

