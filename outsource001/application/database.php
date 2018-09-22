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
    $hostname   = '127.0.0.1';
    $database   = 'outsource';
    $username   = 'root';
    $password   = '';
    $hostport   = 3306;
}elseif(gethostname()=="PC-20180820OUWC"){
    $hostname   = '127.0.0.1';
    $database   = '02demo';
    $username   = 'root';
    $password   = 'root';
    $hostport   = 3306;
}elseif(gethostname()=="ebs-56983"){
    $hostname   = '127.0.0.1';
    $database   = 'os_bibashi_cn';
    $username   = 'os_bibashi_cn';
    $password   = 'xyz98765';
    $hostport   = 3306;
}elseif(gethostname()=="DESKTOP-EQ0PN5V"){
    $hostname   = '127.0.0.1';
    $database   = 'os_bibashi_cn';
    $username   = 'root';
    $password   = 'root';
    $hostport   = 3306;
}
else {
    $hostname   = '127.0.0.1';
    $database   = 'one';
    $username   = 'root';
    $password   = '1esaef6e7qblzsix';
    $hostport   = 3306;
}


return [
    // 数据库类型
    'type'            => 'mysql',
    // 服务器地址
    'hostname'       => $hostname,
    // 数据库名
    'database'       => $database,
    // 用户名
    'username'       => $username,
    // 密码
    'password'       => $password,
    // 端口
    'hostport'        => $hostport,
    // 连接dsn
    'dsn'             => '',
    // 数据库连接参数
    'params'          => [],
    // 数据库编码默认采用utf8
    'charset'         => 'utf8',
    // 数据库表前缀
    'prefix'          => '',
    // 数据库调试模式
    'debug'           => true,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy'          => 0,
    // 数据库读写是否分离 主从式有效
    'rw_separate'     => false,
    // 读写分离后 主服务器数量
    'master_num'      => 1,
    // 指定从服务器序号
    'slave_no'        => '',
    // 是否严格检查字段是否存在
    'fields_strict'   => true,
    // 数据集返回类型
    'resultset_type'  => 'array',
    // 自动写入时间戳字段
    'auto_timestamp'  => true,
    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',
    // 是否需要进行SQL性能分析
    'sql_explain'     => false,
];
