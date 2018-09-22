<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
if (! function_exists('pwd_md5')) {
    /**
     * 加密密码
     *
     * @param $pwd
     * @return bool|string
     */
    function pwd_md5($pwd)
    {
        return substr(md5($pwd . MD5_CODE), 0, 10);
    }
}

if (! function_exists('get_binary_status')) {
    /**
     * 获取目标对应状态
     *
     * $stat 状态值
     * $position 对应的第几位标志位
     * return 返回标志位是否为1
     */
    function get_binary_status($stat, $position)
    {
        $t = pow(2, $position - 1);
        return ((int)$stat & $t) == $t;
    }
}
if (! function_exists('set_binary_status')) {
    /**
     * 设置目标对应状态
     *
     * $stat 状态值
     * $position 对应的标志值
     * $val 设置标志位值1或者0
     * return 状态值
     */
    function set_binary_status($stat, $position = 1, $val = 1)
    {
        $t = pow(2, $position - 1);
        return $val == 1 ? ((int)$stat | $t) : ((int)$stat & ~$t);
    }
}

//
if (! function_exists('curl_request')) {
    /**
     * @param $url
     * @param $post_string
     * @param string $method
     * @param int $port
     * @param int $connectTimeout
     * @param int $readTimeout
     * @param null $errmsg
     * @return bool|mixed|string
     */
    function curl_request($url, $post_string = null, $method = "post", $port = 0, $connectTimeout = 1, $readTimeout = 2, &$errmsg = null)
    {
        $method = strtolower($method);

        if ($method == "get") {
            if(is_array($post_string)){
                $url_str = '';
                foreach((array)$post_string as $k => $v){
                    $url_str .= ($url_str ? '&' : '').$k .'='.$v;
                }
                $url = $url . "?" . $url_str;
            }else{
                $url = $url . (!empty($post_string) ? "?" . $post_string : '');
            }
        }

//        echo $url;

        $result = "";
        if (function_exists('curl_init')) {
            $timeout = $connectTimeout + $readTimeout;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));

            curl_setopt($ch, CURLOPT_URL, $url);
            if ($port) {
                curl_setopt($ch, CURLOPT_PORT, $port);
            }
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            //curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            if ($method == "post") {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_string));
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'API PHP5 Client (curl) ' . phpversion());
            $result = curl_exec($ch);
            if (!$result) {
                $errmsg = curl_error($ch);
            }
            curl_close($ch);
        } else {
            $result = false;
            $errmsg = "can not find function curl_init";
        }
        return $result;
    }
}

if (! function_exists('re_curl_request')) {
    /**
     * 请求重试
     *
     * @param $url
     * @param null $post_string
     * @param string $method
     * @param int $re_nums
     * @param int $port
     * @param int $connectTimeout
     * @param int $readTimeout
     * @param null $errmsg
     * @return array|string
     */
    function re_curl_request($url, $post_string = null, $method = "post", $re_nums = 3 , $port = 0, $connectTimeout = 1, $readTimeout = 2, &$errmsg = null)
    {
        $i = 0;

        $ret_arr    = array();

        while(1){

            if($i >= $re_nums){
                break;
            }

            $ret        = curl_request($url, $post_string, $method, $port, $connectTimeout, $readTimeout, $errmsg);
            $ret_arr    = json_encode($ret);

            if(empty($ret_arr) || !is_array($ret_arr)){
                $i++;
            }

        }

        return $ret_arr;
    }
}



if (! function_exists('array_index_value')) {
    /**
     * 重组数组的结构(二维数组)
     *
     * @param $arr
     * @param null $find_index
     * @param null $value_index
     * @param null $operation
     * @return mixed|null|number
     */
    function array_index_value($arr, $find_index = null, $value_index = null, $operation = null)
    {
        if(empty($arr)){
            return array();
        }
        $ret = null;
        $names = @array_reduce($arr, create_function('$v,$w', '$v['.($find_index ? '$w['.$find_index.']' : '').']='.($value_index ? '$w['.$value_index.']' : '$w').';return $v;'));

        switch($operation){
            case 'sum':
                $ret = array_sum($names);
                break;
            default:
                $ret = $names;
                break;
        }
        return $ret;
    }
}

if (! function_exists('diff_days')) {
    /**
     * 相差天数
     *
     * @param $day1
     * @param $day2
     * @return float
     */
    function diff_days($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }

        return ($second1 - $second2) / 86400;
    }
}

if (! function_exists('ip_filter')) {
    /**
     * ip/ip段验证过滤
     *
     * @param $ip
     * @param $ip_arr
     *                 array('123.12.*.*','22.18.10.*', '192.168.8.821')
     * @return int
     */
    function ip_filter($ip, $ip_arr)
    {
        $ipregexp = implode('|', str_replace(array('*', '.'), array('\d+', '\.'), $ip_arr));
        return preg_match("/^(" . $ipregexp . ")$/", $ip);
    }
}

