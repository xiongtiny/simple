<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/3/27
 * Time: 下午7:57
 */
return [
    /*
     * 应用id
     */
    'appId'=>env('ALIPAY.APPID','2018031302363481'),
    /**
     * 私钥文件路径
     */
    'rsaPrivateKeyFilePath'=>env('ALIPAY.RSAP_RIVATE_KEY_FILE_PATH',''),
    /**
     * 私钥值
     */
    'rsaPrivateKey'=>env('ALIPAY.RSA_PRIVATE_KEY','MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDjMaJXKZZSxSJKjym2r4tCuGRMIRJfTvxqoRSSGZnDb0qxBU+cYKqLw1JvxWvfxGMbRNEwJalY24BgBxO3qdLKbHaMJTZEraN4wDx4jsyW5ucB1LZB9hzIfAqhLyn37vVXmaGF07fCsEWKzy72DJvgfK2JWb4IIxqg4mBcAHzAYAdCjnXt1eniCUCI8HPU9CcZzZRhrhlV1Ngi7MsZj4CBblcbSNxuKJnkuNsAKu7GowG6AiHkuYdv8kZXQu7qUeOH186Ryd/HJHBwGGlsIp0AgnfvbgX6rySf7+vChR1cknZpxc2Xd5E/Skdo+uUrW9x9TxpEgbJxhB4R9EFAL2HrAgMBAAECggEAR+X5PiRHEkKYq4fK56l+JMs90mnU6pyQfR4k6Gd5pcOem47WtuJQlpJlkEGl9dasloCcwuPoR9qPMdSLhOAVeUIB8jAEkI9y4E/V00E9tbO0/3tVgmJkkX3Pz1qhqXjR47sWxsdNrCsklt0iO3OaENzj/keMP/77+lYpsHPnBunEPJBCnCf5p/Ifq2MdLJymaY9edT3J3/JDKlawFsOHhK7ZgLOJOqNkuZyAdf9RLdKlom2djslfOU6ZwAoE6J/HeFDnzKmd89pbmjJphf72EOKQennY/0ZRUnGTC/F4PO3hmJGIpGQNgSRqePovLHtZ0B1luJ5RYeEt8qL8Aql2oQKBgQDzE2h/aYNYeQZVAaUCtVu3BEg7YwNPh5JZsphFW6TLObWzP6V0dJGxrtjjx9/zLNlN7whmiWEvTy4gUtK+aHlP3MR3dGHJ3H7Pm+nLEyhqzRQc5/EzJM077hwm6keUhOFt+O9asBWDQmi8jcdwoLWIKrbN6c/1oN+oRPNvEtpo3QKBgQDvRg0jcPxXDVP+3TgUppvOp+PySoBWmLzNYQ0MqS9PBpGbt4ifPwAhE3JU5jzGBEm709KUP4+qsj8ZcaeTEqYqZ0gRxoqp9/lSkMNI4KYc36MRvyCNNJa0y0SeHgw1X0slGKr8SSIkcBgnZsVZ5YO9ZTfmLR9SQ+WvLLnwE7BlZwKBgE+L72ua1P/0Ay14b062mQAIp7a/jUrOfAdcmdZAymozRZIWZwf4SeGS7amFNHW5HJgTfHVJygMYb2jmkc78E48eGTFaZdIQlXNNe7IYX+arnERlZxqslXliT9YwXyJsZfV+PJ4596BP8EScRUNHZIDeMZqrRIIGlorTnbKgwdcFAoGAWdFI80nhX2ggZKZz+8SC7jM1rOjsfhU9ojbRKDSGDrsfg32EqoqCqOfc3iPDIm3Po9Mi1AV8D45zg0CXr+yrNXWppwqJWL49+BFhTQUPNf15ABtnw7m+7MT00AnleU95LMaywJtPVrBBUOESKemu5zSMpDnB7SaRnI1EiutJJvcCgYEAi/OVvruBFe5R0jE2Wdlb3z+UuzKny1xvIxK8jounCvRSr6dutIP1SYbyoKZcDUqHcWsH+V+1lJdZMQ0EHCyXBzv7hxIBUQRzgN2NktpXhweUDYtgcs2+uwrRx7MsQBojrf6NiqL/+je4Xu2xz6NZrJXWbtKwGb2QsJZS/6c88DQ='),
    /**
     * 支付宝网关，一般不用修改
     */
    'gatewayUrl'=>env('ALIPAY.GATEWAY_URL','https://openapi.alipay.com/gateway.do'),
    /**
     * 返回数据格式
     */
    'format'=>env('ALIPAY.FORMAT','json'),
    /**
     * api版本
     */
    'apiVersion'=>env('ALIPAY.APIVERSION','1.0'),
    /**
     * 表单提交字符集编码
     */
    'postCharset'=>env('ALIPAY.POST_CHARSET','UTF-8'),
    /**
     * 使用文件读取文件格式，请只传递该值
     */
    'alipayPublicKey'=>env('ALIPAY.PUBLIC_KEY',""),
    /**
     * 使用读取字符串格式，请只传递该值
     */
    'alipayrsaPublicKey'=>env('ALIPAY.RSA_PUBLIC_KEY','MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4zGiVymWUsUiSo8ptq+LQrhkTCESX078aqEUkhmZw29KsQVPnGCqi8NSb8Vr38RjG0TRMCWpWNuAYAcTt6nSymx2jCU2RK2jeMA8eI7MlubnAdS2QfYcyHwKoS8p9+71V5mhhdO3wrBFis8u9gyb4HytiVm+CCMaoOJgXAB8wGAHQo517dXp4glAiPBz1PQnGc2UYa4ZVdTYIuzLGY+AgW5XG0jcbiiZ5LjbACruxqMBugIh5LmHb/JGV0Lu6lHjh9fOkcnfxyRwcBhpbCKdAIJ3724F+q8kn+/rwoUdXJJ2acXNl3eRP0pHaPrlK1vcfU8aRIGycYQeEfRBQC9h6wIDAQAB'),

    'debugInfo'=>env('ALIPAY.DEBUG',true),

    'fileCharset'=>env('ALIPAY.FILE_CHARSER','UTF-8'),

    'RESPONSE_SUFFIX'=>env('ALIPAY.RESPONSE_SUFFIX','_response'),

    'ERROR_RESPONSE'=>env('ALIPAY.ERROR_RESPONSE','error_response'),

    'SIGN_NODE_NAME'=>env('ALIPAY.SIGN_NODE_NAME','sign'),
    /**
     * 加密XML节点名称
     */
    'ENCRYPT_XML_NODE_NAME'=>env('ALIPAY.ENCRYPT_XML_NODE_NAME','response_encrypted'),
    'needEncrypt'=>env('ALIPAY.NEED_ENCRYPT',false),
    /**
     * 签名类型
     */
    'signType'=>env('ALIPAY.SIGN_TYPE','RSA2'),

    /**
     * 加密密钥和类型
     */
    'encryptKey'=>env('ALIPAY.ENCRYPT_KEY',''),
    'encryptType'=>env('ALIPAY.ENCRYPT_KEY','AES'),


];