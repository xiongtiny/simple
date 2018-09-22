<?php
namespace app\common\model;


Class MessageFlags extends Base {
    /**
     * 初始化
     *
     * MessageFlags constructor.
     */
    public function __construct()
    {
        parent::__construct('MessageFlags');

        $this->db           = $this->MessageFlagsDb;
//      $this->redis        = $this->MessageFlagRedis;
//      $this->memcached    = $this->MessageFlagMemcached;
    }
}

