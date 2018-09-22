<?php
namespace app\index\controller\v1;

use app\model\IndexImage;
use app\model\User;
use app\model\Grade;
use app\model\Course;
use app\model\News as NewsModel;
use app\plugins\alipay\AopClient;
use app\plugins\alipay\request\AlipayTradeWapPayRequest;
use app\facade\Jwt;
use Request;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;

class Index
{
    public function index(){
        $app =new Application(config('wechat.'));
        $payment =$app->payment;
        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => 'iPad mini 16G 白色',
            'detail'           => 'iPad mini 16G 白色',
            'out_trade_no'     => '1217752501201407033233368018',
            'total_fee'        => 5388, // 单位：分
            'notify_url'       => 'http://xxx.com/order-notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];

        $order = new Order($attributes);
        $result = $payment->pay($order);

//        $aop=new AopClient();
        $request = new AlipayTradeWapPayRequest ();
        $request->setNotifyUrl('请填写您的异步通知地址');
//        $request->setBizContent('{"product_code":"FAST_INSTANT_TRADE_PAY","out_trade_no":"20150320010101001","subject":"Iphone6 16G","total_amount":"88.88","body":"Iphone6 16G"}');




    }

    /**
     * 首页图片
     * @return string
     */
    public function IndexImage(){
        $IndexImage = IndexImage::where('status',1)->order('id','desc')->limit(3)->select();
        if(!$IndexImage->isEmpty()){
            return ajax_success($IndexImage,'获取图片成功');
        }else{
            return ajax_error($IndexImage,'暂无图片信息');
        }
    }

    /**
     * 首页课程推荐
     * weilang 2018/4/11
     * @return string
     */
    public function index_course(){
        $data           = Request::post();
        if(!empty($data)){
            $where['grade'] = $data['grade'];//前端传过来的年级id
            $grade = Grade::where($where)->find();//通过查询年级表获取年级信息
            $index_course = Course::where('grade_id',$grade)->order('id','desc')->limit(3)->select();
            foreach ($index_course as $key => $value) {
                $start_time = strtotime($value['start_time']);
                $index_course[$key]['start_time_md'] = date('n月j日',$start_time);
                $aa = date('w',$start_time);
                if($aa == 0){$index_course[$key]['start_time_w'] = '日';}
                if($aa == 1){$index_course[$key]['start_time_w'] = '一';}
                if($aa == 2){$index_course[$key]['start_time_w'] = '二';}
                if($aa == 3){$index_course[$key]['start_time_w'] = '三';}
                if($aa == 4){$index_course[$key]['start_time_w'] = '四';}
                if($aa == 5){$index_course[$key]['start_time_w'] = '五';}
                if($aa == 6){$index_course[$key]['start_time_w'] = '六';}
                $index_course_start_time1 = date('G:i',$start_time);
                $index_course_start_time2 = date('G:i',$start_time+5400);
                $index_course[$key]['start_time_end'] = $index_course_start_time1.'-'.$index_course_start_time2;
            }
        }else{
            $index_course = Course::order('id','desc')->limit(3)->select();
            foreach ($index_course as $key => $value) {
                $start_time = strtotime($value['start_time']);
                $index_course[$key]['start_time_md'] = date('n月j日',$start_time);
                $aa = date('w',$start_time);
                if($aa == 0){$index_course[$key]['start_time_w'] = '日';}
                if($aa == 1){$index_course[$key]['start_time_w'] = '一';}
                if($aa == 2){$index_course[$key]['start_time_w'] = '二';}
                if($aa == 3){$index_course[$key]['start_time_w'] = '三';}
                if($aa == 4){$index_course[$key]['start_time_w'] = '四';}
                if($aa == 5){$index_course[$key]['start_time_w'] = '五';}
                if($aa == 6){$index_course[$key]['start_time_w'] = '六';}
                $index_course_start_time1 = date('G:i',$start_time);
                $index_course_start_time2 = date('G:i',$start_time+5400);
                $index_course[$key]['start_time_end'] = $index_course_start_time1.'-'.$index_course_start_time2;
            }
        }
        if(!$index_course->isEmpty()){
            return ajax_success($index_course,'获取课程成功');
        }else{
            return ajax_error($index_course,'暂无课程信息');
        }
    }



    /**
     * 首页新闻咨询
     * weilang 2018/4/11
     * @return string
     */
    public function index_news(){
        $index_news = NewsModel::order('id','desc')->limit(5)->select();
        if(!$index_news->isEmpty()){
            return ajax_success($index_news,'获取新闻成功');
        }else{
            return ajax_error($index_news,'暂无新闻信息');
        }
    }


}
