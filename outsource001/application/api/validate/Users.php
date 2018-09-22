<?php
/**
 * Created by PhpStorm.
 * User: Damow
 * Date: 2018/7/18
 * Time: 10:24
 */
namespace app\api\validate;
use think\validate;

class Users extends validate
{
	protected $rule=[
		'mobile'			 =>'require|unique:users|/^1[3-8]{1}[0-9]{9}$/',
		'type'			 	 =>'require',
		'email'              =>"require|email|unique:users|checkUserEmail:net.com",
		'nick_name'			 =>'require|unique:users|min:2|max:16',
		'pwd'			 	 =>'require|min:6|max:16',
		'pay_pwd'			 =>'require|min:6|max:16',
		'new_pwd'			 =>'require|min:6|max:16',
		'code'				 =>'require',
		'reuser_pwd'		 =>'require|min:6|max:16',
		'head_image'		 =>'require',
		'money'		 		 =>'require|number',
		'real_name'			 =>'require|min:2|max:16',
		'bank'			 	 =>'require',
		'bank_account'		 =>'require',
		'bank_address'		 =>'require',
		'activation_num'	 =>'require|number',
		'count'				 =>'require|number',
		'money_addr'		 =>'require|/^1[3-8]{1}[0-9]{9}$/',
		'coin'		 		 =>'require|number',
	];

	protected $message=[
		'mobile.require'	=> '手机号必须有！',
		'mobile.unique'		=> '该用户已存在！',
		'mobile'			=> '手机号格式有误！',
		'type'			    => '非法来源！',
		'nick_name.require' => '用户名不能为空',
		'nick_name.unique'  => '用户名已存在',
		'nick_name.min'     => '昵称长度不符',
		'nick_name.max'     => '昵称不能大于16位字符',
		'code.require'		=> '验证码必须有',
		'pwd.require'		=> '密码必须有',
		'pwd.min'      		=> '密码不能小于6位数',
		'pwd.max'      		=> '密码不能大于16位数',
		'pay_pwd.require'	=> '支付密码必须有',
		'pay_pwd.min'       => '支付密码不能小于6位数',
		'pay_pwd.max'      	=> '支付密码不能大于16位数',

		'new_pwd.require'		=> '确认密码必须有',
		'new_pwd.min'      		=> '确认密码不能小于6位数',
		'new_pwd.max'      		=> '确认密码不能大于16位数',
		're_pwd.require'		=> '确认密码必须有',
		're_pwd.min'      		=> '确认密码不能小于6位数',
		're_pwd.max'      		=> '确认密码不能大于16位数',
		'head_image.require'	=> '图片必须有',
		'money.require'			=> '转账数量必须有',
		'money.number'			=> '请输入正确的转账数量',

		'real_name.require' 	=> '真实姓名不能为空',
		'real_name.min'     	=> '真实姓名长度不符',
		'real_name.max'     	=> '真实姓名不能大于16位字符',
		'bank.require' 			=> '开户银行不能为空',
		'bank_account.require' 	=> '银行账户不能为空',
		'bank_address.require' 	=> '开户行地址不能为空',

		'activation_num.require'=> '兑换数量必须有',
		'activation_num.number' => '兑换数量格式不正确',

		'coin.require'			=> '数量必须有',
		'coin.number' 			=> '数量格式不正确',
		'money_addr.require'	=> '钱包地址或手机号必须有！',
		'money_addr'			=> '手机号格式有误！',
	];

	protected $scene = [
		'sms'				=>  ['mobile'=>'require|/^[19][3-9]{1}[0-9]{9}$/','type'],
		'login'  			=>  ['mobile'=>'require|/^[19][3-9]{1}[0-9]{9}$/','pwd'],
		'register'  		=>  ['mobile','nick_name','pwd','pay_pwd','code'],
		'forgetPwd'  		=>  ['mobile'=>'require|/^[19][3-9]{1}[0-9]{9}$/','code','pwd'],
		'forgetPayPwd'  	=>  ['mobile'=>'require|/^[19][3-9]{1}[0-9]{9}$/','code','pay_pwd'],
		'modifyPwd'  		=>  ['pwd','new_pwd'],
		'modifyPayPwd'  	=>  ['pay_pwd','new_pwd'],
		'modifyNick'  		=>  ['nick_name'],
		'saveCoverimg'  	=>  ['head_image'],
		'userTrue'  		=>  ['mobile'=>'require|/^[19][3-9]{1}[0-9]{9}$/'],
		'transfer'  		=>  ['money_addr'=>'require|/^[19][3-9]{1}[0-9]{9}$/','coin'],
		'transfer1'  		=>  ['mobile'=>'require|/^[19][3-9]{1}[0-9]{9}$/','money','pay_pwd'],
		'transferaddr'  	=>  ['money_addr'=>'require','coin'],
		'bindBank'  		=>  ['real_name','bank','bank_account','bank_address'],
		'giveActivation'  	=>  ['mobile'=>'require|/^[19][3-9]{1}[0-9]{9}$/','count'],
		'exchange'  		=>  ['activation_num'],
	];

}