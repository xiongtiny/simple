<?php
/**
 * Created by PhpStorm.
 * User: Damow
 * Date: 2018/8/30
 * Time: 11:18
 */

function lang1($lang)
{
    switch ($lang)
    {
        case '用户不存在或被禁用':
            $lang="The user does not exist or is disabled";
            break;
        case '请选择正确的操作类型':
            $lang="Please select the correct operation type";
            break;

        case '密码或账号错误':
            $lang="Wrong password or account number";
            break;

        case '登录成功':
            $lang="login successfully";
            break;

        case '验证码错误或验证码已过期':
            $lang="Validation code error or expired";
            break;

        case '注册成功':
            $lang="registered successfully";
            break;

        case '用户不存在':
            $lang="The user does not exist";
            break;

        case '修改成功':
            $lang="modify successfully ";
            break;

        case '成功':
            $lang="succeed";
            break;

        case '该用户不能删除':
            $lang="This user cannot be deleted";
            break;

        case '不能激活自己':
            $lang="You can't activate yourself";
            break;

        case '该用户已经被激活':
            $lang="The user has been activated";
            break;

        case '转入人不能是自己':
            $lang="The transferee cannot be himself";
            break;

        case '余额不足':
            $lang="not sufficient funds";
            break;

        case '兑换金额不得小于20':
            $lang="The exchange amount shall not be less than 20";
            break;

        case '必须是20的整倍数':
            $lang="It has to be an integral multiple of 20";
            break;

        case '赠送人不能是自己':
            $lang="The giver cannot be himself";
            break;

        case '激活次数不足':
            $lang="underactivation";
            break;

        case '用户已存在，请勿重复注册':
            $lang="Users already exist, do not register repeatedly";
            break;

        case '该用户还未注册':
            $lang="The user is not registered";
            break;

        case '找不到该记录或已被删除':
            $lang="The record could not be found or has been deleted";
            break;

        case '非法来源':
            $lang="Illegal sources";
            break;

        case '已读':
            $lang="read";
            break;

        case '未读':
            $lang="unread";
            break;

        case '发送失败，请联系客服':
            $lang="Delivery failed. Please contact customer service";
            break;

        case '接入人未激活':
            $lang="The caller is not activated";
            break;

        case '支付密码错误':
            $lang="Payment password error";
            break;
    }

    return $lang;
}