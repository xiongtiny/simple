<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/28
 * Time: 11:32
 */
namespace app\index\controller\v2;
use app\model\Feedback;
use app\model\Order;
use app\model\SendSms;
use app\model\Farm;
use EasyWeChat\Foundation\Application;
use \think\Controller;
use \think\Validate;
use \think\facade\Session;

class Lease extends Controller{

    /**
     * 用户租赁农场
     * @return \think\response\Json
     */
    public function lease_farm1()
    {
        return $this->fetch();
    }
    public function lease_farm(){
        $user_id = Session::get('user_id');
        $farm_id = request()->get('farm_id');
        //获取农场租赁价格
        $farm_price = Farm::where('id',$farm_id)->value('price');
        $order_number = order_number();
        $order = Order::create([
            'user_id'=>$user_id,
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
                'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
                'body'             => '购买农场',
                'detail'           => '方块科技',
                'out_trade_no'     => $order_number,
                'total_fee'        => 0.01*100, // 单位：分
                'notify_url'       => '回调地址', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
                'openid'           =>request()->get('openid'),
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
    }

    /**
     * 支付成功回调地址
     */
    public function payment_state(){
        $order_no = "接收回调信息中的订单号";
        if("判断支付结果"){
            $order_state = Order::where('order_number',$order_no)->update(['type'=>1]);
            if($order_state){
                $farm_id = Order::where('order_number',$order_no)->value('farm_id');
                $user_id = Farm::where('id',$farm_id)->value('');
                $order = Order::create([
                    'user_id'=>$user_id,
                    'order_number'=>$order_no,
                    'type'=>2,
                    'farm_id'=>$farm_id
                ]);
            }
        }
        $app = new Application(config('wechat.'));
//        file_put_contents('wechat.txt','get');
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order_no =$notify->out_trade_no;
            $state = \app\model\Order::where('order_number',$order_no)->find();
            if(empty($state)){
                return "Order not exist";
            }
            if ($successful) {
//                file_put_contents('wechat1.txt','begin');
                // file_put_contents('trade_status.txt',$_POST['trade_status']);
                // 启动事务
                Db::startTrans();
                try {
                    $order_state = Order::where('order_number',$order_no)->update(['type'=>1]);
                    if($order_state){
                        $farm_id = Order::where('order_number',$order_no)->value('farm_id');
                        $user_id = Farm::where('id',$farm_id)->value('');
                        $order = Order::create([
                            'user_id'=>$user_id,
                            'order_number'=>$order_no,
                            'type'=>2,
                            'farm_id'=>$farm_id
                        ]);
                    }
                    // 提交事务
                    Db::commit();
                } catch (\Exception $e) {
                    // 回滚事务
                    file_put_contents('error.txt',$e->getMessage());
                    Db::rollback();
                }
            }
            return true;
        });
        return $response;

    }

}