<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/19
 * Time: 11:52
 */

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

if (! function_exists('site_url')) {
    /**
     * 拼接链接地址
     *
     * @param $controller
     * @param $action
     * @param $params
     * @return string
     */
    function site_url($controller = null, $action = null, $params = array())
    {
        $url_str = '';

        $controller = $controller ? $controller : 'Index';
        $action     = $action ? $action : 'index';

        foreach ((array)$params as $k => $v) {
            $url_str .= '&'.$k.'='.$v;
        }

        $url_str .= IS_DEBUG ? '&'.'debug=1' : '';

        return '?s='.($controller.'/'.$action).$url_str;
    }
}

if (! function_exists('verify_mobile')) {
    /**
     * 验证手机号码
     *
     * @param $mobile
     * @return bool
     */
    function verify_mobile($mobile)
    {
        if (preg_match("/^1[34578]{1}[0-9]{1}[0-9]{8}$/", $mobile)) {
            return true;
        }

        return false;
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
        $names = @array_reduce($arr, @create_function('$v,$w', '$v['.($find_index ? '$w['.$find_index.']' : '').']='.($value_index ? '$w['.$value_index.']' : '$w').';return $v;'));

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

if (! function_exists('site_server_addr')) {
    /**
     * 当前站点环境
     *
     * @return string
     */
    function site_server_addr()
    {
        $ip = $_SERVER['SERVER_ADDR'];

        $ip_arr = array(
            '127.0.0.1'         => '本机开发'
        );

        $css_url    = '/static/dwz/themes/default/images/listLine_none.png';

        return '<li style=\'background: url("'.$css_url.'") no-repeat scroll 0 0 rgba(0, 0, 0, 0);color: #ff0000\'><a href="#" title="'.$ip.'" style="color:red">'.(isset($ip_arr[$ip]) ? $ip_arr[$ip] : $ip).'环境</a></li>';
    }
}

if (! function_exists('rand_str')) {
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

if (! function_exists('cate_sidebar_child')) {
    /**
     * 格式化成菜单树
     *
     * @param $data
     * @param $admin_user_cate_ids
     * @return string
     */
    function cate_sidebar_child($data, $admin_user_cate_ids)
    {
        $data = array_sort($data, 'rank');
        $html = '';
        foreach ($data as $k => $v) {
            if ($v['status'] == 2 && in_array($v['id'], $admin_user_cate_ids)) {
                if (isset($v['son'])) {   //父亲找到儿子
                    if($v['url']){
                        $html .= '<li><a href="?s=' . $v['url'] . '&debug=1" target="navTab" rel="' . $v['rel'] . '">' . $v['name'] . '</a></li>';
                    }else{
                        $html .= '<li><a>' . $v['name'] . '</a>';
                        $html .= cate_sidebar_child($v['son'], $admin_user_cate_ids);
                        $html .= '</li>';
                    }
                } else {
                    if(!empty($v['link']))
                    {
                        $html .= '<li><a href="' . $v['link'] . '" target="navTab" rel="' . $v['rel'] . '">' . $v['name'] . '</a></li>';
                    }else
                    {
                        $html .= '<li><a href="?s=' . $v['url'] . '&debug=1" target="navTab" rel="' . $v['rel'] . '">' . $v['name'] . '</a></li>';
                    }
                }
            }
        }
        return '<ul>' . $html . '</ul>';
    }
}

if (! function_exists('cate_sidebar')) {
    /**
     * 显示左侧菜单
     *
     * @param $cates
     * @param $admin_user_cate_ids
     * @return string
     */
    function cate_sidebar($cates, $admin_user_cate_ids = array())
    {
        $html = '<div class="accordion" fillSpace="sidebar">';

        foreach ((array)$cates as $value) {
            if ($value['status'] && in_array($value['id'], $admin_user_cate_ids)) {
                $html .= '<div class="accordionHeader">';
                $html .= '<h2><span>Folder</span>' . $value['name'] . '</h2>';
                $html .= '</div>';
                $html .= '<div class="accordionContent">';
                $html .= '<ul class="tree treeFolder expand">';
                if (isset($value['son'])) {
                    $html .= substr(substr(cate_sidebar_child($value['son'], $admin_user_cate_ids), 4), 0, -5);
                }
                $html .= '</ul>';
                $html .= '</div>';
            }
        }

        $html .= '</div>';

        return $html;
    }
}

if (! function_exists('parent_cate')) {
    /**
     * 格式话成多选菜单列表
     *
     * @param $data
     * @return string
     */
    function parent_cate($data)
    {
        $data = array_sort($data, 'left_value');
        $html = '';
        foreach ($data as $k => $v) {
            $title_tips = '';
            if (isset($v['son'])) {   //父亲找到儿子
                $html .= '<li><a tname="cate_ids" tvalue="' . $v['id'] . '">' . $v['name'] . $title_tips . '</a>';
                $html .= parent_cate($v['son']);
                $html .= '</li>';
            } else {
                $html .= '<li><a tname="cate_ids" tvalue="' . $v['id'] . '">' . $v['name'] . $title_tips . '</a></li>';
            }
        }
        if (!empty($html)) {
            return '<ul>' . $html . '</ul>';
        }
        return '';
    }
}

if (! function_exists('cate_role')) {
    /**
     * 格式化成菜单树
     *
     * @param $data
     * @param $cate_ids
     * @return string
     */
    function cate_role($data, $cate_ids)
    {
        $data = array_sort($data, 'rank');
        $html = '';
        foreach ($data as $k => $v) {
            if (isset($v['son'])) {   //父亲找到儿子
                $checked = in_array($v['id'], $cate_ids) ? 'checked="true"' : '';
                $html .= '<li><a tname="cate_ids" tvalue="' . $v['id'] . '" ' . $checked . '>' . $v['name'] . '</a>';
                $html .= cate_role($v['son'], $cate_ids);
                $html .= '</li>';
            } else {
                $checked = in_array($v['id'], $cate_ids) ? 'checked="true"' : '';
                $html .= '<li><a tname="cate_ids" tvalue="' . $v['id'] . '" ' . $checked . '>' . $v['name'] . '</a></li>';
            }
        }
        return '<ul>' . $html . '</ul>';
    }
}

if (! function_exists('cate_user')) {
    /**
     * 格式化成菜单树
     *
     * @param $data
     * @param $user_cate_ids
     * @return string
     */
    function cate_user($data, $user_cate_ids)
    {
        $data = array_sort($data, 'rank');
        $html = '';
        foreach ($data as $k => $v) {
            if (isset($v['son'])) {   //父亲找到儿子
                $checked = in_array($v['id'], $user_cate_ids) ? 'checked="true"' : '';
                $html .= '<li><a tname="cate_ids" tvalue="' . $v['id'] . '" ' . $checked . '>' . $v['name'] . '</a>';
                $html .= cate_user($v['son'], $user_cate_ids);
                $html .= '</li>';
            } else {
                $checked = in_array($v['id'], $user_cate_ids) ? 'checked="true"' : '';
                $html .= '<li><a tname="cate_ids" tvalue="' . $v['id'] . '" ' . $checked . '>' . $v['name'] . '</a></li>';
            }
        }
        return '<ul>' . $html . '</ul>';
    }
}

if (! function_exists('page')) {
    /**
     * 分页导航
     *
     * @param array $pages
     * @return string
     */
    function page($pages = array()){

        if(empty($pages)){
            $page           = 1;
            $total_pages    = 0;
            $total_rows     = 0;
            $page_list      = DEFAULT_PAGE;
        }else{
            $page           = $pages['page'];
            $total_pages    = $pages['total_pages'];
            $total_rows     = $pages['total_rows'];
            $page_list      = $pages['page_list'];
        }

        $html  = '<div class="panelBar">
                    <div class="pages">
                        <span>显示</span>
                        <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
                            <option value="10" '.($page_list == 10 ? 'selected' : '').'>10</option>
                            <option value="30" '.($page_list == 30 ? 'selected' : '').'>30</option>
                            <option value="50" '.($page_list == 50 ? 'selected' : '').'>50</option>
                            <option value="100" '.($page_list == 100 ? 'selected' : '').'>100</option>
                            <option value="200" '.($page_list == 200 ? 'selected' : '').'>200</option>
                            <option value="500" '.($page_list == 500 ? 'selected' : '').'>500</option>
                        </select>
                        <span>条，共'.$total_pages.'页，'.$total_rows.'条数据</span>
                    </div>
                    <div class="pagination"
                         targetType="navTab"
                         totalCount="'.$total_rows.'"
                         numPerPage="'.$page_list.'"
                         pageNumShown="5"
                         currentPage="'.$page.'">
                         
                    </div>
                </div>';


        return $html;

    }
}

if (! function_exists('dialog_page')) {
    /**
     * 弹框分页导航
     *
     * @param array $pages
     * @return string
     */
    function dialog_page($pages = array()){

        if(empty($pages)){
            $page           = 1;
            $total_pages    = 0;
            $total_rows     = 0;
            $page_list      = DEFAULT_PAGE;
        }else{
            $page           = $pages['page'];
            $total_pages    = $pages['total_pages'];
            $total_rows     = $pages['total_rows'];
            $page_list      = $pages['page_list'];
        }

        $html  = '<div class="panelBar">
                    <!--<div class="pages">
                        <span>显示</span>
                        <select class="combox" name="numPerPage" onchange="dwzPageBreak({targetType:\'dialog\', numPerPage:this.value})">
                            <option value="10" '.($page_list == 10 ? 'selected' : '').'>10</option>
                            <option value="30" '.($page_list == 30 ? 'selected' : '').'>30</option>
                            <option value="50" '.($page_list == 50 ? 'selected' : '').'>50</option>
                            <option value="100" '.($page_list == 100 ? 'selected' : '').'>100</option>
                            <option value="200" '.($page_list == 200 ? 'selected' : '').'>200</option>
                            <option value="500" '.($page_list == 500 ? 'selected' : '').'>500</option>
                        </select>
                        <span>条，共'.$total_pages.'页，'.$total_rows.'条数据</span>
                    </div>-->
                    <div class="pagination"
                         targetType="dialog"
                         totalCount="'.$total_rows.'"
                         numPerPage="'.$page_list.'"
                         pageNumShown="5"
                         currentPage="'.$page.'">
                         
                    </div>
                </div>';


        return $html;

    }
}

if (! function_exists('upload_move_path')) {
    /**
     * 上传保存文件路径
     *
     * @param string $flag
     * @param null $flag_id
     * @return string
     */
    function upload_move_path($flag = '', $flag_id = null){
        $path   = '';

        switch ($flag){
            case 'brand_logo':
            case 'commodity_from_logo':
            case 'commodity_type_icon_bright':
            case 'commodity_type_icon_dark':
            case 'user_avatar':
            case 'commodity_component_image':
            case 'commodity_model_image':
                $path   = DS . $flag;
                break;
            case 'ueditor':
                $path   = DS . $flag;
                break;
            case 'common':
                $path   = DS . $flag;
                break;
        }

        return $path;
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

if (! function_exists('format_status_show')) {
    /**
     * 格式显示状态方法
     *
     * @param $status
     * @param string $controller
     * @param bool $is_color
     * @param bool $show_all
     * @return string
     */
    function format_status_show($status, $controller = '', $is_color = false, $show_all = false, $is_tips = true, $change_show = false)
    {
        if($is_color){
            switch ($status){
                case 0:
                    return 'red';
                    break;
                case 1:
                    return 'blue';
            }

            return 'black';
        }

        $arr    = array(0   => '禁用', 1  => '启用');
        $arr1   = array(0   => '禁用', 1  => '启用');

        switch (strtolower($controller)){
            case 'comment_report':
                $arr    = array(0 => '未处理', 1 => '无效举报', 2 => '点评被禁用');
                break;
            case 'comment':
                $arr   = array(0   => '不显示', 1  => '&nbsp;&nbsp;显示&nbsp;&nbsp;');
                break;
            case 'brandmessage':
            case 'systemmessage':
                $arr    = array(0   => '未发送', 1  => '已发送');
                $arr1   = array(0   => '未发送', 1  => '已发送');
                break;
            case 'posttype':
                $arr    = array(0   => '不在线', 1  => '在线上');
                break;
            case 'commodity':
                $arr1   = array(0   => '不在线', 1  => '在线上');
                break;
            case 'brand':
                $arr1    = array(0   => '不显示', 1  => '&nbsp;&nbsp;显示&nbsp;&nbsp;');
                break;
            case 'post_top':
                $arr    = array(0   => '取消', 1  => '置顶');
                $arr1   = array(0   => '未置顶', 1  => '&nbsp;&nbsp;置顶nbsp;&nbsp;');
                break;
        }

        if($change_show){
            return $arr[$status];
        }

        if($status == 1){
            $show_str   = '<font style="color: green;width: 30px">'.$arr1[1].'</font>&nbsp;&nbsp;&nbsp;&nbsp;';
            $str        = '<font data-tips = "1" style="cursor: pointer;padding-top: 4px;">'.$arr[0].'</font>';
            $flag       = $arr[0];
        }else{
            $show_str   = '<font style="color: black;width: 30px">'.$arr1[0].'</font>&nbsp;&nbsp;&nbsp;&nbsp;';
            $str        = '<font data-tips = "1" style="cursor: pointer;padding-top: 4px;">'.$arr[1].'</font>';
            $flag       = $arr[1];
        }

        if(in_array(strtolower($controller), array('brandmessage', 'systemmessage'))){
            if($status == 1){
                $show_str    = '';
                $str         = $arr[$status];
                $flag        = $arr1[$status];
            }else{
                $show_str    = '';
                $str         = '<font data-tips = "1" style="cursor: pointer;padding-top: 4px;">'.$arr[0].'</font>';
                $flag        = '';
            }
        }

        return ($show_all ? $show_str : '').($is_tips ? ($str) : ($flag));
    }
}

if (! function_exists('format_post_show')) {
    /**
     * 帖子格式显示状态方法
     *
     * @param $status
     * @param string $controller
     * @param bool $is_color
     * @param bool $show_all
     * @return string
     */
    function format_post_show($status, $controller = '', $is_color = false, $show_all = false)
    {

        if($is_color){
            switch ($status){
                case 0:
                    return 'red';
                    break;
                case 1:
                    return 'blue';
            }

            return 'black';
        }

        switch (strtolower($controller)) {
            case 'post_top':
                $arr    = array(0   => '取消', 1  => '置顶');
                $arr1   = array(0   => '未置顶', 1  => '&nbsp;&nbsp;置顶&nbsp;&nbsp;');
                break;
            case 'post':
                $arr    = array(0   => '下线', 1  => '发布');
                $arr1   = array(0   => '未发布', 1  => '已发布');
                break;
        }


        if($status == 1){
            $show_str   = '<font style="color: green">'.$arr1[1].'</font>&nbsp;&nbsp;&nbsp;&nbsp;';
            $str        = '<font data-tips = "1" style="cursor: pointer">'.$arr[0].'</font>';
        }else{
            $show_str   = '<font style="color: black">'.$arr1[0].'</font>&nbsp;&nbsp;&nbsp;&nbsp;';
            $str        = '<font data-tips = "1" style="cursor: pointer">'.$arr[1].'</font>';
        }

        return ($show_all ? $show_str : '').$str;
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


//if (! function_exists('format_time_to_date')) {
//    /**
//     * 用户生日转换成年龄
//     *
//     * @param $birthday
//     * @return false|string
//     */
//    function format_time_to_date($time)
//    {
//        return $time;
//        //return date('Y-m-d H:i:s', $time);
//    }
//}


