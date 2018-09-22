<?php

use think\migration\Migrator;
use think\migration\db\Column;

class IndexImage extends Migrator
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
        $table=$this->table('IndexImage');
        $table->addColumn('type','integer',['limit'=>1,'comment'=>'类型（1轮播，2活动，3专题'])
            ->addColumn('title','string',['comment'=>"标题"])
            ->addColumn('photo','string',['comment'=>'图片'])
            ->addColumn('status','integer',['comment'=>'状态（0未发布、1已发布）','limit'=>1])
            ->addColumn('url','string',['comment'=>'链接','null'=>true])
            ->addColumn('del_time','datetime',['comment'=>'软删除时间','null'=>true])
            ->addTimestamps()
            ->create();
    }
}