if (! function_exists('array_sort')) {
    /**
     * 对二维数组,按第二维数组中的某个键值对进行排序
     *
     * @param array $arr 二维数组如 array('0'=> array('v_title' => 'title2','v_image'=>'image2','v_sort'=>'sort2'),'1'=>array('v_title' => 'title1','v_image'=>'image1','v_sort'=>'sort1'))
     * @param string 二维数组中的某个键值对 如（v_sort）
     * @param int $sort_flags 排序方式 0:升序，1:降序
     * @return array 排序后的数二维数组
     * @date 2011-09-22
     * @ + 增加一个排序方式，
     */
    function array_sort($arr, $field, $sort_flags =0)
    {
        $sort_tmp =array();
        $arr_tmp  =array();
        foreach ($arr as $key=>$value) {
            $sort_tmp[$key]=$value[$field];//取出排列顺序字段
        }
        asort($sort_tmp);//按值排序，保留键的对应,可校正排序相同的情况
        foreach ($sort_tmp as $k=>$v) {
            $arr_tmp[] = $arr[$k] ;
        }
        return $sort_flags ? array_reverse($arr_tmp): $arr_tmp ;
    }
}

if (! function_exists('alert')) {
    /**
     * php 弹窗方法 跳转方法
     *
     * @param $msg
     * @param null $url
     */
    function alert($msg, $url = null)
    {
        $str = '<script type="text/javascript">alert("' . $msg . '");  ' . ($url ? 'window.location.href ="' . $url . '"' : '') . '</script>';

        echo $str;exit;
    }
}



if (! function_exists('client_ip')) {
    /**
     * 获取IP地址
     * @return string
     */
    function client_ip()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');

        } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

if (! function_exists('rand_str')) {
    /**
     * 随机字符串
     *
     * @param int $len
     * @param string $format
     * @return string
     */
    function rand_str($len = 6, $format = 'number')
    {
        $is_abc = $is_numer = 0;
        $str = $tmp = '';

        $format = strtolower($format);

        switch ($format) {
            case 'char':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                break;
            case 'number':
                $chars = '0123456789';
                break;
            default :
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                break;
        }
        mt_srand((double)microtime() * 1000000 * getmypid());
        while (strlen($str) < $len) {
            $tmp = substr($chars, (mt_rand() % strlen($chars)), 1);
            if (($is_numer <> 1 && is_numeric($tmp) && $tmp > 0) || $format == 'char') {
                $is_numer = 1;
            }
            if (($is_abc <> 1 && preg_match('/[a-zA-Z]/', $tmp)) || $format == 'number') {
                $is_abc = 1;
            }
            $str .= $tmp;
        }
        if ($is_numer <> 1 || $is_abc <> 1 || empty($str)) {
            $str = rand_str($len, $format);
        }
        return $str;
    }
}
if (! function_exists('mkdirs')) {
    /**
     * 创建多级目录
     *
     * @param $path
     * @return bool
     */
    function mkdirs($path)
    {
        if (!is_dir($path)) {
            mkdirs(dirname($path));
            if (!mkdir($path, 0777)) {
                return false;
            }
        }
        return true;
    }
}

if (! function_exists('save_base64_img')) {
    /**
     * base64转换
     * @param $base64 编码
     * @param string $path 路径
     * @return bool|string
     * @param string $file_name 文件名称
     * @return [type] [description]
     */
    function save_base64_img($base64, $path = 'icon', $file_name = null)
    {

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)) {

            $type = $result[2];

            $file_path = STATIC_PATH . 'upload' . DS . $path . DS . ($file_name ? substr($file_name,0,2).DS.substr($file_name,2,2).DS : '');

            mkdirs($file_path);


            $file_name = ($file_name ? $file_name : md5(time())) . ".{$type}";

            if (file_put_contents($file_path . $file_name, base64_decode(str_replace($result[1], '', $base64)))) {
                return $path . DS  . ($file_name ? substr($file_name,0,2).DS.substr($file_name,2,2).DS : '') . $file_name;
            } else {
                return false;
            }

        }

    }
}


    /**
     * base64转换
     * @param $base64 编码
     * @param string $path 路径
     * @return bool|string
     * @param string $file_name 文件名称
     * @return [type] [description]
     */
    function save_base64_cover_img($base64, $path = 'icon', $file_name = null)
    {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)) {
            $type = $result[2];
            $file_name =md5(time()). ".{$type}";
            $file_path = STATIC_PATH . 'upload' . DS . $path . DS . ($file_name ? date('Y-m-d',time()).DS : '');

            mkdirs($file_path);

            if (file_put_contents($file_path . $file_name, base64_decode(str_replace($result[1], '', $base64)))) {
                return $path . DS  . ($file_name ? date('Y-m-d',time()).DS : '') . $file_name;
            } else {
                return false;
            }

        }
    }

