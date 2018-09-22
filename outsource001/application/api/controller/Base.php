<?php

namespace app\api\controller;

use Pimple\Container;
use think\Request;
use think\Controller;
use think\Cookie;
use think\Session;

class Base extends Controller
{
    //容器变量
    public $container;

    public $module = '';
    public $controller = '';
    public $action = '';

    //数据模型
    protected $UsersModel;
    protected $LogsModel;
    protected $OrdersModel;
    protected $MessagesModel;
    protected $MessageFlagsModel;

    public $user;
    public $data;
    public $lang;

    /**
     * 初始化
     *
     * Common constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        !request()->isPost() && $this->ajaxReturn(AJ_RET_FAILED, '非法操作');

        $this->data = input('post.');

        parent::__construct($request);
        $this->container = new Container();

        $this->setContainerModel();

        $this->module = Request::instance()->module();
        $this->controller = Request::instance()->controller();
        $this->action = Request::instance()->action();


        $this->lang = session('language');

        if (!in_array(strtolower($this->action), array('login', 'language', 'codeimg', 'resetreleasestatus'))) {
            $this->user = session('user');
            $this->user = [
                "id" => 1001,
                "mobile" => "13027199173",
                "nick_name" => "大声道",
                "pwd" => "46f92d17ba",
                "head_image" => "http://demo/static/upload/cover_img/10/01/1001.png",
                "level" => 0,
                "assets" => "9644.5604",
                "coin" => "106.6319",
                "money" => "248.8077",
                "pid" => 0,
                "activation_num" => 6,
                "token" => "6498a94485deb34653e6795e066bf036",
                "money_addr" => "864d6f17f620fe112e65637308a51c71",
            ];

            empty($this->user) && $this->ajaxReturn(AJ_RET_FAILED, '请先登录');

//            $token  = $this->UsersModel->getInfo(array('id'=>$this->user['id']),'token');
//            $this->user['token']!=$token && $this->ajaxReturn(AJ_RET_FAILED, '登录超时');

        }

        $this->isLogin();
    }

    /**
     * 统计资产
     */
    public function statAssets($user_id)
    {
        $res = $this->UsersModel->getAll(array('pid' => $user_id), array('position' => 'asc'));

        $res = array_index_value($res, 'position');

        $assets1 = 0;
        $assets2 = 0;

        if (!empty($res[0])) {
            $res1 = $this->UsersModel->child($res[0]['id']);
            $assets1 = array_index_value($res1, 'id', 'money_log', 'sum');
        }
        if (!empty($res[1])) {
            $res2 = $this->UsersModel->child($res[1]['id']);
            $assets2 = array_index_value($res2, 'id', 'money_log', 'sum');
        }


        $result['max'] = $assets1 > $assets2 ? $assets1 : $assets2;
        $result['min'] = $assets1 > $assets2 ? $assets2 : $assets1;

        $result['a'] = $assets1;
        $result['b'] = $assets2;

        return $result;
    }


    /**
     * 查询用户列表
     */
    public function childList($user_id)
    {
        $res = $this->UsersModel->getAll(array('pid' => $user_id), array('id' => 'asc'));

        $res = array_index_value($res, 'position');

        if (isset($res[0]['id'])) {
            $res1 = $this->UsersModel->child($res[0]['id']);
            $res1 = array_index_value($res1, 'id', 'assets', 'sum');
        } else {
            $res1 = 0;
        }


        if (isset($res[1]['id'])) {
            $res2 = $this->UsersModel->child($res[1]['id']);
            $res2 = array_index_value($res2, 'id', 'assets', 'sum');
        } else {
            $res2 = 0;
        }


        $result['a'] = $res1;
        $result['b'] = $res2;
        return $result;
    }


    /**
     * 系统级提示
     */
    protected function systemTip()
    {
        $this->ajaxReturn(AJ_RET_BAD, '系统维护中，请稍后再试');
    }


    /**
     * 验证是否登录
     *
     * @return bool|mixed
     */
    protected function isLogin()
    {
        //登录的cookie信息
        $cookie_user_id = (int)Cookie::get('id');
        //登录的session信息
        $session_user_id = (int)Session::get('id');

//        if(!in_array(strtolower($this->action), array('login')) && !in_array(strtolower($this->controller), array('test'))){
//            if($session_user_id <= 0) {
//                $this->ajaxReturn(AJ_RET_NOLOGIN, '请先登录！');
//            }
//        }
    }

