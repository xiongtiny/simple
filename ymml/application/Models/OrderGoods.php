<?php

namespace app\Models;

use think\Model;

class OrderGoods extends Model
{
    protected $name='order_goods';

    public function getName(){
        return $this->hasOne('Goods','id','goods_id');
    }
}