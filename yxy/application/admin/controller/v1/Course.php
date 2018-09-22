<?php
/**
 * Created by PhpStorm.
 * Name: 课程管理
 * User: shaoguo
 * Date: 2018/4/17
 * Time: 上午10:10
 */

namespace app\admin\controller\v1;
use app\model\Course as CourseModel;
use app\model\Grade as GradeModel;
use app\model\Admin as AdminModel;
use app\model\Subject as SubjectModel;
use app\model\Season as SeasonModel;
use app\model\Charging as ChargingModel;
use app\model\Role as RoleModel;
use think\Validate;
class Course extends BaseController
{
    /**
     * 首页
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function index(){
        $this->method();
        $this->auth();
        /**
         * 判断是什么类型
         */
        $type=request()->has('type')?request()->get('type'):'1';
        $orders=array();

        //学科
        $subject_data = SubjectModel::all();

        //年级
        $grade_data = GradeModel::all();
        $headmaster=RoleModel::where('name','班主任')->find()->admins;
        $consolution=RoleModel::where('name','上课老师')->find()->admins;

        $grade=request()->get('grade_id');
        $year=request()->get('year');
        $mode=request()->get('mode');
        $on_line=request()->get('on_line');
        $season=request()->get('season');
        $start_order=request()->get('start_order');
        $subject=request()->get('subject_id');
        $teacher_a=request()->get('teacher_a');
        $teacher_b=request()->get('teacher_b');

        // $wheres[]=['type','eq',$type];


        if(!empty($grade)){

            $wheres[]=['grade_id','eq',$grade];
        }

        // if(!empty($year)){
        //     $wheres[]=['year','like',$year."%"];
        // }

        if(!empty($mode)){
            $wheres[]=['mode','eq',$mode];
        }

        if(is_numeric($on_line)){
            $wheres[]=['on_line','eq',$on_line];
        }

        if(!empty($season)){
            $wheres[]=['season','eq',$season];

        }

        // if(!empty($start_order)){
        //     $orders['course_time']=$start_order;
        // }

        if(!empty($subject)){
            $wheres[]=['subject_id','eq',$subject];
        }


        if(!empty($teacher_a)){

            $wheres[]=['teacher_a','eq',$teacher_a];
        }

        if(!empty($teacher_b)){
            $wheres[]=['teacher_b','eq',$teacher_b];
        }
        if(empty($wheres)){
            $courses=CourseModel::order('start_time','desc')->paginate();
        }else{
            $courses=CourseModel::where($wheres)->order('start_time','desc')->paginate();
        }
        $courses->appends(compact('type','grade','year','mode','on_line','season','start_order','subject','teacher_a','teacher_b'));

