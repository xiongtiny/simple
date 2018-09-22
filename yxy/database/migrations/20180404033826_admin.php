<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Admin extends Migrator
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
        $table=$this->table('admin',['comment'=>"管理员表"]);
        $table->addColumn('name','string',['comment'=>"管理员姓名",'null'=>true])
            ->addColumn('number','string',['comment'=>"管理员账号登录"])
            ->addColumn('password','string',['comment'=>'管理员密码','limit'=>60])
            ->addColumn('del_time','datetime',['comment'=>'软删除时间','null'=>true])
            ->addColumn('last_time','datetime',['comment'=>"最后一次登陆时间",'null'=>true])
            ->addTimestamps()
            ->create();
    }
}
