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
if (in_array(gethostname(), array('zhouyangdeMacBook-Pro.local'))){
    //outsource1
    $s1_hostname   = '127.0.0.1';
    $s1_database   = 'outsource';
    $s1_username   = 'root';
    $s1_password   = '';

    $s1_hostport   = 3306;

    //outsource2
    $s2_hostname   = '127.0.0.1';
    $s2_database   = 'outsource';
    $s2_username   = 'root';
    $s2_password   = '';

    $s2_hostport   = 3306;
}else{
    //outsource1
    $s1_hostname   = '127.0.0.1';
    $s1_database   = 'dev_yhjs_info';
    $s1_username   = 'dev_yhjs_info';
    $s1_password   = 'fGa5aipPrBdSmETw';

    $s1_hostport   = 3306;

    //outsource2
    $s2_hostname   = '127.0.0.1';
    $s2_database   = 'dev_yhjs_info';
    $s2_username   = 'dev_yhjs_info';
    $s2_password   = 'fGa5aipPrBdSmETw';

    $s2_hostport   = 3306;
}


return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    // 应用调试模式
    'app_debug'              => IS_DEBUG,
    // 应用Trace
    'app_trace'              => false,
    // 应用模式状态
    'app_status'             => '',
    // 是否支持多模块
    'app_multi_module'       => true,
    // 入口自动绑定模块
    'auto_bind_module'       => true,
    // 注册的根命名空间
    'root_namespace'         => [],
    // 扩展函数文件
    'extra_file_list'        => [THINK_PATH . 'helper' . EXT],
    // 默认输出类型
    'default_return_type'    => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认时区
    'default_timezone'       => 'PRC',
    // 是否开启多语言
    'lang_switch_on'         => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => '',
    // 默认语言
    'default_lang'           => 'zh-cn',
    // 应用类库后缀
    'class_suffix'           => false,
    // 控制器类后缀
    'controller_suffix'      => false,

    // +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------

    // 默认模块名
    'default_module'         => 'index',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'Index',
    // 默认操作名
    'default_action'         => 'index',
    // 默认验证器
    'default_validate'       => '',
    // 默认的空控制器名
    'empty_controller'       => 'Error',
    // 操作方法后缀
    'action_suffix'          => '',
    // 自动搜索控制器
    'controller_auto_search' => false,

    // +----------------------------------------------------------------------
    // | URL设置
    // +----------------------------------------------------------------------

    // PATHINFO变量名 用于兼容模式
    'var_pathinfo'           => 's',
    // 兼容PATH_INFO获取
    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
    // pathinfo分隔符
    'pathinfo_depr'          => '/',
    // URL伪静态后缀
    'url_html_suffix'        => 'html',
    // URL普通方式参数 用于自动生成
    'url_common_param'       => false,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type'         => 0,
    // 是否开启路由
    'url_route_on'           => true,
    // 路由使用完整匹配
    'route_complete_match'   => false,
    // 路由配置文件（支持配置多个）
    'route_config_file'      => ['route'],
    // 是否强制使用路由
    'url_route_must'         => false,
    // 域名部署
    'url_domain_deploy'      => false,
    // 域名根，如thinkphp.cn
    'url_domain_root'        => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert'            => true,
    // 默认的访问控制器层
    'url_controller_layer'   => 'controller',
    // 表单请求类型伪装变量
    'var_method'             => '_method',
    // 表单ajax伪装变量
    'var_ajax'               => '_ajax',
    // 表单pjax伪装变量
    'var_pjax'               => '_pjax',
    // 是否开启请求缓存 true自动缓存 支持设置请求缓存规则
    'request_cache'          => false,
    // 请求缓存有效期
    'request_cache_expire'   => null,
    // 全局请求缓存排除规则
    'request_cache_except'   => [],

    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------

    'template'               => [
        // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
        // 模板路径
        'view_path'    => '',
        // 模板后缀
        'view_suffix'  => 'html',
        // 模板文件名分隔符
        'view_depr'    => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '{#',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '#}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end'   => '}',
    ],

    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',

    // +----------------------------------------------------------------------
    // | 异常及错误设置
    // +----------------------------------------------------------------------

    // 异常页面的模板文件
    'exception_tmpl'         => IS_DEBUG ? THINK_PATH . 'tpl' . DS . 'think_exception.tpl' :THINK_PATH . 'tpl' . DS . 'error.tpl',//

    // 错误显示信息,非调试模式有效
    'error_message'          => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'         => false,
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => '',

    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------

    'log'                    => [
        // 日志记录方式，内置 file socket 支持扩展
        'type'  => 'File',
        // 日志保存目录
        'path'  => LOG_PATH,
        // 日志记录级别
        'level' => [],
    ],

    // +----------------------------------------------------------------------
    // | Trace设置 开启 app_trace 后 有效
    // +----------------------------------------------------------------------
    'trace'                  => [
        // 内置Html Console 支持扩展
        'type' => 'Html',
    ],

    // +----------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------

