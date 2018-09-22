<?php
namespace app\admin\controller;

use think\Controller;
use think\facade\Request;
use think\Db;
use app\model\User;
use app\model\Order;
use app\model\Farm;
use think\facade\Session;

class Index extends Check{

    public function __construct(){
        parent::__construct();
    }
   
// 首页
    public function index(){ 
        return $this->fetch();
       
    }
// 用户列表
    public function users(){   
   		
      $name  = input('post.name'); 
      // if($name){ 
      $where = ['name','like','%'.$name.'%'];      
      $res    = User::where([$where])->paginate(10);      
    // }else{
    //   $res = User::paginate(10);      
    // }
      $this->assign('data',$res);
      return $this->fetch();       
    }
// 用户删除
    public function user_del(){
	    $id = input('get.id');
	    $res = User::where(array('id'=>$id))->delete();
	    if($res){
	    	$this->success('删除成功','/ami/index/users','',1);
	      }    

    }
// 用户详情
   public function user_details(){
	   	$id = input('get.id');
	   	$res = User::where('id',$id)->find();
	   	$this->assign('data',$res);
	   	return $this->fetch();
   }
// 用户交易记录
   public function records(){
    $id = input('get.id');
    $res = Order::where('user_id',$id)->paginate(10);
    foreach ($res as $key => $value) {
      if($value['type'] == 0){$res[$key]['type'] = '未支付' ;}
      if($value['type'] == 1){$res[$key]['type'] = '租赁' ;}
      if($value['type'] == 2){$res[$key]['type'] = '租出' ;}
      if($value['type'] == 3){$res[$key]['type'] = '已过期' ;}
    }
    $farm = new Farm();
    $this->assign('farm',$farm);
    $this->assign('data',$res);
    return $this->fetch();

   }


}
