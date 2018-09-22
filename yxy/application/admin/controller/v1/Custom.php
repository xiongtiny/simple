<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/5/8
 * Time: 下午2:37
 */

namespace app\admin\controller\v1;
use app\model\ProblemType;
use app\model\Problem;
use think\Validate;
class Custom extends BaseController
{
    public function index(){
        $this->method();
        $this->auth();
        $types=ProblemType::order('listor')->select();
        if(request()->get('type_id')!=0){
            $problems=Problem::where('type_id',request()->get('type_id'))->paginate();
            $problems->appends([
                'type_id'=>request()->get('type')
            ]);
        }else{
            $problems=Problem::paginate();

        }

        return view('',compact('problems','types'));

    }


    public function add(){
        $this->method();
        $this->auth();
        $types=ProblemType::order('listor')->select();
        return view('',compact('types'));
    }


    public function addPost(){
        $this->method('post');
        $this->auth();
        $data=request()->post();
        $validate=Validate::make([
            'title'=>'require',
            'content'=>"require",
            'type_id'=>'require'
        ],[],[
            'title'=>"标题",
            'content'=>"内容",
            'type_id'=>"类型"
        ]);

        if(!$validate->check($data)){
            ajax_error('',$validate->getError());
        }
        if(Problem::create($data)){
            ajax_success('','成功');
        }
    }
}