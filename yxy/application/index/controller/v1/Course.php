<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/10
 * Time: 10:27
 */
namespace app\index\controller\v1;

use app\model\Class_hour;
use app\model\Grade;
use app\model\Subject;
use app\model\Course as CourseModel;

class Course extends BaseController{

    /**
     *  班级课--年级展示
     * @return string
     */
    public function grade(){
        $grade = Grade::all();
        if(!$grade->isEmpty()){
            ajax_success($grade,'获取年级成功');
        }else{
            ajax_error($grade,'暂未年级信息');
        }
    }

    /**
     *  班级课--学科展示
     * @return string
     */
    public function subject(){
        $subject = Subject::all();
        if(!$subject->isEmpty()){
            ajax_success($subject,'获取学科成功');
        }else{
            ajax_error($subject,'获取学科失败');
        }
    }

    /**
     *  班级课--筛选
     * @return string
     * @param  grade_id  年级id
     * @param  subject_id  学科id
     */
    public function course(){
        $this->method();
        $grade_id = request()->get('grade_id');
        $subject_id = request()->get('subject_id');
        $recommend = request()->get('recommend');
        $type = request()->get('type');
        //判断筛选条件
        if($grade_id!=100 && !empty($grade_id)){
            $arrWhere['grade_id'] =$grade_id;
        }
        if($subject_id!=100 && !empty($subject_id)){
            $arrWhere['subject_id'] =$subject_id;
        }
        if(!empty($recommend)){
            $arrWhere['recommend']=1;
        }
        if($type!=3){
            $arrWhere['type']=$type;
        }
        // dump($arrWhere);
        $course = CourseModel::where($arrWhere)->limit(5)->select();
        foreach ($course as $key => $value){
            $start_time = strtotime($value['start_time']);
            $course[$key]['start_time_md'] = date('n月j日',$start_time);
            $aa = date('w',$start_time);
            if($aa == 0){$course[$key]['start_time_w'] = '日';}
            if($aa == 1){$course[$key]['start_time_w'] = '一';}
            if($aa == 2){$course[$key]['start_time_w'] = '二';}
            if($aa == 3){$course[$key]['start_time_w'] = '三';}
            if($aa == 4){$course[$key]['start_time_w'] = '四';}
            if($aa == 5){$course[$key]['start_time_w'] = '五';}
            if($aa == 6){$course[$key]['start_time_w'] = '六';}
            $index_course_start_time1 = date('G:i',$start_time);
            $index_course_start_time2 = date('G:i',$start_time+5400);
            $course[$key]['start_time_end'] = $index_course_start_time1.'-'.$index_course_start_time2;
        }
        if(!$course->isEmpty()){
            ajax_success($course,'获取课程成功');
        }else{
            ajax_error($course,'暂无课程');
        }
    }

        /**
     *  班级课--详情
     * @return string
     */
    public function course_details(){
        //获取课程id
        $this->method();
        $course_id = request()->get('course_id');
        $course = CourseModel::where('id',$course_id)->with('getAdmin')->select();
        foreach ($course as $key => $value) {
            $time1 = strtotime($value['start_time']);
            $course[$key]['start_time'] = date('m月d日', $time1);
            $time2 = strtotime($value['end_time']);
            $course[$key]['end_time'] = date('m月d日', $time2);
        }
        if(!$course->isEmpty()){
            ajax_success($course->toArray(),'获取课程详情成功');
        }else{
            ajax_error($course->toArray(),'获取课程详情失败');
        }
    }
}