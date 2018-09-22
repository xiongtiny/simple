<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/12
 * Time: 18:07
 */
namespace app\admin\controller\v1;
use app\model\NewsType;
use Request;
use Db;
use think\Controller;

class News extends BaseController{

    /**
     *  新闻管理--新闻类别展示
     *  @return string
     */
    public function news_type(){
        $this->method();
        $this->auth();
        $news_type = NewsType::order('id','desc')->select();
        return view('',compact('news_type'));
    }

    /**
     *  新闻管理--新闻列表
     *  @return string
     */

    public function news_list(){
        $this->method();
        $this->auth();
        //获取总条数
        $news_list = \app\model\News::order('id','desc')
                                    ->with('getType')
                                    ->paginate(8);
        return view('/v1/news/news_list',compact('news_list'));
    }

    /**
     *  新闻管理--筛选
     *  @return string
     */
    public function screen_news(){
        $this->method('post');
        $this->auth();
        $data = request()->post();
        //判断筛选条件
        $arrWhere = [];
        if(!empty($data['type'])){
            $arrWhere[] = ['type','=',$data['type']];
        }
        if(!empty(is_numeric($data['status']))){
            $arrWhere[] = ['status','=',$data['status']];
        }
        if(!empty($data['start_time'])&&!empty($data['end_time'])){
            $news_list = \app\model\News::where($arrWhere)
                        ->whereBetweenTime('create_time', $data['start_time'], $data['end_time'])
                        ->with('getType')
                        ->paginate(10);
        }else{
            $news_list = \app\model\News::where($arrWhere)->with('getType')->paginate(10);
        }
        if(!$news_list->isEmpty()){
            ajax_success($news_list,'筛选新闻成功');
        }else{
            ajax_error($news_list,'暂未筛选内容');
        }
    }

    /**
     *  新闻管理--批量/单个发布
     *  @return string
     */
    public function release(){
        $this->method('post');
        $this->auth();
        $data = request()->post('news_id/a');
        $new_id = implode(",",$data);
        $state = \app\model\News::whereIn('id',$new_id)->update(['status'=>1]);
        if($state){
            ajax_success($state,'修改成功');
        }else{
            ajax_error($state,'修改失败');
        }
    }

    /**
     *  新闻管理--批量/单个删除
     *  @return string
     */
    public function del(){
        $this->method('post');
        $this->auth();
        $data = request()->post('news_id/a');
        if(empty($data)){
            ajax_error('','请选择要删除的新闻');

        }
        $new_id = implode(",",$data);
        $state = \app\model\News::destroy($new_id);
        if($state){
            ajax_success($state,'删除成功');
        }else{
            ajax_error($state,'删除失败');
        }
    }

    /**
     * 
     */
    public function add()
    {
        $this->method();
        $this->auth();
        // echo 111;
        $news_type=NewsType::order('listor','asc')->select();
       return view('',compact('news_type'));
    }


    /**
     *  新闻管理--添加新闻
     *  @return string
     */
    public function add_news(){
        $this->method('post');
        $this->auth();
        $data = request()->post();
        $photo = uploadImageOne('photo');
        if($photo['status']==0){
            $data['photo']=$photo['message'];
        }
        $news = new \app\model\News($data);
        if(empty($data['title'])){
            ajax_error($data,'新闻标题不可为空');
        }
        if(empty($data['photo'])){
            ajax_error($data,'新闻图片不可为空');
        }
        if(empty($data['content'])){
            ajax_error($data,'新闻内容不可为空');
        }
        if(empty($data['content'])){
            ajax_error($data,'新闻内容不可为空');
        }
        $state = $news->save();
        if($state){
            ajax_success($state,'添加成功');
        }else{
            ajax_error($state,'添加失败');
        }
    }

    /**
     *  新闻管理--修改
     *  @return string
     */
    public function edit_news(){
        $this->method('post');
        $this->auth();
        $news_id = request()->get('id');
        $data = request()->post();
        $photo = uploadImageOne('photo');
        $news = new \app\model\News;
        $news->save([
            'type'=>$data['type'],
            'title'=>$data['title'],
            'photo'=>$photo['message'],
            'content'=>$data['content'],
            'status'=>$data['status'],
        ],['id' => $news_id]);
        $state = $news->save();
        if($state){
            ajax_success($state,'修改成功');
        }else{
            ajax_error($state,'修改失败');
        }
    }


    /**
     * 新闻内容
     */
    public function news_content()
    {
        $this->auth();
        // echo 111;
        $id = request()->get('id');
        $news = new \app\model\News;
        $data = $news->where(['id'=>$id])->find();
        // $data['content'] = strip_tags($data['content']);
        return view('',compact('data'));
    }


}