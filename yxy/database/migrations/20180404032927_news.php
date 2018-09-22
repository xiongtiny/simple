<?php

use think\migration\Migrator;
use think\migration\db\Column;

class News extends Migrator
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
        $table=$this->table('news',['comment'=>"新闻表"]);
        $table->addColumn('type','integer',['comment'=>"新闻分类id"])
            ->addColumn('title','string',['comment'=>'新闻标题'])
            ->addColumn('photo','string',['comment'=>'展示图'])
            ->addColumn('content','text',['comment'=>'新闻内容'])
            ->addColumn('status','integer',['comment'=>"状态（0未发布、1已发布",'null'=>true,'default'=>0])
            ->addColumn('del_time','datetime',['comment'=>"软删除时间",'null'=>true])
            ->addTimestamps()
            ->create();
    }
}
