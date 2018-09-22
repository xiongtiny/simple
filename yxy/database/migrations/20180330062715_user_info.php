<?php

use think\migration\Migrator;
use think\migration\db\Column;

class UserInfo extends Migrator
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
        $table=$this->table('UserInfo',['comment'=>'用户详情表']);
        $table->addColumn('user_id','integer',['comment'=>'用户ID'])
            ->addColumn('grade','integer',['comment'=>'年级','null'=>true])
            ->addColumn('school','string',['comment'=>'学校','null'=>true])
            ->addColumn('province','integer',['comment'=>"省",'null'=>true])
            ->addColumn('city','integer',['comment'=>'市','null'=>true])
            ->addColumn('area','integer',['comment'=>"区",'null'=>true])
            ->addColumn('address','string',['comment'=>"地址",'null'=>true])
            ->addColumn('email','string',['comment'=>"邮箱",'null'=>true])
            ->addColumn('weixin','string',['comment'=>"微信",'null'=>true])
            ->addColumn('alipay','string',['comment'=>"支付宝",'null'=>true])
            ->addColumn('hours','string',['comment'=>"1对1课时"])
            ->addColumn('bank_card','string',['comment'=>"银行卡号",'null'=>true])
            ->addTimestamps()
            ->create();

    }
}
