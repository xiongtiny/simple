<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/5/7
 * Time: 下午7:28
 */

namespace app\admin\controller\v1;
use app\model\Recruit as RecruitModel;

class Recruit extends BaseController
{
    public function index(){
        $this->auth();
        $this->method();
        $recruits=RecruitModel::paginate();
        return view('',compact('recruits'));
    }
}