<?php
namespace app\admin\controller;

use think\Controller;
use think\facade\Request;
use think\Db;
use app\model\Farm as FarmModel;
use app\model\User;
use app\model\Service;

class Farm  extends Check{
  public function __construct(){
        parent::__construct();
    }
// 农场列表
    public function index(){   
   		$res = FarmModel::paginate(10);
      foreach($res as $k=>$val){
         if($val['type'] == 0){ $res[$k]['type'] = '已上线'; }
         if($val['type'] == 1){ $res[$k]['type'] = '已租出'; }
         if($val['type'] == 2){ $res[$k]['type'] = '租赁到期下线'; }
         if($val['type'] == 3){ $res[$k]['type'] = '用户手动下线'; }
      }
   		$this->assign('data',$res);
        return $this->fetch();       
    }

// 农场详情
   public function farm_details(){
	   	$id = input('get.id');
	   	$res = FarmModel::where('id',$id)->find();
       if($res['lease_type']==1){
          $res['lease_type'] = '一年';
       }
       if($res['lease_type']==2){
          $res['lease_type'] = '半年';
       }
       if($res['lease_type']==3){
          $res['lease_type'] = '一季';
       }
       if($res['lease_type']==4){
          $res['lease_type'] = '一月';
       }
      $res['service'] = Service::whereIn('id',$res['service'])->column('name');      
      $user = new User();
	   	$this->assign('data',$res);
      $this->assign('service',$res['service']);
      $this->assign('user',$user);
	   	return $this->fetch();
   }


}
