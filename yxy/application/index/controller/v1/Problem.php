<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/5/4
 * Time: 下午5:14
 */

namespace app\index\controller\v1;
use app\model\Problem as ProblemModel;
use app\model\ProblemType;

class Problem extends BaseController
{
    public function index(){
        $type=ProblemType::order('listor')->select();

        if(request()->get('type')!==0){
            $problems=ProblemModel::where('type_id',request()->get('type'))->paginate();
            $problems->appends([
                'type'=>request()->get('type')
            ]);
        }else{
            $problems=ProblemModel::paginate();

        }

        if($problems->isEmpty()){
            ajax_error($problems,'没有数据');
        }
        ajax_success($problems,'获取成功');

    }
}