/**
 * 图片转换
 * @param $img
 * @return string
 */
function cover_path($img)
{
    $path = request()->domain(). '/static/upload/' . strtr($img, "\\", "/");
    empty($img) &&$path ="";
    return $path."?v=".rand();
}

/**
 * 获取配置比例
 * @param $assets
 * @return mixed
 */
function exchange_ft_ratio($assets){
    $index  = 0;

   if($assets<100000)
   {
       $index=0;
   }elseif($assets>100000 && $assets<=500000)
   {
       $index=1;
   }elseif($assets>500000 && $assets<=1000000)
   {
       $index=2;
   }elseif($assets>1000000 && $assets<=3000000)
   {
       $index=3;
   }elseif($assets>3000000)
   {
       $index=4;
   }

    $config = config('ft_ratio');
    return $config[$index];
}

if (! function_exists('gen_safe_sign')) {
    /**
     * 生成 sign code
     *
     * @param $params
     * @param $prikey
     * @param null $query_string2
     * @return string
     */
    function gen_safe_sign($params, $prikey, &$query_string2 = null)
    {
        ksort($params);
        $query_string = array();
        $query_string2 = array();
        foreach ($params as $key => $val) {
            if ($key == "sig" || $key == "sign") {
                continue;
            }
            array_push($query_string, $key . '=' . $val);
            array_push($query_string2, $key . '=' .rawurlencode($val));//
        }
        $query_string = join('&', $query_string);
        $query_string2 = join('&', $query_string2);
        $sign = md5($prikey . $query_string);
        $query_string2 .= "&sign=" . $sign;
        return $sign;
    }
}

if (! function_exists('check_sign_code')) {
    /**
     * 验证 sign code
     *
     * @param $params
     * @param $prikey
     * @return bool
     */
    function check_sign_code($params, $prikey)
    {
        $real_code = gen_safe_sign($params, $prikey);
//        echo $real_code;
        if (empty($params['sign']) || $params['sign'] != $real_code) {
            return false;
        }

        return true;
    }
}


if (! function_exists('my_substr')) {
    /**
     * 字符串截取
     *
     * @param $string
     * @param int $start
     * @param int $sublen
     * @param string $tip
     * @return string
     */
    function my_substr($string, $start = 0, $sublen = 0, $tip=''){
        $str=' ';

        if(strlen($string)>$sublen){
            for($i=$start;$i<$sublen;$i++){
                if(ord(substr($string,$i,1))>0xa0){//0xa0代表中文字符的开始
                    if($i+2<strlen($string)){
                        $str.=substr($string,$i,3);
                        $i+=2;
                    }
                }else{
                    $str.=substr($string,$i,1);
                }
            }
            return $str.$tip;
        }else{
            $str=$string;
            return $str;
        }
    }
}



if (! function_exists('birthday_to_age')) {
    /**
     * 用户生日转换成年龄
     *
     * @param $birthday
     * @return false|string
     */
    function birthday_to_age($birthday)
    {
        $birthday   = strtotime($birthday);
        $age = date('Y') - date('Y', $birthday) - 1;

        if (date('m') == date('m', $birthday)) {
            if (date('d') > date('d', $birthday)) {
                $age++;
            }
        } elseif (date('m') > date('m', $birthday)) {
            $age++;
        }

        return $age;
    }
}
//if (! function_exists('cover_path')) {
//
//    /**
//     * 图片路径
//     *
//     * @param $img
//     * @return string
//     */
//    function cover_path($img)
//    {
//        $path = request()->domain() . '/uploads/' . strtr($img, "\\", "/");
//        if (empty($img)) {
//            $path = "";
//        }
//        return $path;
//    }
//}

if (! function_exists('jsons_string')) {
    /**
     * json转字符串
     *
     * @param $str
     * @return mixed
     */
    function json_string($str)
    {
        return preg_replace("/([\\\\\/'])/", '\\\$1', $str);
    }
}

if (! function_exists('format_bytes')) {
    /**
     * 格式化文件大小
     *
     * @param $bytes
     * @return string
     */
    function format_bytes($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = round($bytes / 1073741824 * 100) / 100 . 'GB';
        } elseif ($bytes >= 1048576) {
            $bytes = round($bytes / 1048576 * 100) / 100 . 'MB';
        } elseif ($bytes >= 1024) {
            $bytes = round($bytes / 1024 * 100) / 100 . 'KB';
        } else {
            $bytes = $bytes . 'Bytes';
        }
        return $bytes;
    }
}
