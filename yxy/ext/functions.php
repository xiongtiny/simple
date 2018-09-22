<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/3/29
 * Time: 下午4:21
 */
use \think\Image;
use app\model\SendSms;

/**
 * 上传单个图片
 * @param string $size
 * @param string $ext
 * @param string $file
 * @param string $width
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
function uploadsImg($fileName,$max=false,$size='10',$width='1000',$height='1000',$ext='jpg,png,gif,jpeg',$path='./uploads'){
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
     $apikey = "d0a614ab1e413bb0ef972f42d88fe57f"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
     $mobile = $phone; //请用手机号代替
     $text="【悦学优】您的验证码是".$code."，如非本人操作，请忽略本短信";
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
     if(!$array){
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



/**
 * 保存64位编码图片
 */

function saveBase64ImageOne($base64_image_content,$width='100',$height='200'){

    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){

        //图片后缀
        $type = $result[2];

        //保存位置--图片名
        $image_name=date('His').str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT).".".$type;
        $saveName='/uploads/'.date('Ymd').'/'.$image_name;
        $image_url = env('root_path').'/public'.$saveName;
        if(!is_dir(dirname('.'.$image_url))){
            mkdir(dirname('.'.$image_url));
            chmod(dirname('.'.$image_url), 0777);
            umask($oldumask);

        }

        //解码
        $decode=base64_decode(str_replace($result[1], '', $base64_image_content));
        if (file_put_contents($image_url, $decode)){


            $image=Image::open($image_url);
            $image->thumb($width,$height)->save($image_url);
            return ['status'=>0,'message'=>$saveName];
        }else{
            return ['status'=>1,'message'=>'图片保存失败'];

        }
    }else{
        return ['status'=>2,'message'=>'base64图片格式有误'];



    }

}




/**
 * 保存64位编码图片
 */

function saveBase64Images($base64_image_contents,$width='100',$height='200'){
    $response['status']=0;
    $base64_image_contents=request()->post($base64_image_contents);
    if(request()->post($base64_image_contents)){
        return ['status'=>1,'message'=>"无上传图片"];
    }
    foreach($base64_image_contents as $img) {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)) {
            //图片后缀
            $type = $result[2];

            //保存位置--图片名
            $image_name = date('His') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT) . "." . $type;
            $image_url1 = '/uploads/' . date('Ymd') . '/' ;
            $image_url = env('root_path') . '/public' . $image_url1;
            $img_1=$image_url.$image_name;
            if (!is_dir(dirname( $image_url))) {
                mkdir(dirname( $image_url));
                chmod(dirname($image_url), 0777);
                umask($oldumask);

            }

            //解码
            $decode = base64_decode(str_replace($result[1], '', $img));
            if (file_put_contents($img_1, $decode)) {

                $image = Image::open($img_1);
                $image->thumb($width, $height)->save($img_1);
                $response['message'][]=$image_url1.$image_name;
            }
        }
    }

    return $response;
}