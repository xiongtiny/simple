<?php
namespace app\admin\model;

class AdminUserHasRoles extends Base
{
    protected $createTime = false;
    protected $updateTime = false;

    /**
     * 查询用户角色信息
     *
     * @param $user_id
     * @return bool|mixed
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function getRolesByUserId($user_id)
    {
        if (empty($user_id) || !is_numeric($user_id)) {
            return false;
        }

        $sql = 'select r.* from admin_user_has_roles u left join admin_roles r on u.role_id = r.id where u.user_id = '.$user_id;

        $ret = $this->query($sql);

        return $ret;
    }
}
