<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/5/30
 * Time: 14:30
 */
namespace app\index\controller\v1;

use app\index\controller\BaseController;

use app\Models\Area;
use app\Models\City;
use app\Models\OrderGoods;
use app\Models\Province;
use app\Models\Special;
use think\Validate;
use think\Db;

class Order extends BaseController {

    /**
     *  添加订单--点击确定
     * @return string
     */
    public function fill_order(){ 
       $this->auth(false);
       $this->method('post');  //提交方式
        $goods=[];
        $goods['num'] = 0;
//      根据是否有一级id参数,有则为客户下单,否则为当前登录用户下单
        $user_id = request()->post('user_id');
        if(empty($user_id)){
            $user_id = $this->user->id;
            //获取用户的等级
            $grade = \app\Models\User::where('id',$user_id)->value('grade');
            if($grade==1){
                $status = 1;
                $type = 1;
                $grade = 1;
            }else{
                $status = 2;
                $type = 2;
                $grade = 0;
            }
        }else{
            $status = 0;
            $type = 0;
            $grade = 1;
        }
        $data = json_decode(request()->post('goods'),true);
        // $data = request()->post('goods/a');
        $goods['order_type'] = 0;
        //获取商品总数量
        foreach ($data as $key => $value) {
        	$goods['num'] += $value['num'];
        }
        foreach ($data as $k=>$v){
            $goods['goods'][$k]['id']=$v['id'];
            $goods['goods'][$k]['name']=\app\Models\Goods::get($v['id'])->name;
            $goods['goods'][$k]['img']=\app\Models\Goods::get($v['id'])->img;
            $goods['goods'][$k]['num']=$v['num'];
            //获取商品等于的麻辣包数
            if($goods['goods'][$k]['name']=='秘制酱板鸭(微辣)'||$goods['goods'][$k]['name']=='秘制酱板鸭(中辣)'||$goods['goods'][$k]['name']=='秘制酱板鸭(特辣)'){
                $goods['goods'][$k]['bag'] = $v['num']*3;
            }elseif($goods['goods'][$k]['name']=='秘制毛豆'|| $goods['goods'][$k]['name']=='滋味藕片'){
                $goods['goods'][$k]['bag'] = $v['num']*1.5;
            }else{
                $goods['goods'][$k]['bag'] = $v['num'];
            }
            $whe_price = \app\Models\Goods::get($v['id'])->whe_price;
            $batch_price = \app\Models\Goods::get($v['id'])->batch_price;
            $goods['goods'][$k]['gen_price'] = \app\Models\Goods::get($v['id'])->gen_price;
            // $type=0和$type=1是分享下单 $type=2为总代自己下单
            //判断当前订单是否是分享下单
            //分享下单和一级下单
            if($type==0||$type==1){
                if($goods['num']>=50){
                    $goods['goods'][$k]['price'] =$batch_price;
                    $goods['goods'][$k]['goods_price'] = $batch_price*$v['num'];
                }else{
                    $goods['goods'][$k]['price'] =$whe_price;
                    $goods['goods'][$k]['goods_price'] = $whe_price*$v['num'];
                }
            }else{
            	//总代下单
            	//判断下单用户是否有特殊价格
                $user_special = Special::where('user_id', $user_id)->where('goods_id', $v['id'])->value('price');
                if (!empty($user_special)) {
                    $goods['order_type'] = 1;  //有特价商品的订单为特价订单
                    $goods['goods'][$k]['price'] = $user_special;
                    $goods['goods'][$k]['goods_price'] = $user_special * $v['num'];
                }else{
                    $goods['goods'][$k]['price'] =$goods['goods'][$k]['gen_price'];
                    $goods['goods'][$k]['goods_price'] = $goods['goods'][$k]['gen_price']*$v['num'];
                }
            }
            //混批酱板鸭返利
            if($goods['num']>=50&&($goods['goods'][$k]['name']=='秘制酱板鸭(微辣)'||$goods['goods'][$k]['name']=='秘制酱板鸭(中辣)'||$goods['goods'][$k]['name']=='秘制酱板鸭(特辣)')){
            	$goods['goods'][$k]['rebate'] = $v['num']*2;
            }
            //批发酱板鸭返利
            if($goods['num']<50&&($goods['goods'][$k]['name']=='秘制酱板鸭(微辣)'||$goods['goods'][$k]['name']=='秘制酱板鸭(中辣)'||$goods['goods'][$k]['name']=='秘制酱板鸭(特辣)')){
            	$goods['goods'][$k]['rebate'] = $v['num']*3;
            }
            //混批鸭舌返利
            if($goods['num']>=50&&$goods['goods'][$k]['name']=='爆爆鸭舌'){
            	$goods['goods'][$k]['rebate'] = $v['num']*0.5;
            }
            //批发鸭舌返利
            if($goods['num']<50&&$goods['goods'][$k]['name']=='爆爆鸭舌'){
            	$goods['goods'][$k]['rebate'] = $v['num']*1.5;
            }
            //
            if($goods['num']>=50 && $goods['goods'][$k]['name'] !== '爆爆鸭舌' && $goods['goods'][$k]['name'] !== '秘制酱板鸭(微辣)' && $goods['goods'][$k]['name'] !== '秘制酱板鸭(中辣)' && $goods['goods'][$k]['name'] !== '秘制酱板鸭(特辣)'){
            	$goods['goods'][$k]['rebate'] = $v['num']*0.5;
            }

            if($goods['num']<50&&$goods['goods'][$k]['name']!=='爆爆鸭舌'&&$goods['goods'][$k]['name']!=='秘制酱板鸭(微辣)'&&$goods['goods'][$k]['name']!=='秘制酱板鸭(中辣)'&&$goods['goods'][$k]['name']!=='秘制酱板鸭(特辣)'){
            	$goods['goods'][$k]['rebate'] = $v['num']*1;
            }

        }
        $goods['goods_total_price'] = 0;
        $goods['gen_total_price'] = 0;
        $goods['total_rebate'] = 0;
        $goods['bag'] = 0;
        foreach ($goods['goods'] as $vo){
            $goods['goods_total_price'] +=$vo['goods_price'];
            $goods['bag'] +=$vo['bag'];
            $goods['gen_total_price'] +=$vo['num']*$vo['gen_price'];
            $goods['total_rebate'] +=$vo['rebate'];
        }
        $goods['user_id'] = $user_id;
        $goods['type'] = $type;
        $goods['status'] = $status;
        $goods['grade'] = $grade;
        if(!empty($goods)){
            return ajax_success($goods,'添加商品成功');
        }else{
            return ajax_error([],'添加商品失败');
        }
    }

