<?php
namespace app\common\model;


Class Messages extends Base {
    /**
     * 初始化
     *
     * Messages constructor.
     */
    public function __construct()
    {
        parent::__construct('Messages');

        $this->db           = $this->MessagesDb;
//        $this->redis        = $this->MessagesRedis;
//        $this->memcached    = $this->MessagesMemcached;
    }
}

