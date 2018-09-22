<?php

use think\migration\Migrator;
use think\migration\db\Column;

class UserCourse extends Migrator
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
        $table=$this->table('UserCourse',['学生关联课程表']);
        $table->addColumn('user_id','integer',['comment'=>"用户ID"])
            ->addColumn('course_id','integer',['comment'=>"课程id",'null'=>true])
            ->addColumn('class_hour_id','integer',['comment'=>"课时id",'null'=>true])
            ->addColumn('del_time','datetime',['comment'=>"软删除",'null'=>true])
            ->addTimestamps('created_at','updated_at')
            ->create();

    }
}
