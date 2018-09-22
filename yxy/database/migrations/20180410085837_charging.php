<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Charging extends Migrator
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
        $table=$this->table('charging',['comment'=>"计费形式表"]);
        $table->addColumn('name','string',['comment'=>'计费名'])
            ->addColumn('listor','integer',['comment'=>"排序"])
            ->addColumn('del_time','datetime',['comment'=>"删除时间"])
            ->addTimestamps()
            ->create();
    }
}
