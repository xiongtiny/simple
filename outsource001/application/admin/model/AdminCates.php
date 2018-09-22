<?php 
namespace app\admin\model;

Class AdminCates extends Base {

    /**
     * 添加管理菜单
     *
     * @param array $data
     * @return array|bool|false|int|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addCate($data = array()){
        if($data['pid'] > 0){
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
     * 删除管理菜单
     *
     * @param $id
     * @return bool
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function delCate($id)
    {
        $cate_info = $this->getInfo(array('id' => $id));

        if ($cate_info) {
            $v_width    = $cate_info['right_value'] - $cate_info['left_value'] + 1;

            $dsql       = 'DELETE FROM admin_cates WHERE left_value BETWEEN '.$cate_info['left_value'].' AND '.$cate_info['right_value'];
            $lsql       = 'UPDATE admin_cates SET left_value = left_value - '.$v_width.' WHERE left_value > '.$cate_info['right_value'];
            $rsql       = 'UPDATE admin_cates SET right_value = right_value - '.$v_width.' WHERE right_value > '.$cate_info['right_value'];

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
        $lsql = 'UPDATE admin_cates SET left_value=left_value'.$step.' WHERE left_value > '.$right_value;
        $rsql = 'UPDATE admin_cates SET right_value=right_value'.$step.' WHERE right_value >= '.$right_value;

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

    /**
     * 获取最大排序
     *
     * @return int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getMaxRank()
    {
        $ret = json_decode(json_encode($this->field('max(rank)')->select()),true);

        return ($ret[0]['max(rank)'] ? $ret[0]['max(rank)'] : 0)+1;
    }

    /**
     * 获取移动菜单项信息
     *
     * @param $id
     * @param null $cate
     * @return mixed
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function getMoveCates($id, $cate = null)
    {
        if ($cate == null) {
            $cate   =   $this->getInfo(array('id' => $id));
        }

        $left_value     = $cate['left_value'];
        $right_value    = $cate['right_value'];

        $sql            = 'select * from admin_cates where `left_value`>='.$left_value.' AND `right_value`<=' . $right_value;

        return $this->query($sql);
    }

    /**
     * 移动菜单方法
     *
     * @param $id
     * @param $pid
     * @return bool
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function moveCate($id, $pid)
    {
        $cate   =   $this->getInfo(array('id' => $id));
        $pcate  =   $this->getInfo(array('id' => $pid));

        if (empty($cate)) {
            return false;
        }

        $left_value     =   (int)$cate['left_value'];
        $right_value    =   (int)$cate['right_value'];
        $value          =   $right_value-$left_value;

        //取得所有分类的ID方便更新左右值
        $cate_ids = $this->getMoveCates($id, $cate);
        $ids = array();
        foreach ($cate_ids as $v) {
            $ids[]=$v['id'];
        }
        $in_ids = implode(",", $ids);

        $pleft_value    =   0;
        $pright_value   =   0;
        if ($pcate) {
            $pleft_value    = (int)$pcate['left_value'];
            $pright_value   = (int)$pcate['right_value'];
        }

        if ($pright_value > $right_value) {
            $this->query('UPDATE admin_cates SET left_value = left_value - '.$value.' - 1 WHERE left_value > '.$right_value.' and right_value <= '.$pright_value);

            $this->query('UPDATE admin_cates SET right_value = right_value - '.$value.' - 1 WHERE right_value >  '.$right_value.' and right_value < '.$pright_value);

            $tem_value  =   $pright_value-$right_value-1;
            $this->query('UPDATE admin_cates SET left_value = left_value + '.$tem_value.', right_value = right_value + '.$tem_value.' WHERE id IN('.$in_ids.')');
        } else {
            $this->query('UPDATE admin_cates SET left_value = left_value + '.$value.' + 1 WHERE left_value > '.$pright_value.' and left_value < '.$left_value);

            $this->query('UPDATE admin_cates SET right_value = right_value + '.$value.' + 1 WHERE right_value >= '.$pright_value.' and right_value < '.$left_value);

            $tem_value  =   $left_value-$pright_value;
            $this->query('UPDATE  admin_cates SET left_value = left_value - '.$tem_value.', right_value = right_value - '.$tem_value.' WHERE id IN('.$in_ids.')');
        }

        return true;
    }
}

