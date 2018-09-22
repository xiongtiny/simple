<?php
/**
 * Created by PhpStorm.
 * User: shaoguo
 * Date: 2018/5/7
 * Time: 下午4:32
 */

namespace app\admin\controller\v1;
use app\model\NewImg as NewImgModel;

class Newimg extends BaseController
{
    /**
     * 图片列表
     * @return \think\response\View
     */
    public function index(){
        $this->method();
        $this->auth();
        $NewImgs=NewImgModel::all();
        return view('',compact('NewImgs'));
    }

    public function edit($id){
        $this->method();
        $this->auth();
        $img=NewImgModel::get($id);
        return view('',compact('img'));
    }

    public function editPost(){
        $this->method('post');
        $this->auth();
        $id=request()->post('id');
        $img=uploadImageOne('img');
        $data=request()->except('id');
        if($img['status']==0){
            $data['img']=$img['message'];
        }

        if(!NewImgModel::get($id)->save($data)){
            ajax_error('','上传图片失败');
        }
        ajax_success('','上传图片成功');
    }
}