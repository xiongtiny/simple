<?php
namespace app\admin\controller;
use think\Controller;
use think\facade\Request;
use think\Db;
use app\model\Feedback;
use app\model\User;

class Feed  extends Check{
  public function __construct(){
        parent::__construct();
    }
// 反馈列表
    public function index(){   
   		$res = Feedback::paginate(10);
   		foreach ($res as $key => $value) {
   			$value['content'] = mb_substr($res[$key]['content'],0,5,'utf-8');
   		}

   		$this->assign('data',$res);
        return $this->fetch();       
    }
// 反馈删除
    public function feed_del(){
	    $id = input('get.id');
	    $res = Feedback::where(array('id'=>$id))->delete();
	    if($res){
	    	$this->success('删除成功','/ami/feed/index','',1);
	      }    

    }
// 反馈详情
   public function feed_details(){
	   	$id = input('get.id');
	   	$res = Feedback::where('id',$id)->find();
	   	$user = new User();
   		$this->assign('user',$user);
	   	$this->assign('data',$res);
	   	return $this->fetch();
   }


}
