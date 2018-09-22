<?php
namespace app\admin\controller;

use Pimple\Container;
use think\Request;
use think\Controller;
use think\Cookie;
use think\Session;

/**
 * 管理后台入口文件
 *
 * Class Index
 * @package app\admin\controller
 */
class Base extends Controller
{
    //容器变量
    public $container;
    public $super_admin_id                      = 1;

    public $login_admin_user                    = array();

    public $module                              = '';
    public $controller                          = '';
    public $action                              = '';


    //常用model
    protected $AdminUsersModel;
    protected $AdminCatesModel;
    protected $AdminRolesModel;
    protected $AdminCateHasRolesModel;
    protected $AdminCateHasUsersModel;
    protected $AdminUserHasRolesModel;

    protected $AdminDailyModel;
    protected $AdminProjectModel;
    protected $AdminPushModel;

    protected $UsersModel;
    protected $LogsModel;
    protected $OrdersModel;
    protected $MessagesModel;

    protected $AdflashModel;

    protected $ConfModel;
    //广告分类
    protected $AdposModel;
    //文章分类
    protected $ArticleCateModel;
    //文章分类
    protected $CircleModel;
    //文章分类
    protected $ArticleListModel;

    protected $AdminTestModel;
    /**
     * 初始化
     *
     * Common constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->container                = new Container();

        $this->setContainerModel();

        $this->module                   = Request::instance()->module();
        $this->controller               = Request::instance()->controller();
        $this->action                   = Request::instance()->action();


        //验证是否登录
        if (!$this->isLogin() && !in_array(strtolower($this->action), array('login', 'upload', 'uploadpush', 'import', 'loginimagecode', 'loginsendsmscode'))){
            //alert('登录失效请重新登录', site_url('Adminuser','login'));

            if(request()->isAjax()){
                $this->ajaxReturn(AJ_RET_NOLOGIN, '登录失效请重新登录');
            }else{
                alert('Please Login',BASE_URL.'/admin.php'.site_url('Adminuser', 'login'));
            }
        }

        //登录用户信息
        $this->login_admin_user   = array(
            'id'    => Session::get('id'),
            'name'  => Session::get('name')
        );

        //验证操作权限
        if (!$this->isAction()) {
            if(request()->isAjax()){
                $this->ajaxReturn(AJ_RET_FAILED, '没有当前模块的操作权限，如工作需要，请联系管理员开通');
            }else{
                alert('Please Login',BASE_URL.'/admin.php'.site_url('Adminuser', 'login'));
            }
        }
    }

    /**
     * 设置常用数据模型
     */
    private function setContainerModel(){
        //管理用户模型
        $this->setProperty('AdminUsersModel', function (){
            return model('AdminUsers');
        });

        //管理菜单模型
        $this->setProperty('AdminCatesModel', function (){
            return model('AdminCates');
        });

        //管理角色模型
        $this->setProperty('AdminRolesModel', function (){
            return model('AdminRoles');
        });

        //菜单所属角色
        $this->setProperty('AdminCateHasRolesModel', function (){
            return model('AdminCateHasRoles');
        });

        //菜单所属用户
        $this->setProperty('AdminCateHasUsersModel', function (){
            return model('AdminCateHasUsers');
        });

        //用户所属角色
        $this->setProperty('AdminUserHasRolesModel', function (){
            return model('AdminUserHasRoles');
        });


        //管理工作人员日报
        $this->setProperty('AdminDailyModel', function (){
            return model('AdminDaily');
        });


        //项目管理
        $this->setProperty('AdminProjectModel', function (){
            return model('AdminProject');
        });


        //项目需求发布管理
        $this->setProperty('AdminPushModel', function (){
            return model('AdminPush');
        });

        //Zczc User用户角色表
        $this->setProperty('UsersModel', function (){
            return model('Users');
        });

        //Logs记录表
        $this->setProperty('LogsModel', function (){
            return model('Logs');
        });

        //messages 消息提示表
        $this->setProperty('MessagesModel', function (){
            return model('Messages');
        });


        //Orders订单表
        $this->setProperty('OrdersModel', function (){
            return model('Orders');
        });

        //Adflash轮播图
        $this->setProperty('AdflashModel', function (){
            return model('Adflash');
        });

        //Conf配置文件
        $this->setProperty('ConfModel', function (){
            return model('Conf');
        });

        //Adpos广告分类
        $this->setProperty('AdposModel', function (){
            return model('Adpos');
        });

        //Articlecate文章分类
        $this->setProperty('ArticleCateModel', function (){
            return model('ArticleCate');
        });

        //ArticleList文章列表
        $this->setProperty('ArticleListModel', function (){
            return model('ArticleList');
        });

        //Circle文章列表
        $this->setProperty('CircleModel', function (){
            return model('Circle');
        });

        //Circle文章列表
        $this->setProperty('ConfModel', function (){
            return model('Conf');
        });

        //测试多层结构
        $this->setProperty('AdminTestModel', function (){
            return model('test.AdminTest');
        });
    }

