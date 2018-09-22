<?php
/**
 * Created by PhpStorm.
 * User: lizeqiang
 * Date: 2018/4/9
 * Time: 11:41
 */
namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;

class IndexImage extends Model{
    use SoftDelete;
    protected $name='index_image';
    protected $deleteTime = 'del_time';
}