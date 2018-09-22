<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/5/29
 * Time: 10:10
 */
namespace app\index\controller\v1;

use app\index\controller\BaseController;
use think\Validate;
use \app\Models\User;

class Goods extends BaseController
{

    /**
     *  商品列表
     * @return string
     */
    public function goods_list()
    {
        $this->auth(false);  //判断用户是否登录
        // $this->method();  //提交方式
        $user_id = request()->get('user_id');
        if(empty($user_id)){
             $user_id = $this->user->id;
        }
        $goods_data = \app\Models\Goods::all();
        if(!empty($user_id)){
        	$grade = \app\Models\User::where('id',$user_id)->value('grade');
            foreach ($goods_data as $v) {
            	if($grade==0){
            		$v['price2'] = $v['gen_price'];
            	}else{
            		$v['price2'] = $v['whe_price'];
            	}
                $v['user'] = $user_id;
                $v['num']  =0;
            }
            return ajax_success($goods_data,'获取商品成功');
        }else{
            return ajax_error([],'获取商品失败');
        }
    }
}