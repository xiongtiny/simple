<?php 
namespace app\admin\model;

use think\Exception;
use think\Model;

Class Base extends Model{

	protected $autoWriteTimestamp = true;
	protected $createTime = 'create_time';
    protected $updateTime = 'last_time';
	
	protected $lastError;
	protected $errorCode;

	public function __construct($data = [])
    {
        parent::__construct($data);
    }

    public function initialize(){
		parent::initialize();
	}
	
	//设置错误信息
	protected function setError($msg, $code=1, $flag = false){
		$this->lastError = $msg;
		$this->errorCode = $code;
		return $flag;
	}
	
	//错误码
	public function getErrorCode(){
		return $this->errorCode;
	}

	//错误提示
	public function getError(){
		if($this->lastError)
			return $this->lastError;
		return parent::getError();
	}

    /**
     * 获取表信息
     *
     * @return mixed|string
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
	public function getTable(){
	    $sql    = 'SHOW TABLE STATUS';

	    $ret    = $this->query($sql);

	    return $ret;
    }

    /**
     * 查询全部
     *
     * @param array $where
     * @param array $order_by
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
	public function getAll($where = array(), $order_by = array()){
        $this->formatSqlWhere($where);

        if(!empty($order_by)){
            $this->order($order_by);
        }

        $ret    = $this->select();

        $data   = json_decode(json_encode($ret),true);

        return $data;
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
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getPage($page = 1, $page_list = DEFAULT_PAGE, $where = array(), $order_by = array(), $total = 0){
        if (!$total) {
            $total = $this->getCount($where);
        }
        $page_info['page_list']     = (int)$page_list;
        $page_info['page']          = (int)$page;
        $page_info['total_rows']    = (int)$total;
        $page_info['total_pages']   = ceil($page_info['total_rows'] / $page_info['page_list']);

        if ($page_info['total_pages'] < $page_info['page']) {
            $page_info['page'] = $page_info['total_pages'];
        }
        if (2 > intval($page_info['page'])) {
            $page_info['page'] = 1;
        }

        $rows   = $this->getPageList($page_info['page'] , $page_list, $where, $order_by);

        $data   = ['rows'=>$rows, 'pages'=>$page_info];

        return $data;
    }

    /**
     * 分页列表数据
     *
     * @param int $page
     * @param int $page_list
     * @param array $where
     * @param array $order_by
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function getPageList($page = 1, $page_list = DEFAULT_PAGE, $where = array(), $order_by = array()){
        $this->formatSqlWhere($where);

        $this->page($page, $page_list);

        if(!empty($order_by)){
            $this->order($order_by);
        }

        $ret    = $this->select();

        $data   = json_decode(json_encode($ret),true);

        return $data;
    }

    /**
     * 分页列表计数
     *
     * @param array $where
     * @return int
     */
    public function getCount($where = array()){
        $this->formatSqlWhere($where);

        $ret    = $this->count();

        return $ret;
    }

    /**
     * 设置自增字段
     * @param $field
     * @param int $step
     * @param array $where
     * @return bool|int|true
     */
    public function incField($field, $step = 1, $where= array()){
        if(empty($field) || empty($where)){
            return false;
        }

        $this->formatSqlWhere($where);

        $ret    = $this->setInc($field, $step);

        return $ret;
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
        if(empty($field) || empty($where)){
            return false;
        }

        $this->formatSqlWhere($where);

        $ret    = $this->setDec($field, $step);

        return $ret;
    }

    /**
     * 添加
     * @param array $data
     * @param bool $is_batch
     * @return array|bool|false|int|string
     * @throws \Exception
     */
    public function addInfo($data = array(), $is_batch = false){
        if(empty($data) || !is_array($data)){
            return false;
        }

        $ret    = $is_batch ? $this->saveAll($data) : $this->save($data);

        return $is_batch ? $ret : $this->getLastInsID($ret);
    }

    /**
     * 删除
     *
     * @param $where
     * @return bool|int
     */
    public function deleteInfo($where){
        if(empty($where) || !is_array($where)){
            return false;
        }
        $ret        = self::destroy($where);
        return $ret;
    }

    /**
     * 修改
     *
     * @param array $data
     * @param array $where
     * @return bool
     */
    public function updateInfo($data = array(), $where = array()){
        if(empty($where) || !is_array($where) || empty($data) || !is_array($data)){
            return false;
        }

        $this->formatSqlWhere($where);

        $ret    = $this->isUpdate(true)->save($data);

        return $ret;
    }

    /**
     * 查询
     *
     * @param array $where
     * @return bool|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getInfo($where = array()){

        if(empty($where) || !is_array($where)){
            return false;
        }

        $this->formatSqlWhere($where);

        $ret    = $this->find();

        $data   = json_decode(json_encode($ret),true);

        return $data;
    }

    /**
     * 检查插入方法（兼容更新操作）
     *
     * @param array $data
     * @param array $where
     * @param bool $is_update
     * @return array|bool|false|int|mixed|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkAddInfo($data = array(), $where = array(), $is_update = false){
        if(empty($data) || !is_array($where)){
            return false;
        }

        $search_where   = $where;

        if(empty($search_where)){
            $search_where   = $data;
        }

        $check_ret  = $this->getInfo($search_where);

        if(empty($check_ret)){
            $all_data   = array_merge($data, $where);

            $data_arr   = array();
            foreach ((array)$all_data as $k => $v){
                $data_arr[$k]   = $v;
            }

            $ret    = $this->addInfo($data_arr);

            return $ret;
        }else{
            if($is_update){
                $is_edit    = false;

                $all_data   = array_merge($data, $where);

                $data_arr   = array();
                foreach ((array)$all_data as $k => $v){
                    $data_arr[$k]   = $v;
                }

                foreach ((array)$data_arr as $k => $v){
                    if($v != $check_ret[$k]){
                        $is_edit    = true;
                    }
                }

                if($is_edit){
                    $ret    = $this->updateInfo($data, $where);

                    return $ret;
                }else{
                    return false;
                }
            }

            return $check_ret;
        }
    }

    /**
     * 格式where 条件
     *
     * @param array $where
     */
    private function formatSqlWhere($where = array()){
        foreach ((array)$where as $k => $v){
            if(is_array($v)){
                $option = strtolower($v[0]);

                $value  = $v[1];

                if($k == 'create_time_flag'){
                    $k = 'create_time';
                }

                if($option == 'like'){
                    $this->where($k, $option, '%' .$value. '%');
                }elseif ($option == 'where_in'){
                    $this->where($k, 'IN', $value);
                }elseif ($option == 'where_or'){
                    $this->whereOr($k, 'OR', $value);
                }else{
                    $this->where($k, $option, $value);
                }

            }else{
                $this->where($k, '=', $v);
            }
        }
    }
}