    /**
     * 设置容器属性
     *
     * @param $property
     * @param $callable
     */
    protected function setProperty($property, $callable){
        $this->container[$property] = $this->container->factory($callable);
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
            $obj[$key]  = $this->container[$key];
        }

        return $obj[$key];
    }



    /**
     * 渲染/输出模板内容
     *
     * @param string $template
     * @param array $vars
     * @param array $replace
     * @param int $code
     * @param bool $is_content
     *
     * @return \think\response\View
     */
    protected function showView($template = '', $vars = [], $replace = [], $code = 200, $is_content = false){

        $vars = array_merge($vars, array('login_admin_user' => $this->login_admin_user));

        $vars['module']                 = $this->module;
        $vars['controller']             = $this->controller;
        $vars['action']                 = $this->action;

        $vars['cdn_version']            = ADMIN_VERSION;

        if(!$is_content){
            echo $this->fetch($template, $vars, $replace, $code);
        }else{
            return $this->fetch($template, $vars, $replace, $code);
        }
    }

    /**
     * json 数据输出
     *
     * @param array $data
     *
     * @return json
     */
    public function jsonReturn($data = array()){
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * 公共返回数据处理方法
     *
     * @param int $code
     * @param string $msg
     * @param array $data
     * @param string $callback
     * @param string $url
     *
     * @return json
     */
    protected function ajaxReturn($code = AJ_RET_SUCC, $msg = '', $data = [], $callback = 'close', $url = '')
    {
        /**
         * navTabId :
         *      可以把那个navTab标记为reloadFlag=1, 下次切换到那个navTab时会重新载入内容
         *
         * callbackType :
         *      closeCurrent就会关闭当前tab
         *      只有callbackType="forward"时需要forwardUrl值
         */
        $ret = array(
            'statusCode'    => $code,
            'message'       => $msg,
            'navTabId'      => md5($url),
            'rel'           => md5($url),
            'data'          => $data
        );

        switch ($callback) {
            case "forward"://刷新指定窗口
            case "close"://关闭当前窗口
                if ($callback == "forward" && $url) {
                    $ret["forwardUrl"] = $url;
                } else {
                    $ret["callbackType"] = "closeCurrent";
                }
                break;
            default:
                //不进行页面窗口的操作
                break;
        }

        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * 检查方法操作权限
     *
     * @return bool
     */
    protected function isAction(){
        //无需验证的控制器和方法
        $free_action = array(
            'controller'    => array(
                'Adminuser' => array('login', 'autologin', 'logout', 'loginimagecode', 'loginsendsmscode')
            ),
            'action'        => array(
                'upload', 'import', 'uploadpush'
            )
        );

        if($this->login_admin_user['id']  == $this->super_admin_id){
            return true;
        }

        //控制器名称
        $controller_name    = ucfirst(strtolower($this->controller));
        //方法名称
        $action_name        = strtolower($this->action);
        //格式化无需验证的控制器和方法
        $all_free_action    = isset($free_action['controller'][$controller_name]) ? $free_action['controller'][$controller_name] : array();

        if(in_array($action_name, $free_action['action'])){
            return true;
        }

        if(isset($free_action['controller'][$controller_name])){
            if(in_array($action_name, $all_free_action) || $free_action['controller'][$controller_name] == '*'){
                return true;
            }
        }

        if(!empty($this->login_admin_user) && $controller_name == 'Index'){
            return true;
        }

        //检查管理菜单是否加入到后台管理菜单中
        $check_url  = $controller_name.'/'. ( ACTION_MODEL == true ? $action_name : 'index');
        //查询访问的菜单
        $cate_info = $this->AdminCatesModel->getInfo(array('url' => $check_url));

        if ($cate_info) {
            //获取用户拥有的菜单编号
            $user_cate_ids = $this->getCateIdsByUserId($this->login_admin_user['id']);

            if (in_array($cate_info['id'], $user_cate_ids)) {
                return true;
            } else {
                //没有权限
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 检查是否登录
     *
     * @return bool
     */
    protected function isLogin(){
//        $controller_name    = ucfirst(strtolower($this->controller));
//        $action_name        = strtolower($this->action);

        //登录的cookie信息
        $cookie_user_id     = (int)Cookie::get('id');
        //登录的session信息
        $session_user_id    = (int)Session::get('id');

        if ($cookie_user_id > 0 && $cookie_user_id && $session_user_id && $session_user_id == $cookie_user_id) {
            return true;
        }

        return false;
    }

    /**
     * excel文件导出 (简洁方式直接导出)
     *
     * @param $file_name
     * @param $data
     *
     * @return file（返回下载文件）
     */
    protected function simpleExportExcel($file_name, $data){
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$file_name.".xls");
        foreach($data as $val){
            foreach($val as $item){
                echo iconv("UTF-8","GB2312//IGNORE",$item) ."\t";
            }
            echo "\n";
        }

        exit;
    }

    /**
     * 导入excel 数据
     *
     * @param $file
     * @return array
     */
    protected function importExcel($file){
        if(!file_exists($file)){
            return array();
        }

        $php_reader = \PHPExcel_IOFactory::load($file);
        $data       = $php_reader->getActiveSheet()->toArray(null, true, true, true);
        return $data;
    }

    /**
     * 发送短信码
     *
     * @param $mobile
     * @param $text
     * @return bool
     */
    protected function sendSms($mobile, $text){

        return false;
    }

    /**
     * 无限分类格式化成数组
     *
     * @param $items
     *
     * @return array
     */
    protected function genTree($items)
    {
        $tree = array(); //格式化的树
        /**
         * 定义树中的所有子孙节点所对应的键值 :
         * 如元素： array('id' => 14, 'pid' => 1, 'name' => '二级14' ),则 $son_keys[9] = "[1]['son'][5]['son'][9]"，
         * 则：$parent[1][14] = 14
         */

        $parent = array();  //以键值作为父节点的子

        /**
         * 定义树中的所有子孙节点所对应的键值:
         * 如 $tree[1]['son'][5]['son'][9]= array('id' => 9, 'pid' => 1, 'name' => '二级13' )
         * 则 $son_keys[9] = "[1]['son'][5]['son'][9]"
         */

        $son_keys = array();

        foreach ($items as $value) {
            //如果当前节点的父亲是一级（暂时是在一级）
            if (isset($tree[$value['pid']])) {
                $tree[$value['pid']]['son'][$value['id']] = $value;

                $son_keys[$value['id']] = "[{$value['pid']}]['son'][{$value['id']}]";
                //如果有以当前节点作为父节点
                if (isset($parent[$value['id']])) {
                    foreach ($parent[$value['id']] as $val) {
                        $tree[$value['pid']]['son'][$value['id']]["son"][$val]=$tree[$val];

                        unset($tree[$val]);

                        $son_keys[$val] = "[{$value['pid']}]['son'][{$value['id']}]['son'][$val]";
                    }
                    unset($parent[$value['id']]);
                }
            } elseif (isset($son_keys[$value['pid']])) { //如果当前节点的父亲类是二级或以上
                $current_key = "{$son_keys[$value['pid']]}['son'][{$value['id']}]";

                $son_keys[$value['id']] = $current_key;

                eval('$tree'.$current_key.'=$value;');
                //如果有以当前节点作为父节点
                if (isset($parent[$value['id']])) {
                    foreach ($parent[$value['id']] as $val) {
                        eval('$tree'.$current_key.'["son"][$val]=$tree[$val];');

                        unset($tree[$val]);

                        $son_keys[$val] = "{$current_key}['son'][$val]";
                    }
                    unset($parent[$value['id']]);
                }
            } else { //当前节点或暂时没有父亲
                $tree[$value['id']] = $value;
                //如果有以当前节点作为父节点
                if (isset($parent[$value['id']])) {
                    foreach ($parent[$value['id']] as $val) {
                        $tree[$value['id']]["son"][$val]=$tree[$val];

                        unset($tree[$val]);

                        $son_keys[$val] = "[{$value['id']}]['son'][$val]";
                    }
                    unset($parent[$value['id']]);
                }
            }
            $parent[$value['pid']][$value['id']] = $value['id'];
        }

        return $tree;
    }

    /**
     * 获取用户所有的权限分类ID
     *
     * @param $user_id
     *
     * @return array
     */
    protected function getCateIdsByUserId($user_id)
    {
        static $caches = array();

        if (isset($caches[$user_id])) {
            return $caches[$user_id];
        } else {
            //菜单拥有的角色信息
            $rcate_ids = $this->AdminCateHasRolesModel->getCateIdsByUserId($user_id);

            $rcate_ids = !empty($rcate_ids) ? @array_index_value($rcate_ids, 'cate_id', 'cate_id') : array();

            $ucate_ids = array();

            if ($user_id == $this->super_admin_id) {
                //超级管理员是所有菜单
                $cate_ids = $this->AdminCatesModel->getAll();

                foreach ((array)$cate_ids as $k => $v) {
                    $ucate_ids[] = $v['id'];
                }
            } else {
                //获取管理员所有菜单列表
                $cate_ids = $this->AdminCateHasUsersModel->getCateIdsByUserId($user_id);

                foreach ((array)$cate_ids as $k => $v) {
                    $ucate_ids[] = $v['cate_id'];
                }
            }

            $ucate_ids = !empty($ucate_ids) ? $ucate_ids : array();

            //用户拥有的菜单数组
            $has_cate_ids = array_unique(array_merge($rcate_ids, $ucate_ids));

            $caches[$user_id] = $has_cate_ids;

            return $has_cate_ids;
        }
    }

    /**
     * 获取用户角色信息
     *
     * @param $user_id
     *
     * @return array
     */
    protected function getRolesByUserId($user_id)
    {
        if ((!$user_id || !is_numeric($user_id))) {
            return false;
        }

        if ($user_id == $this->super_admin_id) {
            //超级管理员是所有权限
            //$role_list = $this->AdminRolesModel->getAll();

            $role_list = array(0 => array('name' => '超级管理员'));
        } else {
            $role_list = $this->AdminUserHasRolesModel->getRolesByUserId($user_id);
        }

        return $role_list;
    }

    /**
     * 上传
     *
     * @return json
     */
    public function uploadPush(){
        $inputName='filedata';//表单文件域name
        $attachDir='static/upload/push';//上传文件保存路径，结尾不要带/
        $dirType=1;//1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
        $maxAttachSize=2097152;//最大上传大小，默认是2M
        $upExt='txt,rar,zip,jpg,jpeg,gif,png,swf,wmv,avi,wma,mp3,mid';//上传扩展名
        $msgType=2;//返回上传参数的格式：1，只返回url，2，返回参数数组
        $immediate=isset($_GET['immediate'])?$_GET['immediate']:0;//立即上传模式，仅为演示用
        ini_set('date.timezone','Asia/Shanghai');//时区
        $err = "";
        $msg = "''";
        $tempPath=$attachDir.'/'.date("YmdHis").mt_rand(10000,99999).'.tmp';
        $localName='';
        if(isset($_SERVER['HTTP_CONTENT_DISPOSITION'])&&preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i',$_SERVER['HTTP_CONTENT_DISPOSITION'],$info)){//HTML5上传
            file_put_contents($tempPath,file_get_contents("php://input"));
            $localName=urldecode($info[2]);
        }
        else{//标准表单式上传
            $upfile=@$_FILES[$inputName];
            if(!isset($upfile))$err='文件域的name错误';
            elseif(!empty($upfile['error'])){
                switch($upfile['error'])
                {
                    case '1':
                        $err = '文件大小超过了php.ini定义的upload_max_filesize值';
                        break;
                    case '2':
                        $err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
                        break;
                    case '3':
                        $err = '文件上传不完全';
                        break;
                    case '4':
                        $err = '无文件上传';
                        break;
                    case '6':
                        $err = '缺少临时文件夹';
                        break;
                    case '7':
                        $err = '写文件失败';
                        break;
                    case '8':
                        $err = '上传被其它扩展中断';
                        break;
                    case '999':
                    default:
                        $err = '无有效错误代码';
                }
            }
            elseif(empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none')$err = '无文件上传';
            else{
                move_uploaded_file($upfile['tmp_name'],$tempPath);
                $localName=$upfile['name'];
            }
        }
        if($err==''){
            $fileInfo=pathinfo($localName);
            $extension=$fileInfo['extension'];
            if(preg_match('/^('.str_replace(',','|',$upExt).')$/i',$extension))
            {
                $bytes=filesize($tempPath);
                if($bytes > $maxAttachSize)$err='请不要上传大小超过'.format_bytes($maxAttachSize).'的文件';
                else
                {
                    switch($dirType)
                    {
                        case 1: $attachSubDir = 'day_'.date('ymd'); break;
                        case 2: $attachSubDir = 'month_'.date('ym'); break;
                        case 3: $attachSubDir = 'ext_'.$extension; break;
                    }
                    $attachDir = $attachDir.'/'.$attachSubDir;

                    if(!is_dir($attachDir))
                    {
                        @mkdir($attachDir, 0777);
                        @fclose(fopen($attachDir.'/index.htm', 'w'));
                    }
                    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
                    $newFilename=date("YmdHis").mt_rand(1000,9999).'.'.$extension;
                    $targetPath = $attachDir.'/'.$newFilename;

                    rename($tempPath,$targetPath);
                    @chmod($targetPath,0755);
                    $targetPath=json_string($targetPath);
                    if($immediate=='1')$targetPath='!'.$targetPath;
                    if($msgType==1)$msg="'$targetPath'";
                    else $msg="{'url':'".$targetPath."','localname':'".json_string($localName)."','id':'1'}";//id参数固定不变，仅供演示，实际项目中可以是数据库ID
                }
            }
            else $err='上传文件扩展名必需为：'.$upExt;
            @unlink($tempPath);
        }
        echo "{'err':'".json_string($err)."','msg':".$msg."}";
    }
}
