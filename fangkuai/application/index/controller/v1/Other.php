<?php
namespace app\index\controller\v1;
use app\model\Feedback;
use app\model\Order;
use app\model\SendSms;
use \think\Controller;
use \think\Validate;
use think\facade\Session;

/**
* 
*/
class Other extends Controller
{
	
	public function other_product_description()
	{
	    $id = Session::get('user_id');
        $name = \app\model\User::where('id',$id)->value('name');
        $this->assign('name',$name);
		return $this->fetch();
	}
	public function other_about_us()
	{
		                $id = Session::get('user_id');
        $name = \app\model\User::where('id',$id)->value('name');
        $this->assign('name',$name);
		return $this->fetch();
	}
	public function other_pay()
	{
		                $id = Session::get('user_id');
        $name = \app\model\User::where('id',$id)->value('name');
        $this->assign('name',$name);
		return $this->fetch();
	}
}

?>