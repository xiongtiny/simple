<?php

use think\migration\Migrator;
use think\migration\db\Column;

class ClassHour extends Migrator
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
        $table=$this->table('class_hour',['comment'=>"课时表"]);
        $table->addColumn('name','string',['comment'=>"课时名"])
            ->addColumn('hours','string',['comment'=>"小时"])
            ->addColumn('price','string',['comment'=>'价格'])
            ->addColumn('activity_price','string',['comment'=>'活动优惠','null'=>true,'default'=>0])
            ->addColumn('activity_desc','string',['comment'=>'活动优惠描述','null'=>true,'default'=>0])
            ->addColumn('mode','integer',['comment'=>'授课方式（1线上直播，2面授）','default'=>0])
            ->addColumn('grade_id','integer',['comment'=>'年级id'])
            ->addColumn('del_time','datetime',['comment'=>'软删除'])
            ->addTimestamps()
            ->create();
    }
}
