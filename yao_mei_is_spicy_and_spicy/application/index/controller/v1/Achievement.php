<?php
namespace app\index\controller\v1;

use app\index\controller\BaseController;
use app\Models\User;
use app\Models\Order;
use app\Models\Goods;
use app\Models\OrderGoods;
use app\Models\Special;
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
        	if(request()->post('id')){
        		$id = request()->post('id');
        	}else{
        		$id = $this->user->id;
        	}
	    }				
		$name = User::where('id',$id)->value('name');				
		$second_time = request()->post('second_time');
		// dump($second_time);die;
		if($second_time){
			// 时间段查询
			$first_time = strtotime($second_time);
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
			$under_user = User::where('rec_id',$id)->where('grade', 1)->column('id');
			$rec_rebate = Order::whereIn('user_id',$under_user)->where('status',3)->whereTime('update_time','between',[$first_time,$second_time])->sum('rec_rebate');
			$order['first_money'] = $rec_rebate;
		}else{
			$time = date('Y-m');
            $start_time = date("Y-m-d H:i:s",strtotime($time));
            $end_time = date("Y-m-d H:i:s",strtotime("+1month",strtotime($time))-1);
            $arrWhere[] = ['update_time', 'between time', [$start_time, $end_time]];
			// 进货价
			$goods_price = Order::where('user_id',$id)->where('status',3)->where($arrWhere)->sum('goods_price');
			// 业绩金额
			$price = Order::where('user_id',$id)->where('status',3)->where($arrWhere)->sum('price');
			// 商品数量				
			$num = Order::where('user_id',$id)->where('status',3)->where($arrWhere)->sum('sum');				
			// 个人返利						
			$under_user = User::where('rec_id',$id)->where('grade', 1)->column('id');
			$rec_rebate = Order::whereIn('user_id',$under_user)->where('status',3)->where($arrWhere)->sum('rec_rebate');
			$order['first_money'] = $rec_rebate;
			$order['price_sum'] = $price;			
			$order['goods_num'] = $num;
			$order['price_goods'] = $goods_price;
			$order['name'] = $name;
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
	public function sales_details($id='',$start_time='')
    {
        $this->auth();
        if(empty($id)){
        	if(request()->post('id')){
        		$id = request()->post('id');
        	}else{
        		$id = $this->user->id;
        	}
	    }
        $grade = $this->user->grade;
        $time = date('Y-m');
        $start_time = date("Y-m-d H:i:s",strtotime($time));
        $end_time = date("Y-m-d H:i:s",strtotime("+1month",strtotime($time))-1);
        $arrWhere[] = ['update_time', 'between time', [$start_time, $end_time]];
         $order_no = Order::where('user_id', $id)->where('status', 3)->where($arrWhere)->column('order_no');
        $order_no1 = Order::where('user_id', $id)->where('status', 3)->where($arrWhere)->where('sum','>=',50)->column('order_no');
        $order_no2 = Order::where('user_id', $id)->where('status', 3)->where($arrWhere)->where('sum','<',50)->column('order_no');
        $goods = OrderGoods::whereIn('order_no', $order_no)->field('order_no,sum(price) as price,sum(sum) as sum')->group('order_no')->select();
        $goodss['goods_num1'] = 0;
        $goodss['goods_num2'] = 0;
        foreach ($goods as $key => $value) {           
            $arrWhere = '';
            if (!empty($start_time) && !empty($end_time)) {
                $arrWhere[] = ['update_time', 'between time', [$start_time, $end_time]];
            } 
            if($goods[$key]['sum'] >= 50){
            	// 混批包数
            	$goodss['goods_num1'] += $value['sum'];            	
            }else{
            	// 批发包数
            	$goodss['goods_num2'] += $value['sum'];  
            }  
        }
        // 混批
        $god = OrderGoods::whereIn('order_no',$order_no1)->field('goods_id,sum(sum) as sum,sum(price) as price')->group('goods_id')->select();
        foreach($god as $value1){
            $value1['name'] = Goods::get($value1['goods_id'])->name;
            $value1['img'] = Goods::get($value1['goods_id'])->img;
        }
        // 普通批发
        $good = OrderGoods::whereIn('order_no',$order_no2)->field('goods_id,sum(sum) as sum,sum(price) as price')->group('goods_id')->select();
        foreach($good as $value2){
            $value2['name'] = Goods::get($value2['goods_id'])->name;
            $value2['img'] = Goods::get($value2['goods_id'])->img;
        } 

        if(!empty($god)){
        	$goodss['god'] = $god;        	      	
        }else{
        	$goodss['god'] = 0;
    	}
        if(!empty($good)){
            $goodss['good'] = $good;                    
        }else{
            $goodss['good'] = 0;
        }
        
        if($goodss){
            return ajax_success($goodss, '获取成功');
        }else{
            return ajax_error(400, '获取失败');
        }

    }
	
}