        return view('',compact('courses','subject_data','grade_data','headmaster','consolution'));
    }


    /**
     * 
     */
    public function onevone()
    {
        // echo 111;
       return view();
    }

    /**
     * 
     */
    public function addone()
    {
        // echo 111;
       return view();
    }



    /**
     * 添加课程视图
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add(){
        $this->method();
        $this->auth();
        $grades=GradeModel::order('listor','asc')->select();
        $seasons=SeasonModel::order('listor','asc')->select();
        $charging=ChargingModel::order('listor','asc')->select();
        $subjects=SubjectModel::order('listor','asc')->select();
        $headmaster=RoleModel::where('name','班主任')->find()->admins;
        $class_teacher=RoleModel::where('name','上课老师')->find()->admins;
        $type=request()->has('type')?request()->get('type'):'1';
        return view('',compact('type','grades','seasons','charging','subjects','headmaster','class_teacher','counselor'));
    }


    /**
     * 添加课程
     */
    public function addPost(){
        $this->method('post');
        $this->auth();
        $data=request()->post();
        $validate=Validate::make([
            'type'=>'require|number',
            'grade_id'=>'require|number',
            'subject_id'=>'require|number',
            'season_id'=>'require|number',
            'charging'=>'require|number',
            'mode'=>'require|number',
            'free_trial'=>'require|number',
            'name'=>'require',
            'hours'=>'require',
            'course_desc'=>'require',
            'course_num'=>'require',
            'price'=>'require|float',
            'start_time'=>'require',
            'end_time'=>'require',
            'teacher_a'=>'require|number',
            'teacher_b'=>'require|number',
            'bady_max'=>'require|number',
            'course_address'=>"require",
        ],[],[
            'type'=>"类型",
            'grade_id'=>'年级',
            'subject_id'=>'科目',
            'season_id'=>"季节",
            'charging'=>'计费形式表',
            'mode'=>'授课方式',
            'free_trial'=>'是否上线',
            'name'=>"课程名称",
            'hours'=>'课时数',
            'course_desc'=>'课程介绍',
            'course_num'=>'课程大纲',
            'price'=>'价格',
            'start_time'=>'开课时间',
            'end_time'=>'结课时间',
            'teacher_a'=>'班主任',
            'teacher_b'=>'上课老师',
            'bady_max'=>'人数上限',
            'course_address'=>'上课地点'

        ]);
        if(!$validate->check($data)){
           ajax_error([],$validate->getError());
        }
        $course=CourseModel::create($data);
        if(!$course->id){
            ajax_error([],'添加失败');
        }
        ajax_success($course,'添加成功');
    }

    /**
     * 修改课程页面
     * @param $id
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function edit($id){
        $this->method();
        $this->auth();
        $course=CourseModel::get($id);
        if(empty($course)){
            $this->error('没有该课程');
        }

        $course->start_time=explode(' ',$course->start_time)[0]."T".explode(' ',$course->start_time)[1];
        $course->end_time=explode(' ',$course->end_time)[0]."T".explode(' ',$course->end_time)[1];

        $grades=GradeModel::order('listor','asc')->select();
        $seasons=SeasonModel::order('listor','asc')->select();
        $charging=ChargingModel::order('listor','asc')->select();
        $subjects=SubjectModel::order('listor','asc')->select();
        $role=RoleModel::where('name','老师')->find();
        $headmaster=RoleModel::where('name','班主任')->find()->admins;
        $class_teacher=RoleModel::where('name','上课老师')->find()->admins;
        return view('',compact('course','grades','seasons','charging','role','seasons','class_teacher','headmaster','subjects'));
    }


    /***
     * 修改课程
     * @throws \think\exception\DbException
     */
    public function editPost(){
        $this->method('post');
        $this->auth();
        $id=request()->post('id');
        $data=request()->except('id');
        $validate=Validate::make([
            'id'=>'require|number'
        ]);
        if(!$validate->check(['id'=>$id])){
            ajax_error($validate->getError());
        }
        $course=CourseModel::get($id);
        if(empty($course)){
            ajax_error([],'没有该课程');
        }

        if(!$course->save($data)){
            ajax_error([],'修改失败');
        }
        $course=CourseModel::get($id);
        ajax_success($course,'修改成功');



    }

    public function course_student($id){
        $this->method();
        $this->auth();
       $students=CourseModel::get($id)->getStudent()->with(['getOrder'=>function($query)use($id){
           $query->where('course_id',$id)->whereIn('status',1);
           }])->paginate();
       return view('',compact('students'));
    }


    public function up(){
        $this->method('post');
        $this->auth();
        $ids=request()->post('id/a');
        if(empty($ids)){
            ajax_error('',"请选择你要上线的课程");
        }
        $course=CourseModel::whereIn('id',$ids)->update(['on_line'=>1]);
        if(!$course){
            ajax_error('',"上线失败");
        }
        ajax_success($course,'上线成功');
    }



    public function down(){
        $this->method('post');
        $this->auth();
        $ids=request()->post('id/a');
        if(empty($ids)){
            ajax_error('',"请选择你要下线的课程");
        }
        $course=CourseModel::whereIn('id',$ids)->update(['on_line'=>0]);
        if(!$course){
            ajax_error('',"下线失败");
        }
        ajax_success($course,'下线成功');
    }


}