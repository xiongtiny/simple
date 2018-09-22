<?php
namespace app\common\model\db;


class Users extends BaseDb
{

    /**
     * 获取所有子节点
     *
     * @param $id
     * @return array|mixed
     */
    public function child($id,$limit=0){
        $info   = $this->getInfo(array('id'  => $id));

        if(empty($info)){
            return array();
        }

        $limit  = $limit>0 ? ' limit 0,'.$limit : '';
        $sql    = "select id,mobile,status,pid,money_log from users where left_value >= ".$info['left_value']." and right_value <= ".$info['right_value'].$limit;

        $ret    = $this->query($sql);

        return $ret;
    }

    /**
     * 获取用户路径
     *
     * @param $id
     * @return mixed
     */
    public function path($id){
        $sql    = "select parent.id, parent.real_name, parent.left_value, parent.right_value, parent.release_status from user as node, user as parent where node.left_value between parent.left_value and parent.right_value and node.id = ".$id." order by parent.left_value;";

        $ret    = $this->query($sql);

        return $ret;
    }

    /**
     * 获取最终节点
     */
    public function last(){
        $sql    = "select id,real_name from users where right_value = left_value + 1;";

        $ret    = $this->query($sql);

        return $ret;
    }

    /**
     * 获取节点深度
     */
    public function deep(){
        $sql    = "select node.id as id, node.nick_name as nick_name, node.release_status,  (count(parent.nick_name) - 1) as deep from users as node,users as parent where node.left_value between parent.left_value and parent.right_value group by node.nick_name order by node.left_value;";

        $ret    = $this->query($sql);

        return $ret;
    }

    /**
     * 获取不同深度的子集
     *
     * @param string $deep
     * @return mixed
     */
    public function childDeep($id, $deep = "1", $user_info = array()){
        $info   = empty($user_info) ? $this->getInfo(array('id'  => $id)):$user_info;

        $sql    = "select *,
                      case deep when 0 then 0.3*release_assets*0.7
                                when 1 then 0.2*release_assets*0.7
                                when 2 then 0.1*release_assets*0.7
                                when 3 then 0.05*release_assets*0.7
                                when 4 then 0.025*release_assets*0.7
                                when 5 then 0.01*release_assets*0.7
                                when 6 then 0.005*release_assets*0.7
                                when 7 then 0.0025*release_assets*0.7
                                when 8 then 0.001*release_assets*0.7 end as deep_ratio from (select node.position,node.mobile,node.status,node.left_value,node.right_value,node.pid,node.release_assets,node.release_status,node.id,node.nick_name as nick_name,(count(parent.nick_name) - 1) as deep from users as node,(select nick_name,left_value,right_value from users where left_value >= ".$info['left_value']." and right_value <= ".$info['right_value'].") as parent where node.left_value >= ".$info['left_value']." and node.right_value <= ".$info['right_value']." and node.left_value between parent.left_value and parent.right_value group by node.nick_name order by node.left_value) as a where a.deep <= ".$deep." order by deep asc;";

        $ret    = $this->query($sql);

        return $ret;
    }

    /**
     * 添加用户
     *
     * @param array $data
     * @return array|bool|false|int|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addUser($data = array()){
        if(isset($data['pid']) && $data['pid'] > 0){
            $cate_info  = $this->getInfo(array('id' => $data['pid']));

            $left_value     = $cate_info['right_value'];
            $right_value    = $cate_info['right_value'] + 1;

            $this->refreshCateTree($cate_info['right_value']);
        }else{
            $max_value      = $this->getMaxRightValue();

            $left_value     = $max_value + 1;
            $right_value    = $max_value + 2;
        }

        $data['left_value']     = $left_value;
        $data['right_value']    = $right_value;

        return $this->addInfo($data);
    }

    /**
     * 删除用户
     *
     * @param $id
     * @return bool
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function delUser($id)
    {
        $cate_info = $this->getInfo(array('id' => $id));

        if ($cate_info) {
            $v_width    = $cate_info['right_value'] - $cate_info['left_value'] + 1;

            $dsql       = 'DELETE FROM users WHERE left_value BETWEEN '.$cate_info['left_value'].' AND '.$cate_info['right_value'];
            $lsql       = 'UPDATE users SET left_value = left_value - '.$v_width.' WHERE left_value > '.$cate_info['right_value'];
            $rsql       = 'UPDATE users SET right_value = right_value - '.$v_width.' WHERE right_value > '.$cate_info['right_value'];

            $this->query($dsql);
            $this->query($lsql);
            $this->query($rsql);

            return true;
        } else {
            return false;
        }
    }

    /**
     * 刷新分类树的预排序
     *
     * @param $right_value
     * @param string $step
     * @return bool
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    private function refreshCateTree($right_value, $step = '+2'){
        $lsql = 'UPDATE users SET left_value=left_value'.$step.' WHERE left_value > '.$right_value;
        $rsql = 'UPDATE users SET right_value=right_value'.$step.' WHERE right_value >= '.$right_value;

        $this->query($lsql);
        $this->query($rsql);
        return true;
    }

    /**
     * 由于树的顶部是虚拟的：left_value:0,right_value:max_value
     *
     * @return int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function getMaxRightValue()
    {
        $ret = json_decode(json_encode($this->field('max(right_value)')->select()),true);
        return $ret[0]['max(right_value)'] ? $ret[0]['max(right_value)'] : 0;
    }



}
