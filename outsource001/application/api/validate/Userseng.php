<?php
/**
 * Created by PhpStorm.
 * User: Damow
 * Date: 2018/7/18
 * Time: 10:24
 */
namespace app\api\validate;
use think\validate;

class Userseng extends validate
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
		'mobile.require'	=> 'Cell phone number must be available！',
		'mobile.unique'		=> 'The user already exists！',
		'mobile'			=> 'Incorrect format of mobile phone number！',
		'type'			    => 'Illegal sources！',
		'nick_name.require' => 'The username cannot be empty',
		'nick_name.unique'  => 'User name already exists',
		'nick_name.min'     => 'Nickname length',
		'nick_name.max'     => 'A nickname cannot be more than 16 - bit characters',
		'code.require'		=> 'The verification code must be available',
		'pwd.require'		=> 'he password must be',
		'pwd.min'      		=> 'The password cannot be less than 6 digits',
		'pwd.max'      		=> 'The password cannot be more than 16 digits',
		'pay_pwd.require'	=> 'Payment passwords must be available',
		'pay_pwd.min'       => 'The payment password cannot be less than 6 digits',
		'pay_pwd.max'      	=> 'The payment password cannot be more than 16 digits',

		'new_pwd.require'		=> 'The confirmation password must be available',
		'new_pwd.min'      		=> 'Verify that the password cannot be less than 6 digits',
		'new_pwd.max'      		=> 'Verify that the password cannot be more than 16 digits',
		're_pwd.require'		=> 'The confirmation password must be available',
		're_pwd.min'      		=> 'Verify that the password cannot be less than 6 digits',
		're_pwd.max'      		=> 'Verify that the password cannot be more than 16 digits',
		'head_image.require'	=> 'The picture must have',
		'money.require'			=> 'The number of transfers must be',
		'money.number'			=> 'Please enter the correct amount of transfer',

		'real_name.require' 	=> 'Real names cannot be empty',
		'real_name.min'     	=> 'The real name doesn\'t match the length',
		'real_name.max'     	=> 'The real name cannot be more than 16 - bit characters',
		'bank.require' 			=> 'The opening bank cannot be empty',
		'bank_account.require' 	=> 'Bank accounts cannot be empty',
		'bank_address.require' 	=> 'The opening bank address cannot be empty',

		'activation_num.require'=> 'The exchange amount must be available',
		'activation_num.number' => 'The exchange amount is not in correct format',

		'coin.require'			=> 'Quantity must be',
		'coin.number' 			=> 'Quantity format is incorrect',
		'money_addr.require'	=> 'Wallet address or phone number must be available！',
		'money_addr'			=> 'Incorrect format of mobile phone number！',
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
		'transferaddr'  	=>  ['money_addr'=>'require','coin'],
		'bindBank'  		=>  ['real_name','bank','bank_account','bank_address'],
		'giveActivation'  	=>  ['mobile'=>'require|/^[19][3-9]{1}[0-9]{9}$/','count'],
		'exchange'  		=>  ['activation_num'],
	];

}