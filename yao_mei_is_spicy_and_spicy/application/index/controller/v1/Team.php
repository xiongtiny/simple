<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/6/7
 * Time: 10:11
 */
namespace app\index\controller\v1;

use app\index\controller\BaseController;

use app\Models\Area;
use app\Models\City;
use app\Models\OrderGods;
use app\Models\Order;
use app\Models\User;
use app\Models\Province;
use app\Models\Special;
use think\Validate;
use think\Db;

class Team extends BaseController{

    /**
     *  团队业绩
     * @return string
     */
     public function team_per(){
     	$this->auth();
     	$this->method();  //提交方式
    	$user_id = $this->user->id;//获取当前登录用的id
        $ids = $this->lower_level(true,$user_id);
        $start_time = request()->get('start_time');
        $arrWhere = $this->time($start_time);
        $ids2 = $this->lower_level(false,$user_id);
        $user_ids = User::whereIn('rec_id',$ids2)->where('grade', 1)->column('id');
        $data = Order::where('status',3)->whereIn('user_id',$ids)->where($arrWhere)->field(['SUM(price) as price,SUM(goods_price) as goods_price,SUM(sum) as sum'])->find();
        $data['rebate_total_price'] = 0;
        $data['rebate_total_price'] = Order::where('status',3)->whereIn('user_id',$user_ids)->where($arrWhere)->sum('rec_rebate');
     if(!empty($data['price'])&&!empty($data['goods_price'])&&!empty($data['sum'])){
            return ajax_success($data,'获取数据成功');
        }else {
            $data['price'] = 0;
            $data['goods_price'] = 0;
            $data['sum'] = 0;
            return ajax_success($data,'获取数据成功');
        }
    }

   /**
     *  代理销售排行
     * @return string
     * Date: 2018/6/8
     */
    public function rankings(){
       	$this->auth();
       	$this->method('post');  //提交方式
        $search = '';
        if(request()->isPost()){
            if(!empty(request()->post('search'))){
                $search = request()->post('search');
            }else{
                $search = '';
            }
        }
         $start_time = request()->post('start_time');
        $arrWhere = $this->time($start_time);
        $user_id = $this->user->id;//获取当前登录用的id
        $ids = $this->lower_level(false,$user_id,$search);
        $data = Order::where('status',3)->whereIn('user_id',$ids)->where($arrWhere)->group('user_id')->field(['user_id,SUM(sum)as sum'])->order('sum desc')->with(['getUser'=>function($query){
            $query->column('id,name,phone');
        }])->select();
       if(!$data->isEmpty()){
            return ajax_success($data,'获取数据成功');
       }else{
           return ajax_error([],'暂无推荐销售数据');
       }
    }

    /**
     *  代理销售排行(点击代理查看具体商品数量)
     * @return string
     * Date: 2018/6/12
     */
    public function goods_count(){
        $this->auth();
        $this->method();  //提交方式
        $id = request()->get('user_id');
        $start_time = request()->post('start_time');
        //直接调用个人商品销售明细
        $ach = new Achievement();
        $user_data = $ach->sales_details($id,$start_time);
        return $user_data;
    }


    /**
     *  推荐总代业绩
     * @return string
     * Date: 2018/6/8
     */
    public function rec_gen(){
        $this->auth();
        $this->method('post');  //提交方式
        $user_id = $this->user->id;//获取当前登录用的id
//        $user_id = 1;
        $start_time = request()->post('start_time');
        $arrWhere = $this->time($start_time);
        //获取当前登录用户的推荐总代
        $gen_ids = User::where(['rec_id'=>$user_id,'grade'=>0])->column('id');
        $data = Order::where('status',3)->where($arrWhere)->whereIn('user_id',$gen_ids)->group('user_id')->field(['user_id,SUM(sum)as sum,SUM(price)as price'])->order('sum desc')->with(['getUser'=>function($query){
            $query->column('id,name,phone');
    }])->select();
       if(!$data->isEmpty()){
           return ajax_success($data,'获取数据成功');
       }else{
           return ajax_error([],'暂无推荐总代业绩');
       }
    }

