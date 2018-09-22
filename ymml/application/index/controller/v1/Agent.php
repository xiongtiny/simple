<?php
namespace app\index\controller\v1;

use app\index\controller\BaseController;
use app\Models\User;
use app\Models\SendSms;
use app\facade\Jwt;
use think\Validate;
use Db;

class Agent extends BaseController{



	/*
	我的代理（一级+直属+搜索）
	*/
	public function myagent(){		
	    $this->auth();
	    $this->method('post');
	    $user_id = $this->user->id;
	    $nameorphone = request()->post('nameorphone');
	    $where = ['name|phone','like','%'.$nameorphone.'%'];
	    $user = User::where('id',$user_id)->find();
	    if($user['grade'] == 0){
	    	if(!$nameorphone){
	        	$res = User::whereOr('rec_id',$user_id)->whereOr('gen_id',$user_id)->select();
	        	foreach ($res as $key => $value) {
	        		if($value['rec_id'] == $value['gen_id']){
	        			$value['type'] = 1;
	        		}else{
	        			$value['type'] = 2;
	        		}
	        	}
	     	}else{
	     		$res = User::where([$where])->select();	    	
	     	}	    
	    }else{
	    	if(!$nameorphone){
	       		$res = User::where('rec_id',$user_id)->select();
	     	}else{
	     		$res = User::where([$where])->select();	    	
	     	}	    
	    }	    
	   
	   if($res){
			return ajax_success($res,'获取成功');
		}else{
			return ajax_error(400,'获取失败');
		}
	}



	/*
	我的代理的个人信息+下级人数
	*/
	public function myagent_info(){
		$this->auth();
		$this->method();
		$id = request()->get('id');
		$res = User::where('id',$id)->with('getPro')->with('getCity')->with('getArea')->find();
		if($res['grade'] == 1){
			$res['grade'] = '一级代理';
		}
		if($res['grade'] == 0){
			$res['grade'] = '总代';
		}
		$count = User::where('rec_id',$id)->count();
		$res['num'] = $count;

		if($res){
			return ajax_success($res,'获取成功');
		}else{
			return ajax_error(400,'获取失败');
		}

	}



	/*
	我一级代理的下级代理
	*/
	public function lower_agent(){
		$this->auth();
		$this->method();
		$id = request()->get('id');
		$res = User::where('rec_id',$id)->select();

		if($res){
			return ajax_success($res,'获取成功');
		}else{
			return ajax_error(400,'获取失败');
		}
	}

}