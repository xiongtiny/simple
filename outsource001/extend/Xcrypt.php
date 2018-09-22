<?php
/**
 * 常用对称加密算法类
 * 支持密钥：64/128/256 bit（字节长度8/16/32）
 * 支持算法：DES/AES（根据密钥长度自动匹配使用：DES:64bit AES:128/256bit）
 * 支持模式：CBC/ECB/OFB/CFB
 * 密文编码：base64字符串/十六进制字符串/二进制字符串流
 * 填充方式: PKCS5Padding（DES）
 */
class Xcrypt{

    public static function encrypt($code){
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5('!s@z#d%p$2018'), $code, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }

    public static function decrypt($code){
        return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5('!s@z#d%p$2018'), base64_decode($code), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
    }
}