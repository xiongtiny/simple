<?php
namespace app\common\model;


Class Orders extends Base {
    /**
     * 初始化
     *
     * orders constructor.
     */
    public function __construct()
    {
        parent::__construct('Orders');

        $this->db           = $this->OrdersDb;
//        $this->redis        = $this->OrdersRedis;
//        $this->memcached    = $this->OrdersMemcached;
    }
}

