<?php
namespace app\index\controller\v1;

use app\index\controller\BaseController;
use app\Models\User;
use app\Models\Order;
use app\Models\Goods;
use app\Models\OrderGoods;
use app\facade\Jwt;
use think\Validate;
use Db;

class Achievement extends BaseController{

	/*
	个人业绩
	*/
	public function personal($id=''){
		$this->auth();
		if(empty($id)){
			$id = $this->user->id;
		}	
		$first_time = request()->post('first_time');		
		$second_time = request()->post('second_time');
		if($first_time && $second_time){
			// 时间段查询
			$first_time = strtotime($first_time);
			$first_time = date('Y-m-d H:i:s',$first_time);
			$second_time = strtotime('+1months',strtotime($second_time))-1;
			$second_time = date('Y-m-d H:i:s',$second_time);
			// 进货价
			$goods_price = Order::where('user_id',$id)->where('status',3)->whereTime('update_time','between',[$first_time,$second_time])->sum('goods_price');
			// 业绩金额
			$sum = Order::where('user_id',$id)->where('status',3)->whereTime('update_time','between',[$first_time,$second_time])->sum('price');
			// 商品数量		
			$num = Order::where('user_id',$id)->where('status',3)->whereTime('update_time','between',[$first_time,$second_time])->sum('sum');
			$order['price_sum'] = $sum;			
			$order['goods_num'] = $num;
			$order['price_goods'] = $goods_price;
			// 某时间段个人返利
			$under_user = User::where('rec_id',$id)->column('id');
			$rec_rebate = Order::whereIn('user_id',$under_user)->whereTime('update_time','between',[$first_time,$second_time])->sum('rec_rebate');
			$order['first_money'] = $rec_rebate;
		}else{
			// 进货价
			$goods_price = Order::where('user_id',$id)->where('status',3)->sum('goods_price');
			// 业绩金额
			$price = Order::where('user_id',$id)->where('status',3)->sum('price');
			// 商品数量				
			$num = Order::where('user_id',$id)->where('status',3)->sum('sum');				
			// 个人返利						
			$under_user = User::where('rec_id',$id)->column('id');
			$rec_rebate = Order::whereIn('user_id',$under_user)->sum('rec_rebate');
			$order['first_money'] = $rec_rebate;
			$order['price_sum'] = $price;			
			$order['goods_num'] = $num;
			$order['price_goods'] = $goods_price;
		}		
				
		if($order){
			return ajax_success($order,'获取个人业绩成功');
		}else{
			return ajax_error(400,'获取失败');
		}
		
	}



	/*
	个人销售明细
	*/
	public function sales_details($id='',$start_time='',$end_time='')
    {
        $this->auth();
        if (empty($id)) {
            $id = $this->user->id;
        }
        $grade = $this->user->grade;
        $goods_num = Order::where('user_id', $id)->where('status', 3)->sum('sum');
        $order_no = Order::where('user_id', $id)->where('status', 3)->column('order_no');
        $goods = OrderGoods::whereIn('order_no', $order_no)->field('goods_id,sum(sum) as sum,sum(price) as price')->group('goods_id')->select();
        foreach ($goods as $key => $value) {
            $goods[$key]['name'] = Goods::get($value['goods_id'])->name;
            $arrWhere = '';
            if (!empty($start_time) && !empty($end_time)) {
                $arrWhere[] = ['update_time', 'between time', [$start_time, $end_time]];
            }
            $grade = $this->user->grade;
            $goods_num = Order::where('user_id', $id)->where('status', 3)->where($arrWhere)->sum('sum');
            $order_no = Order::where('user_id', $id)->where('status', 3)->where($arrWhere)->column('order_no');
            $goods = OrderGoods::whereIn('order_no', $order_no)->field('goods_id,sum(sum) as sum,sum(price) as price')->group('goods_id')->select();
            foreach ($goods as $key => $value) {
                $goods[$key]['name'] = Goods::get($value['goods_id'])->name;
            }
            $goods['goods_num'] = $goods_num;


            if ($goods) {
                return ajax_success($goods, '获取成功');
            } else {
                return ajax_error(400, '获取失败');
            }

        }
    }
	
}