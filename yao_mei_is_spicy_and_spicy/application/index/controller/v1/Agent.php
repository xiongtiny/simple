<?php
namespace app\index\controller\v1;

use app\index\controller\BaseController;
use app\Models\User;
use app\Models\Province;
use app\Models\City;
use app\Models\Area;
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
	    $user_id = request()->post('id');
	    if($user_id){
	    	$user_id = request()->post('id');
	    }else{
	    	$user_id = $this->user->id;
	    }	
	    $nameorphone = request()->post('nameorphone');
	    $where = ['name|phone','like','%'.$nameorphone.'%'];
	    $user = User::where('id',$user_id)->find();
	    if($user['grade'] == 0){
	    	if(!$nameorphone){
	        	$res = User::whereOr('rec_id',$user_id)->whereOr('gen_id',$user_id)->where('grade',1)->whereNotIn('id',$user_id)->where('status',1)->select();
	        	foreach ($res as $key => $value) {
	        		if($value['rec_id'] == $value['gen_id'] && !empty($value['rec_id'])){
	        			$value['type'] = 2;
	        		}else{
	        			$value['type'] = 1;
	        		}
	        	}
	     	}else{
	     		$res = User::where([$where])->where('gen_id',$user_id)->whereNotIn('id',$user_id)->where('grade',1)->where('status',1)->select();	
	     			foreach ($res as $key => $value) {
	        		if($value['rec_id'] == $value['gen_id'] && !empty($value['rec_id'])){
	        			$value['type'] = 2;
	        		}else{
	        			$value['type'] = 1;
	        		}
	        	}
	     	}	    
	    }else{
	    	if(empty($nameorphone)){
	       		$res = User::where('rec_id',$user_id)->whereNotIn('id',$user_id)->where('grade',1)->where('status',1)->select();
	       		foreach ($res as $key => $value) {
	        		
	        			$value['type'] = 1;
	        		
	        	}
	     	}else{
	     		$res = User::where([$where])->where('rec_id',$user_id)->whereNotIn('id',$user_id)->where('grade',1)->where('status',1)->select();	
	     		foreach ($res as $key => $value) {
	        		
	        			$value['type'] = 1;
	        		
	        	}  
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
		$id = request()->get('id');
		$res = User::where('id',$id)->find();
		if($res['province_code']){
			$res['province_code'] = Province::where('code',$res['province_code'])->value('name');
		}
		if($res['city_code']){
			$res['city_code'] = City::where('code',$res['city_code'])->value('name');
		}
		if($res['area_code']){
			$res['area_code'] = Area::where('code',$res['area_code'])->value('name');
		}
		if($res['grade'] == 1){
			$res['grade'] = '一级代理';
		}else{
            $res['grade'] = '总代';
        }
		$count = User::where('rec_id',$id)->where('grade',1)->where('status',1)->count();
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
		$res = User::where('rec_id',$id)->where('status',1)->where('grade',1)->select();

		if($res){
			return ajax_success($res,'获取成功');
		}else{
			return ajax_error(400,'获取失败');
		}
	}

}