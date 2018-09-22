<?php
/**
 * Created by PhpStorm.
 * Name: 课时
 * User: shaoguo
 * Date: 2018/4/18
 * Time: 上午11:40
 */

namespace app\admin\controller\v1;
use app\model\ClassHour as ClassHourModel;
use app\model\ClassHour;
use think\Validate;
use app\model\Grade as GradeModel;
use app\model\Charging as ChargingModel;
use app\model\Role as RoleModel;
class Hours extends BaseController
{
    /**
     * 首页
     * @throws \think\exception\DbException
     */
    public function index(){
        $this->method();
        $this->auth();
        $grade=request()->get('grade_id');
        $type=request()->get('type');
         if(!empty($grade)){

            $wheres[]=['grade_id','eq',$grade];
        
        }
        if(!empty($mode)){
            $wheres[]=['type','eq',$type];
        }

        $grades = GradeModel::all();
        if(empty($wheres)){
             $classes=ClassHourModel::paginate();
        }else{
             $classes=ClassHourModel::where($wheres)->paginate();
        }
       
        return view('',compact('classes','grades'));
    }

    /**
     * 添加课程视图
     * @return \think\response\View
     */
    public function add(){
        $this->method();
        $this->auth();
        $grades=GradeModel::order('listor','desc')->select();
        $charging=ChargingModel::order('listor','asc')->select();

        return view('',compact('grades','charging'));
    }

    /**
     *添加课程视图
     */
    public function addPost(){
        $this->method('post');
        $this->auth();
        $data=request()->post();
        $validate=Validate::make([
            'name'=>'require',
            'price'=>'require|float',
            'activity_price'=>'require|float',
            'mode'=>"require|number",
            'grade_id'=>'require|number'
        ],[],[
            'name'=>'课程名',
            'price'=>'价格',
            'activity_price'=>'优惠价格',
            'mode'=>'授课方式',
            'grade_id'=>"课程"
        ]);

        if(!$validate->check($data)){
            ajax_error([],$validate->getError());
        }

        if(!ClassHour::create($data)){
            ajax_error([],'添加失败');
        }
        ajax_success([],'添加成功');

    }

    /**
     * 修改课程视图
     * @param $id
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function edit($id){
        $this->method();
        $this->auth();
        $course=ClassHourModel::get($id);
        $grades=GradeModel::order('listor','desc')->select();
        $charging=ChargingModel::order('listor','asc')->select();

        if(empty($course)){
            ajax_error([],'没该课时');
        }

        return view('',compact('course','grades','charging'));

    }

    /**
     *修改课程
     * @throws \think\exception\DbException
     */
    public function editPost(){
        $this->method('post');
        $this->auth();
        $id=request()->post('id');
        $validate=Validate::make([
            'id'=>'require|number'
        ]);
        if(!$validate->check(['id'=>$id])){
            ajax_error('',$validate->getError());
        }
        $hour=ClassHourModel::get($id);
        if(empty($hour)){
            ajax_error([],'没该课时');
        }
        $data=request()->except('id');
        if(!$hour->save($data)){
            ajax_error([],'修改失败');
        }
        $hour=ClassHourModel::get($id);
        ajax_success($hour,'修改成功');

    }


    public function OneToOne(){
        $this->method();
        $this->auth();
        $web=htmlspecialchars_decode(file_get_contents(env('config_path').'1v1.txt'));
        return view('',compact('web'));
    }



    public function OneToOnePost(){
        $this->method('post');
        $data=request()->post();
        $this->auth();
        $web=file_put_contents(env('config_path').'1v1.txt',htmlspecialchars(($data['desc'])));
        if(!$web){
            ajax_error('','修改信息错误');
        }
        ajax_success('','修改信息成功');


    }

}