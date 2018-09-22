<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Users extends Migrator
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
        $table=$this->table('user',['comment'=>"用户表"]);
        $table->addColumn('username','string',['comment'=>"用户名"])
            ->addColumn('number','string',['limit'=>255,'comment'=>"学籍号",'null'=>true])
            ->addColumn('phone','string',['limit'=>20,'comment'=>"手机号"])
            ->addColumn('password','string',['limit'=>60,'comment'=>"密码"])
            ->addColumn('img','string',['comment'=>"头像",'null'=>'true'])
            ->addColumn('teacher','integer',['limit'=>11,'comment'=>"咨询老师id",'null'=>true,'default'=>0])
            ->addColumn('sex','integer',['limit'=>1,'comment'=>"性别",'default'=>0,'comment'=>"0:男,1:女",'null'=>true])
            ->addColumn('last_login_ip','string',['comment'=>"登录ip",'null'=>true])
            ->addColumn('last_login_time', 'datetime',array('default'=>0,'comment'=>'最后登录时间','null'=>true))
            ->addTimestamps()
            ->create();



    }
}
