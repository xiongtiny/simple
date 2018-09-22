<?php

namespace app\admin\controller;

/**
 * 管理后台入口文件
 *
 * Class Index
 * @package app\admin\controller
 */
class Index extends Base
{
    /**
     * 管理后台首页
     */
    public function index()
    {
        $data = array(
            'seo' => config('seo'),
            'userCateIds' => isset($this->login_admin_user['id']) && $this->login_admin_user['id'] > 0 ? $this->getCateIdsByUserId($this->login_admin_user['id']) : '',
            'roleList' => isset($this->login_admin_user['id']) && $this->login_admin_user['id'] > 0 ? $this->getRolesByUserId($this->login_admin_user['id']) : ''
        );

        $project_id = (int)cookie('project_id');
        $where = array();
        if ($project_id > 0) {
            $where['project_id'] = $project_id;
        }

        //查询全部菜单信息
        $allCate = $this->AdminCatesModel->getAll($where, array('rank' => 'asc'));

        //过滤为可显示的菜单信息
        $showCate = $this->genTree($allCate);

        $data['showCate'] = $showCate;

        $this->showView('index', $data);
    }

}
