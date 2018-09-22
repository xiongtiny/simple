<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/3/29
 * Time: 下午4:21
 */
use \think\Image;
use app\Models\SendSms;

/**
 * 上传单个图片
 * @param string $size
 * @param string $ext
 * @param string $width
 * @param string $file
 * @param string $height
 * @return array status=>状态 message=>错误或路径
 */
function uploadImageOne($fileName,$size='1',$ext='jpg,png,gif,jpeg',$path='./uploads',$width='150',$height='150'){
    $file=request()->file($fileName);
    if(empty($file)){
        return ['status'=>2,'message'=>"请上传图片"];

    }
    $size=$size*1024*1024;
    $info=$file->validate(['size'=>$size,'ext'=>$ext])->move($path);
//    dump($info);
    if($info){
        $saveName=DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$info->getSaveName();
        $saveName1=".".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$info->getSaveName();
        $image=Image::open($saveName1);
        $image->thumb($width,$height)->save($saveName1);
        return ['status'=>0,'message'=>$saveName];

    }else{
        return ['status'=>1,'message'=>$file->getError()];
    }

/*    $file->validate();*/
}

/**
 * ajax返回正确时调用
 * @param array $data
 * @param string $message
 * @return \think\response\Json
 */
function ajax_success($data=[],$message=''){
    $data1['code']=200;
    $data1['status']='success';
    $data1['data']=$data;
    $data1['message']=$message;
    json($data1, 200, ['Access-Control-Allow-Origin'=> '*','Access-Control-Allow-Headers'=>'Content-type,token,x-requested-with','Access-Control-Expose-Headers'=>'*','Access-Control-Allow-Methods'=>"GET,POST,PUT,DELETE,PATCH,OPTIONS"])->send();
    exit();
}

/**
 * 返回错误时调用
 * @param array $data
 * @param string $message
 * @return \think\response\Json
 */
function ajax_error($data=[],$message=''){
    $data1['code']=400;
    $data1['status']='fail';
    $data1['data']=$data;
    $data1['message']=$message;
    json($data1, 200, ['Access-Control-Allow-Origin'=> '*','Access-Control-Allow-Headers'=>'Content-type,token,x-requested-with','Access-Control-Expose-Headers'=>'*','Access-Control-Allow-Methods'=>"GET,POST,PUT,DELETE,PATCH,OPTIONS"])->send();
    exit();
}

function ajax_error1($data=[],$message=''){
    $data1['code']=402;
    $data1['status']='fail';
    $data1['data']=$data;
    $data1['message']=$message;
    json($data1, 200, ['Access-Control-Allow-Origin'=> '*','Access-Control-Allow-Headers'=>'Content-type,token,x-requested-with','Access-Control-Expose-Headers'=>'*','Access-Control-Allow-Methods'=>"GET,POST,PUT,DELETE,PATCH,OPTIONS"])->send();
    exit();
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
 * @param $fileName
 * @param bool $max
 * @param string $size
 * @param string $ext
 * @param string $path
 * @param string $width
 * @param string $height
 * @return array status=>状态 message=>错误或路径
 */
function uploadsImg($fileName,$max=false,$size='10',$ext='jpg,png,gif,jpeg',$path='./uploads',$width='1000',$height='1000'){
    $files=request()->file($fileName);
    if(is_numeric($max)){
        if(count($files)>$max){
            return ['status'=>1,'message'=>"超过文件上传数"];

        }
    }
    if(empty($files)){
        return ['status'=>2,'message'=>"请上传文件"];
    }
    $size=$size*1024*1024;
    $response['status']=0;
    foreach($files as $file){
        $info=$file->validate(['size'=>$size,'ext'=>$ext])->move($path);
        if($info){
            $saveName=DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$info->getSaveName();
            $saveName1=".".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$info->getSaveName();
            $image=Image::open($saveName1);
            $image->thumb($width,$height)->save($saveName1);
            $response['message'][]=$saveName;
        }
    }

    return $response;

}

/**
 * @param $phone
 * @param int $length
 * @param int $out_time
 * @param int $get_ime
 */
function sendSms($phone,$length=4,$out_time=60,$get_ime=60){
    $code=generate_code($length);

    $sms=SendSms::where("phone",$phone)->order('create_time','desc')->find();
//        dump($sms);
//        exit();
    if(!empty($sms) && strtotime($sms->create_time)+$get_ime>time()){
        ajax_error('',$out_time.'秒内只能获取一次');

    }

     $ch = curl_init();
     // 必要参数
     $apikey =env('API_KEY','d0a614ab1e413bb0ef972f42d88fe57f'); //修改为您的apikey(https://www.yunpian.com)登录官网后获取
     $mobile = $phone; //请用手机号代替
     $text="【中奥互联】您的验证码是".$code."，如非本人操作，请忽略本短信";
     //将验证码存入数据库
     $data['phone'] = $phone;
     $data['code'] = $code;
     $data['create_time'] = time();
     // 发送短信
     $data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
     curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
     curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
     $json_data = curl_exec($ch);
     //解析返回结果（json格式字符串）
     $array = json_decode($json_data,true);
     if(!is_array($array) || $array['code']!=0){
         ajax_error('','验证码发送失败');

     }
    $user=SendSms::create([
        'phone'=>$phone,
        'code'=>$code,
        'code_out_time'=>date("Y-m-d H:i:s",time()+$out_time),
        'is_use'=>0
    ]);

    if(!$user->id){
        ajax_error('','验证码发送失败');

    }
    ajax_success('','验证码发送成功');
}