//    'cache'                  => [
//        // 驱动方式
//        'type'   => 'File',
//        // 缓存保存目录
//        'path'   => CACHE_PATH,
//        // 缓存前缀
//        'prefix' => '',
//        // 缓存有效期 0表示永久缓存
//        'expire' => 0,
//    ],

    'cache' =>  [
        // 使用复合缓存类型
        'type'  =>  'complex',
        // 默认使用的缓存
        'default'   =>  [
            // 驱动方式
            'type'          => 'File',
            // 缓存保存目录
            'path'          => CACHE_PATH,
        ],
        // 文件缓存
        'file'   =>  [
            // 驱动方式
            'type'          => 'file',
            // 设置不同的缓存保存目录
            'path'          => RUNTIME_PATH . 'file/',
        ],
        // redis缓存
        'redis'   =>  [
            // 驱动方式
            'type'          => 'redis',
            // 服务器地址
            'host'          => '127.0.0.1',
        ],
        // redis缓存
        'memcached'   =>  [
            // 驱动方式
            'type'          => 'memcached',
            // 服务器地址
            'host'          => '127.0.0.1',
        ],
    ],

    // +----------------------------------------------------------------------
    // | 会话设置
    // +----------------------------------------------------------------------

    'session'                => [
        'id'             => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix'         => 'think',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        // 是否自动开启 SESSION
        'auto_start'     => true,
    ],

    //会员等级
    'UserLevel'              =>[
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
    ],
    //激活比例
    'ratio'=>'500',
    //流水记录
    'userlogs'              =>[
        '兑换记录',
        '转账记录',
        '释放记录',
        '释放奖励金额',
        '充值记录',
        '提现记录',
        '互赠记录',
        '激活记录',
        '生成激活卡',
        '释放奖励虚拟币',
        '转tfc记录',
    ],
    //复投兑换比例
    'ft_ratio'=>[
        array(
            'ratio'  => 6.5,
            'release'  => 0.002
        ),
        array(
            'ratio'  => 6,
            'release'  => 0.005
        ),
        array(
            'ratio'  => 5,
            'release'  => 0.008
        ),
        array(
            'ratio'  => 4,
            'release'  => 0.01
        ),
        array(
            'ratio'  => 3,
            'release'  => 0.02
        ),

    ],

    //短信包设置
    'sms'                   =>[
        'smsapi'            => 'http://api.smsbao.com/',
        'user'              => 'DOTON',
        'pass'              => '123456',
    ],
    'seo'                       => array(
        'site_name'         => 'DOTON',
        'site_name_zh'      => 'DOTON',
        'title'             => 'DOTON',
        'keywords'          => 'DOTON',
        'description'       => 'DOTON',
        'copyright'         => 'Copyright &copy; '. (date('Y') == 2018 ? date('Y') : ("2018".'-' . date('Y'))) . ' <a href="/" target="dialog">DATON</a>  | ALL RIGHTS RESERVED',
    ),
    //模板参数替换
    'view_replace_str'          => array(
        '__STATIC__'        => '/static',
        '__PUBLIC__'        => ''

    ),
    // +----------------------------------------------------------------------
    // | Cookie设置
    // +----------------------------------------------------------------------
    'cookie'                 => [
        // cookie 名称前缀
        'prefix'    => '',
        // cookie 保存时间
        'expire'    => 0,
        // cookie 保存路径
        'path'      => '/',
        // cookie 有效域名
        'domain'    => '',
        //  cookie 启用安全传输
        'secure'    => false,
        // httponly设置
        'httponly'  => '',
        // 是否使用 setcookie
        'setcookie' => true,
    ],

    //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 15,
    ],
    'db_outsource1' => [
        // 数据库类型
        'type'        => 'mysql',
        // 服务器地址
        'hostname'    => $s1_hostname,
        // 数据库名
        'database'    => $s1_database,
        // 数据库用户名
        'username'    => $s1_username,
        // 数据库密码
        'password'    => $s1_password,
        //端口
        'hostport'    => $s1_hostport,
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => '',
        // 自动写入时间戳字段
        'auto_timestamp'  => true,
        // 时间字段取出后的默认时间格式
        'datetime_format' => 'Y-m-d H:i:s',
    ],



    'db_outsource2' => [
        // 数据库类型
        'type'        => 'mysql',
        // 服务器地址
        'hostname'    => $s2_hostname,
        // 数据库名
        'database'    => $s2_database,
        // 数据库用户名
        'username'    => $s2_username,
        // 数据库密码
        'password'    => $s2_password,
        //端口
        'hostport'    => $s2_hostport,
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => '',
        // 自动写入时间戳字段
        'auto_timestamp'  => true,
        // 时间字段取出后的默认时间格式
        'datetime_format' => 'Y-m-d H:i:s',
    ],

    //上传配置
    'upload'                    => array(
        'project_icon'      => array(
            'size'      => 1024,                   //允许上传文件大小
            'ext'       => 'jpg,png,jpeg',          //允许上传文件后缀
            'path'      => 'project_icon',          //生成文件路径
            'thumb'     => array(),                 //是否生成缩略图
            'content'   => false,                   //是否获取文件内容
//            'min_width' => 210,                     //最小宽度
//            'min_height'=> 100,                     //最小高度
//            'is_scaling'=> false                    //是否等比缩放
        )
    )
];
