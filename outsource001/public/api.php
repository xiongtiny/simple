<?php
header("Content-Type:text/html; charset=utf-8");
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

defined('IS_DEBUG')                 || define('IS_DEBUG',               true);

if(IS_DEBUG == true){

    if(function_exists('xhprof_enable')){
        include_once  "static/xhprof/xhprof_lib/utils/xhprof_lib.php";
        include_once "static/xhprof/xhprof_lib/utils/xhprof_runs.php";
        xhprof_enable();

        //开启xhprof
        xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

        //注册一个函数，当程序执行结束的时候去执行它。
        register_shutdown_function(function () {
            $xhprof_data = xhprof_disable();

            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            }

            $xhprof_runs = new XHProfRuns_Default();

            $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_yhjs_api");
        });
    }

}

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
