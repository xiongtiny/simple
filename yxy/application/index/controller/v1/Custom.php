<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/4/12
 * Time: 上午10:43
 */

namespace app\index\controller\v1;
use app\model\Evaluate;
use app\model\EvaluateType;
use think\Validate;
use app\model\ProblemType;

class Custom extends BaseController
{
    /**
     * 获取反馈意见
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index(){
        $this->method();
        $this->auth();
        $data=request()->get();
        $wheres=[];
        $type=ProblemType::order('listor','asc')->select();
        if(!empty($data['type'])){
            $wheres['type_id']=$data['type'];
        }
        if(!empty($wheres)){
            $evaluate=\app\model\Problem::where($wheres)->paginate();

        }else{
            $evaluate=\app\model\Problem::paginate();

        }
        if(!empty($data['type'])){
            $evaluate->appends('type',$data['type']);
        };
       $respone['type']=$type;
       $respone['evaluate']=$evaluate;

       if(!$evaluate->isEmpty()){
           return ajax_success($respone,'成功');
       }
        return ajax_error([],'失败');

    }

    /**
     * 提交反馈
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function submit(){
        $this->method('post');
        $this->auth();

        $evaluate=array();
        $data=request()->post();
        $validate=Validate::make([
            'type'=>"require",
            'content'=>'require'
        ],[],[
            'type'=>"问题类型",
            'content'=>"问题内容"
        ]);

        if(!$validate->check($data)){
            return ajax_error([],$validate->getError());
        }

        $ProblemType=EvaluateType::get($data['type']);
        if(empty($ProblemType)){
            return ajax_error([],"问题类型不存在");

        }



        $evaluate['type_id']=$data['type'];
        $evaluate['content']=$data['content'];

        $img=saveBase64Images('img/a',1024,1024);


        if($img['status']==0){
            $evaluate['picture']=$img['message'];
        }

        $evaluate['user_id']=$this->user->id;

        $evaluateObject=Evaluate::create($evaluate);

        if(!$evaluateObject->id){
             ajax_error([],'反馈失败');
        }
         ajax_success([],'反馈成功');

    }


    /**
     * 反馈详情
     * @param $id
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function show($id){
        $this->method();
        $this->auth();
        $evaluate=Evaluate::get($id);
        if(!empty($evaluate)){
            return ajax_success($evaluate,'成功');
        }
        return ajax_error($evaluate,'不存在');
    }

 	/**
     *获取我的反馈
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function getEvaluate(){
        $this->method();
        $this->auth();

        $evaluates=Evaluate::where('user_id',$this->user->id)->paginate();
        
        if($evaluates->isEmpty()){
           return  ajax_error('','没有数据');
        }

        return ajax_success($evaluates,'成功');
    }

}