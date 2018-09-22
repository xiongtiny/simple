<?php
namespace app\common\model;


Class Users extends Base {
    /**
     * 初始化
     *
     * Users constructor.
     */
    public function __construct()
    {
        parent::__construct('Users');

        $this->db           = $this->UsersDb;
//        $this->redis        = $this->UsersRedis;
//        $this->memcached    = $this->UsersMemcached;
    }

    public function addUser($data = array()){
        return $this->db->addUser($data);
    }

    public function delUser($data =''){
        return $this->db->delUser($data);
    }

    public function child($user_id,$limit = 0){
        return $this->db->child($user_id,$limit);
    }

    public function childDeep($user_id,$deep){
        return $this->db->childDeep($user_id,$deep);
    }
}

