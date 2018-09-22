<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Course extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table=$this->table('course',['comment'=>"课程表"]);
        $table->addColumn('grade_id','integer',['comment'=>'年级id'])
            ->addColumn('subject_id','integer',['comment'=>'科目id'])
            ->addColumn('name','string',['comment'=>'课程名称'])
            ->addColumn('hours','string',['comment'=>'课时数'])
            ->addColumn('price','string',['comment'=>"价格"])
            ->addColumn('activity_price','string',['comment'=>'活动优惠','null'=>true,'default'=>0])
            ->addColumn('activity_desc','string',['comment'=>'活动优惠描述','null'=>true,'default'=>0])
            ->addColumn('start_time','datetime',['comment'=>'开课时间'])
            ->addColumn('end_time','datetime',['comment'=>'结课时间'])
            ->addColumn('class_time','text',['comment'=>'上课时间','null'=>true])
            ->addColumn('teacher_a','integer',['comment'=>'班主任','null'=>true,'default'=>0])
            ->addColumn('teacher_b','integer',['comment'=>'上课老师','null'=>true,'default'=>0])
            ->addColumn('study_num','integer',['comment'=>"在学人数",'default'=>0,'null'=>true])
            ->addColumn('bady_max','integer',['comment'=>"人数上限(0不限，输入非0限量数字)",'default'=>0,'null'=>true])
            ->addColumn('mode','integer',['comment'=>'授课方式（1线上直播，2面授）','default'=>1])
            ->addColumn('type','integer',['comment'=>'授课类型（1班级课，2一对一）','default'=>1])
            ->addColumn('on_line','integer',['comment'=>'是否上线（0没有上，1上线了）','default'=>1])
            ->addColumn('free_trial','integer',['comment'=>'是否上线（0不能试听，1可以试听）','default'=>1])
            ->addColumn('charging','integer',['comment'=>'计费形式id'])
            ->addColumn('course_address','string',['comment'=>"上课地点",'null'=>true])
            ->addColumn('course_desc','text',['comment'=>'课程介绍','null'=>true])
            ->addColumn('course_num','text',['comment'=>"课程大纲",'null'=>true])
            ->addColumn('student_id','integer',['comment'=>'学生id','null'=>true])
            ->addColumn('start','decimal',['comment'=>'评星','null'=>true,'default'=>"0",'scale'=>2,'precision'=>3])
            ->addColumn('recommend','integer',['comment'=>"推荐（0否，1是）",'null'=>true,'default'=>0])
            ->addColumn('range','string',['comment'=>"适用范围",'null'=>true])
            ->addColumn('season','integer',['comment'=>"季节id"])
            ->addColumn('listor','integer',['comment'=>"排序",'default'=>0,'null'=>true])
            ->addColumn('del_time','datetime',['comment'=>'软删除时间','null'=>true])
            ->addTimestamps()
            ->create();
    }
}
