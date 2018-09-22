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

class AuditOrder extends BaseController{

	/*
	客户订单
	*/
	public function user_order(){
		$this->auth();
		$id = $this->user->id;
		$user_order = Order::where('user_id',$id)->where('type',0)->select();
		if(empty($user_order)){
			return ajax_error($user_order,'没有订单');
		}else{
			return ajax_success($user_order,'获取订单成功');
		}
		
	}



	/*
	审核客户订单
	*/
	public function audit_order(){
		$this->auth();
		$id =$this->user->id;
		$order_no = request()->post('order_no');
		$user = User::where('id',$id)->find();
		if($user['grade'] == 1){
			// 一级审核
			$res = new Order;
			$res->save([
				'status' => 1 
			],['order_no'=>$order_no]);
			return ajax_success($res,'一级审核通过');
		}else{
			// 总代审核
			$res = new Order;
			$res->save([
				'status' => 2 
			],['order_no'=>$order_no]);

			if($res){
				return ajax_success($res,'总代审核通过');
			}else{
				return ajax_error(400,'总代审核失败');
			}
			
		}	

	}



	/*
	我的订单
	*/
	public function my_order(){
		$this->auth();
		$id = $this->user->id;
		$grade = $this->user->grade; 		
		$user = User::where('id',$id)->find();
		$order_status = request()->post('order_status');
		if($grade == 1){
			if($order_status){			
				if($order_status == 1){
					$res = Order::where('user_id',$id)->whereIn('status','1,2')->where('type',1)->select();
				}else{
					$res = Order::where('user_id',$id)->where('status',$order_status)->where('type',1)->select();
				}		
			}else{
				$res = Order::where('user_id',$id)->whereIn('status','1,2')->where('type',1)->select();
			}
		}else{
			if($order_status){		
				$res = Order::where('user_id',$id)->where('status',$order_status)->where('type',2)->select();						
			}else{
				$res = Order::where('user_id',$id)->where('status',2)->where('type',2)->select();
			}
		}		
		
		
		if($res){
			return ajax_success($res,'获取成功');
		}else{
			return ajax_error(400,'获取失败');
		}

	}



	/*
	下级订单
	*/
	public function lower_order(){
		$this->auth();
		$id =$this->user->id;
		$user = User::where('id',$id)->find();
		if($user['grade'] == 1){
			return ajax_error(400,'您没有下级订单,0.0');
		}else{
			$one_user = User::where('gen_id',$id)->where('grade',1)->column('id');
			$order_status = request()->post('order_status');			
			if($order_status){	
				if($order_status == 1 ){
					$under_order = Order::whereIn('user_id',$one_user)->whereIn('status','1,2')->select();
				}else{
					$under_order = Order::whereIn('user_id',$one_user)->where('status',$order_status)->select();
				}	
			}else{
				$under_order = Order::whereIn('user_id',$one_user)->whereIn('status','1,2')->select();
			}

			if($under_order){
				return ajax_success($under_order,'获取成功');
			}else{
				return ajax_error(400,'获取失败');
			}
		}
		
	}



	/*
	总代驳回订单
	*/
	public function rejected_order(){
		$this->auth();
		$id = $this->user->id;
		$order_no = request()->post('order_no');
		$user = User::where('id',$id)->find();
		if($user['grade'] == 0){
			$res = new Order;
			$res->save([
				'status' => 4 
			],['order_no'=>$order_no]);
			return ajax_success($res,'总代驳回订单');			
		}else{
			return ajax_error(400,'您没有下级订单,0.0');
		}	

	}



	/*
	订单详情
	*/
	public function order_details(){
		$this->auth();
		$order_no = request()->post('order_no');
		$order_details = Order::where('order_no',$order_no)->with(['getGoods'=>function($query){
				$query->with('getName');
		}])->find();
		if($order_details){
			return ajax_success($order_details,'获取成功');
		}else{
			return ajax_error(400,'获取失败');
		}
	}
}