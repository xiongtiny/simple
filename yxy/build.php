<<<<<<< HEAD
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
    // 生成应用公共文件
    '__file__' => ['common.php'],

    // 定义demo模块的自动生成 （按照实际定义的文件名生成）
    'demo'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'view'],
        'controller' => ['Index', 'Test', 'UserType'],
        'model'      => ['User', 'UserType'],
        'view'       => ['index/index'],
    ],

    // 其他更多的模块定义
];
=======
./configure  \
--prefix=/usr/local/php-5.6.30 \
--with-config-file-path=/usr/local/php-5.6.30/etc \
--with-fpm-user=nginx \
--with-fpm-group=nginx \
--with-bz2 \
--with-curl \
--with-gd \
--with-mcrypt \
--with-openssl \
--with-mhash \
--with-jpeg-dir \
--with-png-dir \
--with-freetype-dir \
--with-iconv-dir=/usr/local/libiconv \
--with-gettext \
--with-libxml-dir=/usr/local \
--with-zlib \
--with-xsl \
--with-pdo-mysql=mysqlnd \
--with-mysql=mysqlnd \
--with-mysqli=mysqlnd \
--with-libdir=lib64 \
--enable-dom \
--enable-xml \
--enable-fpm \
--enable-bcmath \
--enable-ftp \
--enable-sockets \
--disable-ipv6 \
--enable-mbregex \
--enable-mbstring \
--enable-calendar \
--enable-gd-native-ttf \
--enable-static
make
make install
>>>>>>> 22ba0fd1a519f100dbcfa4a8a6268fda5c9e9727