    /**
     *  添加订单--点击确认提交
     * @return string
     * Time: 2018/5/31
     */
    public function confirm_sub(){
        $this->method('post');
        $data = json_decode(request()->post('goods'),true);
        //获取用户收货地址的省份
        $pro_name = Province::where('code',$data['province_code'])->value('name');
        //1为普通快递的运费,2为顺丰空运,3为顺丰陆运
        //获取不同快递的运费
        if($data['log_type']==1){
            $data['postage_name'] = '普通快递';
            $freight = config('ordinary.'.$pro_name);
        }
        if($data['log_type']==2){
            $data['postage_name'] = '顺丰空运';
            $freight = config('airlift.'.$pro_name);
        }
        if($data['log_type']==3){
            $data['postage_name'] = '顺丰陆运';
            $freight = config('land.'.$pro_name);
        }
     
        if($data['bag']/8>(int)explode(".",$data['bag']/8)[0]){
            $weight = (int)explode(".",$data['bag']/8)[0]+1;
        }else{
            $weight = $data['bag']/8;
        }
       
        $data['postage'] = $freight[0]+($weight-1)*$freight[1];
        $data['order_no'] = order_number();
        $data['province_name'] = Province::where('code',$data['province_code'])->value('name');
        $data['city_name'] = City::where('code',$data['city_code'])->value('name');
        $data['area_name'] = Area::where('code',$data['area_code'])->value('name');
        $data['time'] = date('Y-m-d H:i:s');
        if(!empty($data)){
            return ajax_success($data,'提交成功');
        }else{
            return ajax_error([],'提交失败');
        }
    }

    /**
     *  添加订单--点击提交订单
     * @return string
     * Time: 2018/6/1
     */
    public function sub_order(){
        $this->method('post');
        $data = json_decode(request()->post('goods'),true);
        $sum = 0;
        /**
         * 开启实物
         */
        Db::startTrans();
        try{
            //插入订单商品记录
            foreach ($data['goods'] as $v){
                //总代价
                $gen_total_price = $v['gen_price']*$v['num'];
                //商品总数量
                $sum += $v['num'];
                OrderGoods::create([
                    'order_no'=>$data['order_no'],
                    'goods_id'=>$v['id'],
                    'price'=>$v['price'],
                    'gen_price'=>$v['gen_price'],
                    'sum'=>$v['num'],
                    'total_price'=>$v['goods_price'],
                    'gen_total_price'=>$gen_total_price,
                ]);
            }
            $gen_rebate = 0;
            $rec_rebate = 0;
            $user_data = \app\Models\User::where('id',$data['user_id'])->find();
            //总代自己下单
            // if($data['grade']==0 && $user_data['grade']==0 && $data['type']==2 || $data['order_type']==1){
            //     $gen_rebate = 0;
            //     $rec_rebate = 0;
            // }
            // //总代分享下单
            // if($data['grade']==1 && $user_data['grade']==0 && $data['type']==0){
            //     $gen_rebate = $data['goods_total_price']-$data['gen_total_price'];
            //     $rec_rebate = 0;
            // }
            // //一级自己下单(判断一级的推荐代理等级)
            $rec_grade = \app\Models\User::where('id',$user_data['rec_id'])->value('grade');
            // //一级的推荐的代理为总代,返利全部给总代
            if($data['grade']==1 && $user_data['grade']==1 && $rec_grade!==1){
                $gen_rebate = $data['total_rebate'];
                $rec_rebate = 0;
            }
            //一级的推荐的代理是一级,返利总代和一级代理平分
            if($data['grade']==1 && $user_data['grade']==1 && $rec_grade==1){
                $rec_rebate = $data['total_rebate'];
                $gen_rebate = $data['total_rebate'];
            }
            //插入订单记录
            $order = \app\Models\Order::create([
                'order_no'=>$data['order_no'],
                'user_id'=>$data['user_id'],
                'consignee'=>$data['consignee'],
                'phone'=>$data['phone'],
                'postage'=>$data['postage'],
                'log_type'=>$data['log_type'],
                'goods_price'=>$data['goods_total_price'],
                'price'=>$data['postage']+$data['goods_total_price'],
                'province_code'=>$data['province_code'],
                'city_code'=>$data['city_code'],
                'area_code'=>$data['area_code'],
                'address_deta'=>$data['address_deta'],
                'type'=>$data['type'],
                'order_type'=>$data['order_type'],
                'status'=>$data['status'],
                'sum'=>$sum,
                'rec_rebate'=>$rec_rebate,
                'gen_rebate'=>$gen_rebate,
                'create_time'=>$data['time']
            ]);
            /**
             * 事务运行
             */
            Db::commit();
            return ajax_success($order->id,'生成订单成功');
        }catch (\Exception $e){
            // 回滚事务
            Db::rollback();
            return ajax_error([],$e->getMessage());
        }
    }

}