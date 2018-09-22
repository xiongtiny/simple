<?php
namespace app\admin\model;

class AdminCateHasUsers extends Base
{
    protected $createTime = false;
    protected $updateTime = false;

    /**
     * 获取用户所有的权限分类ID
     *
     * @param $user_id
     * @return bool|mixed
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function getCateIdsByUserId($user_id)
    {
        if (empty($user_id) || !is_numeric($user_id)) {
            return false;
        }

        $sql = 'select cate_id from admin_cate_has_users where user_id = '.$user_id;

        $ret = $this->query($sql);

        return $ret;
    }
}
