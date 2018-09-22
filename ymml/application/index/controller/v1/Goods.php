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
        $this->auth();  //判断用户是否登录
        $this->method();  //提交方式
        $user_data = $this->user;
        $goods_data = \app\Models\Goods::all();
        if(!empty($user_data)){
            foreach ($goods_data as $v) {
                $v['user'] = $user_data->id;
            }
            return ajax_success($goods_data,'获取商品成功');
        }else{

            return ajax_error([],'获取商品失败');
        }


    }
}