<?php 
namespace app\admin\model;

Class AdminRoles extends Base {

    protected $createTime = false;
    protected $updateTime = false;

    /**
     * 根据菜单编号 获取 角色信息
     *
     * @param $cate_id
     * @return bool|mixed
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function getRolesByCateId($cate_id)
    {
        if (empty($cate_id) || !is_numeric($cate_id)) {
            return false;
        }

        $sql = 'select r.* from admin_roles r left join  admin_cate_has_roles cr on r.id = cr.role_id where cr.cate_id = '.$cate_id;

        $ret = $this->query($sql);

        return $ret;
    }
}

