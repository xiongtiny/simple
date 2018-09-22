<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/5/8
 * Time: 上午11:48
 */

namespace app\admin\controller\v1;
use app\model\Evaluate as EvaluateModel;
use app\model\EvaluateType;

class Evaluate extends BaseController
{
    public function index(){
        $this->method();
        $this->auth();
        $wheres=array();
        $data=request()->get();

        $types=EvaluateType::all();
        if(isset($data['is_read']) && is_numeric($data['is_read'])){
            $wheres[]=['is_read','=',$data['is_read']];
        }

        if(isset($data['type_id']) && is_numeric($data['type_id'])){
            $wheres[]=['type_id','=',$data['type_id']];
        }
        if(!empty($wheres)){
            $evaluates=EvaluateModel::where($wheres)->paginate();
        }else{
            $evaluates=EvaluateModel::paginate();

        }


        return view('',compact('evaluates','types'));

    }


    public function show($id){
        $this->method();
        $this->auth();
        $evaluate=EvaluateModel::get($id);

        return view('',compact('evaluate'));
    }


    public function read(){
        $this->method('post');
        $this->auth();
        $evaluate=EvaluateModel::get(request()->post('id'));
        if($evaluate->save(['is_read'=>1])){
            ajax_success('','成功');
        }
        ajax_error('','失败');

    }
}