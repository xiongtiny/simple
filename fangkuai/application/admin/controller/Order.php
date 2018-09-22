<?php
namespace app\admin\controller;

use think\Controller;
use think\facade\Request;
use think\Db;
use app\model\Order as OrderModel;
use app\model\User;
use app\model\Farm;

class Order  extends Check{
  public function __construct(){
        parent::__construct();
    }
// 订单列表
    public function index(){
      $query = new \think\db\Query;
      $order_number = input('post.order_number');       
      $where = ['order_number','like','%'.$order_number.'%'];
      $res = OrderModel::where([$where])->where(function ($query){$query->where('id', ['<', 3], ['>', 0], 'or');})->paginate(10);
   		foreach ($res as $key => $value) {
   			if($value['type'] == 1){ $res[$key]['type'] = '租聘'; }
   			if($value['type'] == 2){ $res[$key]['type'] = '租出'; }
   		}   	
   		$farm = new Farm();
   		$user = new User();   		
   		$this->assign('data',$res);
      $this->assign('user',$user);
      $this->assign('farm',$farm);
      return $this->fetch();       
    }


}
