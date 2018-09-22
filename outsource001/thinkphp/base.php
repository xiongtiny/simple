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

define('THINK_VERSION', '5.0.20');
define('THINK_START_TIME', microtime(true));
define('THINK_START_MEM', memory_get_usage());
define('EXT', '.php');
define('DS', DIRECTORY_SEPARATOR);
defined('THINK_PATH') or define('THINK_PATH', __DIR__ . DS);
define('LIB_PATH', THINK_PATH . 'library' . DS);
define('CORE_PATH', LIB_PATH . 'think' . DS);
define('TRAIT_PATH', LIB_PATH . 'traits' . DS);
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . DS);
defined('ROOT_PATH') or define('ROOT_PATH', dirname(realpath(APP_PATH)) . DS);
defined('EXTEND_PATH') or define('EXTEND_PATH', ROOT_PATH . 'extend' . DS);
defined('VENDOR_PATH') or define('VENDOR_PATH', ROOT_PATH . 'vendor' . DS);
defined('RUNTIME_PATH') or define('RUNTIME_PATH', ROOT_PATH . 'runtime' . DS);
defined('LOG_PATH') or define('LOG_PATH', RUNTIME_PATH . 'log' . DS);
defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);
defined('TEMP_PATH') or define('TEMP_PATH', RUNTIME_PATH . 'temp' . DS);
defined('CONF_PATH') or define('CONF_PATH', APP_PATH); // 配置文件目录
defined('CONF_EXT') or define('CONF_EXT', EXT); // 配置文件后缀
defined('ENV_PREFIX') or define('ENV_PREFIX', 'PHP_'); // 环境变量的配置前缀

//自定义常量---------------------------------------------start

defined('STATIC_PATH')              || define('STATIC_PATH',            ROOT_PATH . 'public/static' . DS);

defined('BASE_DOMAIN')              || define('BASE_DOMAIN',            $_SERVER['SERVER_NAME']);

defined('BASE_URL')                 || define('BASE_URL',               'http://' . BASE_DOMAIN);

defined('STATIC_URL')               || define('STATIC_URL',             'http://' . BASE_DOMAIN . '/static/');

defined('DEFAULT_IMAGE')            || define('DEFAULT_IMAGE',          'http://' . BASE_DOMAIN . '/logo.png');

defined('IS_DEBUG')                 || define('IS_DEBUG',               true);

defined('VALIDATE_IMAGE')           || define('VALIDATE_IMAGE',         false);

defined('VALIDATE_SMS')             || define('VALIDATE_SMS',           false);

defined('ACTION_MODEL')             || define('ACTION_MODEL',           false);

defined('AJ_RET_SUCC')              || define('AJ_RET_SUCC',            200);
defined('AJ_RET_EXISTEED')          || define('AJ_RET_EXISTEED',        201);

defined('AJ_RET_FAILED')            || define('AJ_RET_FAILED',          300);
defined('AJ_RET_NOLOGIN')           || define('AJ_RET_NOLOGIN',         301);

defined('AJ_RET_BAD')               || define('AJ_RET_BAD',             400);

defined('AJ_RET_NOT_FOUND')         || define('AJ_RET_NOT_FOUND',       404);

defined('AJ_RET_SERVER_ERROR')      || define('AJ_RET_SERVER_ERROR',    500);

defined('MD5_CODE')                 || define('MD5_CODE',               'outsource!@001#$%');

defined('DEFAULT_PAGE')             || define('DEFAULT_PAGE',           30);

defined('VERSION')                  || define('VERSION',                20180816);
defined('ADMIN_VERSION')            || define('ADMIN_VERSION',          20180816085555);
defined('OTHER_VERSION')            || define('OTHER_VERSION',          20180816);

//自定义常量---------------------------------------------start

// 环境常量
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
define('IS_WIN', strpos(PHP_OS, 'WIN') !== false);

// 载入Loader类
require CORE_PATH . 'Loader.php';

// 加载环境变量配置文件
if (is_file(ROOT_PATH . '.env')) {
    $env = parse_ini_file(ROOT_PATH . '.env', true);

    foreach ($env as $key => $val) {
        $name = ENV_PREFIX . strtoupper($key);

        if (is_array($val)) {
            foreach ($val as $k => $v) {
                $item = $name . '_' . strtoupper($k);
                putenv("$item=$v");
            }
        } else {
            putenv("$name=$val");
        }
    }
}

// 注册自动加载
\think\Loader::register();

// 注册错误和异常处理机制
\think\Error::register();

// 加载惯例配置文件
\think\Config::set(include THINK_PATH . 'convention' . EXT);
