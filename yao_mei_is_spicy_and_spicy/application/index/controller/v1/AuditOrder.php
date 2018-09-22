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
        $grade = $this->user->grade;
		if($grade == 0){
            $order = Order::where('user_id',$id)->where('type',0)->order('status desc')->with('getGoods')->select();
            foreach($order as $k => $v){
                $order[$k]['goods_num'] = count($v['getGoods']);
                if($v['status'] == 3){$v['status'] = 3;}
                elseif ($v['status'] == 4) {$v['status'] = 4;}
                elseif ($v['status'] == 2) {$v['status']=1;}
                else{$v['status']=2;}

            }
        }else {
            $order = Order::where('user_id', $id)->where('type', 0)->order('create_time desc')->with('getGoods')->select();
            foreach ($order as $k => $v) {
                $order[$k]['goods_num'] = count($v['getGoods']);
                if ($v['status'] == 3) {
                    $v['status'] = 3;
                } elseif ($v['status'] == 4) {
                    $v['status'] = 4;
                } elseif ($v['status'] == 1) {
                    $v['status'] = 1;
                } else {
                    $v['status'] = 2;
                }
            }
        }

		if(empty($order)){
			return ajax_error($order,'没有订单');
		}else{
			return ajax_success($order,'获取订单成功');
		}
		
	}



    /*
    推荐代理订单
    */
    public function gen_order(){
        $this->auth();
        $id = $this->user->id;
//        $grade = $this->user->grade;
//        if($grade == 0){
            $one_user = User::where('rec_id',$id)->where('grade',1)->column('id');
            $order = Order::whereIn('user_id',$one_user)->order('create_time desc')->whereNotIn('status',0)->with('getGoods')->select();
            foreach($order as $k => $v){
                $order[$k]['goods_num'] = count($v['getGoods']);
                if($v['status'] == 3){$v['status'] = '已审核';}
                elseif ($v['status'] == 4) {$v['status'] = '已驳回';}
//                elseif ($v['status'] == 2) {$v['status']=1;}
                else{$v['status']= '待审核';}

            }
//        }else {
//            $one_user = User::where('gen_id',$id)->where('grade',1)->column('id');
//            $order = Order::whereIn('user_id', $one_user)->where('type', 1)->with('getGoods')->select();
//            foreach ($order as $k => $v) {
//                $order[$k]['goods_num'] = count($v['getGoods']);
//                if ($v['status'] == 3) {
//                    $v['status'] = 3;
//                } elseif ($v['status'] == 4) {
//                    $v['status'] = 4;
//                } elseif ($v['status'] == 1) {
//                    $v['status'] = 1;
//                } else {
//                    $v['status'] = 2;
//                }
//            }
//        }

        if(empty($order)){
            return ajax_error($order,'没有订单');
        }else{
            return ajax_success($order,'获取订单成功');
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
				'status' => 1,
				'order_red' => 4 
			],['order_no'=>$order_no]);
			return ajax_success($res,'一级审核通过');
		}else{
			// 总代审核
			$res = new Order;
			$res->save([
				'status' => 2,
				'order_red' => 1
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
		$status = request()->post('status');
		if($grade == 1){
            $id = $this->user->id;
			// 一级代理
            if ($status == 1) {
                $status = 3;
                $res = Order::where('user_id', $id)->where('type', 1)->order('status asc, create_time desc')->where('status', $status)->with('getGoods')->select();
                foreach ($res as $v){
                    $v['goods_num'] = count($v['getGoods']);
                }
                $all_order = Order::where('user_id',$id)->where('status',3)->update(['order_red' => 4]);
            } elseif ($status == 2) {
                $status = 4;
                $res = Order::where('user_id', $id)->where('type', 1)->order('create_time desc')->where('status', $status)->with('getGoods')->select();
               
                foreach ($res as $v){
                    $v['goods_num'] = count($v['getGoods']);
                }

                $all_order = Order::where('user_id',$id)->where('status',4)->update(['order_red' => 4]);

            } else {
                $res = Order::where('user_id', $id)->where('type', 1)->order('create_time desc')->whereIn('status', '1,2')->with('getGoods')->select();
                foreach ($res as $v){
                    $v['goods_num'] = count($v['getGoods']);
                }
                $all_order = Order::where('user_id',$id)->whereIn('status','1,2')->update(['order_red' => 4]);
            }
		}else{
			// 总代			
            $id = $this->user->id;
            if ($status == 1) {
                $status = 3;
                $res = Order::where('user_id', $id)->where('type', 2)->order('create_time desc')->where('status', $status)->with('getGoods')->select();
                foreach ($res as $v){
                    $v['goods_num'] = count($v['getGoods']);
                }

               $all_order = Order::where('user_id',$id)->where('status',3)->update(['order_red' => 5]);

            } elseif ($status == 2) {
                $status = 4;
                $res = Order::where('user_id', $id)->where('type', 2)->order('create_time desc')->where('status', $status)->with('getGoods')->select();
                foreach ($res as $v){
                    $v['goods_num'] = count($v['getGoods']);
                }
                $all_order = Order::where('user_id',$id)->where('status',4)->update(['order_red' => 5]);
            } else {
                $res = Order::where('user_id', $id)->where('type', 2)->order('create_time desc')->whereIn('status', '1,2')->with('getGoods')->select();
                foreach ($res as $v){
                    $v['goods_num'] = count($v['getGoods']);
                }
                $all_order = Order::where('user_id',$id)->where('status',2)->update(['order_red' => 5]);
            }

        }
		
		if($res){
			return ajax_success($res,'获取成功');
		}else{
			return ajax_error([],'获取失败');
		}

	}



	/*
	下级订单
	*/
	public function lower_order(){
		$this->auth();
		$id =$this->user->id;
		$user = User::where('id',$id)->find();
        $status = request()->post('status');
		if($user['grade'] == 1){
			return ajax_error([

            ],'您没有下级订单');
		}else{
			$one_user = User::where('gen_id',$id)->where('grade',1)->column('id');
            if ($status == 1) {
                $status = 3;
                $under_order = Order::whereIn('user_id',$one_user)->order('create_time desc')->where('status', $status)->with('getGoods')->select();
                foreach ($under_order as $v){
                    $v['goods_num'] = count($v['getGoods']);
                }
                $res1 = User::where('gen_id',$id)->column('id');
                $all_order = Order::whereIn('user_id',$res1)->where('status',3)->update(['order_red' => 5]);
            } elseif ($status == 2) {
                $status = 4;
                $under_order = Order::whereIn('user_id',$one_user)->order('create_time desc')->where('status', $status)->with('getGoods')->select();
                foreach ($under_order as $v){
                    $v['goods_num'] = count($v['getGoods']);
                }
                $res1 = User::where('gen_id',$id)->column('id');
                $all_order = Order::whereIn('user_id',$res1)->where('status',4)->update(['order_red' => 5]);
            } else {
                $under_order = Order::whereIn('user_id',$one_user)->order('status asc, create_time desc')->whereIn('status', '1,2')->with('getGoods')->select();
                foreach ($under_order as $v){
                    $v['goods_num'] = count($v['getGoods']);
                }
            }


//            $under_order['aaa'] = $under_order;
		}

        if($under_order){
            return ajax_success($under_order,'获取成功');
        }else{
            return ajax_error([],'获取失败');
        }
		
	}



	/*
	驳回订单
	*/
	public function rejected_order(){
		$this->auth();
		$id = $this->user->id;
		$order_no = request()->post('order_no');
		$user = User::where('id',$id)->find();		
		$res = new Order;
		$res->save([
			'status' => 4,
			'order_red' => 3
		],['order_no'=>$order_no]);
		if($res){
			return ajax_success($res,'驳回订单成功');	
		}else{
			return ajax_error(400,'驳回订单失败');
		}
				
		

	}



	/*
	订单详情
	*/
	public function order_details(){
		$this->auth();
		$order_no = request()->post('order_no');
		$order_details = Order::where('order_no',$order_no)->with('getPro')->with('getCity')->with('getArea')->with(['getGoods'=>function($query){
				$query->with('getName');
		}])->find();

		$order_details['province'] = $order_details['get_pro']['name'];
		$order_details['city'] = $order_details['get_city']['name'];
		$order_details['area'] = $order_details['get_area']['name'];
		foreach($order_details['get_goods'] as $k => $v){
			$v['goods_name'] = $v['get_name']['name'];
			$v['img'] = $v['get_name']['img'];			
		}
		if($order_details['log_type'] == 1){$order_details['log_type'] = '普通快递';}
		if($order_details['log_type'] == 2){$order_details['log_type'] = '顺丰空运';}
		if($order_details['log_type'] == 3){$order_details['log_type'] = '顺丰陆运';}
		if($order_details){
			return ajax_success($order_details,'获取成功');
		}else{
			return ajax_error(400,'获取失败');
		}
	}
}