<?php
/**
 * Created by Sublime.
 * User: weilang
 * Date: 2018/4/10
 * Time: 11:19
 */

namespace app\model;
use think\Model;
use think\model\concern\SoftDelete;

class UserIsno extends Model
{
    protected $table='yxy_user_isno';
    use SoftDelete;
    protected $deleteTime = 'del_time';

}