<?php

use think\migration\Migrator;
use think\migration\db\Column;

class NewsType extends Migrator
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
        $table=$this->table('new_type',['comment'=>'新闻分类表']);
        $table->addColumn('name','string',['comment'=>"分类名"])
            ->addColumn('parent_id','integer',['comment'=>'父id','null'=>true,'default'=>0])
            ->addColumn('del_time','datetime',['comment'=>"软删除",'null'=>true])
            ->addColumn('listor','integer',['comment'=>'排序','null'=>true,'default'=>0])
            ->addTimestamps()
            ->create();
    }
}
