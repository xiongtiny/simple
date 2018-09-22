<?php
/**
 * Created by PhpStorm.
 * User: weilang
 * Date: 2018/4/9
 * Time: 15:50
 */
namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;

class News extends Model{
	
    protected $table='yxy_news';
    use SoftDelete;
    protected $deleteTime = 'del_time';

    //关联新闻分类模型
    public function getType(){
        return $this->hasOne('NewsType','id','type');
    }


    public function setContentAttr($v){
        return  htmlspecialchars($v);
    }

    public function getContentAttr($v){
        return htmlspecialchars_decode($v);
    }


    public function getPhotoAttr($v){
        return url($v,'',false,true);
    }

}