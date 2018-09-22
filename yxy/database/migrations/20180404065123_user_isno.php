<?php

use think\migration\Migrator;
use think\migration\db\Column;

class UserIsno extends Migrator
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
        $table=$this->table('UserIson',['comment'=>'意向学员表']);
        $table->addColumn('name','string',['comment'=>'姓名'])
            ->addColumn('grade','integer',['comment'=>'年级id'])
            ->addColumn('subject','integer',['comment'=>'科目id'])
            ->addColumn('phone','string',['comment'=>'手机号'])
            ->addColumn('type','string',['comment'=>'类型'])
            ->addColumn('status','integer',['comment'=>'是否转化（0否，1是）'])
            ->addColumn('del_time','datetime',['comment'=>'软删除时间','null'=>true])
            ->addTimestamps()
            ->create();
    }
}
