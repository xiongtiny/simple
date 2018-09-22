<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Evaluate extends Migrator
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
        $table=$this->table('evaluate',['comment'=>"意见反馈表"]);
        $table->addColumn('type_id','integer',['comment'=>'评论分类id'])
            ->addColumn('content','text',['comment'=>'评价内容'])
            ->addColumn('picture','text',['comment'=>'评论图片'])
            ->addColumn('user_id','integer',['comment'=>'用户id'])
            ->addColumn('del_time','datetime',['comment'=>'软删除时间','null'=>true])
            ->addTimestamps()
            ->create();
    }
}
