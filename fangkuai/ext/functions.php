<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/3/29
 * Time: 下午4:21
 */
use \think\Image;
use \app\model\SendSms;

/**
 * 上传单个图片
 * @param string $size
 * @param string $file
 * @param string $ext
 * @param string $width
 * @param string $height
 * @return array
 */
function picture($fileName,$size='10',$ext='jpg,png,gif,jpeg',$path='./uploads',$width='150',$height='150'){
    if(empty($fileName)){
        return ['status'=>2,'message'=>"请上传图片"];
    }
    $size=$size*1024*1024;
    $info=$fileName->validate(['size'=>$size,'ext'=>$ext])->move($path);
    if($info){
        $saveName=DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$info->getSaveName();
        $saveName1=".".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$info->getSaveName();
        $image=Image::open($saveName1);
        $image->thumb($width,$height)->save($saveName1);
        return ['status'=>0,'message'=>$saveName];
    }else{
        return ['status'=>1,'message'=>$fileName->getError()];
    }
}

/**
 *按json方式输出通信数据
 *@param integer $code 状态码
 *@param string $message 提示信息
 *@param array $data 数据
 *return string 返回值为json
 */
//静态方法，构造json数据
function success($code,$message='',$data=array()){
    header('content-type:application/json');
    $result=array(
        'code'=>$code,
        'message'=>$message,
        'data'=>$data
    );
    echo json_encode($result);
    exit;
}
function error($code,$message=''){
    header('content-type:application/json');
    $result=array(
        'code'=>$code,
        'message'=>$message,
    );
    echo json_encode($result);
    exit;
}
function sendSms($phone,$length=4,$out_time=60,$get_ime=60){
    $code=generate_code($length);
    $sms=SendSms::where("phone",$phone)->order('create_time','desc')->find();

    if(!empty($sms) && strtotime($sms->create_time)+$get_ime>time()){

        error('',$out_time.'秒内只能获取一次');

    }
//    $ch = curl_init();
//    // 必要参数
//    $apikey = "d0a614ab1e413bb0ef972f42d88fe57f"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
//    $code = $this->createSMSCode();
//    $text = "【智行保】您的验证码是".$code."。如非本人操作，请忽略本短信";
//    // 发送短信
//    $data = array('text' => $text, 'apikey' => $apikey, 'mobile' => $phone);
//    curl_setopt($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
//    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    $json_data = curl_exec($ch);
//    //解析返回结果（json格式字符串）
//    $array = json_decode($json_data, true);
//    $array['smsCode'] = $code;
//    echo json_encode($array);
    $user=SendSms::create([
        'phone'=>$phone,
        'code'=>$code,
        'code_out_time'=>date("Y-m-d H:i:s",time()+$out_time),
    ]);
    if(!$user->id){

      
        return error('','验证码发送失败');
    }
    return success('','验证码发送成功');
}
/**
 * 生存验证码
 * @param int $length
 * @return int
 */
function generate_code($length = 4) {
    $min = pow(10 , ($length - 1));
    $max = pow(10, $length) - 1;
    return mt_rand($min, $max);
}

/**
 * 订单号生成
 * @return string
 */
function order_number(){
    $time = date('Ymd', time());
    $number = rand(0000,9999);
    $order_number = $time.$number;
    return  $order_number;
}


/**
 * 获取萤石账户accessToken
 * @return \think\response\Json
 */
function get_token(){
    $url = "https://open.ys7.com/api/lapp/token/get";
    $post = array(
        'appKey'=>'9be0b7911f3440cfb8cb98dea3eafdea',
        'appSecret'=>'0886bd1d4f36e170bc5e61a0ebd03bc7'
    );
    $options = array(
        CURLOPT_RETURNTRANSFER =>true,
        CURLOPT_HEADER =>false,
        CURLOPT_POST =>true,
        CURLOPT_POSTFIELDS => $post,
        CURLOPT_SSL_VERIFYPEER =>false,
    );
    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    return json_decode($result,true)['data']['accessToken'];
}
/**
 * 获取设备播放地址
 * @return \think\response\Json
 */
function get_url(){
    $url = "https://open.ys7.com/api/lapp/live/video/list";
    $accessToken =array(
        'accessToken'=>get_token()
    );
    $options = array(
        CURLOPT_RETURNTRANSFER =>true,
        CURLOPT_HEADER =>false,
        CURLOPT_POST =>true,
        CURLOPT_POSTFIELDS => $accessToken,
        CURLOPT_SSL_VERIFYPEER =>false,



    );
    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    return json_decode($result,true)['data'];
}
