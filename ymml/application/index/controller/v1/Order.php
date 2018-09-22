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
        $this->auth();
        $this->method('post');  //提交方式
        $goods=[];
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
        $data = request()->post('goods/a');
        $goods['order_type'] = 0;
        foreach ($data as $k=>$v){
            $goods['goods'][$k]['id']=$v['id'];
            $goods['goods'][$k]['name']=\app\Models\Goods::get($v['id'])->name;
            $goods['goods'][$k]['num']=$v['num'];
            //获取商品等于的麻辣包数
            if($goods['goods'][$k]['name']=='秘制酱板鸭'){
                $goods['goods'][$k]['bag'] = $v['num']*3;
            }elseif($goods['goods'][$k]['name']=='秘制毛豆'|| $goods['goods'][$k]['name']=='滋味藕片'){
                $goods['goods'][$k]['bag'] = $v['num']*1.5;
            }else{
                $goods['goods'][$k]['bag'] = $v['num'];
            }
            $whe_price = \app\Models\Goods::get($v['id'])->whe_price;
            $batch_price = \app\Models\Goods::get($v['id'])->batch_price;
            $goods['goods'][$k]['gen_price'] = \app\Models\Goods::get($v['id'])->gen_price;
            //判断当前订单是否是分享下单
            if($type==0){
                if($v>=50){
                    $goods['goods'][$k]['price'] =$batch_price;
                    $goods['goods'][$k]['goods_price'] = $batch_price*$v['num'];
                }else{
                    $goods['goods'][$k]['price'] =$whe_price;
                    $goods['goods'][$k]['goods_price'] =  $whe_price*$v['num'];
                }
            }else{
                //判断下单用户是否有特殊价格
                $user_special = Special::where('user_id', $user_id)->where('goods_id', $v['id'])->value('price');
                if (!empty($user_special)) {
                    $goods['order_type'] = 1;  //有特价商品的订单为特价订单
                    $goods['goods'][$k]['price'] = $user_special;
                    $goods['goods'][$k]['goods_price'] = $user_special * $v['num'];
                }else{
                    if($type==1){
                        if($v>=50){
                            $goods['goods'][$k]['price'] =$batch_price;
                            $goods['goods'][$k]['goods_price'] = $batch_price*$v['num'];
                        }else{
                            $goods['goods'][$k]['price'] =$whe_price;
                            $goods['goods'][$k]['goods_price'] =  $whe_price*$v['num'];
                        }
                    }else{
                        $goods['goods'][$k]['price'] =$goods['goods'][$k]['gen_price'];
                        $goods['goods'][$k]['goods_price'] = $goods['goods'][$k]['gen_price']*$v['num'];
                    }
                }
            }
        }
        $goods['goods_total_price'] = 0;
        $goods['gen_total_price'] = 0;
        $goods['bag'] = 0;
        foreach ($goods['goods'] as $vo){
            $goods['goods_total_price'] +=$vo['goods_price'];
            $goods['bag'] +=$vo['bag'];
            $goods['gen_total_price'] +=$vo['num']*$vo['gen_price'];
        }
        $goods['user_id'] = $user_id;
        $goods['type'] = $type;
        $goods['status'] = $status;
        $goods['grade'] = $grade;
        dump($goods);exit;
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
        $data = request()->post('goods');
        $validate = Validate::make([
            'consignee'=>'require',
            'phone'=>'require',
            'log_type'=>'require',
            'province_code'=>'require',
            'city_code'=>'require',
            'area_code'=>'require',
            'address_deta'=>'require',
        ],[],
            [
                'consignee'=>'收货人',
                'phone'=>'收货人手机号',
                'log_type'=>'物流方式',
                'province_code'=>'省',
                'city_code'=>'市',
                'area_code'=>'区',
                'address_deta'=>'详细地址',
            ]);
        if(!$validate->check($data)){
            return ajax_error([],$validate->getError());
        }
        //获取用户收货地址的省份
        $pro_name = Province::where('code',$data['province_code'])->value('name');
        //0为普通快递的运费,1为顺丰空运,2为顺丰陆运
        //获取不同快递的运费
        if($data['log_type']==0){
            $freight = config('ordinary.'.$pro_name);
        }elseif ($data['log_type']==1){
            $freight = config('airlift.'.$pro_name);
        }else {
            $freight = config('land.'.$pro_name);
        }
        //顺丰陆运重量在1.5KG及以上需续重
        if($data['log_type']==2){
            if($data['bag']/8<1.5){
                $weight = 1;
            }elseif ($data['bag']/8>(int)explode(".",$data['bag']/8)[0]){
                $weight = explode(".",$data['bag']/8)[0]+1;
            }else{
                $weight = $data['bag']/8;
            }
        }else{
            if($data['bag']/8>(int)explode(".",$data['bag']/8)[0]){
                $weight = explode(".",$data['bag']/8)[0]+1;
            }else{
                $weight = $data['bag']/8;
            }
        }
        $data['postage'] = $freight[0]+($weight-1)*$freight[1];
        $data['postage'] = $freight[0]+($weight-1)*$freight[1];
        $data['order_no'] = order_number();
        $data['province_name'] = Province::where('code',$data['province_code'])->value('name');
        $data['city_name'] = City::where('code',$data['city_code'])->value('name');
        $data['area_name'] = Area::where('code',$data['area_code'])->value('name');
        dump($data);exit;
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
        OrderGoods::create([
            'order_no'=>21121,
            'goods_id'=>1,
            'price'=>2,
            'gen_price'=>2,
            'sum'=>4,
            'total_price'=>10,
            'gen_total_price'=>20,
        ]);exit;

        $this->method('post');
        $data = request()->post('goods');
        $sum = 0;
        /**
         * 开启实物
         */
        Db::startTrans();
        try{
            //插入订单商品记录
            foreach ($data['goods'] as $v){
                //总代价
                $gen_total_price = $v['gen_price']*$v['sum'];
                //商品总数量
                $sum += $v['num'];
                OrderGods::create([
                    'order_no'=>$data['order_no'],
                    'goods_id'=>$v['id'],
                    'price'=>$v['price'],
                    'gen_price'=>$v['gen_price'],
                    'sum'=>$v['sum'],
                    'total_price'=>$v['goods_price'],
                    'gen_total_price'=>$gen_total_price,
                ]);
            }
            $gen_rebate = 0;
            $rec_rebate = 0;
            $user_data = \app\Models\User::where('id',$data['user_id'])->find();
            //总代自己下单
            if($data['grade']==0 && $user_data['grade']==0 && $data['type']==2 || $data['order_type']==1){
                $gen_rebate = 0;
                $rec_rebate = 0;
            }
            //总代分享下单
            if($data['grade']==1 && $user_data['grade']==0 && $data['type']==0){
                $gen_rebate = $data['gen_total_price']-$data['goods_total_price'];
                $rec_rebate = 0;
            }
            //一级自己下单(判断一级的推荐代理等级)
            $rec_grade = \app\Models\User::where('id',$user_data['rec_id'])->value('grade');
            //一级的推荐的代理为总代
            if($data['grade']==1 && $user_data['grade']==1 && $rec_grade!==1){
                $gen_rebate = $data['gen_total_price']-$data['goods_total_price'];
                $rec_rebate = 0;
            }
            //一级的推荐的代理是一级
            if($data['grade']==1 && $user_data['grade']==1 && $rec_grade==1){
                $gen_rebate = ($data['gen_total_price']-$data['goods_total_price'])/2;
                $rec_rebate = ($data['gen_total_price']-$data['goods_total_price'])/2;
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
                'gen_rebate'=>$gen_rebate,
                'rec_rebate'=>$rec_rebate,
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