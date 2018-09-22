<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


return [
//    'api/:version/:controller'=>'index/:version.:controller/index',// 省略方法名时
    'api/:version/:controller/:function'=>'index/:version.:controller/:function',// 有方法名时
    'admin/:version/:controller/:function'=>'admin/:version.:controller/:function',// 有方法名时
    'api/:controller/:function'=>'index/:controller/:function',// 有方法名时
    /*
     * 例如访问v1下面等student控制器下index方法
     * http://xxx/api/v1/student/index
     * */
];

