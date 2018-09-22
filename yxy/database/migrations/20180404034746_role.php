<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Role extends Migrator
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
        $table=$this->table('role');
        $table->addColumn('name','string',['comment'=>"角色名"])
             ->addColumn('parent_id', 'integer', array('limit' => 11, 'default' => 0, 'comment' => '父角色id'))
             ->addColumn('description', 'string', array('limit' => '200', 'default' => '', 'comment' => '描述信息'))
             ->addColumn('status', 'integer', array('limit'=>1, 'default' => 0, 'comment' => '角色状态'))
             ->addColumn('sort_num', 'integer', array('limit' => 11, 'default' => 0, 'comment' => '排序值'))
             ->addColumn('left_key', 'integer', array('limit' => 11, 'default' => 0, 'comment' => '用来组织关系的左值'))
             ->addColumn('right_key', 'integer', array('limit' => 11, 'default' => 0, 'comment' => '用来组织关系的右值'))
             ->addColumn('level', 'integer', array('limit' => 11, 'default' => 0, 'comment' => '所处层级'))
             ->addTimestamps()
            ->create();
    }
}
