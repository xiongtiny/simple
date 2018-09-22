<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/10
 * Time: 16:55
 */

namespace app\index\controller\v1;
use EasyWeChat\Foundation\Application;
use Request;
use app\model\Order as OrderModel;

use app\model\UserCourse;
use app\model\ClassHour;
use app\model\Course;
use app\plugins\alipay\AopClient;
use app\plugins\alipay\request\AlipayTradeWapPayRequest;
use Db;
class Order extends BaseController{

    /**
     *  订单--用户点击报名--生成未支付订单
     * @return string
     * @param  course_id 班级课id
     * @param  class_hour_id 1对1id
     */
    public function place_order(){
        $this->auth();    //判断用户是否登录
        $this->method('get');   //限制提交方式
        //获取当前用户信息
        $user_data = $this->user;
        //实例化订单模型
        $order = new \app\model\Order();
        //生成订单号
        $order_number = order_number();
        $data = request()->get();
        if(!empty($data['course_id'])){
            $course =  Course::where('id',$data['course_id'])->find();
            $order->course_id = $data['course_id'];
            if(empty($course['activity_price'])){
                $order->price = $course['price'];
            }else{
                $order->price = $course['price']-$course['activity_price'];
                $order->activity_price = $course['activity_price'];
            }
        }else{
            $order->class_hour_id = $data['class_hour_id'];
            $hour = ClassHour::where('id',$data['class_hour_id'])->find();

            if(empty($hour['activity_price'])){
                $order->price = $hour['price'];
            }else{
                $order->price = $hour['price']-$hour['activity_price'];
                $order->activity_price = $hour['activity_price'];
            }
        }
        //组装插入的数据
        $order->order_no = $order_number;
        $order->user_id = $user_data->id;
        $order->user_name = $user_data->username;
        $order->user_phone = $user_data->phone;
        $order->status = 0;
        $state = $order->save();
        if($state){
            ajax_success($state,'报名成功');
        }else{
            ajax_error($state,'报名失败');
        }
    }