    /**
     * 验证字段
     */
    public function validate_code($data, $table = "", $val)
    {
        empty($table) ? $table = 'users' : $table = 'userseng';
        $validate = validate($table);
        if (!$validate->scene($val)->check($data)) {
            $this->ajaxReturn(AJ_RET_FAILED, $validate->getError());
        }
    }

    /**
     * 空方法提示
     */
    public function _empty()
    {
        $this->ajaxReturn(AJ_RET_NOT_FOUND, '抱歉，您要查看的数据不存在或已被删除!!!');
    }

    /**
     * 设置常用数据模型
     */
    private function setContainerModel()
    {
        //用户
        $this->setProperty('UsersModel', function () {
            return model('Users');
        });

        //兑换 流水 转账...
        $this->setProperty('LogsModel', function () {
            return model('Logs');
        });

        //挂单交易
        $this->setProperty('OrdersModel', function () {
            return model('orders');
        });

        //Messages 消息通知
        $this->setProperty('MessagesModel', function () {
            return model('Messages');
        });
        $this->setProperty('MessageFlagsModel', function () {
            return model('MessageFlags');
        });

    }

    /**
     * 设置容器属性
     *
     * @param $property
     * @param $callable
     */
    protected function setProperty($property, $callable)
    {
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

        if (!isset($obj[$key])) {
            $obj[$key] = $this->container[$key];
        }

        return $obj[$key];
    }

    /**
     * 获取请求头数据
     *
     * @return array
     */
    public function getAllHeader()
    {
        // 忽略获取的header数据。这个函数后面会用到。主要是起过滤作用
        $ignore = array('host', 'accept', 'content-length', 'content-type');

        $headers = array();
        //这里大家有兴趣的话，可以打印一下。会出来很多的header头信息。咱们想要的部分，都是‘http_'开头的。所以下面会进行过滤输出。
        /*    var_dump($_SERVER);
            exit;*/

        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) === 'HTTP_') {
                //这里取到的都是'http_'开头的数据。
                //前去开头的前5位
                $key = substr($key, 5);
                //把$key中的'_'下划线都替换为空字符串
                $key = str_replace('_', ' ', $key);
                //再把$key中的空字符串替换成‘-’
                $key = str_replace(' ', '-', $key);
                //把$key中的所有字符转换为小写
                $key = strtolower($key);

                //这里主要是过滤上面写的$ignore数组中的数据
                if (!in_array($key, $ignore)) {
                    $headers[$key] = $value;
                }
            }
        }
        //输出获取到的header
        return $headers;

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
                        $tree[$value['pid']]['son'][$value['id']]["son"][$val] = $tree[$val];

                        unset($tree[$val]);

                        $son_keys[$val] = "[{$value['pid']}]['son'][{$value['id']}]['son'][$val]";
                    }
                    unset($parent[$value['id']]);
                }
            } elseif (isset($son_keys[$value['pid']])) { //如果当前节点的父亲类是二级或以上
                $current_key = "{$son_keys[$value['pid']]}['son'][{$value['id']}]";

                $son_keys[$value['id']] = $current_key;

                eval('$tree' . $current_key . '=$value;');
                //如果有以当前节点作为父节点
                if (isset($parent[$value['id']])) {
                    foreach ($parent[$value['id']] as $val) {
                        eval('$tree' . $current_key . '["son"][$val]=$tree[$val];');

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
                        $tree[$value['id']]["son"][$val] = $tree[$val];

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
     * json 数据输出
     *
     * @param array $data
     *
     * @return json
     */
    public function jsonReturn($data = array())
    {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * 公共返回数据处理方法
     *
     * @param int|mixed $code
     * @param string $msg
     * @param string $data
     */
    protected function ajaxReturn($code = AJ_RET_SUCC, $msg = '', $data = '', $lang = 0)
    {
        isset($lang) && $msg = lang1($msg);
        $ret = array(
            "code" => $code,
            "msg" => $msg,
        );

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if ($value === null) {
                    $data[$key] = '';
                }
            }
        }
        $ret['result'] = $this->resultType($data);

//        if(IS_DEBUG == true){
//            $ret['debug_url']   = BASE_URL . '/static/xhprof/xhprof_html/index.php';
//        }

        echo json_encode($ret);
        exit;
    }


    /**
     * 获取json类型
     * @param  [type] $result [json状态]
     * @return [type]         [返回json类型]
     */
    protected function resultType($result)
    {
        $res = $result;
        switch ($result) {
            case 'arr':
                $res = array();
                break;
            case 'obj':
                $res = (object)array();
                break;
            case 'str':
                $res = "";
                break;
            case null:
                $res = (object)array();
                break;
        }
        return $res;
    }
}
