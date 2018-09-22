<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Per extends Migrator
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
        $table=$this->table('per',['comment'=>'权限表']);
        $table->addColumn('name','string',['comment'=>'权限名称'])
            ->addColumn('path', 'string', array('limit' => 100, 'default' => '', 'comment' => '权限路径'))
            ->addColumn('description', 'string', array('limit' => 200, 'default' => '', 'comment' => '权限描述'))
            ->addColumn('status', 'integer', array('limit' => 1, 'default' => 0, 'comment' => '权限状态'))
            ->addTimestamps()
            ->create();
    }
}
