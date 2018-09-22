<?php
namespace app\index\controller\v1;
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/19
 * Time: 16:40
 */
use app\model\Order;
use app\model\Service;
use \think\Controller;
use \think\facade\Session;
use Db;
use app\model\Equipment;
use think\Validate;

class Farm extends Controller{

    /**
     * 添加农场
     * @return \think\response\Json
     */
//    public function add_farm1(){
//        $id = Session::get('user_id');
//        $name = \app\model\User::where('id',$id)->value('name');
//        $this->assign('name',$name);
//
//    }
    public function add_farm(){
        $user_id = Session::get('user_id');
        if(empty($user_id)){
            $this->redirect("/api/v1/index/login1");
        }
        $res = Service::select();
        $this->assign('data',$res);
        if(request()->isPost()){
            $data = request()->post();
            $user_id = Session::get('user_id');
            $validate=Validate::make([
                'name'=>"require",
                'province'=>"require",
                'city'=>'require',
                'area'=>'require',
                'address'=>'require',
                'phone'=>'require',
                'equipment_number'=>'require',
                'acreage'=>'require',
                'price'=>'require',
                'lease_type'=>'require',
                'service'=>'require',

            ],[],
                [
                    'name'=>"农场名称",
                    'province'=>"省份",
                    'city'=>'市',
                    'area'=>'地区',
                    'address'=>'详细地址',
                    'phone'=>'手机号',
                    'equipment_number'=>'设备序列号',
                    'acreage'=>'面积',
                    'price'=>'价格',
                    'lease_type'=>'出租时间',
                    'service'=>'服务',
                ]);
                if(!$validate->check($data)){
                return error(400,$validate->getError());
            }
            $img = picture(request()->file('img'),$size='10',$ext='jpg,png,gif,jpeg',$path='./uploads',$width='392',$height='253');
            if($img['status']==0){
                $img = $img['message'];
                /**
                 * 开启实物
                */
                Db::startTrans();
                try{
                    $farm = \app\model\Farm::create([
                        'user_id'=>$user_id,
                        'name'=>$data['name'],
                        'img'=>$img,
                        'province'=>$data['province'],
                        'city'=>$data['city'],
                        'area'=>$data['area'],
                        'address'=>$data['address'],
                        'phone'=>$data['phone'],
                        'equipment_number'=>$data['equipment_number'],
                        'acreage'=>$data['acreage'],
                        'price'=>$data['price'],
                        'service'=>implode(',', $data['service']),
                        'describe'=>$data['describe'],
                        'lease_type'=>$data['lease_type']
                    ]);
                    //获取设备直播地址url保存在数据库
                    $url = get_url();
                    foreach($url as $v){
                        if($v['deviceSerial']==$data['equipment_number']){
                            $equipment = Equipment::create([
                                'serial_number'=>$v['deviceSerial'],
                                'liveAddress'=>$v['liveAddress'],
                                'hdAddress'=>$v['hdAddress'],
                                'rtmp'=>$v['rtmp'],
                                'rtmpHd'=>$v['rtmpHd'],
                            ]);
                        }
                    }
                    /**
                     * 事务运行
                     */
                    Db::commit();
                    return success(200,'添加成功',$farm->id);
                }catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return error(400,$e->getMessage());
                }
            }else{
                return error(400,$img['message']);
            }
        }
            return $this->fetch();
    }

    /**
     * 农场展示
     * @return \think\response\Json
     */

    public function farm_list(){
        $id = Session::get('user_id');
        $name = \app\model\User::where('id',$id)->value('name');
        $this->assign('name',$name);
        $farm_data = \app\model\Farm::where('type',0)->paginate(9);
        foreach ($farm_data as $k=>$v){
            $v['service'] = Service::whereIn('id',$v['service'])->column('name');
        }

        if(!$farm_data->isEmpty()){
            $this->assign('data',$farm_data);
        }else{
            return error(400,'暂无农场信息');
        }
        return $this->fetch();
    }

    /**
     * 农场详情
     * @return \think\response\Json
     */
    public function farm_detail(){
        $id = Session::get('user_id');
        $name = \app\model\User::where('id',$id)->value('name');
        $this->assign('name',$name);
        $farm_id = request()->get('farm_id');
        // $user_id = Session::get('user_id');
        $farm = \app\model\Farm::where('id',$farm_id)->find();
        $farm['service'] = Service::whereIn('id',$farm['service'])->column('name');
        // //判断农场是否被租赁
        // $farm_state = Order::where('user_id',$user_id)
        //                     ->where('farm_id',$farm_id)
        //                     ->where('type',1)
        //                     ->find();
        // if(empty($farm_state)){
        //     $farm->phone =substr_replace($farm->phone,'****','3','4');
        // }
        $code = \app\model\Farm::where('id',$farm_id)->value('equipment_number');
        $farm_url = Equipment::where('serial_number',$code)->find();
        // dump($farm);exit;
        $this->assign('data',$farm);
        $this->assign('data1',$farm_url);

        //
        //获取农场租赁价格
        $farm_price = Farm::where('id',$farm_id)->value('price');
        $order_number = order_number();
        $order = Order::create([
            'user_id'=>$id,
            'order_number'=>$order_number,
            'type'=>0,
            'farm_id'=>$farm_id,
            'price'=>$farm_price
        ]);
        if($order->id){
            //微信支付
            $app = new Application(config('wechat.'));

            $payment =$app->payment;
            $attributes = [
                'trade_type'       => 'NATIVE', // pc扫码支付
                'body'             => '购买农场',
                'detail'           => '方块科技',
                'out_trade_no'     => $order_number,
                'total_fee'        => 0.01*100, // 单位：分
                'notify_url'       => 'http://www.fineclab.com/api/v1/lease/payment_state', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
                // ...
            ];

            $order = new \EasyWeChat\Payment\Order($attributes);
            $result = $payment->prepare($order);
            if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
                $prepayId = $result->prepay_id;
                $json = $payment->configForPayment($prepayId,false); // 返回 json 字符串，如果想返回数组，传第二个参数 false

                return success(200,'调取支付成功',$json);
            }else{
                return error(400,'调取支付失败');
            }
        }else{
            return error(400,'生成订单失败');
        }
        return $this->fetch();


        // if($farm->id){
        //     return success(200,'获取详情成功',$farm);
        // }else{
        //     return error(400,'获取详情失败');
        // }
    }


    /**
     * 农场主修改农场
     * @return \think\response\Json
     */
    public function edit_farm(){
        $user_id = Session::get('user_id');
        $farm_id = !empty(request()->get('farm_id'))?request()->get('farm_id'):request()->post('farm_id');
        $res = Service::select();
        $farm_data = \app\model\Farm::where('user_id',$user_id)->where('id',$farm_id)->find();
        if(request()->isPost()){
            $data = request()->post();
            if(request()->file('img')){
                $img = picture(request()->file('img'));
                if($img['status']==0){
                    $data['img'] = $img['message'];
                }else{
                    return error(400,$img['message']);
                }
            }
            $data['service'] = implode(',', $data['service']);
            $state = $farm_data->save($data);

            if($state){
                return success(200,'修改成功',$state);
            }else{
                return error(400,'修改失败');
            }
        }


        $this->assign('data1',$res);
        $this->assign('data',$farm_data);
        return $this->fetch();
    }


    /**
     * 获取农场直播url
     * @return \think\response\Json
     */
    public function farm_url(){
        $equipment_number = request()->get('equipment_number');
        $equipment_url = Equipment::where('serial_number',$equipment_number)->find();
        if(!empty($equipment_url)){
            return success(200,'获取播放地址成功',$equipment_url);
        }else{
            return error(400,'获取播放地址失败');
        }
       
    }


    
    public function index()
    {
        $id = Session::get('user_id');
        $name = \app\model\User::where('id',$id)->value('name');
        $this->assign('name',$name);
        $farm_data = \app\model\Farm::where('type',0)->paginate(9);
        foreach ($farm_data as $k=>$v){
            $v['service'] = Service::whereIn('id',$v['service'])->column('name');
        }

        if(!$farm_data->isEmpty()){
            $this->assign('data',$farm_data);
        }else{
            return error(400,'暂无农场信息');
        }

        ////
        $id = Session::get('user_id');
        $name = \app\model\User::where('id',$id)->value('name');
        $this->assign('name',$name);
        return $this->fetch();
    }

    public function a(){
        $url = get_url();
        dump($url);exit;
    }

}