    /**
     *  订单--用户支付
     * @return string
     * @param  order_no 订单号
     * @param  type 支付类型 1为支付宝 2为微信
     */
    public function payment(){
        // $this->auth();   //判断用户是否登录
        $this->method('get');   //限制提交方式
        //接收订单号
        $order_no = request()->get('order_no');
        $order_data = \app\model\Order::where('order_no',$order_no)->find();
        $price = $order_data['price'];
        $appid=config("alipay.appId");
        //1为支付宝支付 2为微信支付
        if(request()->get('type')==2){
            $aop = new AopClient();
            $request = new AlipayTradeWapPayRequest();
            $request->setNotifyUrl('http://yxy.weilang.top/api/v1/order/order_state_alipay');
             $request->setReturnUrl('http://yuexueu.weilang.top/#/order/orderList');

            $price=sprintf("%.2f",$price);
            $biz=[
                'body'=>"购买课程",
                'subject'=>"悦学优",
                'out_trade_no'=>$order_no,
                'timeout_express'=>'90m',
                'total_amount'=>"0.01",
                'quit_url'=>'http://yuexueu.weilang.top/#/order/orderList',
                'product_code'=>'QUICK_WAP_WAY',
                'seller_id'=>''
            ];
            $request->setBizContent(json_encode($biz)); 
            $result = $aop->pageExecute ($request,'get');
            ajax_success($result,'成功');

            // $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
            // dump($result);

            // $resultCode = $result->$responseNode->code;
            // if(!empty($resultCode)&&$resultCode == 10000){
            //     ajax_success($result,'成功');
            // } else {
            //    ajax_error('','失败');
            // }
        }else{
            $app = new Application(config('wechat.'));

            $payment =$app->payment;
            $attributes = [
                'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
                'body'             => '购买课程',
                'detail'           => '悦学优',
                'out_trade_no'     => $order_no,
                'total_fee'        => 0.01*100, // 单位：分
                'notify_url'       => 'http://yxy.weilang.top/api/v1/order/order_state_wxpay', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
                'openid'           =>request()->get('openid'),
                // ...
            ];

            $order = new \EasyWeChat\Payment\Order($attributes);
            $result = $payment->prepare($order);
            if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
                $prepayId = $result->prepay_id;
                $json = $payment->configForPayment($prepayId,false); // 返回 json 字符串，如果想返回数组，传第二个参数 false

                ajax_success($json,'调取支付成功');

            }else{
                ajax_error('','调取支付失败');
            }
        }

    }



    /**
     *  订单--支付成功修改订单状态
     * @return string
     */
    public function order_state_wxpay(){
        $app = new Application(config('wechat.'));
        file_put_contents('wechat.txt','get');
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order =$notify->out_trade_no;

            $date = date('Y-m-d H:i:s',time());
            $state = \app\model\Order::where('order_no',$order)->find();
            if(empty($state)){
                return "Order not exist";
            }


            if ($successful) {
                file_put_contents('wechat1.txt','begin');

                // file_put_contents('trade_status.txt',$_POST['trade_status']);
                // 启动事务
                Db::startTrans();
                try {
/*                    file_put_contents('wechat2.txt','startTrans');*/

                    $state1=$state->save(['status'=>1,'pay_time'=>$date,'pay_type'=>2]);
                    if($state1){
                        $order_data = \app\model\Order::where('order_no',$order)->find();
                        $UserCourse = new UserCourse();
                        if(!empty($order_data['course_id'])){
                            $UserCourse->course_id = $order_data['course_id'];
                            Course::get($order_data['course_id'])->inc('study_num');

                        }else{
                            $UserCourse->class_hour_id = $order_data['class_hour_id'];
                        }
                        $UserCourse->user_id = $order_data['user_id'];
                        $UserCourse->save();
                    }
                    // 提交事务
                    Db::commit();

/*                    file_put_contents('wechat2.txt','commit');*/

                } catch (\Exception $e) {
                    // 回滚事务
/*                    file_put_contents('error.txt',$e->getMessage());*/
                    Db::rollback();
                }
            }
            return true;
        });
        return $response;
    }



    /**
     *  订单--支付成功修改订单状态
     * @return string
     */
    public function order_state_alipay(){
        $aop = new AopClient();
        $aop->rsaCheckV1($_POST,null,'RSA2');      
          if($_POST['trade_status']=='TRADE_SUCCESS'){
            // file_put_contents('trade_status.txt',$_POST['trade_status']);
            // 启动事务
            Db::startTrans();
            try {
                $date = date('Y-m-d H:i:s',time());
                $state = \app\model\Order::where('order_no', $_POST['out_trade_no'])->find();
                $state1=$state->save(['status'=>1,'pay_time'=>$date,'pay_type'=>1]);
                if($state1){
                    $order_data = \app\model\Order::where('order_no', $_POST['out_trade_no'])->find();
                    $UserCourse = new UserCourse();
                    if(!empty($order_data['course_id'])){
                        $UserCourse->course_id = $order_data['course_id'];
                        Course::get($order_data['course_id'])->inc('study_num');

                    }else{
                        $UserCourse->class_hour_id = $order_data['class_hour_id'];
                    }
                    $UserCourse->user_id = $order_data['user_id'];
                    $UserCourse->save();
                }
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                file_put_contents('error.txt',$e->getMessage());
                Db::rollback();
            }
        }
    }


    /**
     *  订单--状态筛选
     * @return string
     */
    public function screen_order(){
        $this->auth();
        $user_data = $this->user;//登录用户所有信息
        $data           = Request::get();
        $where['user_id'] = ['user_id','=',$user_data->id];
        if(is_numeric($data['status'])){
            $where['status'] = ['status','=',$data['status']];
        }
        // dump($where);die;
        $order = OrderModel::where($where)->order('id','desc')->with('getCourse')->select();//该用户的订单
        // dump($order);
        if(!$order->isEmpty()){
            return ajax_success($order,'获取用户订单状态信息成功');
        }else{
            return ajax_success($order,'获取用户订单状态信息失败');
        }
    }


    /**
     *  订单--订单详情
     *  weilang 2018/4/11
     * @return string
     */
    public function order_content(){
        $this->auth();
        $this->method();
        $data_get          = Request::get();
        if(!empty($data_get)){
            $data_order = OrderModel::where('order_no',$data_get['order_no'])->find();
            if(!empty($data_order['course_id'])){
                //为课程表
                $data_course = OrderModel::where('order_no',$data_get['order_no'])->with('getCourse')->find();
                if(!empty($data_course)){
                    return ajax_success($data_course,'获取课程信息成功');
                }else{
                    return ajax_error($data_course,'获取课程信息失败');
                }
            }else{
                //为课时表
                $data_class_hour = OrderModel::where('order_no',$data_get['order_no'])->with('getClassHour')->find();
                if(!empty($data_class_hour)){
                    return ajax_success($data_class_hour,'获取课时信息成功');
                }else{
                    return ajax_error($data_class_hour,'获取课时信息失败');
                }
            }
        }else{
            return ajax_error($data_get,'暂无订单');
        }    
    }


}