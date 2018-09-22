<?php

use think\migration\Migrator;
use think\migration\db\Column;

class SendSms extends Migrator
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
        $table=$this->table('send_sms',['comment'=>"短信表"]);
        $table->addColumn('phone','string',['limit'=>11,'comment'=>"手机号"])
            ->addColumn('code','integer',['limit'=>5,'comment'=>"验证码"])
            ->addColumn('code_out_time','datetime',['comment'=>'验证码过期时间'])
            ->addColumn('is_use','integer',['comment'=>"是否使用（0未使用，1已使用）",'default'=>0,'limit'=>1])
            ->addTimestamps()
            ->create();
    }
}
