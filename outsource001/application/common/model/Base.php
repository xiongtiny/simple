<?php
namespace app\common\model;

use Pimple\Container;

Class Base {

    //容器变量
    public $containerModel;
    //操作模型
    public $model;
    //db数据模型
    protected $db;
    //redis缓存模型
    protected $redis;
    //memcached缓存模型
    protected $memcached;

    //Users
    protected $UsersDb;
    protected $UsersRedis;
    protected $UsersMemcached;

    //Logs
    protected $LogsDb;
    protected $LogsRedis;
    protected $LogsMemcached;

    //orders
    protected $OrdersDb;
    protected $OrdersRedis;
    protected $OrdersMemcached;

    //Messages
    protected $MessagesDb;
    protected $MessagesRedis;
    protected $MessagesMemcached;

    protected $MessageFlagsDb;
    protected $MessageFlagsRedis;
    protected $MessageFlagsMemcached;

    public function __construct($model)
    {
        $this->containerModel               = new Container();

        $this->model                        = $model;

        $this->setContainerModel();
    }

    /**
     * 设置常用数据模型
     */
    private function setContainerModel(){
        //DB数据
        $this->setProperty($this->model.'Db', function (){
            return model('db.'.$this->model);
        });

        //REDIS数据
        $this->setProperty($this->model.'Redis', function (){
            return model('redis.'.$this->model);
        });

        //MEMCACHED数据
        $this->setProperty($this->model.'Memcached', function (){
            return model('memcached.'.$this->model);
        });
    }

    /**
     * 设置容器属性
     *
     * @param $property
     * @param $callable
     */
    protected function setProperty($property, $callable){
        $this->containerModel[$property] = $this->containerModel->factory($callable);
        unset($this->$property);
    }

    /**
     * get 方法
     *
     * @param $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        static $obj;

        if(!isset($obj[$key])){
            $obj[$key]  = $this->containerModel[$key];
        }

        return $obj[$key];
    }
    /********************************************对数据操作进行再次封装*************************************************************/
    /**
     * 查询全部
     *
     * @param array $where
     * @param array $order_by
     * @param string $field
     * @return mixed
     */
    public function getAll($where = array(), $order_by = array(), $field = ''){

        return $this->db->getAll($where, $order_by, $field);
    }

    /**
     * 分页列表
     *
     * @param int $page
     * @param int $page_list
     * @param array $where
     * @param array $order_by
     * @param int $total
     * @return array
     */
    public function getPage($page = 1, $page_list = DEFAULT_PAGE, $where = array(), $order_by = array(), $total = 0){


        return $this->db->getPage($page, $page_list, $where, $order_by, $total);
    }

    /**
     * 分页列表数据
     *
     * @param int $page
     * @param int $page_list
     * @param array $where
     * @param array $order_by
     * @param string $field
     * @return mixed
     */
    private function getPageList($page = 1, $page_list = DEFAULT_PAGE, $where = array(), $order_by = array(), $field = ''){
        return $this->db->getPageList($page, $page_list, $where, $order_by, $field);
    }

    /**
     * 分页列表计数
     *
     * @param array $where
     * @return int
     */
    public function getCount($where = array()){
        return $this->db->getCount($where);
    }

    /**
     * 设置自增字段
     *
     * @param $field
     * @param int $step
     * @param array $where
     * @return bool|int|true
     */
    public function incField($field, $step = 1, $where= array()){
        return $this->db->incField($field, $step, $where);
    }

    /**
     * 设置自减字段
     *
     * @param $field
     * @param int $step
     * @param array $where
     * @return bool|int|true
     */
    public function decField($field, $step = 1, $where= array()){
        return $this->db->decField($field, $step, $where);
    }

    /**
     * 添加
     *
     * @param array $data
     * @param bool $is_batch
     * @return array|bool|false|int|string
     * @throws \Exception
     */
    public function addInfo($data = array(), $is_batch = false){
        return $this->db->addInfo($data, $is_batch);
    }

    /**
     * 删除
     *
     * @param $where
     * @return bool|int
     */
    public function deleteInfo($where){
        return $this->db->deleteInfo($where);
    }

    /**
     * 修改
     *
     * @param array $data
     * @param array $where
     * @return bool
     */
    public function updateInfo($data = array(), $where = array()){
        return $this->db->updateInfo($data, $where);
    }

    /**
     * 查询
     *
     * @param array $where
     * @return bool|mixed
     *
     */
    public function getInfo($where = array(), $field=''){

        return $this->db->getInfo($where,$field);
    }

    /**
     * 检查插入方法（兼容更新操作）
     *
     * @param array $data
     * @param array $where
     * @param bool $is_update
     * @return array|bool|false|int|mixed|string
     */
    public function checkAddInfo($data = array(), $where = array(), $is_update = false){
        return $this->db->checkAddInfo($data, $where, $is_update);
    }

    public function getPk(){
        return $this->db->getPk();
    }

    public function where($field, $op = null, $condition = null){
        return $this->db->where($field, $op, $condition);
    }
}

