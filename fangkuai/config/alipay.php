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
    'appId'=>env('ALIPAY.APPID',''),
    /**
     * 私钥文件路径
     */
    'rsaPrivateKeyFilePath'=>env('ALIPAY.RSAP_RIVATE_KEY_FILE_PATH',''),
    /**
     * 私钥值
     */
    'rsaPrivateKey'=>env('ALIPAY.RSA_PRIVATE_KEY','MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCcA9fhx81QUxsb+CU8gOqaQtdjWkjTQBOAI/gCXyQGt7ll3mL3K6VJCnaJXPhL1aMlEEIN+rfvZubOIgzSOtDoQjeBF+iNx0LsOHmB9KuOUv6hHD3y3NtuH/+JkNhYjWx4VFCqMR++K5R8ENncuNYMzKKGR1lm7+VzzOpz35/0UVnktx9vbY9U8VRj/AfqCgkRFvdMm0bvb6gpaBkM9TH3IVRjHo9Yfpkkqc1tpAxrCAiLfALjuhraBtQQY7chJWF5lRQKA0pnO2OG6KTRBN0bRu5l+4MQpucxlws3w9k521BH+0ClMsKONMtfc6wZIQxoqF33PeuJnTwYjlb5H+ehAgMBAAECggEAVWyVS/7GoHCgq1PXr6U2z3hBzxikP2caRlNrfIDzjOoUDX8S2RuAyNl9xgCtw3gaeDTKtjTNebvyLHPgaUvjDwkSsxCQOPEd55GUll+Nf8RZv4VjNhNP4qCKnpw8mV/2QHyKHmX/Z3UdPEFNyNk7+o4hfzyZ6w73p8xPo1qSjocRrpj9N857zLNVpzSNYYy7tNGhpTlfbSXYk3lutcLZpvOomxJn2HtMsxQ8O0j76+QAPfzLDJndjFv+CPim42lLxWYezrpJf9+M1IjMAtIQtfjSt3rwSsejyUv/B/3bZYz1QYC439L9K94b5K3n2CR3ILWpx9Ymal9nTF93RO+zsQKBgQDNTQbRzjw0lIIYn35xokvTZt4Ac7e/Z1219LDvMk1aUUujYLnkD7PsYwvq1CkCpJQMmdqaqSKMjCu053p8DQg6DgvL0JBvtrblHkNMMN5Ud4xALf9NVAlHLUrXo+DB63WteonFmfLbFsY/oA7+I6Cq41ay9q1prY09WBrOWGLTzwKBgQDCiv/dMMpBXDE8UfVSUfGm25S4Pxz38mqKETOuRMzFzLhx3guAJS8zOztwg7LcbLTnTEE0HIli8QQchw/eu/3/gcf5oQ52Kz6+7dBKIb99/sclYm9/oj+i67q4eMVq5MC0P82URCb0zRpsHAJ0GeIYQmyPXkdLm7MuzwOAmzW5jwKBgQC8fphgUcadUC0Shn4Fv0l3U99I8vYmWrWDtqItPDYhUrrryodiibhctaPfe+QbdRgpaal4jwoVmS0X7+BZvW1sQDE8dMXojA3o15xafBPl4c13r8PUL/BE1aT90I0v/wwQt41/TBXaalKjYEXjuLpvrEOSFUKq4JnpVNdn1WcHqQKBgBskub5q6E1mR5ha9xedR1I4oO90Ht6ZfDP3YnaWMtwGTFXW3VPr3EIRqaFxPqtyn2sGQLK8qI6dgi1YyuYQ5MeZnAVAa3whXIfXNpChVM6HldGpglUUljxtF4hVkXXwpNKBdHWTbLwLQfyDi/QXCGzKF8uJI/lwp/eH+r0e6sgRAoGAR8QzCZAK8PYU2+bqfiUEKx3skRNyBVyITAfykY7gfpVgAOo4SfA6u+1De1xw/crIZJO5KDFw4HR2erZsySsmWwYTSgcXGEbxDCo+4b3KJ4YUbpXE6lrJFGrQTe7Rg//x/Npd2Kbv/aQBSTOgM+8gaTlUPicnWSrZ8ZNSHVc2wn4='),
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
    'alipayPublicKey'=>env('ALIPAY.PUBLIC_KEY',null),
    /**
     * 使用读取字符串格式，请只传递该值
     */
    'alipayrsaPublicKey'=>env('ALIPAY.RSA_PUBLIC_KEY',''),

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
    'signType'=>env('ALIPAY.SIGN_TYPE','RSA'),

    /**
     * 加密密钥和类型
     */
    'encryptKey'=>env('ALIPAY.ENCRYPT_KEY',''),
    'encryptType'=>env('ALIPAY.ENCRYPT_KEY','AES'),


];