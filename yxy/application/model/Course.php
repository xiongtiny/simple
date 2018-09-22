<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/10
 * Time: 14:53
 */
namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;
class Course extends Model{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $table='yxy_course';

    //关联管理员模型(老师)
    public function getAdmin(){
        return $this->hasOne('Admin','id','teacher_b');
    }

    /**
     * 设置课程详情
     * @param $value
     * @return string
     */
    public function setCourseDescAttr($value){
        return htmlspecialchars($value);
    }

    /**
     * 设置课程大纲
     * @param $value
     * @return string
     */
    public function setCourseNumAttr($value){
        return htmlspecialchars($value);
    }

    /**
     * 获取课程详情
     * @param $value
     * @return string
     */
    public function getCourseDescAttr($value){
        return htmlspecialchars_decode($value);
    }


    /**
     * 获取课程大纲
     * @param $value
     * @return string
     */
    public function getCourseNumAttr($value){
        return htmlspecialchars_decode($value);
    }

    /**
     * 获取科目
     * @param $value
     */
    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id','id');
    }

    /**
     * 获取年级
     */
    public function grade(){
        return $this->belongsTo(Grade::class,'grade_id','id');
    }

    /**
     * 获取季节
     */
    public function season(){
        return $this->belongsTo(Season::class,'season_id','id');
    }

    /**
     * 获取班主任
     * @return \think\model\relation\BelongsTo
     */
    public function teacherIndex(){
        return $this->belongsTo(Admin::class,'teacher_a','id');
    }

    /*
     * 获取上课老师
     */
    public function teacherTop(){
        return $this->belongsTo(Admin::class,'teacher_b','id');

    }


    /*
     * 获取上课老师
     */
    public function getCharging(){
        return $this->belongsTo(Charging::class,'charging','id');

    }

    /**
     * 获取学生
     * @return \think\model\relation\BelongsToMany
     */
    public function getStudent(){
        return $this->belongsToMany(User::class,'UserCourse','user_id','course_id');
    }


}

