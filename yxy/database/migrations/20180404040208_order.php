<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Order extends Migrator
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
        $table=$this->table('order',['comment'=>'订单表']);
        $table->addColumn('order_no','integer',['comment'=>'订单号'])
            ->addColumn('course_id','integer',['comment'=>'课程表id'])
            ->addColumn('user_id','integer',['comment'=>'用户id'])
            ->addColumn('user_name','string',['comment'=>'用户名'])
            ->addColumn('user_phone','string',['comment'=>'用户手机号'])
            ->addColumn('price','string',['comment'=>'价格'])
            ->addColumn('pay_time','datetime',['comment'=>'支付时间','null'=>true])
            ->addColumn('status','integer',['comment'=>"支付状态（0待支付，1已支付，2已取消，3已退款）",'limit'=>1])
            ->addColumn('reduce_price','string',['comment'=>'特别优惠价格','null'=>true,'default'=>0])
            ->addColumn('activity_price','string',['comment'=>'活动优惠','null'=>true,'default'=>0])
            ->addColumn('class_hour_id','integer',['comment'=>"课时id",'null'=>true])
            ->addColumn('reduce_explain','string',['comment'=>'优惠说明','null'=>true,'default'=>0])
            ->addColumn('del_time','datetime',['comment'=>'软删除时间','null'=>true])
            ->addTimestamps()
            ->create();

    }
}
