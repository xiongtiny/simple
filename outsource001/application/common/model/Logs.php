<?php
namespace app\common\model;


Class Logs extends Base {
    /**
     * 初始化
     *
     * Logs constructor.
     */
    public function __construct()
    {
        parent::__construct('Logs');

        $this->db           = $this->LogsDb;
//        $this->redis        = $this->LogsRedis;
//        $this->memcached    = $this->LogsMemcached;
    }
}