    /**
     *  代理销售返利明细(代理列表)
     * @return string
     * Date: 2018/6/8
     */
    public function rebate_deta($user_id='',$search=''){
        $this->auth(false);
        $this->method('post');  //提交方式
        if(empty($user_id)){
            $user_id = $this->user->id;//获取当前登录用的id
        }
        // $user_id = 5;
        $user_grade = User::where('id',$user_id)->value('grade');
        if(empty($search)){
            $search = request()->post('search');
        }
        $start_time = request()->post('start_time');
        $arrWhere = $this->time($start_time);
        $ids = $this->lower_level(false,$user_id,$search);
        // $data = Order::where('status',3)->where($arrWhere)->whereIn('user_id',$ids)->group('user_id')->field(['user_id,SUM(sum)as price'])->order('price desc')->with(['getUser'=>function($query){
        //     $query->column('id,name,phone');
        // }])->select();
        $data = User::whereIn('id',$ids)->where('status',1)->group('id')->column('id,name,phone');
        foreach ($data as $key => $value) {
        	$data[$key]['order'] = Order::where('status',3)->where($arrWhere)->where('user_id',$key)->field(['SUM(sum)as sum'])->find();
        }
        if($user_grade==1){
            foreach ($data as $k=>$v) {
            	if(empty($v['order']->sum)){
            		$v['order']->sum = 0;
            	}
            	//贡献返利
                $data[$k]['rebate_price'] = Order::where('status',3)->where('user_id',$v['id'])->field(['SUM(rec_rebate)as price'])->find();
                if(empty($data[$k]['rebate_price']->price)){
                     $data[$k]['rebate_price']->price = 0;
                }
            }
        }else{
        	//获取返利
             //获取用户的业绩一级下级代理的id
            foreach ($data as $k=>$v) {
            	if(empty($v['order']->sum)){
            		$v['order']->sum = 0;
            	}
                $data[$k]['rec_ids'] = $this->lower_level(false, $v['id']);
            } 
            //根据下级id计算出返利总金额
            foreach ($data as $k=>$vo){
                $data[$k]['rebate_price'] = Order::where('status',3)->whereIn('user_id',$data[$k]['rec_ids'])->field(['SUM(rec_rebate)as price'])->find();
                if(empty($data[$k]['rebate_price']->price)){
                    $data[$k]['rebate_price']->price = 0;
                }
            }
        }
        $datas = [];
        $datas['data'] = $data;
        $datas['grade'] = $user_grade;
        // dump($datas);exit;
        if(!empty($datas)){
            return ajax_success($datas,'获取数据成功');
        }else{
            return ajax_error([],'暂无代理销售明细');
        }
    }


    /**
     *  代理列表(点击查看代理个人销量记录)
     * @return string
     * Date: 2018/6/11
     */
    public function agency_per(){
        $this->auth();
        $this->method();  //提交方式
        $id = request()->get('user_id');//获取用户的id
        //直接调用个人业绩方法
        $ach = new Achievement();
        $data = $ach->personal($id);
        return $data;
    }


    /**
     *  代理个人业绩(返利来源明细)
     * @return string
     * Date: 2018/6/11
     */
    public function personal_rebate(){
        $this->auth();
        $this->method('post');  //提交方式
        $user_id = request()->post('user_id');
        $search = '';
        $search = request()->post('search');
        $user_data = $this->rebate_deta($user_id,$search);
        if(!empty($user_data)){
            return $user_data;
        }else{
            return ajax_error([],'暂无代理销售明细');
        }
    }

     public function personal_rebate1(){
        $this->auth();
        $this->method('post');  //提交方式
        $user_id = request()->post('user_id');
        $search = '';
        $search = request()->post('search');
        $user_data = $this->rebate_deta($user_id,$search);
        if(!empty($user_data)){
            return $user_data;
        }else{
            return ajax_error([],'暂无代理销售明细');
        }
    }


    /**
     *  获取当前登录用户下的代理(公共)
     * @return string
     * Date: 2018/6/8
     */
    public function lower_level($flag=false,$user_id='',$search=''){
        $grade = User::where('id',$user_id)->value('grade');
        //判断当前用户的等级,获取当前用户下的代理
        if($grade==1){
            $rec_ids = User::where('rec_id',$user_id)->where('grade',1)->where('name|phone','like','%'.$search.'%')->column('id');
        }else{
            $rec_ids = User::where('gen_id',$user_id)->where('grade',1)->where('name|phone','like','%'.$search.'%')->column('id');
        }
        if($flag){
            array_push($rec_ids,$user_id);
        }
        return $rec_ids;
    }

    

    /**
     *  时间区间查询(公共)
     * @return string
     * Date: 2018/6/11
     */
    public function time($start_time=''){
        //判断时间
        if(!empty($start_time)){
            $start_time = date("Y-m-d H:i:s",strtotime($start_time));
            $end_time = date("Y-m-d H:i:s",strtotime("+1month",strtotime($start_time))-1);
        }else{
            $time = date('Y-m');
            $start_time = date("Y-m-d H:i:s",strtotime($time));
            $end_time = date("Y-m-d H:i:s",strtotime("+1month",strtotime($time))-1);
        }
        $arrWhere[] = ['update_time', 'between time', [$start_time, $end_time]];

        return $arrWhere;
    }
}