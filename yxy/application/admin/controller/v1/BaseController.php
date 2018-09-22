<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/4/9
 * Time: 下午5:03
 */

namespace app\admin\controller\v1;
use app\model\Admin;
use think\Controller;
use app\plugins\gmars\rbac\Rbac;
class BaseController extends Controller
{
    protected $user;
    protected $rbac;

    public function __construct()
    {
        parent::__construct();
        $controller = request()->controller();
        $this->assign('controller',$controller);
        $this->rbac=new Rbac();
    }

    /**
     * 判断是否登陆
     */
    public function auth()
    {
        $admin_id=session('user_id','','admin');
        if(is_null($admin_id)){
            if(request()->isAjax()){
                ajax_error('','请先登录');
            }else{
                $this->error('请先登录','/admin/v1/user/login');
            }
        }else{
            $this->user=Admin::get($admin_id);
            $this->assign('user',$this->user);
                /**
             * 权限检查
             */
            $user=Admin::get($admin_id);
            if(!$user->super){
                if(!$this->rbac->can(request()->url())){
                    if(request()->isAjax()){
                        ajax_error('','您没有权限');
                    }else{
                        $this->error('您没有权限');
                    }
                }
            }

        }
    }

    /**
     * 检查方法
     * @param string $method
     */
    public function method($method='get'){
        $is_method="is".ucfirst($method);
        if(!request()->$is_method()){
            if(request()->isAjax()){
                ajax_error('','请求方式此错误');
            }else{
                $this->error('请求方式此错误');
            }
        }
    }

}