<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/3/27
 * Time: 下午2:58
 */
return [
    'debug'=>env('WECHAT_DEBUG',false),
    /*
     * 账号基本信息，请从微信公众平台/开放平台获取
     * */
    'app_id'=>env('WECHAT_APP_ID','wxbe159023353dc3c7'),
    'secret'=>env('WECHAT_SECRET','5fd6bea2a29dc1ba7a6f45e9ee746b85'),
    'token'=>env('WECHAT_TOKEN',''),
    'aes_key'=>env('WECHAT_AES_KEY',''),
    /**
     * 日志配置
     *
     * level: 日志级别, 可选为：
     *         debug/info/notice/warning/error/critical/alert/emergency
     * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     */
    'log'=>[
        'level'=>env('WECHAT_LOG_LEVEL',''),
        'permission'=>env('WECHAT_LOG_PERMISSION','0777'),
        'file'=>env('WECHAT_LOG_FILE','')
    ],

    /**
     * OAuth 配置
     *
     * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
     * callback：OAuth授权完成后的回调页地址
     */

    'oauth'=>[
        'scopes'=>env('WECHAT_OAUTH_SCOPES',''),
        'callback'=>env('WECHAT_OAUTH_CALLBACK','')
    ],

    /**
     * 微信支付
     */

    'payment'=>[
        'merchant_id'=>env('WECHAT_PAYMENT_MERCHANT_ID','1458811102'),
        'key'=>env('WECHAT_PAYMENT_KEY','fineclab123fineclab123fineclab12'),
        'cert_path'=>env('WECHAT_PAYMENT_CERT_PATH','/wechat/apiclient_cert.pem'),
        'key_path'=>env('WECHAT_PAYMENT_KEY_PATH','/wechat/apiclient_key.pem')
    ],

    /**
     * Guzzle 全局设置
     *
     * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
     */
    'guzzle'=>[
        'timeout'=>env('WECAHT_GUZZLE_TIMEOUT',''),
        'verify'=>env('WECHAT_GUZZLE_VERIFY',false)

    ]
];