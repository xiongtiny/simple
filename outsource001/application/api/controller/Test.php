<?php
namespace app\api\controller;

use app\common;
use think\Loader;

/**
 * 测试
 *
 * Class Test
 * @package app\api\controller
 */
class Test extends Base
{
    public function index(){
        $ret    = $this->UsersModel->getAll(array('id' => 1), array(), 'nick_name');


//        list($a, $b) = new ArrayObject([0, 1]);
//        echo $a.'----'.$b;

        var_dump(date("Y-m-d", strtotime("2017-06-31")));
    }


    public function exportExcel(){

    }

}
