<?php
namespace app\index\controller\v1;

use app\model\News as NewsModel;
use app\model\NewsType;
use app\model\User;
use app\plugins\alipay\AopClient;
use app\plugins\alipay\request\AlipayTradePagePayRequest;
use app\plugins\jwt\JWT;
use think\facade\Request;
class News
{


    /**
     * 新闻查询
     * @return string
     */
    public function index(){
        $type = request()->get('type');
        $where['type'] = $type;
        if(empty($type)){
            $news = NewsModel::order('id','desc')->limit(10)->select();
        }else{
            $news = NewsModel::where($where)->order('id','desc')->limit(10)->select();
        }
        foreach ($news as $key => $value) {
            $news_type = NewsType::where(['id'=>$value['type']])->find();
            $news[$key]['type'] = $news_type['name'];
            $time1 = strtotime($value['create_time']);
            $news[$key]['time'] = date('Y-n-g', $time1);
        }
        if(!$news->isEmpty()){
            return ajax_success($news,'获取新闻成功');
        }else{
            return ajax_error($news,'暂无新闻信息');
        }
    }



    /**
     * 新闻查询
     * @return string
     */
    public function news_content(){
        $news_id = request()->get('id');
        $news_data = NewsModel::get($news_id);
        $news_type = NewsType::where(['id'=>$news_data['type']])->find();
        $news_data['type'] = $news_type['name'];
        // $news_data['content'] = strip_tags($news_data['content']);
        if(!empty($news_data)){
            return ajax_success($news_data,'获取新闻成功');
        }else{
            return ajax_error($news_data,'暂无新闻信息');
        }
    }


    public function news_type(){
        $news_type=NewsType::order("listor",'asc')->select();
        if($news_type->isEmpty()){
            return ajax_error('','获取分类失败');
        }
        return ajax_success($news_type,'获取分类成功');
    }

}
